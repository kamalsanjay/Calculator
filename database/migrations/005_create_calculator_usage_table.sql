-- Migration: Create Calculator Usage Table
-- Version: 005
-- Description: Track calculator usage and calculations

CREATE TABLE IF NOT EXISTS `calculator_usage` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `calculator_id` INT UNSIGNED DEFAULT NULL,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT,
  `input_data` JSON DEFAULT NULL,
  `result_data` JSON DEFAULT NULL,
  `calculation_time` DECIMAL(10,4) DEFAULT NULL COMMENT 'Time in seconds',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_calculator_id` (`calculator_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_calculator_created` (`calculator_id`, `created_at`),
  KEY `idx_user_created` (`user_id`, `created_at`),
  CONSTRAINT `fk_calculator_usage_calculator` FOREIGN KEY (`calculator_id`) REFERENCES `calculators` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_calculator_usage_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;