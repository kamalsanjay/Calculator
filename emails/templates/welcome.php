<?php
/**
 * Welcome Email Template
 * Sent when a new user registers
 */

$subject = "Welcome to Calculator!";

ob_start();
?>

<h1>Welcome to Calculator! 🎉</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'there'); ?>,</p>

<p>Thank you for joining Calculator! We're excited to have you as part of our community of over 100,000 users who trust us for their calculation needs.</p>

<p>With Calculator, you now have access to:</p>

<div class="email-info-box">
    <p><strong>✓ 300+ Professional Calculators</strong><br>From financial planning to health metrics</p>
    <p><strong>✓ Save Your Calculations</strong><br>Access your history anytime, anywhere</p>
    <p><strong>✓ Ad-Free Experience</strong><br>Focus on what matters without distractions</p>
    <p><strong>✓ Mobile & Desktop Access</strong><br>Calculate on the go or at your desk</p>
</div>

<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/calculators" class="email-button">
        🧮 Explore All Calculators
    </a>
</p>

<p><strong>Popular Calculators to Get Started:</strong></p>
<ul>
    <li><a href="<?php echo $siteUrl; ?>/calculators/financial/mortgage-calculator">Mortgage Calculator</a></li>
    <li><a href="<?php echo $siteUrl; ?>/calculators/health/bmi-calculator">BMI Calculator</a></li>
    <li><a href="<?php echo $siteUrl; ?>/calculators/math/percentage-calculator">Percentage Calculator</a></li>
    <li><a href="<?php echo $siteUrl; ?>/calculators/conversion/temperature-converter">Temperature Converter</a></li>
</ul>

<p>Need help getting started? Check out our <a href="<?php echo $siteUrl; ?>/help">Help Center</a> or <a href="<?php echo $siteUrl; ?>/contact">contact our support team</a>.</p>

<p>Happy calculating!</p>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';