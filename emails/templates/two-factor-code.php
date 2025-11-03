<?php
/**
 * Two-Factor Authentication Code Template
 * Sent when user needs 2FA code
 */

$subject = "Your Two-Factor Authentication Code";

ob_start();
?>

<h1>Your Verification Code 🔐</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>You're receiving this email because a two-factor authentication code was requested for your Calculator account.</p>

<p style="text-align: center; margin: 40px 0;">
    <span style="display: inline-block; background: #f8f9fa; padding: 20px 40px; border-radius: 8px; font-size: 32px; font-weight: 700; letter-spacing: 8px; color: #007bff; border: 2px dashed #007bff;">
        <?php echo $code ?? '000000'; ?>
    </span>
</p>

<p style="text-align: center; font-size: 14px; color: #6c757d;">
    Enter this code to complete your login
</p>

<div class="email-info-box">
    <p><strong>Login Details:</strong></p>
    <p>
        📅 Date: <?php echo date('F j, Y'); ?><br>
        🕐 Time: <?php echo date('g:i A'); ?><br>
        📍 IP Address: <?php echo $ipAddress ?? 'Unknown'; ?><br>
        💻 Device: <?php echo substr($userAgent ?? 'Unknown', 0, 50); ?>...
    </p>
</div>

<p style="color: #dc3545;">
    <strong>⚠️ This code will expire in 10 minutes.</strong>
</p>

<div class="email-info-box" style="border-left-color: #dc3545; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>⚠️ Didn't try to log in?</strong><br>
        If this wasn't you, someone may be trying to access your account. We recommend:
    </p>
    <ul style="margin: 10px 0 0 0;">
        <li><a href="<?php echo $siteUrl; ?>/password/reset">Change your password immediately</a></li>
        <li><a href="<?php echo $siteUrl; ?>/contact">Contact our support team</a></li>
    </ul>
</div>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';