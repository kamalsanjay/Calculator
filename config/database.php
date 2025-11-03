<?php
/**
 * Database Configuration
 * Database connection settings
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

// Database credentials
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'calculator_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection
    |--------------------------------------------------------------------------
    */
    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => DB_HOST,
            'port' => DB_PORT,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => DB_CHARSET,
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | PDO Options
    |--------------------------------------------------------------------------
    */
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Table Prefixes
    |--------------------------------------------------------------------------
    */
    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Connection Pool Settings
    |--------------------------------------------------------------------------
    */
    'pool' => [
        'max_connections' => 10,
        'timeout' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => false,
        'slow_query_threshold' => 1000, // milliseconds
        'log_file' => LOGS_PATH . '/queries.log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Configuration
    |--------------------------------------------------------------------------
    */
    'backup' => [
        'enabled' => filter_var(getenv('BACKUP_ENABLED') ?: true, FILTER_VALIDATE_BOOLEAN),
        'path' => getenv('BACKUP_PATH') ?: BASE_PATH . '/backup/database',
        'schedule' => 'daily', // daily, weekly, monthly
        'keep_backups' => 30, // number of backups to keep
        'compression' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Tables
    |--------------------------------------------------------------------------
    */
    'tables' => [
        'users' => 'users',
        'calculators' => 'calculators',
        'calculator_usage' => 'calculator_usage',
        'categories' => 'categories',
        'page_analytics' => 'page_analytics',
        'saved_calculations' => 'saved_calculations',
        'ad_performance' => 'ad_performance',
        'roles' => 'roles',
        'permissions' => 'permissions',
        'role_permissions' => 'role_permissions',
        'sessions' => 'sessions',
        'password_resets' => 'password_resets',
        'email_verifications' => 'email_verifications',
        'login_attempts' => 'login_attempts',
        'two_factor_auth' => 'two_factor_auth',
        'oauth_tokens' => 'oauth_tokens',
    ],
];