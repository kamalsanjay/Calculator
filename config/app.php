<?php
/**
 * Application Configuration
 * General application settings and configurations
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => getenv('APP_NAME') ?: 'Calculator',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    | Values: development, production, staging
    */
    'env' => getenv('APP_ENV') ?: 'development',

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => filter_var(getenv('APP_DEBUG') ?: true, FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */
    'url' => getenv('APP_URL') ?: 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Locale Configuration
    |--------------------------------------------------------------------------
    */
    'locale' => 'en',
    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode
    |--------------------------------------------------------------------------
    */
    'maintenance_mode' => filter_var(getenv('MAINTENANCE_MODE') ?: false, FILTER_VALIDATE_BOOLEAN),
    'maintenance_message' => 'We are currently performing scheduled maintenance. Please check back soon.',
    'maintenance_allowed_ips' => [
        '127.0.0.1',
        '::1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => true,
        'level' => 'error', // debug, info, warning, error, critical
        'path' => LOGS_PATH . '/error.log',
        'max_files' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
    'pagination' => [
        'per_page' => 20,
        'max_per_page' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Configuration
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'max_size' => 10 * 1024 * 1024, // 10MB in bytes
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'],
        'path' => UPLOADS_PATH,
    ],

    /*
    |--------------------------------------------------------------------------
    | Date and Time Formats
    |--------------------------------------------------------------------------
    */
    'date_format' => 'Y-m-d',
    'time_format' => 'H:i:s',
    'datetime_format' => 'Y-m-d H:i:s',
    'display_date_format' => 'F j, Y',
    'display_datetime_format' => 'F j, Y g:i A',

    /*
    |--------------------------------------------------------------------------
    | Calculator Settings
    |--------------------------------------------------------------------------
    */
    'calculators' => [
        'total_count' => 296,
        'categories_count' => 14,
        'enable_history' => true,
        'max_history_items' => 50,
        'enable_save' => true,
        'enable_share' => true,
        'enable_print' => true,
        'enable_pdf_export' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Settings
    |--------------------------------------------------------------------------
    */
    'theme' => [
        'default' => 'light',
        'allow_user_toggle' => true,
        'themes' => ['light', 'dark'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    */
    'social' => [
        'facebook' => 'https://facebook.com/calculator',
        'twitter' => 'https://twitter.com/calculator',
        'instagram' => 'https://instagram.com/calculator',
        'linkedin' => 'https://linkedin.com/company/calculator',
        'youtube' => 'https://youtube.com/calculator',
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'contact' => [
        'email' => 'support@calculator.com',
        'phone' => '+1 (555) 123-4567',
        'address' => '123 Calculator Street, Tech City, TC 12345',
    ],

    /*
    |--------------------------------------------------------------------------
    | Features Toggle
    |--------------------------------------------------------------------------
    */
    'features' => [
        'user_registration' => true,
        'social_login' => true,
        'two_factor_auth' => true,
        'email_verification' => true,
        'newsletter' => true,
        'comments' => false,
        'ratings' => true,
        'favorites' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Third-Party Services
    |--------------------------------------------------------------------------
    */
    'services' => [
        'google_analytics' => [
            'enabled' => true,
            'tracking_id' => getenv('GA_TRACKING_ID'),
        ],
        'google_adsense' => [
            'enabled' => filter_var(getenv('ADSENSE_ENABLED') ?: true, FILTER_VALIDATE_BOOLEAN),
            'client_id' => getenv('ADSENSE_CLIENT_ID'),
        ],
        'recaptcha' => [
            'enabled' => false,
            'site_key' => '',
            'secret_key' => '',
        ],
    ],
];