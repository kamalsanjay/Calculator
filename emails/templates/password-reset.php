<?php
/**
 * Password Reset Template
 * Sent when user requests password reset
 */

$subject = "Reset Your Password";

ob_start();
?>

<h1>Reset Your Password 🔐</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>We received a request to reset the password for your Calculator account. Click the button below to create a new password:</p>

<p style="text-align: center;">
    <a href="<?php echo $resetUrl ?? '#'; ?>" class="email-button">
        🔑 Reset Password
    </a>
</p>

<p>Or copy and paste this link into your browser:</p>
<div class="email-info-box">
    <p style="word-break: break-all; font-size: 14px;">
        <?php echo $resetUrl ?? '#'; ?>
    </p>
</div>

<p style="color: #dc3545;">
    <strong>⚠️ This link will expire in 1 hour for security reasons.</strong>
</p>

<p><strong>Security Tips:</strong></p>
<ul>
    <li>Use a strong, unique password</li>
    <li>Include uppercase, lowercase, numbers, and symbols</li>
    <li>Make it at least 8 characters long</li>
    <li>Don't reuse passwords from other sites</li>
</ul>

<div class="email-info-box" style="border-left-color: #dc3545; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>⚠️ Didn't request this?</strong><br>
        If you didn't request a password reset, please ignore this email. Your password will remain unchanged. You may want to <a href="<?php echo $siteUrl; ?>/security">review your account security</a>.
    </p>
</div>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';