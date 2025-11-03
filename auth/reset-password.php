<?php
/**
 * Reset Password Page
 * Set new password with reset token
 */

require_once '../config.php';
require_once '../includes/functions.php';

$page_title = "Reset Password - Calculator";
$error = '';
$success = '';
$token = $_GET['token'] ?? '';
$valid_token = false;

// Verify token
if (!empty($token)) {
    try {
        $stmt = $db->prepare("
            SELECT pr.user_id, u.email 
            FROM password_resets pr
            JOIN users u ON pr.user_id = u.id
            WHERE pr.token = ? AND pr.expires_at > NOW()
        ");
        $stmt->execute([hash('sha256', $token)]);
        $reset_data = $stmt->fetch();
        
        if ($reset_data) {
            $valid_token = true;
        } else {
            $error = "Invalid or expired reset token.";
        }
    } catch (PDOException $e) {
        error_log("Reset password error: " . $e->getMessage());
        $error = "An error occurred. Please try again.";
    }
}

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($password) || empty($confirm_password)) {
        $error = "Both password fields are required.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Update password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$password_hash, $reset_data['user_id']]);
            
            // Delete used reset token
            $stmt = $db->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $stmt->execute([$reset_data['user_id']]);
            
            $success = "Password reset successful! You can now login with your new password.";
            $valid_token = false; // Prevent form from showing again
        } catch (PDOException $e) {
            error_log("Reset password error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Reset Password</h1>
            <p>Enter your new password</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <div class="auth-links">
                <a href="/auth/login" class="btn btn-primary btn-block">Go to Login</a>
            </div>
        <?php elseif ($valid_token): ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="password">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required
                    minlength="8"
                    autofocus
                >
                <small class="form-text">Minimum 8 characters</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="form-control" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>

        <?php endif; ?>

        <div class="auth-links">
            <a href="/auth/login">Back to Login</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>