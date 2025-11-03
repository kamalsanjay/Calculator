<?php
/**
 * Cache Configuration
 * Caching settings and drivers
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | Cache Driver
    |--------------------------------------------------------------------------
    | Values: file, redis, memcached, array, database
    */
    'default' => getenv('CACHE_DRIVER') ?: 'file',

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    */
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => CACHE_PATH . '/data',
            'permission' => 0755,
        ],

        'redis' => [
            'driver' => 'redis',
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => null,
            'database' => 0,
            'prefix' => 'calc_',
        ],

        'memcached' => [
            'driver' => 'memcached',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
            'prefix' => 'calc_',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => 'mysql',
        ],

        'array' => [
            'driver' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Enabled
    |--------------------------------------------------------------------------
    */
    'enabled' => filter_var(getenv('CACHE_ENABLED') ?: true, FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Cache Time To Live (TTL)
    |--------------------------------------------------------------------------
    | In seconds (3600 = 1 hour)
    */
    'ttl' => (int) getenv('CACHE_TTL') ?: 3600,

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    */
    'prefix' => 'calculator_',

    /*
    |--------------------------------------------------------------------------
    | Specific Cache Settings
    |--------------------------------------------------------------------------
    */
    'calculators' => [
        'enabled' => true,
        'ttl' => 86400, // 24 hours
    ],

    'categories' => [
        'enabled' => true,
        'ttl' => 86400, // 24 hours
    ],

    'analytics' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
    ],

    'api_responses' => [
        'enabled' => true,
        'ttl' => 300, // 5 minutes
    ],

    'views' => [
        'enabled' => true,
        'path' => CACHE_PATH . '/views',
        'ttl' => 3600, // 1 hour
    ],

    'search_results' => [
        'enabled' => true,
        'ttl' => 600, // 10 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Compression
    |--------------------------------------------------------------------------
    */
    'compression' => [
        'enabled' => false,
        'level' => 6, // 1-9
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Tagging
    |--------------------------------------------------------------------------
    */
    'tagging' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Warming
    |--------------------------------------------------------------------------
    */
    'warming' => [
        'enabled' => false,
        'schedule' => 'daily',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Clear Settings
    |--------------------------------------------------------------------------
    */
    'clear' => [
        'on_deploy' => true,
        'on_update' => true,
    ],
];