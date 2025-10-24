<?php
/**
 * Core Functions Library
 * 
 * Contains essential utility functions:
 * - sanitize_input() - Input sanitization
 * - format_number() - Number formatting
 * - generate_breadcrumb() - Breadcrumb navigation
 * - track_calculator_usage() - Usage tracking
 * - save_calculation() - Save user calculations
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

/**
 * Sanitize user input to prevent XSS and SQL injection
 * 
 * @param mixed $input Input to sanitize
 * @param string $type Type of sanitization (string, email, int, float, url)
 * @return mixed Sanitized input
 */
function sanitize_input($input, $type = 'string') {
    if (is_array($input)) {
        return array_map(function($item) use ($type) {
            return sanitize_input($item, $type);
        }, $input);
    }
    
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_SANITIZE_EMAIL);
            
        case 'int':
            return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            
        case 'float':
            return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
        case 'url':
            return filter_var($input, FILTER_SANITIZE_URL);
            
        case 'html':
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            
        case 'string':
        default:
            // Remove HTML tags and encode special characters
            $input = strip_tags($input);
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            return trim($input);
    }
}

/**
 * Format numbers with proper decimal places and thousands separator
 * 
 * @param float $number Number to format
 * @param int $decimals Number of decimal places
 * @param bool $currency Whether to format as currency
 * @param string $currency_symbol Currency symbol (default: $)
 * @return string Formatted number
 */
function format_number($number, $decimals = 2, $currency = false, $currency_symbol = '$') {
    if (!is_numeric($number)) {
        return $number;
    }
    
    $formatted = number_format($number, $decimals, '.', ',');
    
    if ($currency) {
        return $currency_symbol . $formatted;
    }
    
    return $formatted;
}

/**
 * Format large numbers with K, M, B suffixes
 * 
 * @param float $number Number to format
 * @param int $decimals Number of decimal places
 * @return string Formatted number with suffix
 */
function format_number_short($number, $decimals = 1) {
    if ($number < 1000) {
        return number_format($number, 0);
    } elseif ($number < 1000000) {
        return number_format($number / 1000, $decimals) . 'K';
    } elseif ($number < 1000000000) {
        return number_format($number / 1000000, $decimals) . 'M';
    } else {
        return number_format($number / 1000000000, $decimals) . 'B';
    }
}

/**
 * Generate breadcrumb navigation
 * 
 * @param array $custom_crumbs Optional custom breadcrumbs
 * @return string HTML breadcrumb navigation
 */
function generate_breadcrumb($custom_crumbs = []) {
    $breadcrumbs = [];
    
    // Always start with home
    $breadcrumbs[] = [
        'name' => 'Home',
        'url' => '/',
        'active' => false
    ];
    
    if (!empty($custom_crumbs)) {
        // Use custom breadcrumbs if provided
        foreach ($custom_crumbs as $crumb) {
            $breadcrumbs[] = $crumb;
        }
    } else {
        // Auto-generate from URL
        $path = trim($_SERVER['REQUEST_URI'], '/');
        $path = strtok($path, '?'); // Remove query string
        
        if (!empty($path)) {
            $segments = explode('/', $path);
            $url = '';
            
            foreach ($segments as $index => $segment) {
                $url .= '/' . $segment;
                $is_last = ($index === count($segments) - 1);
                
                // Format segment name
                $name = ucwords(str_replace(['-', '_'], ' ', $segment));
                
                $breadcrumbs[] = [
                    'name' => $name,
                    'url' => $url,
                    'active' => $is_last
                ];
            }
        }
    }
    
    // Generate HTML
    $html = '<nav aria-label="Breadcrumb" class="breadcrumb-nav">';
    $html .= '<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    foreach ($breadcrumbs as $index => $crumb) {
        $position = $index + 1;
        $active_class = isset($crumb['active']) && $crumb['active'] ? ' active' : '';
        
        $html .= '<li class="breadcrumb-item' . $active_class . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        
        if (isset($crumb['active']) && $crumb['active']) {
            $html .= '<span itemprop="name">' . htmlspecialchars($crumb['name']) . '</span>';
        } else {
            $html .= '<a href="' . htmlspecialchars($crumb['url']) . '" itemprop="item">';
            $html .= '<span itemprop="name">' . htmlspecialchars($crumb['name']) . '</span>';
            $html .= '</a>';
        }
        
        $html .= '<meta itemprop="position" content="' . $position . '">';
        $html .= '</li>';
    }
    
    $html .= '</ol>';
    $html .= '</nav>';
    
    return $html;
}

/**
 * Track calculator usage for analytics
 * 
 * @param string $calculator_slug Calculator identifier
 * @param array $calculation_data Optional calculation data
 * @return bool Success status
 */
function track_calculator_usage($calculator_slug, $calculation_data = []) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO calculator_usage 
            (calculator_slug, user_id, ip_address, user_agent, page_url, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $page_url = $_SERVER['REQUEST_URI'];
        
        $stmt->execute([
            $calculator_slug,
            $user_id,
            $ip_address,
            $user_agent,
            $page_url
        ]);
        
        // Update calculator statistics
        update_calculator_stats($calculator_slug);
        
        return true;
    } catch (PDOException $e) {
        error_log("Usage tracking error: " . $e->getMessage());
        return false;
    }
}

/**
 * Update calculator statistics (views, uses)
 * 
 * @param string $calculator_slug Calculator identifier
 * @return void
 */
function update_calculator_stats($calculator_slug) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO calculator_stats (calculator_slug, total_uses, last_used)
            VALUES (?, 1, NOW())
            ON DUPLICATE KEY UPDATE 
                total_uses = total_uses + 1,
                last_used = NOW()
        ");
        
        $stmt->execute([$calculator_slug]);
    } catch (PDOException $e) {
        error_log("Stats update error: " . $e->getMessage());
    }
}

/**
 * Save user calculation to database
 * 
 * @param string $calculator_slug Calculator identifier
 * @param array $inputs Input values
 * @param array $results Calculation results
 * @param string $title Optional calculation title
 * @return int|bool Calculation ID or false on failure
 */
function save_calculation($calculator_slug, $inputs, $results, $title = '') {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return false; // User must be logged in to save
    }
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO saved_calculations 
            (user_id, calculator_slug, title, input_data, result_data, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $input_json = json_encode($inputs);
        $result_json = json_encode($results);
        
        if (empty($title)) {
            $title = 'Calculation - ' . date('Y-m-d H:i:s');
        }
        
        $stmt->execute([
            $_SESSION['user_id'],
            $calculator_slug,
            $title,
            $input_json,
            $result_json
        ]);
        
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        error_log("Save calculation error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get user's saved calculations
 * 
 * @param int $limit Number of calculations to retrieve
 * @param int $offset Offset for pagination
 * @return array Array of saved calculations
 */
function get_saved_calculations($limit = 20, $offset = 0) {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return [];
    }
    
    try {
        $stmt = $conn->prepare("
            SELECT 
                sc.*,
                c.name as calculator_name,
                c.category
            FROM saved_calculations sc
            LEFT JOIN calculators c ON sc.calculator_slug = c.slug
            WHERE sc.user_id = ?
            ORDER BY sc.created_at DESC
            LIMIT ? OFFSET ?
        ");
        
        $stmt->execute([$_SESSION['user_id'], $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get calculations error: " . $e->getMessage());
        return [];
    }
}

/**
 * Delete a saved calculation
 * 
 * @param int $calculation_id Calculation ID
 * @return bool Success status
 */
function delete_calculation($calculation_id) {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    try {
        $stmt = $conn->prepare("
            DELETE FROM saved_calculations 
            WHERE id = ? AND user_id = ?
        ");
        
        $stmt->execute([$calculation_id, $_SESSION['user_id']]);
        return true;
    } catch (PDOException $e) {
        error_log("Delete calculation error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get popular calculators
 * 
 * @param int $limit Number of calculators to retrieve
 * @param string $category Optional category filter
 * @return array Array of popular calculators
 */
function get_popular_calculators($limit = 10, $category = '') {
    global $conn;
    
    try {
        $sql = "
            SELECT 
                c.*,
                COALESCE(cs.total_uses, 0) as uses
            FROM calculators c
            LEFT JOIN calculator_stats cs ON c.slug = cs.calculator_slug
            WHERE c.status = 'active'
        ";
        
        if (!empty($category)) {
            $sql .= " AND c.category = ?";
        }
        
        $sql .= " ORDER BY uses DESC LIMIT ?";
        
        $stmt = $conn->prepare($sql);
        
        if (!empty($category)) {
            $stmt->execute([$category, $limit]);
        } else {
            $stmt->execute([$limit]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get popular calculators error: " . $e->getMessage());
        return [];
    }
}

/**
 * Get recent calculations (for activity feed)
 * 
 * @param int $limit Number of calculations to retrieve
 * @return array Array of recent calculations
 */
function get_recent_calculations($limit = 5) {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return [];
    }
    
    try {
        $stmt = $conn->prepare("
            SELECT 
                sc.*,
                c.name as calculator_name,
                c.icon
            FROM saved_calculations sc
            LEFT JOIN calculators c ON sc.calculator_slug = c.slug
            WHERE sc.user_id = ?
            ORDER BY sc.created_at DESC
            LIMIT ?
        ");
        
        $stmt->execute([$_SESSION['user_id'], $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get recent calculations error: " . $e->getMessage());
        return [];
    }
}

/**
 * Format time elapsed (e.g., "2 hours ago")
 * 
 * @param string $datetime Datetime string
 * @return string Formatted time elapsed
 */
function time_elapsed($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return 'just now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $time);
    }
}

/**
 * Generate CSRF token
 * 
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool Validation result
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Track page view for analytics
 * 
 * @return void
 */
function track_page_view() {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO page_views (page_url, user_id, ip_address, user_agent, referer, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $page_url = $_SERVER['REQUEST_URI'];
        
        $stmt->execute([$page_url, $user_id, $ip_address, $user_agent, $referer]);
    } catch (PDOException $e) {
        error_log("Page view tracking error: " . $e->getMessage());
    }
}

/**
 * Send JSON response
 * 
 * @param mixed $data Data to send
 * @param int $status_code HTTP status code
 * @return void
 */
function json_response($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>  
