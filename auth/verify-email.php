<?php
/**
 * Email Verification Page
 * Verify user email address
 */

require_once '../config.php';

$page_title = "Verify Email - Calculator";
$error = '';
$success = '';
$token = $_GET['token'] ?? '';

if (!empty($token)) {
    try {
        // Find verification record
        $stmt = $db->prepare("
            SELECT ev.user_id, u.email 
            FROM email_verifications ev
            JOIN users u ON ev.user_id = u.id
            WHERE ev.token = ? AND ev.expires_at > NOW()
        ");
        $stmt->execute([hash('sha256', $token)]);
        $verification = $stmt->fetch();
        
        if ($verification) {
            // Update user email_verified status
            $stmt = $db->prepare("UPDATE users SET email_verified = 1 WHERE id = ?");
            $stmt->execute([$verification['user_id']]);
            
            // Delete verification token
            $stmt = $db->prepare("DELETE FROM email_verifications WHERE user_id = ?");
            $stmt->execute([$verification['user_id']]);
            
            $success = "Email verified successfully! You can now login to your account.";
        } else {
            $error = "Invalid or expired verification token.";
        }
    } catch (PDOException $e) {
        error_log("Email verification error: " . $e->getMessage());
        $error = "An error occurred. Please try again.";
    }
} else {
    $error = "No verification token provided.";
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Email Verification</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="auth-links">
            <a href="/auth/login" class="btn btn-primary btn-block">Go to Login</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>