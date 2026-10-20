-- ====================================================================
-- Laundry Management System - Discount & Promotion Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage Discount',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '%',
  `start_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Expired','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old promotion records before inserting the official 6 promotions
TRUNCATE TABLE `promotions`;

-- 3. Insert Exactly the 6 Baseline Promotions from Screenshot
-- Total Promotions: 6 | Active: 4 | Expired: 2 | Coupon Codes: 6
INSERT INTO `promotions` (
  `id`,
  `name`,
  `type`,
  `discount_value`,
  `discount_unit`,
  `start_date`,
  `end_date`,
  `coupon_code`,
  `description`,
  `status`,
  `created_at`,
  `updated_at`
) VALUES
(
  1,
  'Back to School Special',
  'Percentage Discount',
  20.00,
  '%',
  '2025-09-01',
  '2025-09-30',
  'SCHOOL20',
  'Special seasonal discount for students and educators on all laundry and washing services.',
  'Active',
  NOW(),
  NOW()
),
(
  2,
  'New Customer Discount',
  'Fixed Amount',
  5.00,
  '$',
  '2025-09-01',
  '2025-12-31',
  'WELCOME5',
  'First-time customer welcome bonus applicable on any drop-off laundry or dry cleaning basket.',
  'Active',
  NOW(),
  NOW()
),
(
  3,
  'Loyalty Program',
  'Loyalty Discount',
  10.00,
  '%',
  '2025-01-01',
  '2025-12-31',
  'LOYALTY10',
  'Exclusive member reward discount for our returning loyal clients throughout the year.',
  'Active',
  NOW(),
  NOW()
),
(
  4,
  'Summer Sale',
  'Percentage Discount',
  15.00,
  '%',
  '2025-07-01',
  '2025-07-31',
  'SUMMER15',
  'Mid-year summer promotion on bulk washing, drying, and ironing services.',
  'Active',
  NOW(),
  NOW()
),
(
  5,
  'Holiday Promotion',
  'Fixed Amount',
  10.00,
  '$',
  '2025-12-20',
  '2025-12-31',
  'HOLIDAY10',
  'Festive end of year promotion for blankets, comforters, and holiday apparel.',
  'Expired',
  NOW(),
  NOW()
),
(
  6,
  'VIP Member Discount',
  'Percentage Discount',
  25.00,
  '%',
  '2025-08-01',
  '2025-08-31',
  'VIP25',
  'Special anniversary appreciation offer exclusively for VIP cardholders.',
  'Expired',
  NOW(),
  NOW()
);

SET FOREIGN_KEY_CHECKS = 1;
