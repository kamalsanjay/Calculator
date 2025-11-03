<?php
/**
 * Account Deleted Template
 * Confirmation when account is deleted
 */

$subject = "Your Account Has Been Deleted";

ob_start();
?>

<h1>Account Deletion Confirmed 👋</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>This email confirms that your Calculator account has been permanently deleted as requested.</p>

<div class="email-info-box">
    <p><strong>Deletion Details:</strong></p>
    <p>
        📅 Date: <?php echo date('F j, Y'); ?><br>
        🕐 Time: <?php echo date('g:i A T'); ?><br>
        📧 Email: <?php echo htmlspecialchars($email ?? ''); ?>
    </p>
</div>

<p><strong>What's been deleted:</strong></p>
<ul>
    <li>Your personal information and account data</li>
    <li>All saved calculations and history</li>
    <li>Account preferences and settings</li>
    <li>Newsletter subscriptions</li>
</ul>

<p><strong>What we've kept:</strong></p>
<ul>
    <li>Anonymous usage statistics (no personal data)</li>
    <li>Legal and compliance records (as required by law)</li>
</ul>

<div class="email-info-box" style="border-left-color: #ffc107; background-color: #fff3cd;">
    <p style="margin: 0;">
        <strong>ℹ️ Didn't request this?</strong><br>
        If you didn't request account deletion, someone may have accessed your account. Please <a href="<?php echo $siteUrl; ?>/contact">contact our support team</a> immediately.
    </p>
</div>

<p><strong>Want to come back?</strong></p>
<p>You're always welcome to create a new account. However, your previous data cannot be recovered.</p>

<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/register" class="email-button">
        ↩️ Create New Account
    </a>
</p>

<p>We're sorry to see you go! If you have a moment, we'd love to know why you decided to leave. Your feedback helps us improve:</p>

<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/feedback?reason=account-deletion">Share Feedback</a>
</p>

<p>Thank you for using Calculator. We wish you all the best!</p>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';