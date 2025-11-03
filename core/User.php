<?php
/**
 * User Model Class
 * Handles user-related database operations
 */

class User {
    private $db;
    private $id;
    private $data = [];
    
    /**
     * Constructor
     */
    public function __construct($id = null) {
        $this->db = Database::getInstance();
        
        if ($id) {
            $this->id = $id;
            $this->load();
        }
    }
    
    /**
     * Load user data
     */
    public function load() {
        try {
            $this->data = $this->db->fetch("SELECT * FROM users WHERE id = ?", [$this->id]);
            return $this->data ? true : false;
        } catch (Exception $e) {
            error_log("Load user error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create new user
     */
    public static function create($data) {
        $db = Database::getInstance();
        
        try {
            // Hash password
            if (isset($data['password'])) {
                $data['password'] = Password::hash($data['password']);
            }
            
            // Set defaults
            $data['role'] = $data['role'] ?? ROLE_USER;
            $data['is_active'] = $data['is_active'] ?? 1;
            $data['email_verified'] = $data['email_verified'] ?? 0;
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $userId = $db->insert('users', $data);
            
            return new self($userId);
            
        } catch (Exception $e) {
            error_log("Create user error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update user
     */
    public function update($data) {
        try {
            // Hash password if provided
            if (isset($data['password'])) {
                $data['password'] = Password::hash($data['password']);
            }
            
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->db->update('users', $data, 'id = ?', [$this->id]);
            
            // Reload data
            $this->load();
            
            return true;
            
        } catch (Exception $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete user
     */
    public function delete() {
        try {
            // Delete user data
            $this->db->delete('saved_calculations', 'user_id = ?', [$this->id]);
            $this->db->delete('calculator_usage', 'user_id = ?', [$this->id]);
            $this->db->delete('user_settings', 'user_id = ?', [$this->id]);
            $this->db->delete('remember_tokens', 'user_id = ?', [$this->id]);
            $this->db->delete('password_resets', 'user_id = ?', [$this->id]);
            $this->db->delete('email_verifications', 'user_id = ?', [$this->id]);
            $this->db->delete('two_factor_auth', 'user_id = ?', [$this->id]);
            
            // Delete user
            $this->db->delete('users', 'id = ?', [$this->id]);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find user by email
     */
    public static function findByEmail($email) {
        $db = Database::getInstance();
        
        try {
            $user = $db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
            
            if ($user) {
                $instance = new self();
                $instance->id = $user['id'];
                $instance->data = $user;
                return $instance;
            }
            
            return null;
            
        } catch (Exception $e) {
            error_log("Find user by email error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Find user by username
     */
    public static function findByUsername($username) {
        $db = Database::getInstance();
        
        try {
            $user = $db->fetch("SELECT * FROM users WHERE username = ?", [$username]);
            
            if ($user) {
                $instance = new self();
                $instance->id = $user['id'];
                $instance->data = $user;
                return $instance;
            }
            
            return null;
            
        } catch (Exception $e) {
            error_log("Find user by username error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get all users
     */
    public static function all($limit = 100, $offset = 0) {
        $db = Database::getInstance();
        
        try {
            return $db->fetchAll("
                SELECT * FROM users 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?
            ", [$limit, $offset]);
        } catch (Exception $e) {
            error_log("Get all users error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get user statistics
     */
    public function getStats() {
        try {
            $stats = [];
            
            // Total calculations
            $stats['total_calculations'] = $this->db->fetchColumn("
                SELECT COUNT(*) FROM calculator_usage WHERE user_id = ?
            ", [$this->id]);
            
            // Saved calculations
            $stats['saved_calculations'] = $this->db->fetchColumn("
                SELECT COUNT(*) FROM saved_calculations WHERE user_id = ?
            ", [$this->id]);
            
            // Member since
            $stats['member_since'] = $this->data['created_at'] ?? null;
            
            // Last login
            $stats['last_login'] = $this->data['last_login'] ?? null;
            
            return $stats;
            
        } catch (Exception $e) {
            error_log("Get user stats error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get saved calculations
     */
    public function getSavedCalculations($limit = 20) {
        try {
            return $this->db->fetchAll("
                SELECT sc.*, c.name as calculator_name, c.slug, c.category
                FROM saved_calculations sc
                JOIN calculators c ON sc.calculator_id = c.id
                WHERE sc.user_id = ?
                ORDER BY sc.created_at DESC
                LIMIT ?
            ", [$this->id, $limit]);
        } catch (Exception $e) {
            error_log("Get saved calculations error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get calculation history
     */
    public function getHistory($limit = 50) {
        try {
            return $this->db->fetchAll("
                SELECT cu.*, c.name as calculator_name, c.slug, c.category
                FROM calculator_usage cu
                JOIN calculators c ON cu.calculator_id = c.id
                WHERE cu.user_id = ?
                ORDER BY cu.created_at DESC
                LIMIT ?
            ", [$this->id, $limit]);
        } catch (Exception $e) {
            error_log("Get history error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verify email
     */
    public function verifyEmail() {
        return $this->update(['email_verified' => 1]);
    }
    
    /**
     * Check if email is verified
     */
    public function isEmailVerified() {
        return (bool) ($this->data['email_verified'] ?? false);
    }
    
    /**
     * Check if active
     */
    public function isActive() {
        return (bool) ($this->data['is_active'] ?? false);
    }
    
    /**
     * Get property
     */
    public function __get($name) {
        return $this->data[$name] ?? null;
    }
    
    /**
     * Set property
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    
    /**
     * Check if property exists
     */
    public function __isset($name) {
        return isset($this->data[$name]);
    }
}