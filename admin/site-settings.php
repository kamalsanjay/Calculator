<?php
/**
 * Professional Site Settings Manager
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();
        
        foreach ($_POST as $key => $value) {
            if ($key === 'csrf_token') continue;
            
            // Handle checkboxes
            if (strpos($key, '_enabled') !== false || strpos($key, '_mode') !== false) {
                $value = isset($_POST[$key]) ? '1' : '0';
            }
            
            $stmt = $db->prepare("
                UPDATE site_settings 
                SET setting_value = ?, updated_at = NOW() 
                WHERE setting_key = ?
            ");
            $stmt->execute([$value, $key]);
        }
        
        $db->commit();
        $success = 'Settings saved successfully! Some changes may require page refresh.';
    } catch (Exception $e) {
        $db->rollBack();
        $error = 'Failed to save settings: ' . $e->getMessage();
    }
}

// Get all settings grouped by category
try {
    $allSettings = $db->fetchAll("SELECT * FROM site_settings ORDER BY category, setting_key");
    
    $settings = [];
    foreach ($allSettings as $setting) {
        $settings[$setting['category']][] = $setting;
    }
} catch (Exception $e) {
    $settings = [];
    $error = 'Failed to load settings';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-cog"></i> Site Settings</h1>
                    <p>Manage all website configuration</p>
                </div>
                <div class="user-info">
                    <button type="button" onclick="document.getElementById('settingsForm').requestSubmit()" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save All Settings
                    </button>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="settingsForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                
                <!-- Settings Tabs -->
                <div class="settings-tabs">
                    <button type="button" class="tab-btn active" data-tab="general">
                        <i class="fas fa-globe"></i> General
                    </button>
                    <button type="button" class="tab-btn" data-tab="database">
                        <i class="fas fa-database"></i> Database
                    </button>
                    <button type="button" class="tab-btn" data-tab="email">
                        <i class="fas fa-envelope"></i> Email
                    </button>
                    <button type="button" class="tab-btn" data-tab="seo">
                        <i class="fas fa-search"></i> SEO
                    </button>
                    <button type="button" class="tab-btn" data-tab="ads">
                        <i class="fas fa-ad"></i> Ads
                    </button>
                    <button type="button" class="tab-btn" data-tab="maintenance">
                        <i class="fas fa-tools"></i> Maintenance
                    </button>
                    <button type="button" class="tab-btn" data-tab="advanced">
                        <i class="fas fa-code"></i> Advanced
                    </button>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    <?php foreach ($settings as $category => $categorySettings): ?>
                        <div class="tab-content <?php echo $category === 'general' ? 'active' : ''; ?>" id="tab-<?php echo $category; ?>">
                            <div class="content-card">
                                <div class="content-card-header">
                                    <h3><?php echo ucfirst($category); ?> Settings</h3>
                                </div>
                                <div class="content-card-body">
                                    <div class="settings-grid-two">
                                        <?php foreach ($categorySettings as $setting): ?>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <?php echo ucwords(str_replace('_', ' ', $setting['setting_key'])); ?>
                                                    <?php if ($setting['description']): ?>
                                                        <i class="fas fa-info-circle" title="<?php echo htmlspecialchars($setting['description']); ?>"></i>
                                                    <?php endif; ?>
                                                </label>
                                                
                                                <?php if ($setting['setting_type'] === 'checkbox'): ?>
                                                    <label class="form-checkbox">
                                                        <input type="checkbox" 
                                                               name="<?php echo $setting['setting_key']; ?>"
                                                               <?php echo $setting['setting_value'] === '1' ? 'checked' : ''; ?>>
                                                        <span>Enable</span>
                                                    </label>
                                                
                                                <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                                                    <textarea name="<?php echo $setting['setting_key']; ?>" 
                                                              class="form-control" 
                                                              rows="4"><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                                                
                                                <?php elseif ($setting['setting_type'] === 'password'): ?>
                                                    <input type="password" 
                                                           name="<?php echo $setting['setting_key']; ?>" 
                                                           class="form-control" 
                                                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                                                           autocomplete="new-password">
                                                
                                                <?php else: ?>
                                                    <input type="<?php echo $setting['setting_type']; ?>" 
                                                           name="<?php echo $setting['setting_key']; ?>" 
                                                           class="form-control" 
                                                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>">
                                                <?php endif; ?>
                                                
                                                <?php if ($setting['description']): ?>
                                                    <small class="form-text"><?php echo htmlspecialchars($setting['description']); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-actions-sticky">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save All Settings
                    </button>
                    <button type="button" onclick="location.reload()" class="btn btn-secondary btn-lg">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>

            <!-- Help Section -->
            <div class="content-card" style="margin-top: 2rem;">
                <div class="content-card-header">
                    <h3><i class="fas fa-question-circle"></i> Important Notes</h3>
                </div>
                <div class="content-card-body">
                    <ul class="help-list">
                        <li><strong>Database Settings:</strong> Changing database settings requires updating the config.php file and may cause connection errors if incorrect.</li>
                        <li><strong>Site URL:</strong> Must include the full URL including protocol (http:// or https://)</li>
                        <li><strong>Email Settings:</strong> Configure SMTP for reliable email delivery. Leave SMTP fields empty to use PHP mail().</li>
                        <li><strong>Maintenance Mode:</strong> When enabled, only admin users can access the website.</li>
                        <li><strong>Custom Code:</strong> Be careful when adding custom CSS/JS. Invalid code may break the website.</li>
                        <li><strong>Ads:</strong> Add your publisher IDs from AdSense or Adsterra, then update the code in includes/ads.php</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <style>
    .settings-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .tab-btn {
        padding: 0.875rem 1.5rem;
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        color: #495057;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tab-btn:hover {
        background: #e9ecef;
        color: #667eea;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }

    .tab-btn i {
        font-size: 1.1rem;
    }

    .settings-content {
        position: relative;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .settings-grid-two {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #495057;
    }

    .form-label i {
        color: #6c757d;
        cursor: help;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: normal;
    }

    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .form-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .form-actions-sticky {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        z-index: 100;
    }

    .help-list {
        list-style: none;
        padding: 0;
    }

    .help-list li {
        padding: 0.75rem;
        border-left: 3px solid #667eea;
        background: #f8f9fa;
        margin-bottom: 0.75rem;
        border-radius: 4px;
        line-height: 1.6;
    }

    .help-list strong {
        color: #667eea;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 1024px) {
        .settings-grid-two {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .settings-tabs {
            flex-direction: column;
        }

        .tab-btn {
            width: 100%;
            justify-content: center;
        }
    }
    </style>

    <script>
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.dataset.tab;
            
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });

    // Form validation
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        const url = document.querySelector('input[name="site_url"]').value;
        if (url && !url.match(/^https?:\/\//)) {
            alert('Site URL must start with http:// or https://');
            e.preventDefault();
            return false;
        }
        
        return confirm('Save all settings? This may affect website functionality.');
    });

    // Auto-save indicator
    let saveTimeout;
    document.querySelectorAll('.form-control, .form-checkbox input').forEach(input => {
        input.addEventListener('change', function() {
            clearTimeout(saveTimeout);
            const indicator = document.createElement('span');
            indicator.textContent = ' (unsaved)';
            indicator.style.color = '#dc3545';
            indicator.style.fontSize = '0.875rem';
            indicator.className = 'unsaved-indicator';
            
            const existing = this.parentElement.querySelector('.unsaved-indicator');
            if (existing) existing.remove();
            
            this.parentElement.appendChild(indicator);
        });
    });
    </script>
</body>
</html>