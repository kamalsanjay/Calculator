<?php
/**
 * Helper Functions
 * Additional utility functions for the application
 */

// Only declare functions if they don't already exist

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize input data
     */
    function sanitize_input($data) {
        if (is_array($data)) {
            return array_map('sanitize_input', $data);
        }
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}

if (!function_exists('generate_breadcrumb')) {
    /**
     * Generate breadcrumb navigation
     */
    function generate_breadcrumb($category = '', $page = '') {
        $breadcrumb = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        $breadcrumb .= '<li class="breadcrumb-item"><a href="' . SITE_URL . '">Home</a></li>';
        
        if ($category) {
            $breadcrumb .= '<li class="breadcrumb-item"><a href="' . SITE_URL . '/calculators/' . $category . '/">' . ucwords(str_replace('-', ' ', $category)) . '</a></li>';
        }
        
        if ($page) {
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">' . $page . '</li>';
        }
        
        $breadcrumb .= '</ol></nav>';
        return $breadcrumb;
    }
}

if (!function_exists('track_calculator_usage')) {
    /**
     * Track calculator usage
     */
    function track_calculator_usage($calculator_id, $input_data = [], $result_data = []) {
        try {
            $db = Database::getInstance();
            $user_id = $_SESSION['user_id'] ?? null;
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            $stmt = $db->prepare("
                INSERT INTO calculator_usage (calculator_id, user_id, ip_address, user_agent, input_data, result_data, created_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $calculator_id,
                $user_id,
                $ip_address,
                $user_agent,
                json_encode($input_data),
                json_encode($result_data)
            ]);
            
            return true;
        } catch (Exception $e) {
            error_log('Error tracking calculator usage: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('save_calculation')) {
    /**
     * Save calculation to user account
     */
    function save_calculation($calculator_id, $calculation_name, $input_data, $result_data, $notes = '') {
        try {
            $db = Database::getInstance();
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$user_id) {
                return false;
            }
            
            $stmt = $db->prepare("
                INSERT INTO saved_calculations (user_id, calculator_id, calculation_name, input_data, result_data, notes, created_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $user_id,
                $calculator_id,
                $calculation_name,
                json_encode($input_data),
                json_encode($result_data),
                $notes
            ]);
            
            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log('Error saving calculation: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format number as currency
     */
    function format_currency($amount, $currency = 'USD', $decimals = 2) {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$'
        ];
        
        $symbol = $symbols[$currency] ?? '$';
        return $symbol . number_format($amount, $decimals, '.', ',');
    }
}

if (!function_exists('validate_email')) {
    /**
     * Validate email address
     */
    function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('send_email')) {
    /**
     * Send email
     */
    function send_email($to, $subject, $message, $headers = []) {
        $default_headers = [
            'From' => MAIL_FROM_NAME . ' <' . MAIL_FROM_ADDRESS . '>',
            'Reply-To' => MAIL_FROM_ADDRESS,
            'X-Mailer' => 'PHP/' . phpversion(),
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];
        
        $headers = array_merge($default_headers, $headers);
        
        $header_string = '';
        foreach ($headers as $key => $value) {
            $header_string .= "$key: $value\r\n";
        }
        
        return mail($to, $subject, $message, $header_string);
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * Get client IP address
     */
    function get_client_ip() {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}

if (!function_exists('is_mobile')) {
    /**
     * Check if user is on mobile device
     */
    function is_mobile() {
        return preg_match('/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT'] ?? '');
    }
}

if (!function_exists('get_browser_info')) {
    /**
     * Get browser information
     */
    function get_browser_info() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $browser = 'Unknown';
        $platform = 'Unknown';
        
        // Detect browser
        if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera/i', $user_agent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Edge/i', $user_agent)) {
            $browser = 'Edge';
        }
        
        // Detect platform
        if (preg_match('/windows/i', $user_agent)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/linux/i', $user_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/android/i', $user_agent)) {
            $platform = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $user_agent)) {
            $platform = 'iOS';
        }
        
        return [
            'browser' => $browser,
            'platform' => $platform,
            'user_agent' => $user_agent
        ];
    }
}

if (!function_exists('array_get')) {
    /**
     * Get array value with default
     */
    function array_get($array, $key, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die (for debugging)
     */
    function dd(...$vars) {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
}

if (!function_exists('asset')) {
    /**
     * Generate asset URL
     */
    function asset($path) {
        return SITE_URL . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /**
     * Generate URL
     */
    function url($path = '') {
        return SITE_URL . '/' . ltrim($path, '/');
    }
}