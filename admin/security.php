<?php
/**
 * Security Settings
 * Configure security and authentication settings
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();

$page_title = "Security Settings - Admin Panel";
$db = Database::getInstance();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_security') {
        $settings = [
            'force_https' => isset($_POST['force_https']) ? 1 : 0,
            'two_factor_required' => isset($_POST['two_factor_required']) ? 1 : 0,
            'password_min_length' => intval($_POST['password_min_length'] ?? 8),
            'password_require_uppercase' => isset($_POST['password_require_uppercase']) ? 1 : 0,
            'password_require_lowercase' => isset($_POST['password_require_lowercase']) ? 1 : 0,
            'password_require_numbers' => isset($_POST['password_require_numbers']) ? 1 : 0,
            'password_require_special' => isset($_POST['password_require_special']) ? 1 : 0,
            'session_timeout' => intval($_POST['session_timeout'] ?? 7200),
            'max_login_attempts' => intval($_POST['max_login_attempts'] ?? 5),
            'lockout_duration' => intval($_POST['lockout_duration'] ?? 900),
            'ip_whitelist' => sanitize_input($_POST['ip_whitelist'] ?? ''),
            'allowed_domains' => sanitize_input($_POST['allowed_domains'] ?? ''),
        ];
        
        foreach ($settings as $key => $value) {
            try {
                $db->query("
                    INSERT INTO settings (setting_key, setting_value) 
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
                ", ["security_{$key}", $value]);
            } catch (Exception $e) {
                error_log("Security settings update error: " . $e->getMessage());
            }
        }
        
        $_SESSION['success'] = "Security settings updated successfully.";
        AdminMiddleware::logAction('security_update', "Updated security settings");
        header('Location: /admin/security');
        exit;
    }
    
    if ($action === 'clear_sessions') {
        try {
            $db->query("DELETE FROM sessions WHERE user_id != ?", [$_SESSION['user_id']]);
            $_SESSION['success'] = "All other user sessions cleared.";
            AdminMiddleware::logAction('sessions_clear', "Cleared all sessions");
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to clear sessions.";
        }
        header('Location: /admin/security');
        exit;
    }
    
    if ($action === 'clear_login_attempts') {
        try {
            $db->query("TRUNCATE TABLE login_attempts");
            $_SESSION['success'] = "Login attempts cleared.";
            AdminMiddleware::logAction('login_attempts_clear', "Cleared login attempts");
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to clear login attempts.";
        }
        header('Location: /admin/security');
        exit;
    }
}

// Get current settings
try {
    $settingsData = $db->fetchAll("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'security_%'");
    $settings = [];
    foreach ($settingsData as $row) {
        $key = str_replace('security_', '', $row['setting_key']);
        $settings[$key] = $row['setting_value'];
    }
    
    // Get security stats
    $activeSessions = $db->fetchColumn("SELECT COUNT(*) FROM sessions WHERE last_activity > UNIX_TIMESTAMP() - 3600");
    $failedLogins = $db->fetchColumn("SELECT COUNT(*) FROM login_attempts WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
    $twoFactorEnabled = $db->fetchColumn("SELECT COUNT(*) FROM two_factor_auth WHERE enabled = 1");
    $recentBlocks = $db->fetchColumn("SELECT COUNT(*) FROM rate_limit_log WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
    
} catch (Exception $e) {
    error_log("Security settings fetch error: " . $e->getMessage());
    $settings = [];
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Security Settings</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Security Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($activeSessions); ?></h3>
                    <p>Active Sessions</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($failedLogins); ?></h3>
                    <p>Failed Logins (24h)</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($twoFactorEnabled); ?></h3>
                    <p>2FA Enabled Users</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($recentBlocks); ?></h3>
                    <p>Rate Limit Blocks (24h)</p>
                </div>
            </div>
        </div>

        <form method="POST">
            <input type="hidden" name="action" value="update_security">

            <!-- General Security -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>General Security</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="force_https" 
                                   <?php echo ($settings['force_https'] ?? 1) ? 'checked' : ''; ?>>
                            Force HTTPS
                        </label>
                        <small class="d-block">Redirect all HTTP requests to HTTPS</small>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="two_factor_required" 
                                   <?php echo ($settings['two_factor_required'] ?? 0) ? 'checked' : ''; ?>>
                            Require Two-Factor Authentication
                        </label>
                        <small class="d-block">Force all users to enable 2FA</small>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Password Requirements</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minimum Length</label>
                                <input type="number" 
                                       name="password_min_length" 
                                       class="form-control" 
                                       value="<?php echo intval($settings['password_min_length'] ?? 8); ?>"
                                       min="6" 
                                       max="32">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="password_require_uppercase" 
                                   <?php echo ($settings['password_require_uppercase'] ?? 1) ? 'checked' : ''; ?>>
                            Require Uppercase Letters
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="password_require_lowercase" 
                                   <?php echo ($settings['password_require_lowercase'] ?? 1) ? 'checked' : ''; ?>>
                            Require Lowercase Letters
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="password_require_numbers" 
                                   <?php echo ($settings['password_require_numbers'] ?? 1) ? 'checked' : ''; ?>>
                            Require Numbers
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="password_require_special" 
                                   <?php echo ($settings['password_require_special'] ?? 1) ? 'checked' : ''; ?>>
                            Require Special Characters
                        </label>
                    </div>
                </div>
            </div>

            <!-- Session & Login Security -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Session & Login Security</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Session Timeout (seconds)</label>
                                <input type="number" 
                                       name="session_timeout" 
                                       class="form-control" 
                                       value="<?php echo intval($settings['session_timeout'] ?? 7200); ?>"
                                       min="600" 
                                       max="86400">
                                <small>Default: 7200 (2 hours)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Max Login Attempts</label>
                                <input type="number" 
                                       name="max_login_attempts" 
                                       class="form-control" 
                                       value="<?php echo intval($settings['max_login_attempts'] ?? 5); ?>"
                                       min="3" 
                                       max="10">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lockout Duration (seconds)</label>
                                <input type="number" 
                                       name="lockout_duration" 
                                       class="form-control" 
                                       value="<?php echo intval($settings['lockout_duration'] ?? 900); ?>"
                                       min="300" 
                                       max="3600">
                                <small>Default: 900 (15 minutes)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IP & Domain Restrictions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>IP & Domain Restrictions</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Admin IP Whitelist</label>
                        <textarea name="ip_whitelist" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="One IP per line (leave empty to allow all)"><?php echo htmlspecialchars($settings['ip_whitelist'] ?? ''); ?></textarea>
                        <small>Restrict admin access to specific IPs</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Allowed Email Domains</label>
                        <textarea name="allowed_domains" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="example.com (leave empty to allow all)"><?php echo htmlspecialchars($settings['allowed_domains'] ?? ''); ?></textarea>
                        <small>Restrict registration to specific email domains</small>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Save Security Settings
                </button>
            </div>
        </form>

        <!-- Security Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Security Actions</h3>
            </div>
            <div class="card-body">
                <div class="security-actions">
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Clear all other user sessions?');">
                        <input type="hidden" name="action" value="clear_sessions">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sign-out-alt"></i> Clear All Sessions
                        </button>
                    </form>
                    
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Clear all failed login attempts?');">
                        <input type="hidden" name="action" value="clear_login_attempts">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-eraser"></i> Clear Login Attempts
                        </button>
                    </form>
                    
                    <a href="/admin/security/logs" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> View Security Logs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.security-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.form-actions {
    text-align: right;
    padding: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>

<?php include '../includes/footer.php'; ?>