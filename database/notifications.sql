-- ====================================================================
-- Laundry Management System - Notifications Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Order Ready',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Order Ready',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'All Customers',
  `scheduled_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Sent','Pending','Scheduled','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old notification records before inserting the official 32 notifications
TRUNCATE TABLE `notifications`;

-- 3. Insert Exactly the 32 Baseline Notifications Matching Teacher Screenshot
INSERT INTO `notifications` (
  `id`,
  `type`,
  `title`,
  `message`,
  `target`,
  `scheduled_date`,
  `status`,
  `created_at`,
  `updated_at`
) VALUES
(1, 'Order Ready', 'Order Ready', 'Your order #ORD-0010 is ready for pickup.', 'Sokha Dara', '2025-09-15 10:24 AM', 'Sent', NOW(), NOW()),
(2, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0009 today.', 'Chan Sreyneath', '2025-09-14 09:00 AM', 'Sent', NOW(), NOW()),
(3, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0008 is out for delivery.', 'Heng Channa', '2025-09-13 02:30 PM', 'Sent', NOW(), NOW()),
(4, 'Payment Reminder', 'Payment Reminder', 'Your payment for order #ORD-0007 is pending.', 'Lim Vannak', '2025-09-12 11:00 AM', 'Pending', NOW(), NOW()),
(5, 'Promotion', 'Promotion', 'Get 20% OFF on dry cleaning service this week!', 'All Customers', '2025-09-12 09:00 AM', 'Sent', NOW(), NOW()),
(6, 'Order Ready', 'Order Ready', 'Your order #ORD-0006 is ready for pickup.', 'Kim Sovannary', '2025-09-11 03:20 PM', 'Sent', NOW(), NOW()),
(7, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0005 today.', 'Thon Sreynich', '2025-09-11 10:00 AM', 'Sent', NOW(), NOW()),
(8, 'Payment Reminder', 'Payment Reminder', 'Your payment for order #ORD-0004 is pending.', 'Pich Sothey', '2025-09-10 04:15 PM', 'Sent', NOW(), NOW()),
(9, 'Promotion', 'Promotion', 'Happy New Month! 15% OFF for all services.', 'All Customers', '2025-09-10 09:00 AM', 'Scheduled', NOW(), NOW()),
(10, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0003 is out for delivery.', 'Va Sovan', '2025-09-09 01:45 PM', 'Sent', NOW(), NOW()),
(11, 'Order Ready', 'Order Ready', 'Your order #ORD-0002 is ready for pickup.', 'Meng Chhay', '2025-09-09 11:15 AM', 'Sent', NOW(), NOW()),
(12, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0001 today.', 'Keo Pisey', '2025-09-08 09:30 AM', 'Sent', NOW(), NOW()),
(13, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0032 is out for delivery.', 'Chea Ratanak', '2025-09-08 03:00 PM', 'Sent', NOW(), NOW()),
(14, 'Payment Reminder', 'Payment Reminder', 'Your payment for order #ORD-0030 is pending.', 'Seng Rath', '2025-09-07 10:45 AM', 'Sent', NOW(), NOW()),
(15, 'Order Ready', 'Order Ready', 'Your order #ORD-0028 is ready for pickup.', 'Somnang Bun', '2025-09-07 02:20 PM', 'Sent', NOW(), NOW()),
(16, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0026 today.', 'Korm Theara', '2025-09-06 08:50 AM', 'Sent', NOW(), NOW()),
(17, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0023 is out for delivery.', 'Nhem Vicheka', '2025-09-06 01:10 PM', 'Sent', NOW(), NOW()),
(18, 'Payment Reminder', 'Payment Reminder', 'Your payment for order #ORD-0021 is pending.', 'Chan Borey', '2025-09-05 11:30 AM', 'Pending', NOW(), NOW()),
(19, 'Order Ready', 'Order Ready', 'Your order #ORD-0019 is ready for pickup.', 'Tep Sreypov', '2025-09-05 04:00 PM', 'Sent', NOW(), NOW()),
(20, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0018 today.', 'Oun Sreymom', '2025-09-04 09:15 AM', 'Sent', NOW(), NOW()),
(21, 'Order Ready', 'Order Ready', 'Your order #ORD-0017 is ready for pickup.', 'Phan Sopheak', '2025-09-04 02:40 PM', 'Sent', NOW(), NOW()),
(22, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0016 is out for delivery.', 'Hout Kolap', '2025-09-03 10:20 AM', 'Sent', NOW(), NOW()),
(23, 'Order Ready', 'Order Ready', 'Your order #ORD-0015 is ready for pickup.', 'Vorn Kosal', '2025-09-03 03:50 PM', 'Sent', NOW(), NOW()),
(24, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0014 today.', 'Ly Davin', '2025-09-02 08:30 AM', 'Sent', NOW(), NOW()),
(25, 'Order Ready', 'Order Ready', 'Your order #ORD-0013 is ready for pickup.', 'Prak Chanthou', '2025-09-02 01:25 PM', 'Sent', NOW(), NOW()),
(26, 'Delivery Reminder', 'Delivery Reminder', 'Your order #ORD-0012 is out for delivery.', 'Say Piseth', '2025-09-01 11:40 AM', 'Sent', NOW(), NOW()),
(27, 'Order Ready', 'Order Ready', 'Your order #ORD-0011 is ready for pickup.', 'Ros Samnang', '2025-09-01 04:10 PM', 'Sent', NOW(), NOW()),
(28, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0033 today.', 'Kruy Sreymao', '2025-08-31 09:00 AM', 'Sent', NOW(), NOW()),
(29, 'Order Ready', 'Order Ready', 'Your order #ORD-0034 is ready for pickup.', 'Nuon Vanna', '2025-08-30 02:15 PM', 'Sent', NOW(), NOW()),
(30, 'Pickup Reminder', 'Pickup Reminder', 'Please pick up your order #ORD-0035 today.', 'Sok Sreymom', '2025-08-30 10:30 AM', 'Sent', NOW(), NOW()),
(31, 'Order Ready', 'Order Ready', 'Your order #ORD-0036 is ready for pickup.', 'Chhit Visal', '2025-08-29 03:00 PM', 'Sent', NOW(), NOW()),
(32, 'Order Ready', 'Order Ready', 'Your order #ORD-0037 is ready for pickup.', 'Pen Socheat', '2025-08-28 11:20 AM', 'Sent', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
