<?php
/**
 * System Settings - Complete Configuration Panel
 * @version 1.0.0
 */

require_once 'includes/auth.php';

if ($_SESSION['admin_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$message = '';
$error = '';
$activeTab = $_GET['tab'] ?? 'general';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request.';
    } else {
        switch ($_POST['action']) {
            case 'save_general':
                $result = saveGeneralSettings($_POST);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            case 'save_seo':
                $result = saveSEOSettings($_POST);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            case 'save_email':
                $result = saveEmailSettings($_POST);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            case 'test_email':
                $result = testEmailConfiguration($_POST['test_email']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            case 'backup_database':
                $result = backupDatabase();
                if ($result['success']) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $result['filename'] . '"');
                    echo $result['data'];
                    exit();
                } else {
                    $error = $result['message'];
                }
                break;
        }
    }
}

$settings = getAllSettings();
require_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs me-2"></i>System Settings
        </h1>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeTab === 'general' ? 'active' : ''; ?>" href="?tab=general">
                        <i class="fas fa-sliders-h me-1"></i>General
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeTab === 'seo' ? 'active' : ''; ?>" href="?tab=seo">
                        <i class="fas fa-search me-1"></i>SEO
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeTab === 'email' ? 'active' : ''; ?>" href="?tab=email">
                        <i class="fas fa-envelope me-1"></i>Email
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeTab === 'backup' ? 'active' : ''; ?>" href="?tab=backup">
                        <i class="fas fa-database me-1"></i>Backup
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <?php if ($activeTab === 'general'): ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action" value="save_general">

                <h5 class="mb-3">Site Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Name *</label>
                        <input type="text" class="form-control" name="site_name" required
                               value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site URL *</label>
                        <input type="url" class="form-control" name="site_url" required
                               value="<?php echo htmlspecialchars($settings['site_url'] ?? ''); ?>">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Site Description</label>
                        <textarea class="form-control" name="site_description" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Email *</label>
                        <input type="email" class="form-control" name="contact_email" required
                               value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Admin Email *</label>
                        <input type="email" class="form-control" name="admin_email" required
                               value="<?php echo htmlspecialchars($settings['admin_email'] ?? ''); ?>">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Site Features</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1"
                                   <?php echo ($settings['maintenance_mode'] ?? 0) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Maintenance Mode</label>
                        </div>
                        <small class="text-muted">Display maintenance page to visitors</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="enable_analytics" value="1"
                                   <?php echo ($settings['enable_analytics'] ?? 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Enable Analytics</label>
                        </div>
                        <small class="text-muted">Track visitor data and usage</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" class="form-control" name="google_analytics_id"
                               value="<?php echo htmlspecialchars($settings['google_analytics_id'] ?? ''); ?>"
                               placeholder="G-XXXXXXXXXX">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Items Per Page</label>
                        <input type="number" class="form-control" name="items_per_page" min="5" max="100"
                               value="<?php echo htmlspecialchars($settings['items_per_page'] ?? 20); ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Save General Settings
                </button>
            </form>
            <?php endif; ?>

            <?php if ($activeTab === 'seo'): ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action" value="save_seo">

                <h5 class="mb-3">Default Meta Tags</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Default Meta Title</label>
                        <input type="text" class="form-control" name="default_meta_title"
                               value="<?php echo htmlspecialchars($settings['default_meta_title'] ?? ''); ?>">
                        <small class="text-muted">Used when page doesn't have specific title</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Default Meta Description</label>
                        <textarea class="form-control" name="default_meta_description" rows="3"><?php echo htmlspecialchars($settings['default_meta_description'] ?? ''); ?></textarea>
                        <small class="text-muted">Used when page doesn't have specific description</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Default Meta Keywords</label>
                        <input type="text" class="form-control" name="default_meta_keywords"
                               value="<?php echo htmlspecialchars($settings['default_meta_keywords'] ?? ''); ?>">
                        <small class="text-muted">Comma-separated keywords</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Social Media</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook Page URL</label>
                        <input type="url" class="form-control" name="facebook_url"
                               value="<?php echo htmlspecialchars($settings['facebook_url'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter Handle</label>
                        <input type="text" class="form-control" name="twitter_handle"
                               value="<?php echo htmlspecialchars($settings['twitter_handle'] ?? ''); ?>"
                               placeholder="@yourusername">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">OG Image URL</label>
                        <input type="url" class="form-control" name="og_image"
                               value="<?php echo htmlspecialchars($settings['og_image'] ?? ''); ?>">
                        <small class="text-muted">Default image for social sharing (1200x630px recommended)</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Structured Data</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="enable_schema" value="1"
                                   <?php echo ($settings['enable_schema'] ?? 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Enable Schema.org Markup</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Save SEO Settings
                </button>
            </form>
            <?php endif; ?>

            <?php if ($activeTab === 'email'): ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action" value="save_email">

                <h5 class="mb-3">SMTP Configuration</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" class="form-control" name="smtp_host"
                               value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>"
                               placeholder="smtp.gmail.com">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" class="form-control" name="smtp_port"
                               value="<?php echo htmlspecialchars($settings['smtp_port'] ?? 587); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Username</label>
                        <input type="text" class="form-control" name="smtp_username"
                               value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" class="form-control" name="smtp_password"
                               value="<?php echo htmlspecialchars($settings['smtp_password'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SMTP Encryption</label>
                        <select class="form-select" name="smtp_encryption">
                            <option value="tls" <?php echo ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">From Email</label>
                        <input type="email" class="form-control" name="smtp_from_email"
                               value="<?php echo htmlspecialchars($settings['smtp_from_email'] ?? ''); ?>">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">From Name</label>
                        <input type="text" class="form-control" name="smtp_from_name"
                               value="<?php echo htmlspecialchars($settings['smtp_from_name'] ?? ''); ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Email Settings
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="testEmail()">
                        <i class="fas fa-paper-plane me-1"></i>Send Test Email
                    </button>
                </div>
            </form>
            <?php endif; ?>

            <?php if ($activeTab === 'backup'): ?>
            <h5 class="mb-3">Database Backup</h5>
            <p class="text-muted">Create a backup of your database. The backup will be downloaded as an SQL file.</p>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action" value="backup_database">

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important:</strong> Store backups securely. Never share database backups publicly.
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i>Download Database Backup
                </button>
            </form>

            <hr class="my-4">

            <h5 class="mb-3">System Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>PHP Version:</strong></td>
                            <td><?php echo phpversion(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>MySQL Version:</strong></td>
                            <td><?php echo getMySQLVersion(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Server Software:</strong></td>
                            <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Max Upload Size:</strong></td>
                            <td><?php echo ini_get('upload_max_filesize'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Memory Limit:</strong></td>
                            <td><?php echo ini_get('memory_limit'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Post Max Size:</strong></td>
                            <td><?php echo ini_get('post_max_size'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Max Execution Time:</strong></td>
                            <td><?php echo ini_get('max_execution_time'); ?>s</td>
                        </tr>
                        <tr>
                            <td><strong>Disk Space Free:</strong></td>
                            <td><?php echo formatBytes(disk_free_space('/')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function testEmail() {
    const email = prompt('Enter email address to send test email:');
    if (email) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="action" value="test_email">
            <input type="hidden" name="test_email" value="${email}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php
require_once 'includes/footer.php';

// FUNCTIONS

function getAllSettings() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT config_key, config_value FROM settings");
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['config_key']] = $row['config_value'];
        }
        return $settings;
    } catch (PDOException $e) {
        error_log("Get settings error: " . $e->getMessage());
        return [];
    }
}

function saveGeneralSettings($data) {
    global $pdo;
    try {
        $fields = [
            'site_name', 'site_url', 'site_description', 
            'contact_email', 'admin_email', 'maintenance_mode', 
            'enable_analytics', 'google_analytics_id', 'items_per_page'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO settings (config_key, config_value, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value), updated_at = NOW()
        ");
        
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            $stmt->execute([$field, $value]);
        }
        
        logActivity($_SESSION['admin_id'], 'update', 'Updated general settings');
        
        return ['success' => true, 'message' => 'General settings saved successfully!'];
    } catch (PDOException $e) {
        error_log("Save general settings error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error saving settings: ' . $e->getMessage()];
    }
}

function saveSEOSettings($data) {
    global $pdo;
    try {
        $fields = [
            'default_meta_title', 'default_meta_description', 'default_meta_keywords',
            'facebook_url', 'twitter_handle', 'og_image', 'enable_schema'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO settings (config_key, config_value, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value), updated_at = NOW()
        ");
        
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            $stmt->execute([$field, $value]);
        }
        
        logActivity($_SESSION['admin_id'], 'update', 'Updated SEO settings');
        
        return ['success' => true, 'message' => 'SEO settings saved successfully!'];
    } catch (PDOException $e) {
        error_log("Save SEO settings error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error saving settings: ' . $e->getMessage()];
    }
}

function saveEmailSettings($data) {
    global $pdo;
    try {
        $fields = [
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
            'smtp_encryption', 'smtp_from_email', 'smtp_from_name'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO settings (config_key, config_value, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value), updated_at = NOW()
        ");
        
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            $stmt->execute([$field, $value]);
        }
        
        logActivity($_SESSION['admin_id'], 'update', 'Updated email settings');
        
        return ['success' => true, 'message' => 'Email settings saved successfully!'];
    } catch (PDOException $e) {
        error_log("Save email settings error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error saving settings: ' . $e->getMessage()];
    }
}

function testEmailConfiguration($toEmail) {
    $settings = getAllSettings();
    
    try {
        $to = filter_var($toEmail, FILTER_VALIDATE_EMAIL);
        if (!$to) {
            return ['success' => false, 'message' => 'Invalid email address.'];
        }
        
        $subject = 'Test Email from ' . ($settings['site_name'] ?? 'Calculator Website');
        $message = '<html><body>';
        $message .= '<h2>Email Configuration Test</h2>';
        $message .= '<p>If you received this email, your SMTP configuration is working correctly!</p>';
        $message .= '<p>Sent from: ' . ($settings['site_name'] ?? 'Calculator Website') . '</p>';
        $message .= '<p>Time: ' . date('Y-m-d H:i:s') . '</p>';
        $message .= '</body></html>';
        
        $headers = "From: " . ($settings['smtp_from_email'] ?? 'noreply@example.com') . "\r\n";
        $headers .= "Reply-To: " . ($settings['smtp_from_email'] ?? 'noreply@example.com') . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        if (mail($to, $subject, $message, $headers)) {
            logActivity($_SESSION['admin_id'], 'test', "Sent test email to {$toEmail}");
            return ['success' => true, 'message' => 'Test email sent successfully! Check your inbox.'];
        } else {
            return ['success' => false, 'message' => 'Failed to send email. Check your SMTP settings.'];
        }
    } catch (Exception $e) {
        error_log("Test email error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

function backupDatabase() {
    global $pdo;
    try {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        $backup = "-- Calculator Website Database Backup\n";
        $backup .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $backup .= "-- MySQL Version: " . $pdo->query("SELECT VERSION()")->fetchColumn() . "\n\n";
        $backup .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $backup .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n";
        $backup .= "SET NAMES utf8mb4;\n\n";
        
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($tables as $table) {
            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
            $backup .= "-- Table structure for `{$table}`\n";
            $backup .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $backup .= $createStmt['Create Table'] . ";\n\n";
            
            $dataStmt = $pdo->query("SELECT * FROM `{$table}`");
            if ($dataStmt->rowCount() > 0) {
                $backup .= "-- Dumping data for table `{$table}`\n";
                while ($row = $dataStmt->fetch(PDO::FETCH_ASSOC)) {
                    $values = array_map(function($value) use ($pdo) {
                        return $value === null ? 'NULL' : $pdo->quote($value);
                    }, array_values($row));
                    $columns = '`' . implode('`, `', array_keys($row)) . '`';
                    $backup .= "INSERT INTO `{$table}` ($columns) VALUES (" . implode(', ', $values) . ");\n";
                }
                $backup .= "\n";
            }
        }
        
        $backup .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        logActivity($_SESSION['admin_id'], 'backup', "Created database backup from settings");
        
        return ['success' => true, 'filename' => $filename, 'data' => $backup];
    } catch (PDOException $e) {
        error_log("Backup error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Backup failed: ' . $e->getMessage()];
    }
}

function getMySQLVersion() {
    global $pdo;
    try {
        return $pdo->query("SELECT VERSION()")->fetchColumn();
    } catch (PDOException $e) {
        return 'Unknown';
    }
}

function formatBytes($bytes, $precision = 2) {
    if ($bytes == 0) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $pow = floor(log($bytes) / log(1024));
    $pow = min($pow, count($units) - 1);
    return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
}
?>