-- ====================================================================
-- Laundry Management System - Inventory Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for inventories
CREATE TABLE IF NOT EXISTS `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `status` enum('In Stock','Low Stock','Out of Stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'In Stock',
  `min_stock` int(11) NOT NULL DEFAULT 15,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `last_restocked` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old inventory records before inserting the official 6 items
TRUNCATE TABLE `inventories`;

-- 3. Insert Exactly the 6 Inventory Items from Screenshot
-- Total Items: 6 | In Stock: 4 | Low Stock: 2
INSERT INTO `inventories` (
  `id`, 
  `name`, 
  `category`, 
  `stock`, 
  `unit`, 
  `status`, 
  `min_stock`, 
  `notes`, 
  `supplier`, 
  `unit_price`, 
  `last_restocked`, 
  `created_at`, 
  `updated_at`
) VALUES
(
  1, 
  'Detergent', 
  'Cleaning', 
  50, 
  'L', 
  'In Stock', 
  20, 
  'High efficiency commercial liquid laundry detergent for washing machines.', 
  'EcoChem Supplies Co.', 
  12.50, 
  '2026-10-01', 
  NOW(), 
  NOW()
),
(
  2, 
  'Softener', 
  'Cleaning', 
  40, 
  'L', 
  'In Stock', 
  15, 
  'Fresh blossom scented fabric conditioner for delicate & everyday fabrics.', 
  'SilkTouch Chemical Ltd', 
  10.00, 
  '2026-10-02', 
  NOW(), 
  NOW()
),
(
  3, 
  'Bleach', 
  'Cleaning', 
  10, 
  'L', 
  'Low Stock', 
  15, 
  'Chlorine-based disinfectant bleach for white garments and linen sanitizing.', 
  'CleanMaster Ind.', 
  8.00, 
  '2026-09-28', 
  NOW(), 
  NOW()
),
(
  4, 
  'Packing Bags', 
  'Packaging', 
  100, 
  'Pcs', 
  'In Stock', 
  30, 
  'Durable transparent plastic garment packaging bags with printed store logo.', 
  'Khmer Pack Solutions', 
  0.25, 
  '2026-10-03', 
  NOW(), 
  NOW()
),
(
  5, 
  'Hangers', 
  'Accessories', 
  200, 
  'Pcs', 
  'In Stock', 
  50, 
  'Sturdy wire and plastic coat hangers for ironed shirts, suits and dresses.', 
  'Universal Hanger Ltd', 
  0.15, 
  '2026-10-02', 
  NOW(), 
  NOW()
),
(
  6, 
  'Cleaning Chemicals', 
  'Chemicals', 
  15, 
  'L', 
  'Low Stock', 
  20, 
  'Enzyme-based spotting agent reagents for grease, rust, and wine stain removal.', 
  'ProWash Chemicals Global', 
  22.00, 
  '2026-09-25', 
  NOW(), 
  NOW()
);

SET FOREIGN_KEY_CHECKS = 1;
