<?php
/**
 * API Configuration
 * RESTful API settings
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    */
    'version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    */
    'base_url' => BASE_URL . '/api',

    /*
    |--------------------------------------------------------------------------
    | API Authentication
    |--------------------------------------------------------------------------
    */
    'authentication' => [
        'enabled' => false,
        'type' => 'bearer', // bearer, api_key, basic
        'header' => 'Authorization',
        'token_prefix' => 'Bearer ',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'enabled' => true,
        'max_requests' => 100,
        'per_minutes' => 60,
        'by_ip' => true,
        'by_key' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    */
    'keys' => [
        'currency_exchange' => getenv('OPENEXCHANGE_API_KEY'),
        'weather' => getenv('WEATHER_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Response Format
    |--------------------------------------------------------------------------
    */
    'response' => [
        'default_format' => 'json', // json, xml
        'include_metadata' => true,
        'pretty_print' => false,
        'wrap_response' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Configuration
    |--------------------------------------------------------------------------
    */
    'cors' => [
        'enabled' => true,
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
        'exposed_headers' => ['X-RateLimit-Limit', 'X-RateLimit-Remaining'],
        'max_age' => 86400,
        'supports_credentials' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    */
    'endpoints' => [
        'calculators' => [
            'enabled' => true,
            'path' => '/calculators',
            'methods' => ['GET', 'POST'],
        ],
        'categories' => [
            'enabled' => true,
            'path' => '/categories',
            'methods' => ['GET'],
        ],
        'search' => [
            'enabled' => true,
            'path' => '/search',
            'methods' => ['GET'],
        ],
        'popular' => [
            'enabled' => true,
            'path' => '/popular',
            'methods' => ['GET'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Documentation
    |--------------------------------------------------------------------------
    */
    'documentation' => [
        'enabled' => true,
        'path' => '/documentation',
        'format' => 'openapi', // openapi, swagger
    ],

    /*
    |--------------------------------------------------------------------------
    | API Versioning
    |--------------------------------------------------------------------------
    */
    'versioning' => [
        'enabled' => true,
        'method' => 'uri', // uri, header, query
        'header_name' => 'API-Version',
        'query_param' => 'version',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Caching
    |--------------------------------------------------------------------------
    */
    'caching' => [
        'enabled' => true,
        'ttl' => 300, // 5 minutes
        'cache_driver' => 'file',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => true,
        'log_requests' => true,
        'log_responses' => false,
        'log_errors' => true,
        'log_file' => LOGS_PATH . '/api.log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
    'pagination' => [
        'default_limit' => 20,
        'max_limit' => 100,
        'page_param' => 'page',
        'limit_param' => 'limit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    */
    'errors' => [
        'show_trace' => false,
        'log_errors' => true,
        'send_notifications' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'strict_mode' => true,
        'return_errors' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    */
    'webhooks' => [
        'enabled' => false,
        'secret_key' => '',
        'retry_attempts' => 3,
    ],
];