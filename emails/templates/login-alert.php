<?php
/**
 * Login Alert Template
 * Notification for new login from unrecognized device
 */

$subject = "New Login to Your Account";

ob_start();
?>

<h1>New Login Detected 🔔</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>We detected a new login to your Calculator account. If this was you, you can safely ignore this email.</p>

<div class="email-info-box">
    <p><strong>Login Details:</strong></p>
    <p>
        📅 Date: <?php echo date('F j, Y'); ?><br>
        🕐 Time: <?php echo date('g:i A T'); ?><br>
        📍 IP Address: <?php echo $ipAddress ?? 'Unknown'; ?><br>
        🌍 Location: <?php echo $location ?? 'Unknown'; ?><br>
        💻 Device: <?php echo $userAgent ?? 'Unknown'; ?><br>
        🌐 Browser: <?php echo $browser ?? 'Unknown'; ?>
    </p>
</div>

<?php if ($isNewDevice ?? false): ?>
<div class="email-info-box" style="border-left-color: #ffc107; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>ℹ️ New Device Detected</strong><br>
        This is the first time we've seen a login from this device.
    </p>
</div>
<?php endif; ?>

<div class="email-info-box" style="border-left-color: #dc3545; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>⚠️ Wasn't you?</strong><br>
        If you didn't log in from this location, secure your account immediately:
    </p>
</div>

<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/security" class="email-button" style="background-color: #dc3545;">
        🔒 Secure My Account
    </a>
</p>

<p><strong>Security Actions You Can Take:</strong></p>
<ul>
    <li><a href="<?php echo $siteUrl; ?>/password/reset">Change your password</a></li>
    <li><a href="<?php echo $siteUrl; ?>/security/sessions">Review active sessions</a></li>
    <li><a href="<?php echo $siteUrl; ?>/security/2fa">Enable two-factor authentication</a></li>
    <li><a href="<?php echo $siteUrl; ?>/contact">Contact our support team</a></li>
</ul>

<p><strong>Why am I getting this email?</strong></p>
<p style="font-size: 14px; color: #6c757d;">
    We send login alerts to help you keep your account secure. These notifications help you quickly identify unauthorized access attempts.
</p>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';