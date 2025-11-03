-- Migration: Create Roles Table
-- Version: 008
-- Description: Role-based access control - Roles table

CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default roles
INSERT INTO `roles` (`name`, `slug`, `description`) VALUES
('Administrator', 'admin', 'Full system access with all permissions'),
('Moderator', 'moderator', 'Can manage content and users'),
('User', 'user', 'Regular user with basic permissions')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);