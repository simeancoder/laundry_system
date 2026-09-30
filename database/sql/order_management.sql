-- ========================================================
-- Database: laundry_management_system
-- Table Structure and Sample Data for Order Management
-- Compatible with MySQL / MariaDB / Navicat / phpMyAdmin
-- ========================================================

CREATE DATABASE IF NOT EXISTS `laundry_management_system` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laundry_management_system`;

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(8,2) NOT NULL DEFAULT 0.00,
  `items_count` int(11) NOT NULL DEFAULT 1,
  `order_date` datetime NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Received',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_status_index` (`status`),
  KEY `orders_order_date_index` (`order_date`),
  KEY `orders_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `service_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0 kg',
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping sample data for table `orders` (Exact Teacher Sample)
-- --------------------------------------------------------
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `service_type`, `weight`, `items_count`, `order_date`, `pickup_date`, `delivery_date`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-0001', 1, 'Sokha Dara', '012 345 678', 'sokha@example.com', 'Svay Dongkum, Siem Reap', 'Wash & Fold', 5.00, 3, '2025-09-15 10:24:00', '2025-09-16', '2025-09-17', 12.50, 'Washing', 'Handle with extra care', NOW(), NOW()),
(2, 'ORD-0002', 2, 'Chan Sreyneath', '011 234 567', 'sreyneath@example.com', 'Taphul, Siem Reap', 'Dry Cleaning', 2.00, 1, '2025-09-15 09:15:00', '2025-09-16', '2025-09-17', 18.00, 'Drying', 'Silk dress', NOW(), NOW()),
(3, 'ORD-0003', 3, 'Heng Channa', '017 890 123', 'channa@example.com', 'Sala Kamreuk, Siem Reap', 'Wash Only', 8.00, 4, '2025-09-14 11:30:00', '2025-09-15', '2025-09-16', 16.00, 'Ready for Pickup', 'Hung on hangers', NOW(), NOW()),
(4, 'ORD-0004', 4, 'Kim Sovannary', '015 678 901', 'sovannary@example.com', 'Svay Dangkum, Siem Reap', 'Ironing', 3.50, 2, '2025-09-14 14:20:00', '2025-09-15', '2025-09-16', 10.50, 'Out for Delivery', 'Deliver in afternoon', NOW(), NOW()),
(5, 'ORD-0005', 5, 'Neang Pheaktra', '010 555 888', 'pheaktra@example.com', 'Kok Chork, Siem Reap', 'Wash & Dry', 7.00, 3, '2025-09-13 15:45:00', '2025-09-14', '2025-09-15', 14.00, 'Completed', 'Paid cash', NOW(), NOW()),
(6, 'ORD-0006', 6, 'Lim Vannak', '016 222 333', 'vannak@example.com', 'National Road 6, Siem Reap', 'Blanket Cleaning', 4.00, 1, '2025-09-12 09:30:00', '2025-09-13', '2025-09-14', 20.00, 'Received', 'King size blanket', NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `customer_name` = VALUES(`customer_name`),
  `customer_phone` = VALUES(`customer_phone`),
  `service_type` = VALUES(`service_type`),
  `weight` = VALUES(`weight`),
  `items_count` = VALUES(`items_count`),
  `total_price` = VALUES(`total_price`),
  `status` = VALUES(`status`);

-- --------------------------------------------------------
-- Dumping sample data for table `order_items`
-- --------------------------------------------------------
INSERT INTO `order_items` (`id`, `order_id`, `service_name`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
-- ORD-0001 (Matches Screenshot 2)
(1, 1, 'Wash & Fold', '1.0 kg', 2.50, 2.50, NOW(), NOW()),
(2, 1, 'Wash & Fold', '2.0 kg', 2.50, 5.00, NOW(), NOW()),
(3, 1, 'Wash & Fold', '2.0 kg', 2.50, 5.00, NOW(), NOW()),

-- ORD-0002
(4, 2, 'Dry Cleaning', '2.0 kg', 9.00, 18.00, NOW(), NOW()),

-- ORD-0003
(5, 3, 'Wash Only', '8.0 kg', 2.00, 16.00, NOW(), NOW()),

-- ORD-0004
(6, 4, 'Ironing', '3.5 kg', 3.00, 10.50, NOW(), NOW()),

-- ORD-0005
(7, 5, 'Wash & Dry', '7.0 kg', 2.00, 14.00, NOW(), NOW()),

-- ORD-0006
(8, 6, 'Blanket Cleaning', '4.0 kg', 5.00, 20.00, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `service_name` = VALUES(`service_name`),
  `quantity` = VALUES(`quantity`),
  `unit_price` = VALUES(`unit_price`),
  `subtotal` = VALUES(`subtotal`);
