<?php
/**
 * Change Password Page
 * Allow users to update their password
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = "Change Password - Calculator";
$error = '';
$success = '';

// Get user data
try {
    $stmt = $db->prepare("SELECT username, email, avatar FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    error_log("Change password error: " . $e->getMessage());
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (strlen($new_password) < 8) {
        $error = "New password must be at least 8 characters long.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } else {
        try {
            // Verify current password
            $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $stored_password = $stmt->fetchColumn();
            
            if (!password_verify($current_password, $stored_password)) {
                $error = "Current password is incorrect.";
            } else {
                // Update password
                $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$new_password_hash, $_SESSION['user_id']]);
                
                // Send notification email
                // TODO: Send email notification
                
                $success = "Password changed successfully!";
            }
        } catch (PDOException $e) {
            error_log("Password change error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
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
                    <a href="/auth/change-password" class="active">Change Password</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Change Password</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <div class="password-requirements mb-4">
                        <h6>Password Requirements:</h6>
                        <ul>
                            <li>At least 8 characters long</li>
                            <li>Contains uppercase and lowercase letters</li>
                            <li>Contains numbers</li>
                            <li>Contains special characters (@$!%*?&)</li>
                        </ul>
                    </div>

                    <form method="POST" id="changePasswordForm">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    class="form-control" 
                                    required
                                >
                                <button type="button" class="toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password" 
                                    class="form-control" 
                                    required
                                    minlength="8"
                                >
                                <button type="button" class="toggle-password" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength" id="passwordStrength"></div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    id="confirm_password" 
                                    name="confirm_password" 
                                    class="form-control" 
                                    required
                                >
                                <button type="button" class="toggle-password" data-target="confirm_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                        <a href="/auth/profile" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Security Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="security-tips">
                        <li><i class="fas fa-check-circle"></i> Use a unique password for this account</li>
                        <li><i class="fas fa-check-circle"></i> Don't share your password with anyone</li>
                        <li><i class="fas fa-check-circle"></i> Change your password regularly</li>
                        <li><i class="fas fa-check-circle"></i> Enable two-factor authentication for extra security</li>
                    </ul>
                    
                    <a href="/auth/two-factor-auth" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-shield-alt"></i> Setup Two-Factor Authentication
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.password-requirements {
    background: #f8f9fa;
    border-left: 4px solid #667eea;
    padding: 1rem 1.5rem;
    border-radius: 8px;
}

.password-requirements h6 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.password-requirements ul {
    margin: 0;
    padding-left: 1.5rem;
}

.password-requirements li {
    margin-bottom: 0.25rem;
    color: #6c757d;
}

.password-input-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 0.5rem;
}

.toggle-password:hover {
    color: #343a40;
}

.password-strength {
    height: 4px;
    background: #dee2e6;
    border-radius: 2px;
    margin-top: 0.5rem;
    overflow: hidden;
}

.password-strength::after {
    content: '';
    display: block;
    height: 100%;
    transition: 0.3s ease;
}

.password-strength.weak::after {
    width: 33%;
    background: #dc3545;
}

.password-strength.medium::after {
    width: 66%;
    background: #ffc107;
}

.password-strength.strong::after {
    width: 100%;
    background: #28a745;
}

.security-tips {
    list-style: none;
    padding: 0;
}

.security-tips li {
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.security-tips i {
    color: #28a745;
}
</style>

<script>
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.dataset.target;
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Password strength indicator
const newPassword = document.getElementById('new_password');
const strengthIndicator = document.getElementById('passwordStrength');

newPassword.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[@$!%*?&]/.test(password)) strength++;
    
    strengthIndicator.className = 'password-strength';
    if (strength === 0) {
        strengthIndicator.className += '';
    } else if (strength <= 2) {
        strengthIndicator.className += ' weak';
    } else if (strength === 3) {
        strengthIndicator.className += ' medium';
    } else {
        strengthIndicator.className += ' strong';
    }
});

// Form validation
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;
    
    if (newPass !== confirmPass) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>

<?php include '../includes/footer.php'; ?>