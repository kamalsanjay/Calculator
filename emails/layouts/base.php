<?php
/**
 * Base Email Layout
 * Provides consistent styling for all emails
 */

$siteName = getenv('SITE_NAME') ?: 'Calculator';
$siteUrl = getenv('SITE_URL') ?: 'https://calculator.com';
$primaryColor = '#007bff';
$textColor = '#333333';
$backgroundColor = '#f5f7fa';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $subject ?? 'Email from ' . $siteName; ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: <?php echo $backgroundColor; ?>;
            color: <?php echo $textColor; ?>;
            line-height: 1.6;
        }
        .email-wrapper {
            width: 100%;
            background-color: <?php echo $backgroundColor; ?>;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, #0056b3 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-logo {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            display: inline-block;
        }
        .email-logo-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h1 {
            margin: 0 0 20px 0;
            font-size: 24px;
            color: <?php echo $textColor; ?>;
        }
        .email-body p {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #666666;
        }
        .email-button {
            display: inline-block;
            padding: 14px 32px;
            background-color: <?php echo $primaryColor; ?>;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }
        .email-button:hover {
            background-color: #0056b3;
        }
        .email-info-box {
            background-color: #f8f9fa;
            border-left: 4px solid <?php echo $primaryColor; ?>;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .email-footer a {
            color: <?php echo $primaryColor; ?>;
            text-decoration: none;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6c757d;
            text-decoration: none;
            font-size: 24px;
        }
        .divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .email-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <div class="email-logo-icon">🧮</div>
                <a href="<?php echo $siteUrl; ?>" class="email-logo">
                    <?php echo $siteName; ?>
                </a>
            </div>

            <!-- Body Content -->
            <div class="email-body">
                <?php echo $content ?? ''; ?>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p><strong><?php echo $siteName; ?></strong></p>
                <p>Your trusted calculator for 300+ tools</p>
                
                <div class="social-links">
                    <a href="<?php echo $siteUrl; ?>/facebook">📘</a>
                    <a href="<?php echo $siteUrl; ?>/twitter">🐦</a>
                    <a href="<?php echo $siteUrl; ?>/linkedin">💼</a>
                </div>
                
                <div class="divider"></div>
                
                <p>
                    <a href="<?php echo $siteUrl; ?>">Visit Website</a> • 
                    <a href="<?php echo $siteUrl; ?>/help">Help Center</a> • 
                    <a href="<?php echo $siteUrl; ?>/contact">Contact Us</a>
                </p>
                
                <p style="font-size: 12px; color: #999;">
                    You're receiving this email because you have an account with <?php echo $siteName; ?>.
                    <br>
                    <a href="<?php echo $siteUrl; ?>/unsubscribe">Unsubscribe from emails</a>
                </p>
                
                <p style="font-size: 12px; color: #999;">
                    © <?php echo date('Y'); ?> <?php echo $siteName; ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>