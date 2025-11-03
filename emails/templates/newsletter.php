<?php
/**
 * Newsletter Template
 * Monthly newsletter to subscribers
 */

$subject = "Calculator Newsletter - " . date('F Y');

ob_start();
?>

<h1>📰 Calculator Monthly Newsletter</h1>

<p>Hi <?php echo htmlspecialchars($username ?? 'Calculator User'); ?>,</p>

<p>Here's what's new this month at Calculator!</p>

<div style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; padding: 30px; border-radius: 8px; margin: 30px 0; text-align: center;">
    <h2 style="margin: 0 0 10px 0; color: white;">🎉 What's New</h2>
    <p style="margin: 0; font-size: 18px;">5 New Calculators Added!</p>
</div>

<h2>🆕 New Calculators</h2>
<ul>
    <li><strong>Carbon Footprint Calculator</strong> - Track your environmental impact</li>
    <li><strong>Solar Panel ROI Calculator</strong> - Calculate savings from solar energy</li>
    <li><strong>Macro Nutrient Calculator</strong> - Plan your perfect diet</li>
    <li><strong>Retirement Income Calculator</strong> - Plan your retirement finances</li>
    <li><strong>Pet Care Cost Calculator</strong> - Budget for your furry friends</li>
</ul>

<p style="text-align: center;">
    <a href="<?php echo $siteUrl; ?>/calculators?filter=new" class="email-button">
        🔍 Explore New Calculators
    </a>
</p>

<div class="divider"></div>

<h2>📊 Most Popular This Month</h2>
<ol>
    <li><a href="<?php echo $siteUrl; ?>/calculators/financial/mortgage-calculator">Mortgage Calculator</a> - 125K uses</li>
    <li><a href="<?php echo $siteUrl; ?>/calculators/health/bmi-calculator">BMI Calculator</a> - 98K uses</li>
    <li><a href="<?php echo $siteUrl; ?>/calculators/math/percentage-calculator">Percentage Calculator</a> - 87K uses</li>
</ol>

<div class="divider"></div>

<h2>💡 Calculator Tip of the Month</h2>
<div class="email-info-box">
    <p><strong>Did you know?</strong> You can save your calculations for future reference! Just click the "Save" button after any calculation, and access your history anytime from your dashboard.</p>
    <p style="text-align: center; margin-top: 15px;">
        <a href="<?php echo $siteUrl; ?>/dashboard">View My Saved Calculations →</a>
    </p>
</div>

<div class="divider"></div>

<h2>📚 Featured Guide</h2>
<p><strong>Understanding Compound Interest:</strong> Learn how compound interest can help grow your savings exponentially. <a href="<?php echo $siteUrl; ?>/guides/compound-interest">Read the full guide →</a></p>

<div class="divider"></div>

<h2>🎯 Quick Stats</h2>
<div style="display: flex; gap: 20px; margin: 20px 0;">
    <div style="flex: 1; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 32px; font-weight: 700; color: #007bff;">300+</div>
        <div style="color: #6c757d;">Calculators</div>
    </div>
    <div style="flex: 1; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 32px; font-weight: 700; color: #28a745;">2M+</div>
        <div style="color: #6c757d;">Calculations</div>
    </div>
    <div style="flex: 1; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 32px; font-weight: 700; color: #ffc107;">100K+</div>
        <div style="color: #6c757d;">Users</div>
    </div>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="<?php echo $siteUrl; ?>" class="email-button">
        🧮 Start Calculating
    </a>
</p>

<p style="text-align: center; font-size: 14px; color: #6c757d; margin-top: 30px;">
    You're receiving this because you subscribed to our newsletter.<br>
    <a href="<?php echo $siteUrl; ?>/unsubscribe">Unsubscribe</a> • 
    <a href="<?php echo $siteUrl; ?>/preferences">Update Preferences</a>
</p>

<p>
    <strong>The Calculator Team</strong><br>
    <a href="mailto:support@calculator.com">support@calculator.com</a>
</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/base.php';
 