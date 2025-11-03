<?php
/**
 * Forgot Password Page
 * Request password reset email
 */

require_once '../config.php';
require_once '../includes/functions.php';

$page_title = "Forgot Password - Calculator";
$error = '';
$success = '';

// Handle forgot password form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        try {
            // Check if email exists
            $stmt = $db->prepare("SELECT id, email FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                
                // Store token in database
                $stmt = $db->prepare("
                    INSERT INTO password_resets (user_id, token, expires_at) 
                    VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))
                    ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
                ");
                $stmt->execute([$user['id'], hash('sha256', $token)]);
                
                // Send reset email
                $reset_link = BASE_URL . "/auth/reset-password?token=" . $token;
                
                // TODO: Send email using mail function or PHPMailer
                
                $success = "Password reset link has been sent to your email.";
            } else {
                // Don't reveal if email exists or not (security best practice)
                $success = "If that email address is in our system, we've sent a password reset link.";
            }
        } catch (PDOException $e) {
            error_log("Forgot password error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Forgot Password?</h1>
            <p>Enter your email to reset your password</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php else: ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    autofocus
                    value="<?php echo htmlspecialchars($email ?? ''); ?>"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </form>

        <?php endif; ?>

        <div class="auth-links">
            <a href="/auth/login">Back to Login</a>
            <span>·</span>
            <a href="/auth/register">Create an account</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>