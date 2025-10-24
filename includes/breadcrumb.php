<?php
/**
 * Breadcrumb Component
 * 
 * Generates dynamic breadcrumb navigation with:
 * - Automatic URL-based breadcrumbs
 * - Custom breadcrumb support
 * - Schema.org structured data
 * - SEO optimization
 * - Responsive design
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

/**
 * Generate breadcrumb navigation
 * 
 * @param array $custom_crumbs Optional custom breadcrumbs array
 * @param bool $show_home Whether to show home link (default: true)
 * @return string HTML breadcrumb navigation
 */
function generate_breadcrumb($custom_crumbs = [], $show_home = true) {
    $breadcrumbs = [];
    
    // Always start with home if enabled
    if ($show_home) {
        $breadcrumbs[] = [
            'name' => 'Home',
            'url' => '/',
            'active' => false,
            'icon' => 'fa-home'
        ];
    }
    
    if (!empty($custom_crumbs)) {
        // Use custom breadcrumbs if provided
        foreach ($custom_crumbs as $crumb) {
            $breadcrumbs[] = array_merge([
                'active' => false,
                'icon' => null
            ], $crumb);
        }
    } else {
        // Auto-generate from URL
        $breadcrumbs = array_merge($breadcrumbs, get_breadcrumbs_from_url());
    }
    
    // Mark the last item as active
    if (!empty($breadcrumbs)) {
        $breadcrumbs[count($breadcrumbs) - 1]['active'] = true;
    }
    
    // Generate HTML
    return render_breadcrumb_html($breadcrumbs);
}

/**
 * Auto-generate breadcrumbs from current URL
 * 
 * @return array Breadcrumb items
 */
function get_breadcrumbs_from_url() {
    $breadcrumbs = [];
    
    // Get current path
    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = strtok($path, '?'); // Remove query string
    
    // Return empty if on homepage
    if (empty($path)) {
        return $breadcrumbs;
    }
    
    // Split path into segments
    $segments = explode('/', $path);
    $url = '';
    
    // Map segments to breadcrumbs
    foreach ($segments as $index => $segment) {
        // Skip empty segments
        if (empty($segment)) {
            continue;
        }
        
        $url .= '/' . $segment;
        
        // Format segment name
        $name = format_breadcrumb_name($segment);
        
        // Get icon for segment
        $icon = get_breadcrumb_icon($segment, $index);
        
        $breadcrumbs[] = [
            'name' => $name,
            'url' => $url,
            'active' => false,
            'icon' => $icon
        ];
    }
    
    return $breadcrumbs;
}

/**
 * Format segment name for display
 * 
 * @param string $segment URL segment
 * @return string Formatted name
 */
function format_breadcrumb_name($segment) {
    // Replace hyphens and underscores with spaces
    $name = str_replace(['-', '_'], ' ', $segment);
    
    // Capitalize words
    $name = ucwords($name);
    
    // Special handling for common terms
    $replacements = [
        'Bmi' => 'BMI',
        'Gpa' => 'GPA',
        'Roi' => 'ROI',
        'Api' => 'API',
        'Faq' => 'FAQ',
        'Html' => 'HTML',
        'Css' => 'CSS',
        'Php' => 'PHP',
        'Mpg' => 'MPG',
        'Sql' => 'SQL',
        'Url' => 'URL',
        'Qr' => 'QR'
    ];
    
    foreach ($replacements as $search => $replace) {
        $name = str_replace($search, $replace, $name);
    }
    
    return $name;
}

/**
 * Get appropriate icon for breadcrumb segment
 * 
 * @param string $segment URL segment
 * @param int $index Segment position
 * @return string|null Font Awesome icon class or null
 */
function get_breadcrumb_icon($segment, $index = 0) {
    // Icon mapping for common segments
    $icon_map = [
        // Categories
        'category' => 'fa-th',
        'categories' => 'fa-th-large',
        'math' => 'fa-calculator',
        'finance' => 'fa-dollar-sign',
        'health' => 'fa-heartbeat',
        'conversion' => 'fa-exchange-alt',
        'date' => 'fa-calendar-alt',
        'time' => 'fa-clock',
        'statistics' => 'fa-chart-bar',
        'science' => 'fa-flask',
        'engineering' => 'fa-cogs',
        'cooking' => 'fa-utensils',
        'construction' => 'fa-hard-hat',
        'automotive' => 'fa-car',
        'education' => 'fa-graduation-cap',
        'business' => 'fa-briefcase',
        
        // Pages
        'calculator' => 'fa-calculator',
        'calculators' => 'fa-calculator',
        'about' => 'fa-info-circle',
        'contact' => 'fa-envelope',
        'blog' => 'fa-blog',
        'search' => 'fa-search',
        'profile' => 'fa-user',
        'dashboard' => 'fa-tachometer-alt',
        'settings' => 'fa-cog',
        'saved' => 'fa-bookmark',
        'history' => 'fa-history',
        'premium' => 'fa-crown',
        
        // Actions
        'edit' => 'fa-edit',
        'delete' => 'fa-trash',
        'add' => 'fa-plus',
        'view' => 'fa-eye'
    ];
    
    // Convert segment to lowercase for matching
    $segment_lower = strtolower($segment);
    
    // Return icon if found
    return isset($icon_map[$segment_lower]) ? $icon_map[$segment_lower] : null;
}

/**
 * Render breadcrumb HTML with Schema.org markup
 * 
 * @param array $breadcrumbs Breadcrumb items
 * @return string HTML output
 */
function render_breadcrumb_html($breadcrumbs) {
    if (empty($breadcrumbs)) {
        return '';
    }
    
    $html = '<nav class="breadcrumb-wrapper" aria-label="Breadcrumb">' . "\n";
    $html .= '    <div class="container">' . "\n";
    $html .= '        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">' . "\n";
    
    foreach ($breadcrumbs as $position => $crumb) {
        $position_number = $position + 1;
        $active_class = $crumb['active'] ? ' active' : '';
        $aria_current = $crumb['active'] ? ' aria-current="page"' : '';
        
        $html .= '            <li class="breadcrumb-item' . $active_class . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"' . $aria_current . '>' . "\n";
        
        if ($crumb['active']) {
            // Active/current item (no link)
            $html .= '                <span itemprop="name">';
            if ($crumb['icon']) {
                $html .= '<i class="fas ' . htmlspecialchars($crumb['icon']) . '"></i> ';
            }
            $html .= htmlspecialchars($crumb['name']);
            $html .= '</span>' . "\n";
        } else {
            // Linked item
            $html .= '                <a href="' . htmlspecialchars($crumb['url']) . '" itemprop="item">' . "\n";
            $html .= '                    <span itemprop="name">';
            if ($crumb['icon']) {
                $html .= '<i class="fas ' . htmlspecialchars($crumb['icon']) . '"></i> ';
            }
            $html .= htmlspecialchars($crumb['name']);
            $html .= '</span>' . "\n";
            $html .= '                </a>' . "\n";
        }
        
        $html .= '                <meta itemprop="position" content="' . $position_number . '">' . "\n";
        $html .= '            </li>' . "\n";
    }
    
    $html .= '        </ol>' . "\n";
    $html .= '    </div>' . "\n";
    $html .= '</nav>' . "\n";
    
    return $html;
}

/**
 * Get breadcrumbs for calculator page
 * 
 * @param string $calculator_slug Calculator slug
 * @param string $category Category slug
 * @param string $calculator_name Calculator display name
 * @return array Breadcrumb items
 */
function get_calculator_breadcrumbs($calculator_slug, $category = '', $calculator_name = '') {
    global $conn;
    
    $breadcrumbs = [];
    
    // If we don't have category or name, fetch from database
    if (empty($category) || empty($calculator_name)) {
        try {
            $stmt = $conn->prepare("SELECT name, category FROM calculators WHERE slug = ? LIMIT 1");
            $stmt->execute([$calculator_slug]);
            $calc = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($calc) {
                $calculator_name = $calc['name'];
                $category = $calc['category'];
            }
        } catch (PDOException $e) {
            error_log("Breadcrumb fetch error: " . $e->getMessage());
        }
    }
    
    // Add category breadcrumb
    if (!empty($category)) {
        $breadcrumbs[] = [
            'name' => format_breadcrumb_name($category) . ' Calculators',
            'url' => '/category/' . $category,
            'icon' => get_breadcrumb_icon($category)
        ];
    }
    
    // Add calculator breadcrumb
    if (!empty($calculator_name)) {
        $breadcrumbs[] = [
            'name' => $calculator_name,
            'url' => '/calculator/' . $calculator_slug,
            'icon' => 'fa-calculator'
        ];
    } else {
        // Fallback to slug if name not available
        $breadcrumbs[] = [
            'name' => format_breadcrumb_name($calculator_slug),
            'url' => '/calculator/' . $calculator_slug,
            'icon' => 'fa-calculator'
        ];
    }
    
    return $breadcrumbs;
}

/**
 * Get breadcrumbs for category page
 * 
 * @param string $category_slug Category slug
 * @param string $category_name Category display name (optional)
 * @return array Breadcrumb items
 */
function get_category_breadcrumbs($category_slug, $category_name = '') {
    if (empty($category_name)) {
        $category_name = format_breadcrumb_name($category_slug);
    }
    
    return [
        [
            'name' => 'Categories',
            'url' => '/categories.php',
            'icon' => 'fa-th-large'
        ],
        [
            'name' => $category_name . ' Calculators',
            'url' => '/category/' . $category_slug,
            'icon' => get_breadcrumb_icon($category_slug)
        ]
    ];
}

/**
 * Get breadcrumbs for blog post
 * 
 * @param string $post_slug Post slug
 * @param string $post_title Post title
 * @param string $category Category (optional)
 * @return array Breadcrumb items
 */
function get_blog_breadcrumbs($post_slug, $post_title, $category = '') {
    $breadcrumbs = [
        [
            'name' => 'Blog',
            'url' => '/blog.php',
            'icon' => 'fa-blog'
        ]
    ];
    
    if (!empty($category)) {
        $breadcrumbs[] = [
            'name' => format_breadcrumb_name($category),
            'url' => '/blog/category/' . $category,
            'icon' => 'fa-folder'
        ];
    }
    
    $breadcrumbs[] = [
        'name' => $post_title,
        'url' => '/blog/' . $post_slug,
        'icon' => 'fa-file-alt'
    ];
    
    return $breadcrumbs;
}

/**
 * Display breadcrumb navigation
 * Helper function that directly outputs HTML
 * 
 * @param array $custom_crumbs Optional custom breadcrumbs
 * @param bool $show_home Whether to show home link
 * @return void
 */
function display_breadcrumb($custom_crumbs = [], $show_home = true) {
    echo generate_breadcrumb($custom_crumbs, $show_home);
}

/**
 * Get JSON-LD structured data for breadcrumbs
 * 
 * @param array $breadcrumbs Breadcrumb items
 * @return string JSON-LD script tag
 */
function get_breadcrumb_json_ld($breadcrumbs) {
    if (empty($breadcrumbs)) {
        return '';
    }
    
    $items = [];
    $position = 1;
    
    foreach ($breadcrumbs as $crumb) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $crumb['name'],
            'item' => 'https://' . $_SERVER['HTTP_HOST'] . $crumb['url']
        ];
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items
    ];
    
    $json = json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    
    return '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>' . "\n";
}
?>

<style>
/* Breadcrumb Styles */
.breadcrumb-wrapper {
    background: var(--bg-secondary);
    padding: var(--space-3) 0;
    border-bottom: 1px solid var(--border-color);
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: var(--font-sm);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    color: var(--text-secondary);
}

.breadcrumb-item a {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color var(--transition-fast);
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.breadcrumb-item a:hover {
    color: var(--primary);
}

.breadcrumb-item.active {
    color: var(--text-primary);
    font-weight: var(--font-medium);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    padding: 0 var(--space-2);
    color: var(--text-tertiary);
}

.breadcrumb-item i {
    font-size: 0.9em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .breadcrumb-wrapper {
        padding: var(--space-2) 0;
    }
    
    .breadcrumb {
        font-size: var(--font-xs);
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        padding: 0 var(--space-1);
    }
}

/* Dark mode */
:root[data-theme="dark"] .breadcrumb-wrapper {
    background: var(--bg-secondary);
    border-bottom-color: var(--border-color);
}
</style>  
