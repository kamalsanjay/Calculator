<?php
/**
 * Email Template Editor
 * Manage email templates
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();
AdminMiddleware::requirePermission('send_emails');

$page_title = "Email Templates - Admin Panel";
$db = Database::getInstance();

// Available templates
$templates = [
    'welcome' => ['name' => 'Welcome Email', 'description' => 'Sent to new users after registration'],
    'verify-email' => ['name' => 'Email Verification', 'description' => 'Email verification link'],
    'password-reset' => ['name' => 'Password Reset', 'description' => 'Password reset instructions'],
    'password-changed' => ['name' => 'Password Changed', 'description' => 'Password change confirmation'],
    'two-factor-code' => ['name' => 'Two-Factor Code', 'description' => '2FA verification code'],
    'login-alert' => ['name' => 'Login Alert', 'description' => 'New login notification'],
    'account-deleted' => ['name' => 'Account Deleted', 'description' => 'Account deletion confirmation'],
    'newsletter' => ['name' => 'Newsletter', 'description' => 'Monthly newsletter template']
];

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'preview') {
        $template = $_POST['template'] ?? '';
        $templatePath = BASE_PATH . "/emails/templates/{$template}.php";
        
        if (file_exists($templatePath)) {
            // Mock data for preview
            $username = 'John Doe';
            $email = 'john@example.com';
            $verificationUrl = 'https://calculator.com/verify?token=xxxxx';
            $resetUrl = 'https://calculator.com/reset?token=xxxxx';
            $code = '123456';
            $ipAddress = '192.168.1.1';
            $userAgent = 'Mozilla/5.0...';
            $location = 'New York, USA';
            $browser = 'Chrome';
            $isNewDevice = true;
            $siteUrl = getenv('SITE_URL') ?: 'https://calculator.com';
            
            ob_start();
            include $templatePath;
            $preview = ob_get_clean();
            
            echo $preview;
            exit;
        }
    }
    
    if ($action === 'send_test') {
        $template = $_POST['template'] ?? '';
        $testEmail = sanitize_input($_POST['test_email'] ?? '');
        
        if ($testEmail && filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                // Send test email
                $email = new Email();
                $email->to($testEmail)
                      ->subject("Test Email - {$templates[$template]['name']}")
                      ->body("This is a test email from the template: {$template}")
                      ->send();
                
                $_SESSION['success'] = "Test email sent to {$testEmail}";
                AdminMiddleware::logAction('email_test', "Sent test email: {$template}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to send test email: " . $e->getMessage();
            }
        }
        header('Location: /admin/email-templates');
        exit;
    }
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Email Templates</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Templates Grid -->
        <div class="templates-grid">
            <?php foreach ($templates as $slug => $template): ?>
                <div class="template-card">
                    <div class="template-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($template['name']); ?></h3>
                    <p><?php echo htmlspecialchars($template['description']); ?></p>
                    
                    <div class="template-actions">
                        <button class="btn btn-sm btn-primary" onclick="previewTemplate('<?php echo $slug; ?>')">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        <button class="btn btn-sm btn-info" onclick="editTemplate('<?php echo $slug; ?>')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-success" onclick="sendTest('<?php echo $slug; ?>')">
                            <i class="fas fa-paper-plane"></i> Test
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Email Statistics -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Email Statistics (Last 30 Days)</h3>
            </div>
            <div class="card-body">
                <div class="email-stats">
                    <?php
                    try {
                        $emailStats = $db->fetchAll("
                            SELECT 
                                event_data->>'$.template' as template,
                                COUNT(*) as sent_count
                            FROM events
                            WHERE event_name = 'email_sent'
                            AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                            GROUP BY template
                            ORDER BY sent_count DESC
                        ");
                    } catch (Exception $e) {
                        $emailStats = [];
                    }
                    ?>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Template</th>
                                <th>Emails Sent</th>
                                <th>Last Sent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($emailStats as $stat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($templates[$stat['template']]['name'] ?? $stat['template']); ?></td>
                                    <td><?php echo number_format($stat['sent_count']); ?></td>
                                    <td><?php echo date('M d, Y'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="modal">
    <div class="modal-content modal-large">
        <span class="close" onclick="closeModal('previewModal')">&times;</span>
        <h2>Email Preview</h2>
        <div id="previewContent" class="email-preview">
            <div class="loading">Loading preview...</div>
        </div>
    </div>
</div>

<!-- Test Email Modal -->
<div id="testModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('testModal')">&times;</span>
        <h2>Send Test Email</h2>
        <form method="POST" id="testForm">
            <input type="hidden" name="action" value="send_test">
            <input type="hidden" name="template" id="testTemplate">
            
            <div class="form-group">
                <label>Send test email to:</label>
                <input type="email" 
                       name="test_email" 
                       class="form-control" 
                       placeholder="your-email@example.com"
                       required>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('testModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Test Email</button>
            </div>
        </form>
    </div>
</div>

<style>
.templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.template-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    transition: 0.3s ease;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.template-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.template-card h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
}

.template-card p {
    color: #6c757d;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.template-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.email-preview {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
    max-height: 70vh;
    overflow-y: auto;
}

.modal-large {
    max-width: 900px;
}

.loading {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.email-stats table {
    margin: 0;
}
</style>

<script>
function previewTemplate(template) {
    document.getElementById('previewModal').style.display = 'block';
    document.getElementById('previewContent').innerHTML = '<div class="loading">Loading preview...</div>';
    
    // Load preview via AJAX
    fetch('/admin/email-templates', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=preview&template=${template}`
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('previewContent').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('previewContent').innerHTML = '<div class="loading">Error loading preview</div>';
    });
}

function editTemplate(template) {
    // Open template file for editing (could redirect to code editor)
    window.open(`/admin/file-editor?file=emails/templates/${template}.php`, '_blank');
}

function sendTest(template) {
    document.getElementById('testTemplate').value = template;
    document.getElementById('testModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<?php include '../includes/footer.php'; ?>