<?php
/**
 * Password Changed Template
 * Notification when password is changed
 */

$subject = "Your Password Has Been Changed";

ob_start();
?>

<h1>Password Changed Successfully ✓</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>This is a confirmation that the password for your Calculator account has been changed successfully.</p>

<div class="email-info-box">
    <p><strong>Change Details:</strong></p>
    <p>
        📅 Date: <?php echo date('F j, Y'); ?><br>
        🕐 Time: <?php echo date('g:i A'); ?><br>
        📍 IP Address: <?php echo $ipAddress ?? 'Unknown'; ?><br>
        💻 Device: <?php echo $userAgent ?? 'Unknown'; ?>
    </p>
</div>

<p>You can now log in with your new password at:</p>
<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/login" class="email-button">
        🔐 Log In to Your Account
    </a>
</p>

<div class="email-info-box" style="border-left-color: #dc3545; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>⚠️ Didn't make this change?</strong><br>
        If you didn't change your password, your account may be compromised. Please:
    </p>
    <ul style="margin: 10px 0 0 0;">
        <li><a href="<?php echo $siteUrl; ?>/password/reset">Reset your password immediately</a></li>
        <li><a href="<?php echo $siteUrl; ?>/contact">Contact our support team</a></li>
        <li>Review your <a href="<?php echo $siteUrl; ?>/security">security settings</a></li>
    </ul>
</div>

<p><strong>Security Recommendations:</strong></p>
<ul>
    <li>Enable two-factor authentication for extra security</li>
    <li>Use a unique password for each online account</li>
    <li>Consider using a password manager</li>
    <li>Regularly review your account activity</li>
</ul>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';