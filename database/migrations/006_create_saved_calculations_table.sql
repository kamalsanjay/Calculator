-- Migration: Create Saved Calculations Table
-- Version: 006
-- Description: Allow users to save their calculations

CREATE TABLE IF NOT EXISTS `saved_calculations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `calculator_id` INT UNSIGNED NOT NULL,
  `calculation_name` VARCHAR(200) DEFAULT NULL,
  `input_data` JSON NOT NULL,
  `result_data` JSON NOT NULL,
  `notes` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_calculator_id` (`calculator_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_saved_calculations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_saved_calculations_calculator` FOREIGN KEY (`calculator_id`) REFERENCES `calculators` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;