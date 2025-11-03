<?php
/**
 * Advertisement Configuration
 * Google AdSense and ad placement settings
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | AdSense Configuration
    |--------------------------------------------------------------------------
    */
    'adsense' => [
        'enabled' => filter_var(getenv('ADSENSE_ENABLED') ?: true, FILTER_VALIDATE_BOOLEAN),
        'client_id' => getenv('ADSENSE_CLIENT_ID') ?: 'ca-pub-XXXXXXXXXXXXXXXX',
        'test_mode' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Positions
    |--------------------------------------------------------------------------
    */
    'positions' => [
        'sidebar_top' => [
            'enabled' => true,
            'slot_id' => '1234567890',
            'format' => 'vertical',
            'size' => '300x600',
            'responsive' => true,
            'display_on' => ['calculator', 'category'],
        ],

        'sidebar_bottom' => [
            'enabled' => true,
            'slot_id' => '0987654321',
            'format' => 'vertical',
            'size' => '300x600',
            'responsive' => true,
            'display_on' => ['calculator', 'category'],
        ],

        'horizontal_top' => [
            'enabled' => true,
            'slot_id' => '1122334455',
            'format' => 'horizontal',
            'size' => '728x90',
            'responsive' => true,
            'display_on' => ['homepage', 'calculator', 'category'],
        ],

        'horizontal_bottom' => [
            'enabled' => true,
            'slot_id' => '5544332211',
            'format' => 'horizontal',
            'size' => '728x90',
            'responsive' => true,
            'display_on' => ['homepage', 'calculator', 'category'],
        ],

        'in_content' => [
            'enabled' => false,
            'slot_id' => '6677889900',
            'format' => 'rectangle',
            'size' => '336x280',
            'responsive' => true,
            'display_on' => ['calculator'],
        ],

        'mobile_anchor' => [
            'enabled' => true,
            'slot_id' => '9988776655',
            'format' => 'anchor',
            'display_on' => ['all'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Display Rules
    |--------------------------------------------------------------------------
    */
    'display_rules' => [
        'show_to_logged_in' => true,
        'show_on_mobile' => true,
        'show_on_tablet' => true,
        'show_on_desktop' => true,
        'min_page_views' => 0,
        'delay_seconds' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Loading Strategy
    |--------------------------------------------------------------------------
    */
    'loading' => [
        'async' => true,
        'lazy_load' => true,
        'preload' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Refresh Settings
    |--------------------------------------------------------------------------
    */
    'refresh' => [
        'enabled' => false,
        'interval' => 30, // seconds
        'max_refreshes' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Blocking Detection
    |--------------------------------------------------------------------------
    */
    'adblock_detection' => [
        'enabled' => false,
        'message' => 'Please consider disabling your ad blocker to support our free calculators.',
        'alternative_content' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics Integration
    |--------------------------------------------------------------------------
    */
    'analytics' => [
        'track_impressions' => true,
        'track_clicks' => true,
        'track_revenue' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Placement Exclusions
    |--------------------------------------------------------------------------
    */
    'exclusions' => [
        'pages' => [
            '/admin/',
            '/auth/login',
            '/auth/register',
        ],
        'user_roles' => [
            'admin',
            'premium',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Responsive Ad Sizes
    |--------------------------------------------------------------------------
    */
    'responsive_sizes' => [
        'vertical' => [
            'mobile' => '300x250',
            'tablet' => '300x600',
            'desktop' => '300x600',
        ],
        'horizontal' => [
            'mobile' => '320x50',
            'tablet' => '728x90',
            'desktop' => '728x90',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ad Performance Tracking
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'enabled' => true,
        'track_viewability' => true,
        'track_ctr' => true,
        'track_revenue' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Alternative Ad Networks
    |--------------------------------------------------------------------------
    */
    'alternative_networks' => [
        'media_net' => [
            'enabled' => false,
            'site_id' => '',
        ],
        'propeller_ads' => [
            'enabled' => false,
            'zone_id' => '',
        ],
    ],
];