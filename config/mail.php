<?php
/**
 * Email Configuration
 * SMTP and email settings
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    | Values: smtp, sendmail, mail
    */
    'default' => 'smtp',

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */
    'mailers' => [
        'smtp' => [
            'host' => getenv('MAIL_HOST') ?: 'smtp.gmail.com',
            'port' => getenv('MAIL_PORT') ?: 587,
            'username' => getenv('MAIL_USERNAME'),
            'password' => getenv('MAIL_PASSWORD'),
            'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls', // tls or ssl
            'auth' => true,
            'timeout' => 30,
        ],

        'sendmail' => [
            'path' => '/usr/sbin/sendmail -bs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | From Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => getenv('MAIL_FROM_ADDRESS') ?: 'noreply@calculator.com',
        'name' => getenv('MAIL_FROM_NAME') ?: 'Calculator Website',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reply To Address
    |--------------------------------------------------------------------------
    */
    'reply_to' => [
        'address' => 'support@calculator.com',
        'name' => 'Calculator Support',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Templates
    |--------------------------------------------------------------------------
    */
    'templates' => [
        'path' => BASE_PATH . '/emails/templates',
        'layout' => BASE_PATH . '/emails/layouts/base.php',
        'cache' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Queue
    |--------------------------------------------------------------------------
    */
    'queue' => [
        'enabled' => false,
        'connection' => 'default',
        'table' => 'email_queue',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => true,
        'log_file' => LOGS_PATH . '/email.log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */
    'verification' => [
        'enabled' => true,
        'token_lifetime' => 24 * 60 * 60, // 24 hours in seconds
        'verify_url' => BASE_URL . '/auth/verify-email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */
    'password_reset' => [
        'token_lifetime' => 60 * 60, // 1 hour in seconds
        'reset_url' => BASE_URL . '/auth/reset-password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Content Settings
    |--------------------------------------------------------------------------
    */
    'content' => [
        'charset' => 'UTF-8',
        'html' => true,
        'line_length' => 70,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'enabled' => true,
        'max_per_hour' => 50,
        'max_per_day' => 200,
    ],

    /*
    |--------------------------------------------------------------------------
    | Newsletter Configuration
    |--------------------------------------------------------------------------
    */
    'newsletter' => [
        'enabled' => true,
        'subscription_table' => 'newsletter_subscriptions',
        'double_opt_in' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Testing
    |--------------------------------------------------------------------------
    */
    'testing' => [
        'enabled' => false,
        'test_email' => 'test@calculator.com',
    ],
];