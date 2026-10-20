-- ====================================================================
-- Laundry Management System - Settings Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create Table Structure for database_backups
CREATE TABLE IF NOT EXISTS `database_backups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filesize` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0 KB',
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Clear old records to avoid duplication
TRUNCATE TABLE `settings`;
TRUNCATE TABLE `database_backups`;

-- 4. Insert Default Baseline Settings (Matching Teacher Screenshot exactly)
INSERT INTO `settings` (`key`, `value`, `group`, `description`, `created_at`, `updated_at`) VALUES
-- Laundry Information
('laundry_name', 'Clean & Fresh Laundry', 'laundry_info', 'Name of the laundry business', NOW(), NOW()),
('phone_number', '012 345 678', 'laundry_info', 'Contact phone number', NOW(), NOW()),
('email', 'info@cleanfresh.com', 'laundry_info', 'Contact email address', NOW(), NOW()),
('address', '#123, Street 456, Sangkat Boeung Kak, Khan Toul Kork, Phnom Penh, Cambodia', 'laundry_info', 'Physical address of laundry shop', NOW(), NOW()),
('logo', 'default_logo.png', 'laundry_info', 'Laundry shop logo file', NOW(), NOW()),

-- Business Hours
('hours_monday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Monday', NOW(), NOW()),
('hours_tuesday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Tuesday', NOW(), NOW()),
('hours_wednesday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Wednesday', NOW(), NOW()),
('hours_thursday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Thursday', NOW(), NOW()),
('hours_friday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Friday', NOW(), NOW()),
('hours_saturday', '{\"from\":\"07:00 AM\",\"to\":\"07:00 PM\",\"active\":1}', 'business_hours', 'Operating hours for Saturday', NOW(), NOW()),
('hours_sunday', '{\"from\":\"Closed\",\"to\":\"\",\"active\":0}', 'business_hours', 'Operating hours for Sunday', NOW(), NOW()),

-- Pricing Configuration
('pricing_wash_fold', '1.50', 'pricing', 'Wash & Fold Price (USD)', NOW(), NOW()),
('pricing_ironing', '0.80', 'pricing', 'Ironing Price (USD)', NOW(), NOW()),
('pricing_dry_cleaning', '3.00', 'pricing', 'Dry Cleaning Price (USD)', NOW(), NOW()),
('pricing_blanket', '4.00', 'pricing', 'Blanket Price (USD)', NOW(), NOW()),
('pricing_curtain', '2.00', 'pricing', 'Curtain Price (USD)', NOW(), NOW()),
('pricing_shoes_cleaning', '2.50', 'pricing', 'Shoes Cleaning Price (USD)', NOW(), NOW()),

-- Tax Settings
('tax_name', 'Value Added Tax (VAT)', 'tax', 'Tax name or designation', NOW(), NOW()),
('tax_rate', '10', 'tax', 'Tax rate percentage', NOW(), NOW()),
('tax_type', 'Inclusive', 'tax', 'Tax calculation type (Inclusive/Exclusive)', NOW(), NOW()),
('apply_tax_on', 'All Services', 'tax', 'Services subject to this tax', NOW(), NOW()),

-- Backup Meta
('last_backup_date', '01 May 2024 10:30 AM', 'backup', 'Date and time of last database backup', NOW(), NOW()),
('last_backup_by', 'Admin', 'backup', 'User who ran the last backup', NOW(), NOW());

-- 5. Insert Baseline Database Backup Record
INSERT INTO `database_backups` (`id`, `filename`, `filesize`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'backup_20240501.sql', '24.6 MB', 'Admin', '2024-05-01 10:30:00', '2024-05-01 10:30:00');

SET FOREIGN_KEY_CHECKS = 1;
