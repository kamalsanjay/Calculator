<?php
/**
 * Input Validation Class
 * Provides validation methods for user inputs
 */

class Validator {
    private $errors = [];
    private $data = [];
    
    /**
     * Constructor
     */
    public function __construct($data = []) {
        $this->data = $data;
    }
    
    /**
     * Set data
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Required field validation
     */
    public function required($field, $message = null) {
        if (!isset($this->data[$field]) || empty(trim($this->data[$field]))) {
            $message = $message ?: ucfirst($field) . " is required";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Email validation
     */
    public function email($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $message = $message ?: "Invalid email address";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Minimum length validation
     */
    public function min($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $message = $message ?: ucfirst($field) . " must be at least {$length} characters";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Maximum length validation
     */
    public function max($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $message = $message ?: ucfirst($field) . " must not exceed {$length} characters";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Numeric validation
     */
    public function numeric($field, $message = null) {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $message = $message ?: ucfirst($field) . " must be a number";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Integer validation
     */
    public function integer($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
            $message = $message ?: ucfirst($field) . " must be an integer";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Float validation
     */
    public function float($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_FLOAT)) {
            $message = $message ?: ucfirst($field) . " must be a decimal number";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * URL validation
     */
    public function url($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
            $message = $message ?: "Invalid URL";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Date validation
     */
    public function date($field, $format = 'Y-m-d', $message = null) {
        if (isset($this->data[$field])) {
            $d = DateTime::createFromFormat($format, $this->data[$field]);
            if (!$d || $d->format($format) !== $this->data[$field]) {
                $message = $message ?: "Invalid date format";
                $this->errors[$field] = $message;
            }
        }
        return $this;
    }
    
    /**
     * Match fields validation
     */
    public function match($field1, $field2, $message = null) {
        if (isset($this->data[$field1]) && isset($this->data[$field2]) && 
            $this->data[$field1] !== $this->data[$field2]) {
            $message = $message ?: ucfirst($field1) . " and " . ucfirst($field2) . " must match";
            $this->errors[$field1] = $message;
        }
        return $this;
    }
    
    /**
     * Regular expression validation
     */
    public function regex($field, $pattern, $message = null) {
        if (isset($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $message = $message ?: ucfirst($field) . " format is invalid";
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * In array validation
     */
    public function in($field, $values, $message = null) {
        if (isset($this->data[$field]) && !in_array($this->data[$field], $values)) {
            $message = $message ?: ucfirst($field) . " must be one of: " . implode(', ', $values);
            $this->errors[$field] = $message;
        }
        return $this;
    }
    
    /**
     * Unique validation (database)
     */
    public function unique($field, $table, $column = null, $message = null) {
        $column = $column ?: $field;
        
        if (isset($this->data[$field])) {
            try {
                $db = Database::getInstance();
                $result = $db->fetch("SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?", [$this->data[$field]]);
                
                if ($result['count'] > 0) {
                    $message = $message ?: ucfirst($field) . " already exists";
                    $this->errors[$field] = $message;
                }
            } catch (Exception $e) {
                error_log("Unique validation error: " . $e->getMessage());
            }
        }
        return $this;
    }
    
    /**
     * Between validation
     */
    public function between($field, $min, $max, $message = null) {
        if (isset($this->data[$field])) {
            $value = $this->data[$field];
            if ($value < $min || $value > $max) {
                $message = $message ?: ucfirst($field) . " must be between {$min} and {$max}";
                $this->errors[$field] = $message;
            }
        }
        return $this;
    }
    
    /**
     * Check if validation passes
     */
    public function passes() {
        return empty($this->errors);
    }
    
    /**
     * Check if validation fails
     */
    public function fails() {
        return !empty($this->errors);
    }
    
    /**
     * Get errors
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Get first error
     */
    public function getFirstError() {
        return !empty($this->errors) ? reset($this->errors) : null;
    }
    
    /**
     * Add custom error
     */
    public function addError($field, $message) {
        $this->errors[$field] = $message;
        return $this;
    }
    
    /**
     * Sanitize input
     */
    public static function sanitize($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}