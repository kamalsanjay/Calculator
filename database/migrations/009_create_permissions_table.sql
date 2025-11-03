-- Migration: Create Permissions Table
-- Version: 009
-- Description: Role-based access control - Permissions table

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default permissions
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
('Backup Database', 'backup_database', 'Create database backups')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);