<?php
/**
 * Base Calculator Class
 * Abstract class for all calculator implementations
 */

abstract class Calculator {
    protected $inputs = [];
    protected $results = [];
    protected $errors = [];
    protected $name = '';
    protected $category = '';
    protected $description = '';
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->name = static::getName();
        $this->category = static::getCategory();
        $this->description = static::getDescription();
    }
    
    /**
     * Get calculator name
     */
    abstract public static function getName();
    
    /**
     * Get calculator category
     */
    abstract public static function getCategory();
    
    /**
     * Get calculator description
     */
    abstract public static function getDescription();
    
    /**
     * Validate inputs
     */
    abstract protected function validate();
    
    /**
     * Perform calculation
     */
    abstract protected function calculate();
    
    /**
     * Set input values
     */
    public function setInputs($inputs) {
        $this->inputs = $inputs;
        return $this;
    }
    
    /**
     * Set single input
     */
    public function setInput($key, $value) {
        $this->inputs[$key] = $value;
        return $this;
    }
    
    /**
     * Get input value
     */
    public function getInput($key, $default = null) {
        return $this->inputs[$key] ?? $default;
    }
    
    /**
     * Get all inputs
     */
    public function getInputs() {
        return $this->inputs;
    }
    
    /**
     * Run calculation
     */
    public function run() {
        $this->errors = [];
        
        if (!$this->validate()) {
            return false;
        }
        
        try {
            $this->calculate();
            return true;
        } catch (Exception $e) {
            $this->addError('calculation', $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get results
     */
    public function getResults() {
        return $this->results;
    }
    
    /**
     * Get single result
     */
    public function getResult($key, $default = null) {
        return $this->results[$key] ?? $default;
    }
    
    /**
     * Set result
     */
    protected function setResult($key, $value) {
        $this->results[$key] = $value;
        return $this;
    }
    
    /**
     * Add error
     */
    protected function addError($field, $message) {
        $this->errors[$field] = $message;
    }
    
    /**
     * Get errors
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Check if has errors
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * Format number
     */
    protected function formatNumber($number, $decimals = 2) {
        return number_format($number, $decimals, '.', ',');
    }
    
    /**
     * Format currency
     */
    protected function formatCurrency($amount, $currency = '$') {
        return $currency . $this->formatNumber($amount, 2);
    }
    
    /**
     * Format percentage
     */
    protected function formatPercentage($value, $decimals = 2) {
        return $this->formatNumber($value, $decimals) . '%';
    }
    
    /**
     * Save calculation to database
     */
    public function save($userId = null) {
        try {
            $db = Database::getInstance();
            
            $data = [
                'user_id' => $userId,
                'calculator_name' => $this->name,
                'input_data' => json_encode($this->inputs),
                'result_data' => json_encode($this->results),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            return $db->insert('calculator_usage', $data);
            
        } catch (Exception $e) {
            error_log("Save calculation error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Track usage
     */
    public function trackUsage($userId = null) {
        try {
            $db = Database::getInstance();
            
            $data = [
                'user_id' => $userId,
                'calculator_name' => $this->name,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->insert('calculator_usage', $data);
            
        } catch (Exception $e) {
            error_log("Track usage error: " . $e->getMessage());
        }
    }
}