<?php
/**
 * Security Configuration
 * Security settings and protections
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */
    'key' => getenv('APP_KEY') ?: 'base64:your-32-character-secret-key-here',

    /*
    |--------------------------------------------------------------------------
    | Encryption Cipher
    |--------------------------------------------------------------------------
    */
    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    */
    'csrf' => [
        'enabled' => true,
        'token_name' => 'csrf_token',
        'header_name' => 'X-CSRF-TOKEN',
        'regenerate_on_use' => false,
        'expire_time' => 7200, // 2 hours in seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | XSS Protection
    |--------------------------------------------------------------------------
    */
    'xss' => [
        'enabled' => true,
        'auto_clean_input' => true,
        'allowed_tags' => '<p><a><strong><em><ul><ol><li><br>',
    ],

    /*
    |--------------------------------------------------------------------------
    | SQL Injection Protection
    |--------------------------------------------------------------------------
    */
    'sql_injection' => [
        'enabled' => true,
        'use_prepared_statements' => true,
        'auto_escape' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Policy
    |--------------------------------------------------------------------------
    */
    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special_chars' => true,
        'hash_algorithm' => PASSWORD_BCRYPT,
        'hash_cost' => 12,
        'max_age_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Security
    |--------------------------------------------------------------------------
    */
    'login' => [
        'max_attempts' => 5,
        'lockout_duration' => 900, // 15 minutes in seconds
        'track_ip' => true,
        'require_email_verification' => true,
        'session_regenerate' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'enabled' => filter_var(getenv('RATE_LIMIT_ENABLED') ?: true, FILTER_VALIDATE_BOOLEAN),
        'max_requests' => (int) getenv('RATE_LIMIT_MAX_REQUESTS') ?: 100,
        'window' => (int) getenv('RATE_LIMIT_WINDOW') ?: 3600, // 1 hour in seconds
        'by_ip' => true,
        'by_user' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Brute Force Protection
    |--------------------------------------------------------------------------
    */
    'brute_force' => [
        'enabled' => true,
        'max_attempts' => 10,
        'decay_minutes' => 60,
        'lockout_duration' => 3600, // 1 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Authentication
    |--------------------------------------------------------------------------
    */
    'two_factor' => [
        'enabled' => true,
        'required_for_admin' => true,
        'code_length' => 6,
        'code_lifetime' => 300, // 5 minutes
        'backup_codes_count' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Whitelist/Blacklist
    |--------------------------------------------------------------------------
    */
    'ip_filtering' => [
        'enabled' => false,
        'whitelist' => [
            '127.0.0.1',
            '::1',
        ],
        'blacklist' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    */
    'file_upload' => [
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'],
        'max_size' => 10485760, // 10MB in bytes
        'scan_for_viruses' => false,
        'rename_files' => true,
        'check_mime_type' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Headers Security
    |--------------------------------------------------------------------------
    */
    'headers' => [
        'x_frame_options' => 'SAMEORIGIN',
        'x_xss_protection' => '1; mode=block',
        'x_content_type_options' => 'nosniff',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'permissions_policy' => 'geolocation=(), microphone=(), camera=()',
        'strict_transport_security' => 'max-age=31536000; includeSubDomains',
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    */
    'csp' => [
        'enabled' => true,
        'directives' => [
            'default-src' => ["'self'"],
            'script-src' => ["'self'", "'unsafe-inline'", "'unsafe-eval'", 'https://www.googletagmanager.com'],
            'style-src' => ["'self'", "'unsafe-inline'", 'https://fonts.googleapis.com'],
            'img-src' => ["'self'", 'data:', 'https:'],
            'font-src' => ["'self'", 'https://fonts.gstatic.com'],
            'connect-src' => ["'self'"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    */
    'session_security' => [
        'fingerprint' => true,
        'check_ip' => false,
        'check_user_agent' => true,
        'regenerate_id' => true,
        'timeout' => 1800, // 30 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Security
    |--------------------------------------------------------------------------
    */
    'admin' => [
        'require_https' => true,
        'ip_whitelist' => [],
        'two_factor_required' => true,
        'session_timeout' => 900, // 15 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    */
    'api' => [
        'require_authentication' => false,
        'rate_limit' => 60,
        'token_lifetime' => 3600,
        'allowed_origins' => ['*'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Logging
    |--------------------------------------------------------------------------
    */
    'audit' => [
        'enabled' => true,
        'log_login_attempts' => true,
        'log_admin_actions' => true,
        'log_failed_requests' => true,
        'retention_days' => 90,
    ],
];