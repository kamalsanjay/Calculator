<?php
/**
 * Two-Factor Authentication Setup
 * Enable/disable 2FA for account
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = "Two-Factor Authentication - Calculator";
$error = '';
$success = '';

// Get user data and 2FA status
try {
    $stmt = $db->prepare("SELECT username, email, avatar FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    // Check if 2FA is enabled
    $stmt = $db->prepare("SELECT enabled, secret FROM two_factor_auth WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $twofa = $stmt->fetch();
    $twofa_enabled = $twofa && $twofa['enabled'];
    
} catch (PDOException $e) {
    error_log("2FA error: " . $e->getMessage());
    $error = "An error occurred loading 2FA settings.";
}

// Handle 2FA enable/disable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'enable') {
        // Generate secret key
        $secret = base64_encode(random_bytes(32));
        
        try {
            // Store secret
            $stmt = $db->prepare("
                INSERT INTO two_factor_auth (user_id, secret, enabled) 
                VALUES (?, ?, 0)
                ON DUPLICATE KEY UPDATE secret = VALUES(secret)
            ");
            $stmt->execute([$_SESSION['user_id'], $secret]);
            
            // Generate QR code URL (using Google Charts API)
            $qr_code_url = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . 
                          urlencode("otpauth://totp/Calculator:{$user['email']}?secret={$secret}&issuer=Calculator");
            
            $success = "Scan the QR code with your authenticator app.";
            
        } catch (PDOException $e) {
            error_log("2FA enable error: " . $e->getMessage());
            $error = "An error occurred enabling 2FA.";
        }
        
    } elseif ($action === 'verify') {
        $code = $_POST['code'] ?? '';
        
        if (empty($code)) {
            $error = "Please enter the verification code.";
        } else {
            // TODO: Verify TOTP code
            // For now, just enable 2FA
            try {
                $stmt = $db->prepare("UPDATE two_factor_auth SET enabled = 1 WHERE user_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                
                $success = "Two-factor authentication enabled successfully!";
                $twofa_enabled = true;
                
            } catch (PDOException $e) {
                error_log("2FA verify error: " . $e->getMessage());
                $error = "An error occurred verifying the code.";
            }
        }
        
    } elseif ($action === 'disable') {
        $password = $_POST['password'] ?? '';
        
        if (empty($password)) {
            $error = "Please enter your password to disable 2FA.";
        } else {
            try {
                // Verify password
                $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $stored_password = $stmt->fetchColumn();
                
                if (!password_verify($password, $stored_password)) {
                    $error = "Incorrect password.";
                } else {
                    // Disable 2FA
                    $stmt = $db->prepare("UPDATE two_factor_auth SET enabled = 0 WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $success = "Two-factor authentication disabled.";
                    $twofa_enabled = false;
                }
            } catch (PDOException $e) {
                error_log("2FA disable error: " . $e->getMessage());
                $error = "An error occurred disabling 2FA.";
            }
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <img src="<?php echo $user['avatar'] ?? '/assets/images/default-avatar.png'; ?>" alt="Avatar">
                </div>
                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                
                <div class="profile-menu">
                    <a href="/auth/profile">Profile</a>
                    <a href="/auth/settings">Settings</a>
                    <a href="/auth/change-password">Change Password</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-shield-alt"></i> Two-Factor Authentication</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <div class="twofa-info mb-4">
                        <p>Two-factor authentication adds an extra layer of security to your account. When enabled, you'll need to enter a code from your authenticator app in addition to your password when logging in.</p>
                        
                        <div class="status-badge <?php echo $twofa_enabled ? 'status-enabled' : 'status-disabled'; ?>">
                            <i class="fas fa-<?php echo $twofa_enabled ? 'check-circle' : 'times-circle'; ?>"></i>
                            Status: <?php echo $twofa_enabled ? 'Enabled' : 'Disabled'; ?>
                        </div>
                    </div>

                    <?php if (!$twofa_enabled): ?>
                        <!-- Enable 2FA -->
                        <?php if (!isset($qr_code_url)): ?>
                            <h5>Enable Two-Factor Authentication</h5>
                            <p>Click the button below to set up 2FA for your account.</p>
                            
                            <form method="POST">
                                <input type="hidden" name="action" value="enable">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-shield-alt"></i> Enable 2FA
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- QR Code Display -->
                            <h5>Scan QR Code</h5>
                            <p>Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)</p>
                            
                            <div class="qr-code-container">
                                <img src="<?php echo $qr_code_url; ?>" alt="QR Code" class="qr-code">
                            </div>
                            
                            <div class="secret-key">
                                <label>Or enter this key manually:</label>
                                <code><?php echo $secret ?? ''; ?></code>
                            </div>
                            
                            <!-- Verification Form -->
                            <form method="POST" class="mt-4">
                                <input type="hidden" name="action" value="verify">
                                <div class="form-group">
                                    <label for="code">Enter Verification Code</label>
                                    <input 
                                        type="text" 
                                        id="code" 
                                        name="code" 
                                        class="form-control" 
                                        required
                                        placeholder="000000"
                                        maxlength="6"
                                        pattern="[0-9]{6}"
                                    >
                                    <small class="form-text">Enter the 6-digit code from your authenticator app</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Verify & Enable</button>
                                <a href="/auth/two-factor-auth" class="btn btn-secondary">Cancel</a>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Disable 2FA -->
                        <h5>Disable Two-Factor Authentication</h5>
                        <p>Enter your password to disable 2FA for your account.</p>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="disable">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-control" 
                                    required
                                >
                            </div>
                            
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times-circle"></i> Disable 2FA
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recommended Apps -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Recommended Authenticator Apps</h5>
                </div>
                <div class="card-body">
                    <div class="app-list">
                        <div class="app-item">
                            <i class="fab fa-google"></i>
                            <div>
                                <strong>Google Authenticator</strong>
                                <small>iOS & Android</small>
                            </div>
                        </div>
                        <div class="app-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Authy</strong>
                                <small>iOS, Android & Desktop</small>
                            </div>
                        </div>
                        <div class="app-item">
                            <i class="fas fa-lock"></i>
                            <div>
                                <strong>Microsoft Authenticator</strong>
                                <small>iOS & Android</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.1rem;
}

.status-enabled {
    background: #d4edda;
    color: #155724;
}

.status-disabled {
    background: #f8d7da;
    color: #721c24;
}

.qr-code-container {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin: 2rem 0;
}

.qr-code {
    max-width: 200px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
}

.secret-key {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin: 1rem 0;
}

.secret-key label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.secret-key code {
    display: block;
    padding: 0.75rem;
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    font-size: 1.1rem;
    letter-spacing: 2px;
}

.app-list {
    display: grid;
    gap: 1rem;
}

.app-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.app-item i {
    font-size: 2rem;
    color: #667eea;
}

.app-item strong {
    display: block;
}

.app-item small {
    color: #6c757d;
}
</style>

<?php include '../includes/footer.php'; ?>