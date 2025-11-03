<?php
/**
 * Database Setup Script
 * Creates all necessary tables and inserts initial data
 */

require_once 'config.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getPDO();
    
    echo "<h1>Setting up Calculator Database</h1>";
    echo "<pre>";
    
    // Drop existing tables if needed (optional)
    if (isset($_GET['reset']) && $_GET['reset'] === 'yes') {
        echo "Dropping existing tables...\n";
        $pdo->exec("DROP TABLE IF EXISTS calculator_usage");
        $pdo->exec("DROP TABLE IF EXISTS saved_calculations");
        $pdo->exec("DROP TABLE IF EXISTS page_analytics");
        $pdo->exec("DROP TABLE IF EXISTS ad_performance");
        $pdo->exec("DROP TABLE IF EXISTS login_attempts");
        $pdo->exec("DROP TABLE IF EXISTS refresh_tokens");
        $pdo->exec("DROP TABLE IF EXISTS two_factor_auth");
        $pdo->exec("DROP TABLE IF EXISTS password_reset_tokens");
        $pdo->exec("DROP TABLE IF EXISTS email_verifications");
        $pdo->exec("DROP TABLE IF EXISTS sessions");
        $pdo->exec("DROP TABLE IF EXISTS activity_logs");
        $pdo->exec("DROP TABLE IF EXISTS calculators");
        $pdo->exec("DROP TABLE IF EXISTS categories");
        $pdo->exec("DROP TABLE IF EXISTS users");
        $pdo->exec("DROP TABLE IF EXISTS settings");
        echo "✓ Tables dropped\n\n";
    }
    
    // Create users table
    echo "Creating users table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            email_verified TINYINT(1) DEFAULT 0,
            verification_token VARCHAR(255) NULL,
            email_verified_at DATETIME NULL,
            is_active TINYINT(1) DEFAULT 1,
            last_login DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_email (email),
            INDEX idx_username (username)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Users table created\n";
    
    // Create categories table
    echo "Creating categories table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) UNIQUE NOT NULL,
            icon VARCHAR(50) NULL,
            description TEXT NULL,
            display_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_slug (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Categories table created\n";
    
    // Create calculators table
    echo "Creating calculators table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS calculators (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(200) NOT NULL,
            slug VARCHAR(200) UNIQUE NOT NULL,
            category VARCHAR(50) NOT NULL,
            subcategory VARCHAR(50) NULL,
            description TEXT NULL,
            formula TEXT NULL,
            page_views INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            display_order INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_slug (slug),
            INDEX idx_category (category),
            INDEX idx_active (is_active)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Calculators table created\n";
    
    // Create calculator_usage table
    echo "Creating calculator_usage table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS calculator_usage (
            id INT AUTO_INCREMENT PRIMARY KEY,
            calculator_id INT NULL,
            user_id INT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            input_data JSON NULL,
            result_data JSON NULL,
            calculation_time DECIMAL(10,6) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_calculator (calculator_id),
            INDEX idx_user (user_id),
            INDEX idx_created (created_at),
            FOREIGN KEY (calculator_id) REFERENCES calculators(id) ON DELETE SET NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Calculator usage table created\n";
    
    // Create saved_calculations table
    echo "Creating saved_calculations table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS saved_calculations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            calculator_id INT NULL,
            calculation_name VARCHAR(200) NULL,
            input_data JSON NULL,
            result_data JSON NULL,
            notes TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user (user_id),
            INDEX idx_calculator (calculator_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (calculator_id) REFERENCES calculators(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Saved calculations table created\n";
    
    // Create page_analytics table
    echo "Creating page_analytics table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS page_analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page_url VARCHAR(500) NOT NULL,
            page_title VARCHAR(200) NULL,
            page_views INT DEFAULT 0,
            unique_visitors INT DEFAULT 0,
            avg_time_on_page INT DEFAULT 0,
            bounce_rate DECIMAL(5,2) DEFAULT 0.00,
            date DATE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_url (page_url(255)),
            INDEX idx_date (date),
            UNIQUE KEY unique_page_date (page_url(255), date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Page analytics table created\n";
    
    // Create ad_performance table
    echo "Creating ad_performance table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS ad_performance (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ad_position VARCHAR(50) NOT NULL,
            page_url VARCHAR(500) NOT NULL,
            impressions INT DEFAULT 0,
            clicks INT DEFAULT 0,
            ctr DECIMAL(5,2) DEFAULT 0.00,
            revenue DECIMAL(10,2) DEFAULT 0.00,
            date DATE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_position (ad_position),
            INDEX idx_date (date),
            UNIQUE KEY unique_ad_date (ad_position, page_url(255), date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Ad performance table created\n";
    
    // Create login_attempts table
    echo "Creating login_attempts table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS login_attempts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            status VARCHAR(20) NOT NULL,
            user_agent TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_email (email),
            INDEX idx_ip (ip_address),
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Login attempts table created\n";
    
    // Create sessions table
    echo "Creating sessions table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS sessions (
            id VARCHAR(128) PRIMARY KEY,
            user_id INT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            payload TEXT NOT NULL,
            last_activity INT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user (user_id),
            INDEX idx_last_activity (last_activity),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Sessions table created\n";
    
    // Create settings table
    echo "Creating settings table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT NULL,
            setting_type VARCHAR(20) DEFAULT 'text',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_key (setting_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Settings table created\n";
    
    // Create activity_logs table
    echo "Creating activity_logs table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS activity_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            action VARCHAR(100) NOT NULL,
            description TEXT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user (user_id),
            INDEX idx_action (action),
            INDEX idx_created (created_at),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Activity logs table created\n";
    
    // Insert default admin user
    echo "\nCreating default admin user...\n";
    $adminPassword = password_hash('Admin@123', PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password, role, email_verified, is_active, created_at)
        VALUES (?, ?, ?, 'admin', 1, 1, NOW())
        ON DUPLICATE KEY UPDATE username = username
    ");
    
    $stmt->execute(['admin', 'admin@calculator.com', $adminPassword]);
    echo "✓ Admin user created\n";
    echo "  Username: admin\n";
    echo "  Email: admin@calculator.com\n";
    echo "  Password: Admin@123\n\n";
    
    // Insert categories
    echo "Inserting categories...\n";
    $categories = [
        ['Financial', 'financial', 'dollar-sign', 'Financial calculators for loans, mortgages, investments', 1],
        ['Health & Fitness', 'health', 'heartbeat', 'Health and fitness calculators', 2],
        ['Math', 'math', 'calculator', 'Mathematical calculators and tools', 3],
        ['Conversion', 'conversion', 'exchange-alt', 'Unit conversion calculators', 4],
        ['Date & Time', 'date-time', 'calendar', 'Date and time calculators', 5],
        ['Construction', 'construction', 'hammer', 'Construction and building calculators', 6],
        ['Electronics', 'electronics', 'bolt', 'Electronics calculators', 7],
        ['Automotive', 'automotive', 'car', 'Automotive calculators', 8],
        ['Education', 'education', 'graduation-cap', 'Education calculators', 9],
        ['Utility', 'utility', 'tools', 'Utility tools and calculators', 10],
        ['Weather', 'weather', 'cloud', 'Weather calculators', 11],
        ['Cooking', 'cooking', 'utensils', 'Cooking calculators', 12],
        ['Gaming', 'gaming', 'gamepad', 'Gaming calculators', 13],
        ['Sports', 'sports', 'football-ball', 'Sports calculators', 14]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO categories (name, slug, icon, description, display_order, is_active)
        VALUES (?, ?, ?, ?, ?, 1)
        ON DUPLICATE KEY UPDATE name = name
    ");
    
    foreach ($categories as $cat) {
        $stmt->execute($cat);
    }
    echo "✓ Categories inserted\n";
    
    // Insert sample calculators
    echo "Inserting sample calculators...\n";
    $calculators = [
        ['BMI Calculator', 'bmi-calculator', 'health', 'Calculate your Body Mass Index', 'BMI = weight / (height * height)'],
        ['Mortgage Calculator', 'mortgage-calculator', 'financial', 'Calculate monthly mortgage payments', 'M = P[r(1+r)^n]/[(1+r)^n-1]'],
        ['Loan Calculator', 'loan-calculator', 'financial', 'Calculate loan payments', 'Payment = Principal × r × (1 + r)^n / ((1 + r)^n - 1)'],
        ['Percentage Calculator', 'percentage-calculator', 'math', 'Calculate percentages', 'Percentage = (Value / Total) × 100'],
        ['Age Calculator', 'age-calculator', 'date-time', 'Calculate your age', 'Age = Current Date - Birth Date']
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO calculators (name, slug, category, description, formula, is_active)
        VALUES (?, ?, ?, ?, ?, 1)
        ON DUPLICATE KEY UPDATE name = name
    ");
    
    foreach ($calculators as $calc) {
        $stmt->execute($calc);
    }
    echo "✓ Sample calculators inserted\n";
    
    echo "\n";
    echo "========================================\n";
    echo "✓ DATABASE SETUP COMPLETE!\n";
    echo "========================================\n";
    echo "\nAdmin Login Details:\n";
    echo "URL: http://localhost/Calculator/admin/login.php\n";
    echo "Username: admin\n";
    echo "Email: admin@calculator.com\n";
    echo "Password: Admin@123\n";
    echo "\n⚠️  Please change the password after first login!\n";
    echo "========================================\n";
    
    echo "</pre>";
    
    echo "<p><a href='admin/login.php' style='display:inline-block; padding:15px 30px; background:#28a745; color:white; text-decoration:none; border-radius:8px; margin-top:20px;'>Go to Admin Login</a></p>";
    
} catch (Exception $e) {
    echo "<div style='color:red; padding:20px; background:#ffe6e6; border-radius:8px;'>";
    echo "<h2>❌ Error Setting Up Database</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}
?>