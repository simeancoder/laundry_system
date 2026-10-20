-- ====================================================================
-- Laundry Management System - Reports Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sales',
  `date_range` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generated_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `generated_on` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Completed',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old report records before inserting the official 25 baseline reports
TRUNCATE TABLE `reports`;

-- 3. Insert Exactly the 25 Baseline Reports Matching Teacher Screenshot
INSERT INTO `reports` (
  `id`,
  `name`,
  `type`,
  `date_range`,
  `generated_by`,
  `generated_on`,
  `status`,
  `created_at`,
  `updated_at`
) VALUES
-- Page 1 (Rows 1 to 5 from screenshot)
(1, 'Daily Sales Report', 'Sales', '01 May 2024', 'Admin', '01 May 2024 10:30 AM', 'Completed', NOW(), NOW()),
(2, 'Monthly Sales Report', 'Sales', 'April 2024', 'Admin', '01 May 2024 10:25 AM', 'Completed', NOW(), NOW()),
(3, 'Laundry Order Report', 'Order', '01 Apr 2024 - 30 Apr 2024', 'Admin', '01 May 2024 10:20 AM', 'Completed', NOW(), NOW()),
(4, 'Payment Report', 'Payment', '01 Apr 2024 - 30 Apr 2024', 'Admin', '01 May 2024 10:15 AM', 'Completed', NOW(), NOW()),
(5, 'Inventory Report', 'Inventory', '30 Apr 2024', 'Admin', '30 Apr 2024 05:40 PM', 'Completed', NOW(), NOW()),

-- Page 2 (Rows 6 to 10)
(6, 'Employee Report', 'Employee', '01 Apr 2024 - 30 Apr 2024', 'Admin', '30 Apr 2024 04:30 PM', 'Completed', NOW(), NOW()),
(7, 'Machine Usage Report', 'Machine', '01 Apr 2024 - 30 Apr 2024', 'Admin', '30 Apr 2024 03:15 PM', 'Completed', NOW(), NOW()),
(8, 'Delivery Report', 'Delivery', '01 Apr 2024 - 30 Apr 2024', 'Admin', '30 Apr 2024 02:00 PM', 'Completed', NOW(), NOW()),
(9, 'Service Popularity Report', 'Service', '01 Apr 2024 - 30 Apr 2024', 'Admin', '30 Apr 2024 11:30 AM', 'Completed', NOW(), NOW()),
(10, 'Customer Report', 'Customer', '01 Apr 2024 - 30 Apr 2024', 'Admin', '30 Apr 2024 09:45 AM', 'Completed', NOW(), NOW()),

-- Page 3 (Rows 11 to 15)
(11, 'Daily Sales Report', 'Sales', '30 Apr 2024', 'Admin', '30 Apr 2024 08:30 PM', 'Completed', NOW(), NOW()),
(12, 'Daily Sales Report', 'Sales', '29 Apr 2024', 'Admin', '29 Apr 2024 08:30 PM', 'Completed', NOW(), NOW()),
(13, 'Laundry Order Report', 'Order', '15 Apr 2024 - 21 Apr 2024', 'Admin', '22 Apr 2024 10:00 AM', 'Completed', NOW(), NOW()),
(14, 'Payment Report', 'Payment', '15 Apr 2024 - 21 Apr 2024', 'Admin', '22 Apr 2024 09:30 AM', 'Completed', NOW(), NOW()),
(15, 'Inventory Report', 'Inventory', '15 Apr 2024', 'Admin', '15 Apr 2024 04:00 PM', 'Completed', NOW(), NOW()),

-- Page 4 (Rows 16 to 20)
(16, 'Machine Usage Report', 'Machine', '01 Apr 2024 - 15 Apr 2024', 'Admin', '16 Apr 2024 11:00 AM', 'Completed', NOW(), NOW()),
(17, 'Delivery Report', 'Delivery', '08 Apr 2024 - 14 Apr 2024', 'Admin', '15 Apr 2024 02:20 PM', 'Completed', NOW(), NOW()),
(18, 'Monthly Sales Report', 'Sales', 'March 2024', 'Admin', '01 Apr 2024 10:00 AM', 'Completed', NOW(), NOW()),
(19, 'Laundry Order Report', 'Order', '01 Mar 2024 - 31 Mar 2024', 'Admin', '01 Apr 2024 09:30 AM', 'Completed', NOW(), NOW()),
(20, 'Payment Report', 'Payment', '01 Mar 2024 - 31 Mar 2024', 'Admin', '01 Apr 2024 09:00 AM', 'Completed', NOW(), NOW()),

-- Page 5 (Rows 21 to 25)
(21, 'Customer Report', 'Customer', '01 Mar 2024 - 31 Mar 2024', 'Admin', '31 Mar 2024 04:30 PM', 'Completed', NOW(), NOW()),
(22, 'Employee Report', 'Employee', '01 Mar 2024 - 31 Mar 2024', 'Admin', '31 Mar 2024 03:00 PM', 'Completed', NOW(), NOW()),
(23, 'Inventory Report', 'Inventory', '31 Mar 2024', 'Admin', '31 Mar 2024 01:15 PM', 'Completed', NOW(), NOW()),
(24, 'Service Popularity Report', 'Service', '01 Mar 2024 - 31 Mar 2024', 'Admin', '30 Mar 2024 10:45 AM', 'Completed', NOW(), NOW()),
(25, 'Machine Usage Report', 'Machine', '01 Mar 2024 - 31 Mar 2024', 'Admin', '30 Mar 2024 09:30 AM', 'Completed', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
