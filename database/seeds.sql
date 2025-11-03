-- Sample Data for Calculator Website
-- Insert test data for development/testing

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================
-- ROLES AND PERMISSIONS
-- =============================================

-- Insert Roles
INSERT INTO `roles` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Administrator', 'admin', 'Full system access with all permissions'),
(2, 'Moderator', 'moderator', 'Can manage content and users'),
(3, 'User', 'user', 'Regular user with basic permissions');

-- Insert Permissions
INSERT INTO `permissions` (`name`, `slug`, `description`) VALUES
('Manage Users', 'manage_users', 'Create, edit, and delete users'),
('Manage Calculators', 'manage_calculators', 'Create, edit, and delete calculators'),
('View Analytics', 'view_analytics', 'Access analytics and reports'),
('Manage Settings', 'manage_settings', 'Modify system settings'),
('Manage Roles', 'manage_roles', 'Create and modify roles'),
('Manage Permissions', 'manage_permissions', 'Assign permissions to roles'),
('View Logs', 'view_logs', 'Access system logs'),
('Manage Ads', 'manage_ads', 'Configure advertisements'),
('Send Emails', 'send_emails', 'Send email notifications'),
('Backup Database', 'backup_database', 'Create database backups');

-- Assign Permissions to Admin Role
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT 1, id FROM `permissions`;

-- Assign Limited Permissions to Moderator Role
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT 2, id FROM `permissions` 
WHERE slug IN ('manage_calculators', 'view_analytics', 'view_logs');

-- =============================================
-- USERS
-- =============================================

-- Insert Admin User (password: Admin@123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `is_active`, `email_verified`) VALUES
('admin', 'admin@calculator.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5oBd.vlABjPBi', 1, 1, 1);

-- Insert Test Users (password: User@123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `is_active`, `email_verified`) VALUES
('john_doe', 'john@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 1, 1),
('jane_smith', 'jane@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 1, 1),
('bob_wilson', 'bob@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 1, 0),
('moderator', 'moderator@calculator.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, 1);

-- Insert User Settings
INSERT INTO `user_settings` (`user_id`, `theme`, `language`, `email_notifications`, `newsletter_subscription`) VALUES
(1, 'dark', 'en', 1, 1),
(2, 'light', 'en', 1, 0),
(3, 'light', 'en', 1, 1),
(4, 'light', 'en', 0, 0),
(5, 'dark', 'en', 1, 1);

-- =============================================
-- CATEGORIES
-- =============================================

INSERT INTO `categories` (`name`, `slug`, `icon`, `description`, `display_order`, `is_active`) VALUES
('Financial', 'financial', '💰', 'Financial calculators for mortgages, loans, investments, and more', 1, 1),
('Health & Fitness', 'health', '🏥', 'Health and fitness calculators including BMI, calories, and body metrics', 2, 1),
('Math', 'math', '🔢', 'Mathematical calculators for algebra, geometry, statistics, and more', 3, 1),
('Conversion', 'conversion', '🔄', 'Unit conversion tools for length, weight, temperature, and more', 4, 1),
('Date & Time', 'date-time', '📅', 'Date and time calculators including age, duration, and countdown', 5, 1),
('Construction', 'construction', '🏗️', 'Construction calculators for materials, measurements, and estimates', 6, 1),
('Electronics', 'electronics', '⚡', 'Electronics calculators for circuits, power, and resistance', 7, 1),
('Automotive', 'automotive', '🚗', 'Automotive calculators for fuel, performance, and maintenance', 8, 1),
('Education', 'education', '🎓', 'Education calculators for grades, GPA, and academic planning', 9, 1),
('Utility', 'utility', '🛠️', 'Utility tools including generators, counters, and converters', 10, 1),
('Weather', 'weather', '🌤️', 'Weather-related calculators and conversion tools', 11, 1),
('Cooking', 'cooking', '🍳', 'Cooking and recipe calculators for measurements and conversions', 12, 1),
('Gaming', 'gaming', '🎮', 'Gaming calculators for stats, odds, and game-specific tools', 13, 1),
('Sports', 'sports', '⚽', 'Sports calculators for performance, pace, and statistics', 14, 1);

-- =============================================
-- CALCULATORS (Sample - Top 20)
-- =============================================

INSERT INTO `calculators` (`name`, `slug`, `category`, `description`, `formula`, `is_active`) VALUES
-- Financial
('Mortgage Calculator', 'mortgage-calculator', 'financial', 'Calculate monthly mortgage payments based on loan amount, interest rate, and term', 'M = P[r(1+r)^n]/[(1+r)^n-1]', 1),
('Loan Calculator', 'loan-calculator', 'financial', 'Calculate loan payments, interest, and amortization schedules', 'Payment = Principal × (Rate × (1 + Rate)^N) / ((1 + Rate)^N - 1)', 1),
('Investment Calculator', 'investment-calculator', 'financial', 'Calculate investment returns with compound interest', 'A = P(1 + r/n)^(nt)', 1),
('Retirement Calculator', 'retirement-calculator', 'financial', 'Plan your retirement savings and estimate future value', 'FV = PV(1 + r)^n + PMT[((1 + r)^n - 1) / r]', 1),
('Savings Calculator', 'savings-calculator', 'financial', 'Calculate savings growth with regular contributions', 'FV = PV(1 + r)^n + C[((1 + r)^n - 1) / r]', 1),

-- Health
('BMI Calculator', 'bmi-calculator', 'health', 'Calculate Body Mass Index from height and weight', 'BMI = weight(kg) / height(m)²', 1),
('Calorie Calculator', 'calorie-calculator', 'health', 'Calculate daily caloric needs based on activity level', 'BMR × Activity Factor', 1),
('BMR Calculator', 'bmr-calculator', 'health', 'Calculate Basal Metabolic Rate using Mifflin-St Jeor equation', 'BMR = (10 × weight) + (6.25 × height) - (5 × age) + s', 1),
('Body Fat Calculator', 'body-fat-calculator', 'health', 'Estimate body fat percentage using measurements', 'Various formulas based on method', 1),
('Pregnancy Calculator', 'pregnancy-calculator', 'health', 'Calculate due date and pregnancy milestones', 'Due Date = LMP + 280 days', 1),

-- Math
('Percentage Calculator', 'percentage-calculator', 'math', 'Calculate percentages, increases, and decreases', 'Percentage = (Part / Whole) × 100', 1),
('Fraction Calculator', 'fraction-calculator', 'math', 'Add, subtract, multiply, and divide fractions', 'Various operations on fractions', 1),
('Scientific Calculator', 'scientific-calculator', 'math', 'Advanced calculator with scientific functions', 'Multiple mathematical operations', 1),
('Standard Deviation Calculator', 'standard-deviation-calculator', 'math', 'Calculate standard deviation and variance', 'σ = √(Σ(x - μ)² / N)', 1),

-- Conversion
('Length Converter', 'length-converter', 'conversion', 'Convert between different length units', 'Conversion factors between units', 1),
('Temperature Converter', 'temperature-converter', 'conversion', 'Convert between Celsius, Fahrenheit, and Kelvin', 'C = (F - 32) × 5/9', 1),
('Weight Converter', 'weight-converter', 'conversion', 'Convert between kilograms, pounds, and other weight units', 'Conversion factors between units', 1),

-- Date & Time
('Age Calculator', 'age-calculator', 'date-time', 'Calculate age in years, months, and days', 'Current Date - Birth Date', 1),
('Date Calculator', 'date-calculator', 'date-time', 'Add or subtract days, weeks, months from a date', 'Date arithmetic operations', 1),

-- Education
('GPA Calculator', 'gpa-calculator', 'education', 'Calculate Grade Point Average from course grades', 'GPA = Σ(Grade Points × Credits) / Σ Credits', 1);

-- =============================================
-- SAMPLE ANALYTICS DATA
-- =============================================

-- Insert Sample Page Views (last 30 days)
INSERT INTO `page_views` (`page_url`, `page_title`, `ip_address`, `user_id`, `created_at`)
SELECT 
    CONCAT('/calculators/', category, '/', slug) as page_url,
    name as page_title,
    CONCAT('192.168.1.', FLOOR(1 + RAND() * 254)) as ip_address,
    CASE WHEN RAND() > 0.7 THEN FLOOR(1 + RAND() * 5) ELSE NULL END as user_id,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 30) DAY) as created_at
FROM calculators, 
     (SELECT @row := @row + 1 as row FROM 
      (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) t1,
      (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) t2,
      (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) t3) numbers
WHERE (@row := 0) = 0
LIMIT 1000;

-- Insert Sample Calculator Usage
INSERT INTO `calculator_usage` (`calculator_id`, `user_id`, `ip_address`, `input_data`, `result_data`, `created_at`)
SELECT 
    id as calculator_id,
    CASE WHEN RAND() > 0.6 THEN FLOOR(1 + RAND() * 5) ELSE NULL END as user_id,
    CONCAT('192.168.1.', FLOOR(1 + RAND() * 254)) as ip_address,
    '{"input1": 100, "input2": 200}' as input_data,
    '{"result": 300}' as result_data,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 30) DAY) as created_at
FROM calculators, 
     (SELECT @row := @row + 1 as row FROM 
      (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) t1,
      (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3) t2) numbers
WHERE (@row := 0) = 0
LIMIT 500;

-- Update calculator page views based on usage
UPDATE calculators c
SET page_views = (
    SELECT COUNT(*) 
    FROM page_views pv 
    WHERE pv.page_url LIKE CONCAT('%', c.slug, '%')
);

-- =============================================
-- SAMPLE SAVED CALCULATIONS
-- =============================================

INSERT INTO `saved_calculations` (`user_id`, `calculator_id`, `calculation_name`, `input_data`, `result_data`, `notes`) VALUES
(2, 1, 'My Home Mortgage', '{"principal": 300000, "rate": 3.5, "years": 30}', '{"monthly_payment": 1347.13}', 'For my new house purchase'),
(2, 6, 'Current BMI', '{"weight": 75, "height": 1.75}', '{"bmi": 24.49}', 'Monthly tracking'),
(3, 3, 'Retirement Plan', '{"initial": 50000, "monthly": 500, "years": 30, "rate": 7}', '{"future_value": 678146.28}', 'Long-term retirement savings');

-- =============================================
-- ADMIN ACTIONS LOG
-- =============================================

INSERT INTO `admin_actions` (`user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, 'admin_login', 'Admin logged into the system', '127.0.0.1', NOW()),
(1, 'user_create', 'Created new user account', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(1, 'settings_update', 'Updated site settings', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(5, 'calculator_update', 'Updated calculator configuration', '192.168.1.10', DATE_SUB(NOW(), INTERVAL 1 DAY));

SET FOREIGN_KEY_CHECKS = 1;

-- Show summary
SELECT 'Database seeded successfully!' as message;
SELECT COUNT(*) as user_count FROM users;
SELECT COUNT(*) as calculator_count FROM calculators;
SELECT COUNT(*) as category_count FROM categories;
SELECT COUNT(*) as page_view_count FROM page_views;