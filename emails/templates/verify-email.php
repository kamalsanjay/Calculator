<?php
/**
 * Email Verification Template
 * Sent to verify user's email address
 */

$subject = "Verify Your Email Address";

ob_start();
?>

<h1>Verify Your Email Address 📧</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>Thanks for signing up for Calculator! To complete your registration and access all features, please verify your email address by clicking the button below:</p>

<p style="text-align: center;">
    <a href="<?php echo $verificationUrl ?? '#'; ?>" class="email-button">
        ✓ Verify Email Address
    </a>
</p>

<p>Or copy and paste this link into your browser:</p>
<div class="email-info-box">
    <p style="word-break: break-all; font-size: 14px;">
        <?php echo $verificationUrl ?? '#'; ?>
    </p>
</div>

<p><strong>Why verify your email?</strong></p>
<ul>
    <li>Access all calculator features</li>
    <li>Save your calculations for future reference</li>
    <li>Receive important account updates</li>
    <li>Enhanced account security</li>
</ul>

<p style="color: #dc3545;">
    <strong>⚠️ This link will expire in 24 hours.</strong>
</p>

<p>If you didn't create an account with Calculator, please ignore this email or <a href="<?php echo $siteUrl; ?>/contact">contact us</a> if you have concerns.</p>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';