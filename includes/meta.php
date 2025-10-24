<?php
/**
 * Meta Tags Component
 * 
 * Generates dynamic SEO meta tags including:
 * - Dynamic title and description
 * - Open Graph tags
 * - Twitter Card tags
 * - Schema.org JSON-LD
 * - Canonical URLs
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

/**
 * Generate SEO-optimized page title
 * 
 * @param string $page_title Specific page title
 * @param bool $include_site_name Whether to include site name
 * @return string Complete page title
 */
function generate_seo_title($page_title = '', $include_site_name = true) {
    $site_name = 'Calculator Hub';
    $separator = ' | ';
    
    if (empty($page_title)) {
        return $site_name . ' - Free Online Calculators for Every Need';
    }
    
    if ($include_site_name) {
        return htmlspecialchars($page_title . $separator . $site_name);
    }
    
    return htmlspecialchars($page_title);
}

/**
 * Generate SEO-optimized meta description
 * 
 * @param string $description Custom description
 * @return string Meta description (max 160 characters)
 */
function generate_meta_description($description = '') {
    $default_description = 'Access 200+ free online calculators across 14 categories including math, finance, health, and more. Fast, accurate, and easy-to-use calculation tools.';
    
    if (empty($description)) {
        return htmlspecialchars($default_description);
    }
    
    // Truncate to 160 characters for optimal SEO
    if (strlen($description) > 160) {
        $description = substr($description, 0, 157) . '...';
    }
    
    return htmlspecialchars($description);
}

/**
 * Get canonical URL for current page
 * 
 * @return string Canonical URL
 */
function get_canonical_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query parameters
    
    return $protocol . '://' . $host . $uri;
}

/**
 * Generate all meta tags for a page
 * 
 * @param array $meta_data Associative array with page meta information
 * @return void Outputs meta tags
 */
function generate_meta_tags($meta_data = []) {
    // Set defaults
    $defaults = [
        'title' => '',
        'description' => '',
        'keywords' => 'calculator, online calculator, free calculator, math calculator, finance calculator',
        'image' => '/assets/images/og-image.jpg',
        'type' => 'website',
        'author' => 'Calculator Hub',
        'robots' => 'index, follow',
        'canonical' => get_canonical_url()
    ];
    
    // Merge with provided data
    $meta = array_merge($defaults, $meta_data);
    
    // Generate title
    $page_title = generate_seo_title($meta['title']);
    $description = generate_meta_description($meta['description']);
    
    // Construct full image URL
    $image_url = (strpos($meta['image'], 'http') === 0) 
        ? $meta['image'] 
        : 'https://' . $_SERVER['HTTP_HOST'] . $meta['image'];
    
    ?>
    <!-- Primary Meta Tags -->
    <title><?php echo $page_title; ?></title>
    <meta name="title" content="<?php echo $page_title; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta['keywords']); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($meta['author']); ?>">
    <meta name="robots" content="<?php echo htmlspecialchars($meta['robots']); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($meta['canonical']); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo htmlspecialchars($meta['type']); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($meta['canonical']); ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $description; ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($image_url); ?>">
    <meta property="og:site_name" content="Calculator Hub">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($meta['canonical']); ?>">
    <meta name="twitter:title" content="<?php echo $page_title; ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($image_url); ?>">
    <meta name="twitter:site" content="@CalculatorHub">
    <meta name="twitter:creator" content="@CalculatorHub">
    
    <!-- Additional SEO Tags -->
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="revisit-after" content="7 days">
    
    <?php
    // Generate Schema.org JSON-LD
    generate_schema_markup($meta);
}

/**
 * Generate Schema.org JSON-LD structured data
 * 
 * @param array $meta Meta data array
 * @return void Outputs JSON-LD script
 */
function generate_schema_markup($meta = []) {
    $canonical = isset($meta['canonical']) ? $meta['canonical'] : get_canonical_url();
    $title = isset($meta['title']) ? $meta['title'] : 'Calculator Hub';
    $description = isset($meta['description']) ? $meta['description'] : '';
    
    // Base organization schema
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => 'https://' . $_SERVER['HTTP_HOST'] . '/#organization',
                'name' => 'Calculator Hub',
                'url' => 'https://' . $_SERVER['HTTP_HOST'],
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/logo.svg',
                    'width' => 250,
                    'height' => 60
                ],
                'sameAs' => [
                    'https://facebook.com/calculatorhub',
                    'https://twitter.com/calculatorhub',
                    'https://instagram.com/calculatorhub',
                    'https://linkedin.com/company/calculatorhub'
                ]
            ],
            [
                '@type' => 'WebSite',
                '@id' => 'https://' . $_SERVER['HTTP_HOST'] . '/#website',
                'url' => 'https://' . $_SERVER['HTTP_HOST'],
                'name' => 'Calculator Hub',
                'publisher' => [
                    '@id' => 'https://' . $_SERVER['HTTP_HOST'] . '/#organization'
                ],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => 'https://' . $_SERVER['HTTP_HOST'] . '/search.php?q={search_term_string}',
                    'query-input' => 'required name=search_term_string'
                ]
            ]
        ]
    ];
    
    // Add WebPage schema for specific pages
    if (!empty($title)) {
        $schema['@graph'][] = [
            '@type' => 'WebPage',
            '@id' => $canonical . '#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'isPartOf' => [
                '@id' => 'https://' . $_SERVER['HTTP_HOST'] . '/#website'
            ],
            'inLanguage' => 'en-US'
        ];
    }
    
    // Add SoftwareApplication schema for calculator pages
    if (isset($meta['calculator']) && $meta['calculator'] === true) {
        $schema['@graph'][] = [
            '@type' => 'SoftwareApplication',
            'name' => $title,
            'description' => $description,
            'url' => $canonical,
            'applicationCategory' => 'UtilitiesApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'ratingCount' => '1250',
                'bestRating' => '5',
                'worstRating' => '1'
            ]
        ];
    }
    
    // Add BreadcrumbList schema
    if (isset($meta['breadcrumbs']) && is_array($meta['breadcrumbs'])) {
        $breadcrumb_items = [];
        $position = 1;
        
        foreach ($meta['breadcrumbs'] as $crumb) {
            $breadcrumb_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $crumb['name'],
                'item' => 'https://' . $_SERVER['HTTP_HOST'] . $crumb['url']
            ];
        }
        
        $schema['@graph'][] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items
        ];
    }
    
    // Output JSON-LD
    echo '<script type="application/ld+json">' . "\n";
    echo json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    echo "\n" . '</script>' . "\n";
}

/**
 * Generate calculator-specific meta tags
 * 
 * @param string $calculator_name Name of the calculator
 * @param string $category Category of the calculator
 * @param string $custom_description Optional custom description
 * @return void Outputs meta tags
 */
function generate_calculator_meta($calculator_name, $category, $custom_description = '') {
    $title = $calculator_name . ' - Free Online Calculator';
    
    if (empty($custom_description)) {
        $custom_description = "Use our free {$calculator_name} to quickly and accurately perform {$category} calculations online. Easy to use, mobile-friendly, and instant results.";
    }
    
    // Build breadcrumbs
    $breadcrumbs = [
        ['name' => 'Home', 'url' => '/'],
        ['name' => ucfirst($category), 'url' => '/category/' . $category],
        ['name' => $calculator_name, 'url' => $_SERVER['REQUEST_URI']]
    ];
    
    $meta_data = [
        'title' => $title,
        'description' => $custom_description,
        'keywords' => "{$calculator_name}, {$category} calculator, online calculator, free calculator",
        'type' => 'website',
        'calculator' => true,
        'breadcrumbs' => $breadcrumbs
    ];
    
    generate_meta_tags($meta_data);
}

/**
 * Generate category page meta tags
 * 
 * @param string $category_name Category name
 * @param string $description Category description
 * @param int $calculator_count Number of calculators in category
 * @return void Outputs meta tags
 */
function generate_category_meta($category_name, $description, $calculator_count = 0) {
    $title = $category_name . ' Calculators - Free Online Tools';
    
    if (empty($description)) {
        $description = "Explore {$calculator_count}+ free {$category_name} calculators. Professional tools for accurate calculations. Easy to use and mobile-friendly.";
    }
    
    $meta_data = [
        'title' => $title,
        'description' => $description,
        'keywords' => "{$category_name} calculator, {$category_name} tools, online {$category_name}",
        'type' => 'website'
    ];
    
    generate_meta_tags($meta_data);
}
?>  
