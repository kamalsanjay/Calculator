<?php
/**
 * SEO Configuration
 * Default SEO settings and meta tags
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

return [
    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'title' => 'Calculator - 300+ Free Online Calculators & Tools',
        'description' => 'Free online calculator with 300+ tools for financial, health, math, conversion, date & time calculations. Fast, accurate, and easy to use.',
        'keywords' => 'calculator, online calculator, free calculator, math calculator, financial calculator, health calculator, conversion calculator, BMI calculator, mortgage calculator',
        'author' => 'Calculator Team',
        'robots' => 'index, follow',
        'language' => 'en',
        'revisit-after' => '7 days',
    ],

    /*
    |--------------------------------------------------------------------------
    | Title Configuration
    |--------------------------------------------------------------------------
    */
    'title' => [
        'separator' => ' - ',
        'prefix' => '',
        'suffix' => ' | Calculator',
        'max_length' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Description Configuration
    |--------------------------------------------------------------------------
    */
    'description' => [
        'max_length' => 160,
        'min_length' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Meta Tags
    |--------------------------------------------------------------------------
    */
    'open_graph' => [
        'enabled' => true,
        'type' => 'website',
        'site_name' => 'Calculator',
        'image' => BASE_URL . '/assets/images/og-image.jpg',
        'image_width' => 1200,
        'image_height' => 630,
        'locale' => 'en_US',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Meta Tags
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'enabled' => true,
        'card' => 'summary_large_image',
        'site' => '@calculator',
        'creator' => '@calculator',
        'image' => BASE_URL . '/assets/images/twitter-card.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Structured Data
    |--------------------------------------------------------------------------
    */
    'schema' => [
        'enabled' => true,
        'organization' => [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Calculator',
            'url' => BASE_URL,
            'logo' => BASE_URL . '/assets/images/logo.png',
            'sameAs' => [
                'https://facebook.com/calculator',
                'https://twitter.com/calculator',
                'https://instagram.com/calculator',
            ],
        ],
        'website' => [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Calculator',
            'url' => BASE_URL,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => BASE_URL . '/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Breadcrumb Configuration
    |--------------------------------------------------------------------------
    */
    'breadcrumb' => [
        'enabled' => true,
        'schema' => true,
        'home_title' => 'Home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Canonical URL
    |--------------------------------------------------------------------------
    */
    'canonical' => [
        'enabled' => true,
        'force_https' => true,
        'force_trailing_slash' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Alternate Language Tags
    |--------------------------------------------------------------------------
    */
    'alternate_languages' => [
        'enabled' => false,
        'languages' => [
            'en' => BASE_URL . '/en',
            'es' => BASE_URL . '/es',
            'fr' => BASE_URL . '/fr',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap' => [
        'enabled' => true,
        'path' => BASE_PATH . '/sitemap.xml',
        'auto_generate' => true,
        'change_frequency' => [
            'homepage' => 'daily',
            'categories' => 'weekly',
            'calculators' => 'monthly',
        ],
        'priority' => [
            'homepage' => '1.0',
            'categories' => '0.9',
            'calculators' => '0.8',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots Meta Tag
    |--------------------------------------------------------------------------
    */
    'robots' => [
        'enabled' => true,
        'default' => 'index, follow',
        'admin' => 'noindex, nofollow',
        'auth' => 'noindex, nofollow',
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON-LD Settings
    |--------------------------------------------------------------------------
    */
    'jsonld' => [
        'enabled' => true,
        'pretty_print' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO-Friendly URLs
    |--------------------------------------------------------------------------
    */
    'urls' => [
        'lowercase' => true,
        'remove_stop_words' => false,
        'max_length' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Category-Specific SEO
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'financial' => [
            'title_suffix' => ' - Financial Calculators',
            'description' => 'Free financial calculators for mortgages, loans, investments, and more.',
        ],
        'health' => [
            'title_suffix' => ' - Health & Fitness Calculators',
            'description' => 'Calculate BMI, calories, body fat percentage, and more health metrics.',
        ],
        'math' => [
            'title_suffix' => ' - Math Calculators',
            'description' => 'Advanced math calculators for algebra, geometry, statistics, and more.',
        ],
    ],
];