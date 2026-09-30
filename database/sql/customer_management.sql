-- ========================================================
-- Database: laundry_management_system
-- Table Structure and Sample Data for Customer Management
-- Compatible with MySQL / MariaDB / Navicat / phpMyAdmin
-- ========================================================

CREATE DATABASE IF NOT EXISTS `laundry_management_system` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laundry_management_system`;

-- --------------------------------------------------------
-- Table structure for table `customers`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'REGULAR',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_customer_id_unique` (`customer_id`),
  KEY `customers_phone_index` (`phone`),
  KEY `customers_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `customer_orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Delivered',
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `customer_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `customers`
-- --------------------------------------------------------
INSERT INTO `customers` (`id`, `customer_id`, `name`, `phone`, `email`, `address`, `tier`, `status`, `avatar`, `registration_date`, `created_at`, `updated_at`) VALUES
(1, 'C0001', 'Sokha Dara', '012 345 678', 'sokha@example.com', 'Svay Dangkum, SR', 'GOLD', 'Active', NULL, '2025-08-01', NOW(), NOW()),
(2, 'C0002', 'Chan Sreyneath', '011 234 567', 'sreyneath@example.com', 'Taphul, SR', 'SILVER', 'Active', NULL, '2025-08-05', NOW(), NOW()),
(3, 'C0003', 'Heng Chana', '017 890 123', 'channa@example.com', 'Sala Kamreuk, SR', 'BRONZE', 'Active', NULL, '2025-08-10', NOW(), NOW()),
(4, 'C0004', 'Kim Sovannary', '015 678 901', 'sovannary@example.com', 'Svay Dangkum, SR', 'GOLD', 'Active', NULL, '2025-08-14', NOW(), NOW()),
(5, 'C0005', 'Neang Pheaktra', '010 555 888', 'pheaktra@example.com', 'Kok Chork, SR', 'REGULAR', 'Active', NULL, '2025-08-18', NOW(), NOW()),
(6, 'C0006', 'Lim Vannak', '016 222 333', 'vannak@example.com', 'National Road 6, SR', 'SILVER', 'Active', NULL, '2025-08-22', NOW(), NOW()),
(7, 'C0007', 'Thon Sreynich', '092 777 666', 'sreynich@example.com', 'Taphul, SR', 'REGULAR', 'Active', NULL, '2025-08-26', NOW(), NOW()),
(8, 'C0008', 'Pich Sothy', '012 999 444', 'sothy@example.com', 'Sla Kram, SR', 'GOLD', 'Active', NULL, '2025-08-30', NOW(), NOW()),
(9, 'C0009', 'Chea Ratanak', '097 333 222', 'ratanak@example.com', 'Bakheng, SR', 'BRONZE', 'Active', NULL, '2025-09-02', NOW(), NOW()),
(10, 'C0010', 'Va Sovan', '099 666 777', 'sovan@example.com', 'Tor Ang, SR', 'REGULAR', 'Active', NULL, '2025-09-05', NOW(), NOW()),
(11, 'C0011', 'Keo Bopha', '070 123 456', 'bopha@example.com', 'Wat Bo, SR', 'SILVER', 'Active', NULL, '2025-09-08', NOW(), NOW()),
(12, 'C0012', 'Seng Samnang', '088 456 789', 'samnang@example.com', 'Kouk Chak, SR', 'GOLD', 'Active', NULL, '2025-09-12', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `name` = VALUES(`name`),
  `phone` = VALUES(`phone`),
  `email` = VALUES(`email`),
  `address` = VALUES(`address`),
  `tier` = VALUES(`tier`),
  `status` = VALUES(`status`),
  `registration_date` = VALUES(`registration_date`);

-- --------------------------------------------------------
-- Dumping data for table `customer_orders`
-- --------------------------------------------------------
INSERT INTO `customer_orders` (`id`, `customer_id`, `order_number`, `service_type`, `status`, `order_date`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '#ORD-0001', 'Wash & Fold', 'Delivered', '2025-09-15', 12.50, NOW(), NOW()),
(2, 1, '#ORD-0002', 'Wash Only', 'Delivered', '2025-09-10', 8.00, NOW(), NOW()),
(3, 1, '#ORD-0003', 'Dry Cleaning', 'Ready for Pickup', '2025-09-05', 25.00, NOW(), NOW()),
(4, 1, '#ORD-0004', 'Wash & Fold', 'Delivered', '2025-08-28', 15.00, NOW(), NOW()),
(5, 1, '#ORD-0005', 'Ironing', 'Completed', '2025-08-09', 6.50, NOW(), NOW()),

(6, 2, '#ORD-0006', 'Dry Cleaning', 'Delivered', '2025-09-12', 30.00, NOW(), NOW()),
(7, 2, '#ORD-0007', 'Wash & Fold', 'Completed', '2025-09-01', 14.00, NOW(), NOW()),

(8, 3, '#ORD-0008', 'Wash Only', 'Delivered', '2025-09-11', 9.50, NOW(), NOW()),
(9, 3, '#ORD-0009', 'Ironing', 'Completed', '2025-08-20', 7.00, NOW(), NOW()),

(10, 4, '#ORD-0010', 'Wash & Fold', 'Ready for Pickup', '2025-09-18', 18.00, NOW(), NOW()),
(11, 4, '#ORD-0011', 'Dry Cleaning', 'Delivered', '2025-09-03', 22.00, NOW(), NOW()),

(12, 5, '#ORD-0012', 'Wash Only', 'Delivered', '2025-09-14', 10.00, NOW(), NOW()),

(13, 6, '#ORD-0013', 'Wash & Fold', 'Delivered', '2025-09-16', 16.50, NOW(), NOW()),
(14, 6, '#ORD-0014', 'Ironing', 'Completed', '2025-09-02', 8.00, NOW(), NOW()),

(15, 7, '#ORD-0015', 'Dry Cleaning', 'Delivered', '2025-09-09', 28.00, NOW(), NOW()),

(16, 8, '#ORD-0016', 'Wash & Fold', 'Delivered', '2025-09-17', 20.00, NOW(), NOW()),
(17, 8, '#ORD-0017', 'Dry Cleaning', 'Ready for Pickup', '2025-09-04', 35.00, NOW(), NOW()),

(18, 9, '#ORD-0018', 'Wash Only', 'Delivered', '2025-09-13', 11.00, NOW(), NOW()),

(19, 10, '#ORD-0019', 'Ironing', 'Completed', '2025-09-07', 7.50, NOW(), NOW()),

(20, 11, '#ORD-0020', 'Wash & Fold', 'Delivered', '2025-09-10', 13.00, NOW(), NOW()),

(21, 12, '#ORD-0021', 'Dry Cleaning', 'Delivered', '2025-09-14', 32.00, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `order_number` = VALUES(`order_number`),
  `service_type` = VALUES(`service_type`),
  `status` = VALUES(`status`),
  `order_date` = VALUES(`order_date`),
  `total_amount` = VALUES(`total_amount`);
