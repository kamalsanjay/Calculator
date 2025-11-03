<?php
/**
 * Analytics Tracking Class
 * Track user activities and page views
 */

class Analytics {
    private $db;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Track page view
     */
    public function trackPageView($pageUrl, $pageTitle = null) {
        try {
            $data = [
                'page_url' => $pageUrl,
                'page_title' => $pageTitle,
                'ip_address' => $this->getClientIP(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
                'user_id' => $_SESSION['user_id'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('page_views', $data);
            
        } catch (Exception $e) {
            error_log("Analytics tracking error: " . $e->getMessage());
        }
    }
    
    /**
     * Track calculator usage
     */
    public function trackCalculatorUsage($calculatorId, $inputData, $resultData) {
        try {
            $data = [
                'calculator_id' => $calculatorId,
                'user_id' => $_SESSION['user_id'] ?? null,
                'ip_address' => $this->getClientIP(),
                'input_data' => json_encode($inputData),
                'result_data' => json_encode($resultData),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('calculator_usage', $data);
            
        } catch (Exception $e) {
            error_log("Calculator tracking error: " . $e->getMessage());
        }
    }
    
    /**
     * Track event
     */
    public function trackEvent($eventName, $eventData = []) {
        try {
            $data = [
                'event_name' => $eventName,
                'event_data' => json_encode($eventData),
                'user_id' => $_SESSION['user_id'] ?? null,
                'ip_address' => $this->getClientIP(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('events', $data);
            
        } catch (Exception $e) {
            error_log("Event tracking error: " . $e->getMessage());
        }
    }
    
    /**
     * Get popular calculators
     */
    public function getPopularCalculators($limit = 10) {
        try {
            return $this->db->fetchAll("
                SELECT c.id, c.name, c.slug, c.category, COUNT(cu.id) as usage_count
                FROM calculators c
                LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id
                WHERE c.is_active = 1
                GROUP BY c.id
                ORDER BY usage_count DESC
                LIMIT ?
            ", [$limit]);
        } catch (Exception $e) {
            error_log("Get popular calculators error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get page views statistics
     */
    public function getPageViewsStats($startDate, $endDate) {
        try {
            return $this->db->fetchAll("
                SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as views,
                    COUNT(DISTINCT ip_address) as unique_visitors
                FROM page_views
                WHERE created_at BETWEEN ? AND ?
                GROUP BY DATE(created_at)
                ORDER BY date DESC
            ", [$startDate, $endDate]);
        } catch (Exception $e) {
            error_log("Get page views stats error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get calculator usage statistics
     */
    public function getCalculatorStats($calculatorId) {
        try {
            return $this->db->fetch("
                SELECT 
                    COUNT(*) as total_uses,
                    COUNT(DISTINCT user_id) as unique_users,
                    COUNT(DISTINCT ip_address) as unique_visitors
                FROM calculator_usage
                WHERE calculator_id = ?
            ", [$calculatorId]);
        } catch (Exception $e) {
            error_log("Get calculator stats error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get user activity
     */
    public function getUserActivity($userId, $limit = 20) {
        try {
            return $this->db->fetchAll("
                SELECT 
                    cu.created_at,
                    c.name as calculator_name,
                    c.slug,
                    c.category
                FROM calculator_usage cu
                JOIN calculators c ON cu.calculator_id = c.id
                WHERE cu.user_id = ?
                ORDER BY cu.created_at DESC
                LIMIT ?
            ", [$userId, $limit]);
        } catch (Exception $e) {
            error_log("Get user activity error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get dashboard statistics
     */
    public function getDashboardStats() {
        try {
            $stats = [];
            
            // Total page views
            $stats['total_page_views'] = $this->db->fetchColumn("SELECT COUNT(*) FROM page_views");
            
            // Total calculator uses
            $stats['total_calculator_uses'] = $this->db->fetchColumn("SELECT COUNT(*) FROM calculator_usage");
            
            // Total users
            $stats['total_users'] = $this->db->fetchColumn("SELECT COUNT(*) FROM users WHERE is_active = 1");
            
            // Today's stats
            $stats['today_views'] = $this->db->fetchColumn("
                SELECT COUNT(*) FROM page_views WHERE DATE(created_at) = CURDATE()
            ");
            
            $stats['today_calculations'] = $this->db->fetchColumn("
                SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = CURDATE()
            ");
            
            return $stats;
            
        } catch (Exception $e) {
            error_log("Get dashboard stats error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get client IP
     */
    private function getClientIP() {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (isset($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
                return $_SERVER[$key];
            }
        }
        
        return '0.0.0.0';
    }
}