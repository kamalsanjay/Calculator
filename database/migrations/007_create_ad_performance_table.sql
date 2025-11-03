-- Migration: Create Ad Performance Table
-- Version: 007
-- Description: Track advertisement performance metrics

CREATE TABLE IF NOT EXISTS `ad_performance` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad_position` VARCHAR(50) NOT NULL,
  `page_url` VARCHAR(500) NOT NULL,
  `impressions` INT UNSIGNED DEFAULT 0,
  `clicks` INT UNSIGNED DEFAULT 0,
  `ctr` DECIMAL(5,2) DEFAULT 0.00 COMMENT 'Click-through rate',
  `revenue` DECIMAL(10,2) DEFAULT 0.00,
  `date` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ad_date` (`ad_position`, `page_url`(255), `date`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;