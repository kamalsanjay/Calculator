-- ========================================
-- Calculator Website - Database Schema
-- Version: 1.0.0
-- Database: MySQL 8.0+ / MariaDB 10.5+
-- Character Set: utf8mb4 (Full Unicode Support)
-- ========================================

-- Set character set and collation
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Drop database if exists (CAUTION: This will delete all data!)
-- Uncomment the next line only for fresh installation
-- DROP DATABASE IF EXISTS calculator_dev;

-- Create database
CREATE DATABASE IF NOT EXISTS calculator_dev
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Use the database
USE calculator_dev;

-- ========================================
-- TABLE 1: users
-- Stores user account information
-- ========================================

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) DEFAULT NULL,
    last_name VARCHAR(50) DEFAULT NULL,
    role ENUM('user', 'admin', 'moderator') DEFAULT 'user',
    avatar VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    country VARCHAR(50) DEFAULT NULL,
    timezone VARCHAR(50) DEFAULT 'America/New_York',
    is_active BOOLEAN DEFAULT TRUE,
    is_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(100) DEFAULT NULL,
    reset_token VARCHAR(100) DEFAULT NULL,
    reset_token_expires DATETIME DEFAULT NULL,
    last_login DATETIME DEFAULT NULL,
    login_attempts INT DEFAULT 0,
    lockout_until DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_is_active (is_active),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 2: categories
-- Stores calculator categories
-- ========================================

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(50) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description TEXT DEFAULT NULL,
    meta_keywords VARCHAR(255) DEFAULT NULL,
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_slug (slug),
    INDEX idx_is_active (is_active),
    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 3: calculators
-- Stores calculator information
-- ========================================

CREATE TABLE IF NOT EXISTS calculators (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    subcategory VARCHAR(100) DEFAULT NULL,
    description TEXT NOT NULL,
    long_description TEXT DEFAULT NULL,
    formula TEXT DEFAULT NULL,
    formula_explanation TEXT DEFAULT NULL,
    how_to_use TEXT DEFAULT NULL,
    example TEXT DEFAULT NULL,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description TEXT DEFAULT NULL,
    meta_keywords VARCHAR(255) DEFAULT NULL,
    schema_markup JSON DEFAULT NULL,
    featured BOOLEAN DEFAULT FALSE,
    trending BOOLEAN DEFAULT FALSE,
    page_views INT UNSIGNED DEFAULT 0,
    unique_visitors INT UNSIGNED DEFAULT 0,
    calculation_count INT UNSIGNED DEFAULT 0,
    avg_time_on_page INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_category_id (category_id),
    INDEX idx_is_active (is_active),
    INDEX idx_featured (featured),
    INDEX idx_trending (trending),
    INDEX idx_page_views (page_views),
    FULLTEXT idx_search (name, description, meta_keywords)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 4: calculator_usage
-- Tracks every calculation performed
-- ========================================

CREATE TABLE IF NOT EXISTS calculator_usage (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calculator_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED DEFAULT NULL,
    session_id VARCHAR(100) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    browser VARCHAR(50) DEFAULT NULL,
    device VARCHAR(50) DEFAULT NULL,
    os VARCHAR(50) DEFAULT NULL,
    country VARCHAR(50) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    input_data JSON NOT NULL,
    result_data JSON NOT NULL,
    calculation_time DECIMAL(10, 6) DEFAULT 0.000000,
    success BOOLEAN DEFAULT TRUE,
    error_message TEXT DEFAULT NULL,
    referrer VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (calculator_id) REFERENCES calculators(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_calculator_id (calculator_id),
    INDEX idx_user_id (user_id),
    INDEX idx_session_id (session_id),
    INDEX idx_ip_address (ip_address),
    INDEX idx_created_at (created_at),
    INDEX idx_success (success)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 5: saved_calculations
-- Stores user's saved calculations
-- ========================================

CREATE TABLE IF NOT EXISTS saved_calculations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    calculator_id INT UNSIGNED NOT NULL,
    calculation_name VARCHAR(200) DEFAULT NULL,
    input_data JSON NOT NULL,
    result_data JSON NOT NULL,
    notes TEXT DEFAULT NULL,
    is_favorite BOOLEAN DEFAULT FALSE,
    share_token VARCHAR(100) DEFAULT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (calculator_id) REFERENCES calculators(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_calculator_id (calculator_id),
    INDEX idx_is_favorite (is_favorite),
    INDEX idx_share_token (share_token),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 6: page_analytics
-- Tracks page-level analytics
-- ========================================

CREATE TABLE IF NOT EXISTS page_analytics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_url VARCHAR(255) NOT NULL,
    page_title VARCHAR(255) DEFAULT NULL,
    page_type ENUM('home', 'category', 'calculator', 'other') DEFAULT 'other',
    page_views INT UNSIGNED DEFAULT 0,
    unique_visitors INT UNSIGNED DEFAULT 0,
    avg_time_on_page INT UNSIGNED DEFAULT 0,
    bounce_rate DECIMAL(5, 2) DEFAULT 0.00,
    exit_rate DECIMAL(5, 2) DEFAULT 0.00,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_page_date (page_url, date),
    INDEX idx_page_url (page_url),
    INDEX idx_date (date),
    INDEX idx_page_type (page_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 7: ad_performance
-- Tracks AdSense ad performance
-- ========================================

CREATE TABLE IF NOT EXISTS ad_performance (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ad_position ENUM('vertical_1', 'vertical_2', 'horizontal_1', 'horizontal_2') NOT NULL,
    page_url VARCHAR(255) NOT NULL,
    page_type VARCHAR(50) DEFAULT NULL,
    impressions INT UNSIGNED DEFAULT 0,
    clicks INT UNSIGNED DEFAULT 0,
    ctr DECIMAL(5, 2) DEFAULT 0.00,
    revenue DECIMAL(10, 2) DEFAULT 0.00,
    rpm DECIMAL(10, 2) DEFAULT 0.00,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_ad_page_date (ad_position, page_url, date),
    INDEX idx_ad_position (ad_position),
    INDEX idx_page_url (page_url),
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 8: search_queries
-- Tracks user search queries
-- ========================================

CREATE TABLE IF NOT EXISTS search_queries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    query VARCHAR(255) NOT NULL,
    user_id INT UNSIGNED DEFAULT NULL,
    session_id VARCHAR(100) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    results_count INT DEFAULT 0,
    clicked_result_id INT UNSIGNED DEFAULT NULL,
    no_results BOOLEAN DEFAULT FALSE,
    search_time DECIMAL(10, 6) DEFAULT 0.000000,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_query (query),
    INDEX idx_user_id (user_id),
    INDEX idx_session_id (session_id),
    INDEX idx_created_at (created_at),
    INDEX idx_no_results (no_results)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 9: user_sessions
-- Tracks active user sessions
-- ========================================

CREATE TABLE IF NOT EXISTS user_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED DEFAULT NULL,
    session_id VARCHAR(100) NOT NULL UNIQUE,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    browser VARCHAR(50) DEFAULT NULL,
    device VARCHAR(50) DEFAULT NULL,
    os VARCHAR(50) DEFAULT NULL,
    country VARCHAR(50) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    referrer VARCHAR(255) DEFAULT NULL,
    landing_page VARCHAR(255) DEFAULT NULL,
    pages_viewed INT DEFAULT 0,
    calculations_performed INT DEFAULT 0,
    session_duration INT DEFAULT 0,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_session_id (session_id),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 10: calculator_ratings
-- Stores calculator ratings and reviews
-- ========================================

CREATE TABLE IF NOT EXISTS calculator_ratings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calculator_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED DEFAULT NULL,
    rating TINYINT UNSIGNED NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review TEXT DEFAULT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    helpful_count INT DEFAULT 0,
    not_helpful_count INT DEFAULT 0,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (calculator_id) REFERENCES calculators(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_calculator_id (calculator_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_is_approved (is_approved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 11: notifications
-- Stores user notifications
-- ========================================

CREATE TABLE IF NOT EXISTS notifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    link VARCHAR(255) DEFAULT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 12: api_keys
-- Stores API keys for external access
-- ========================================

CREATE TABLE IF NOT EXISTS api_keys (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    api_key VARCHAR(64) NOT NULL UNIQUE,
    api_secret VARCHAR(128) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    rate_limit INT DEFAULT 100,
    requests_made INT DEFAULT 0,
    last_used_at TIMESTAMP NULL DEFAULT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    expires_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_api_key (api_key),
    INDEX idx_user_id (user_id),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 13: error_logs
-- Stores application errors
-- ========================================

CREATE TABLE IF NOT EXISTS error_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    error_type VARCHAR(50) NOT NULL,
    error_message TEXT NOT NULL,
    error_code VARCHAR(20) DEFAULT NULL,
    file_path VARCHAR(255) DEFAULT NULL,
    line_number INT DEFAULT NULL,
    stack_trace TEXT DEFAULT NULL,
    user_id INT UNSIGNED DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    request_uri VARCHAR(255) DEFAULT NULL,
    request_method VARCHAR(10) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    severity ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    is_resolved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_error_type (error_type),
    INDEX idx_severity (severity),
    INDEX idx_is_resolved (is_resolved),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLE 14: system_settings
-- Stores system-wide settings
-- ========================================

CREATE TABLE IF NOT EXISTS system_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT DEFAULT NULL,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description TEXT DEFAULT NULL,
    is_editable BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- INSERT DEFAULT CATEGORIES
-- ========================================

INSERT INTO categories (name, slug, icon, description, display_order, is_active) VALUES
('Financial', 'financial', '💰', 'Financial calculators for mortgages, loans, investments, and budgeting', 1, TRUE),
('Health & Fitness', 'health', '🏥', 'Health and fitness calculators including BMI, calorie, and nutrition tools', 2, TRUE),
('Math', 'math', '🔢', 'Mathematical calculators for algebra, geometry, statistics, and more', 3, TRUE),
('Conversion', 'conversion', '🔄', 'Unit conversion tools for length, weight, temperature, and more', 4, TRUE),
('Date & Time', 'date-time', '📅', 'Date and time calculators for age, duration, and calendar calculations', 5, TRUE),
('Construction', 'construction', '🏗️', 'Construction calculators for materials, measurements, and estimates', 6, TRUE),
('Electronics', 'electronics', '⚡', 'Electronics calculators for circuits, resistors, and electrical calculations', 7, TRUE),
('Automotive', 'automotive', '🚗', 'Automotive calculators for fuel economy, horsepower, and vehicle specs', 8, TRUE),
('Education', 'education', '🎓', 'Educational calculators for GPA, grades, and academic planning', 9, TRUE),
('Utility', 'utility', '🛠️', 'Utility tools including random generators, converters, and helpers', 10, TRUE),
('Weather', 'weather', '🌤️', 'Weather calculators for temperature, humidity, and atmospheric conditions', 11, TRUE),
('Cooking', 'cooking', '🍳', 'Cooking calculators for recipes, conversions, and meal planning', 12, TRUE),
('Gaming', 'gaming', '🎮', 'Gaming calculators for stats, damage, and game-specific tools', 13, TRUE),
('Sports', 'sports', '⚽', 'Sports calculators for pace, performance, and athletic metrics', 14, TRUE);

-- ========================================
-- INSERT DEFAULT SYSTEM SETTINGS
-- ========================================

INSERT INTO system_settings (setting_key, setting_value, setting_type, description, is_editable) VALUES
('site_name', 'Calculator', 'string', 'Website name', TRUE),
('site_tagline', 'Free Online Calculators & Tools', 'string', 'Website tagline', TRUE),
('maintenance_mode', 'false', 'boolean', 'Enable maintenance mode', TRUE),
('allow_registration', 'true', 'boolean', 'Allow new user registration', TRUE),
('enable_comments', 'true', 'boolean', 'Enable calculator comments/reviews', TRUE),
('enable_ratings', 'true', 'boolean', 'Enable calculator ratings', TRUE),
('items_per_page', '20', 'number', 'Default items per page', TRUE),
('max_login_attempts', '5', 'number', 'Maximum login attempts before lockout', TRUE),
('session_timeout', '3600', 'number', 'Session timeout in seconds', TRUE),
('enable_api', 'true', 'boolean', 'Enable API access', TRUE),
('enable_analytics', 'true', 'boolean', 'Enable analytics tracking', TRUE),
('enable_adsense', 'true', 'boolean', 'Enable Google AdSense', TRUE);

-- ========================================
-- CREATE VIEWS FOR COMMON QUERIES
-- ========================================

-- View: Popular Calculators
CREATE OR REPLACE VIEW popular_calculators AS
SELECT 
    c.id,
    c.name,
    c.slug,
    c.category_id,
    cat.name AS category_name,
    cat.slug AS category_slug,
    c.page_views,
    c.calculation_count,
    c.is_active
FROM calculators c
JOIN categories cat ON c.category_id = cat.id
WHERE c.is_active = TRUE
ORDER BY c.page_views DESC
LIMIT 20;

-- View: Daily Statistics
CREATE OR REPLACE VIEW daily_statistics AS
SELECT 
    DATE(created_at) AS date,
    COUNT(*) AS total_calculations,
    COUNT(DISTINCT calculator_id) AS unique_calculators_used,
    COUNT(DISTINCT COALESCE(user_id, session_id)) AS unique_users,
    AVG(calculation_time) AS avg_calculation_time
FROM calculator_usage
GROUP BY DATE(created_at)
ORDER BY date DESC;

-- View: Category Statistics
CREATE OR REPLACE VIEW category_statistics AS
SELECT 
    cat.id,
    cat.name,
    cat.slug,
    COUNT(c.id) AS total_calculators,
    SUM(c.page_views) AS total_views,
    SUM(c.calculation_count) AS total_calculations,
    AVG(c.page_views) AS avg_views_per_calculator
FROM categories cat
LEFT JOIN calculators c ON cat.id = c.category_id
WHERE cat.is_active = TRUE
GROUP BY cat.id, cat.name, cat.slug
ORDER BY cat.display_order;

-- ========================================
-- CREATE STORED PROCEDURES
-- ========================================

DELIMITER //

-- Procedure: Update Calculator Statistics
CREATE PROCEDURE update_calculator_stats(IN calc_id INT)
BEGIN
    UPDATE calculators
    SET 
        calculation_count = calculation_count + 1,
        page_views = page_views + 1
    WHERE id = calc_id;
END//

-- Procedure: Clean Old Sessions
CREATE PROCEDURE clean_old_sessions()
BEGIN
    DELETE FROM user_sessions
    WHERE last_activity < DATE_SUB(NOW(), INTERVAL 24 HOUR);
END//

-- Procedure: Get Top Calculators by Category
CREATE PROCEDURE get_top_calculators_by_category(IN cat_id INT, IN limit_count INT)
BEGIN
    SELECT 
        c.id,
        c.name,
        c.slug,
        c.description,
        c.page_views,
        c.calculation_count
    FROM calculators c
    WHERE c.category_id = cat_id AND c.is_active = TRUE
    ORDER BY c.page_views DESC
    LIMIT limit_count;
END//

DELIMITER ;

-- ========================================
-- CREATE TRIGGERS
-- ========================================

DELIMITER //

-- Trigger: Update calculator trend status
CREATE TRIGGER update_trending_status
AFTER UPDATE ON calculators
FOR EACH ROW
BEGIN
    IF NEW.page_views > 1000 AND NEW.page_views > OLD.page_views * 1.5 THEN
        UPDATE calculators SET trending = TRUE WHERE id = NEW.id;
    END IF;
END//

-- Trigger: Log calculation usage
CREATE TRIGGER log_calculation
AFTER INSERT ON calculator_usage
FOR EACH ROW
BEGIN
    UPDATE calculators
    SET calculation_count = calculation_count + 1
    WHERE id = NEW.calculator_id;
END//

DELIMITER ;

-- ========================================
-- CREATE EVENTS (Scheduled Tasks)
-- ========================================

-- Enable event scheduler
SET GLOBAL event_scheduler = ON;

-- Event: Clean old sessions daily
CREATE EVENT IF NOT EXISTS clean_sessions_daily
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
    CALL clean_old_sessions();

-- Event: Update daily statistics
CREATE EVENT IF NOT EXISTS update_daily_stats
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
    INSERT INTO page_analytics (page_url, page_views, unique_visitors, date)
    SELECT 
        'summary' AS page_url,
        COUNT(*) AS page_views,
        COUNT(DISTINCT COALESCE(user_id, session_id)) AS unique_visitors,
        CURDATE() AS date
    FROM calculator_usage
    WHERE DATE(created_at) = CURDATE();

-- ========================================
-- GRANT PRIVILEGES (Adjust as needed)
-- ========================================

-- Create application user (uncomment and modify for production)
-- CREATE USER 'calculator_user'@'localhost' IDENTIFIED BY 'your_secure_password';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON calculator_dev.* TO 'calculator_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ========================================
-- SCHEMA COMPLETE
-- ========================================
-- Total Tables: 14
-- Total Views: 3
-- Total Procedures: 3
-- Total Triggers: 2
-- Total Events: 2
-- ========================================