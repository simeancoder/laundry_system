-- ========================================================
-- Database: laundry_management_system
-- For use in Navicat / MySQL
-- ========================================================

CREATE DATABASE IF NOT EXISTS `laundry_management_system` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laundry_management_system`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `password_resets`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `failed_jobs`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `personal_access_tokens`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `services`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Initial migrations record
-- --------------------------------------------------------
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_09_15_140718_create_services_table', 1);

-- --------------------------------------------------------
-- Default Admin User
-- Email: admin@gmail.com
-- Password: password123
-- --------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`)
VALUES ('Admin User', 'admin@gmail.com', '$2y$12$gmyirRqpyfVAEF1l1su.7ucjrAE5eQBR8Xdx409/gdb21CwJHMSYm', NOW(), NOW())
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);

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

-- --------------------------------------------------------
-- Table structure for table `orders` (Order Management Module)
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
-- Dumping sample data for table `orders`
-- --------------------------------------------------------
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `service_type`, `weight`, `items_count`, `order_date`, `pickup_date`, `delivery_date`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-0001', 1, 'Sokha Dara', '012 345 678', 'sokha@example.com', 'Svay Dangkum, SR', 'Wash & Fold', 5.20, 8, '2025-09-15 08:30:00', '2025-09-16', '2025-09-17', 12.50, 'Washing', 'Customer requested hypoallergenic detergent.', NOW(), NOW()),
(2, 'ORD-0002', 2, 'Chan Sreyneath', '011 234 567', 'sreyneath@example.com', 'Taphul, SR', 'Dry Cleaning', 3.00, 4, '2025-09-15 09:15:00', '2025-09-16', '2025-09-18', 25.00, 'Drying', 'Handle silk dress with extra care.', NOW(), NOW()),
(3, 'ORD-0003', 3, 'Heng Chana', '017 890 123', 'channa@example.com', 'Sala Kamreuk, SR', 'Ironing', 2.50, 6, '2025-09-15 10:00:00', '2025-09-16', '2025-09-17', 8.50, 'Ready for Pickup', 'Hung on hangers, no fold.', NOW(), NOW()),
(4, 'ORD-0004', 4, 'Kim Sovannary', '015 678 901', 'sovannary@example.com', 'Svay Dangkum, SR', 'Wash & Fold', 4.80, 7, '2025-09-14 14:20:00', '2025-09-15', '2025-09-16', 14.00, 'Out for Delivery', 'Deliver between 2 PM and 5 PM.', NOW(), NOW()),
(5, 'ORD-0005', 5, 'Neang Pheaktra', '010 555 888', 'pheaktra@example.com', 'Kok Chork, SR', 'Wash Only', 6.00, 10, '2025-09-14 11:45:00', '2025-09-15', '2025-09-16', 10.00, 'Completed', 'Paid in cash upon pickup.', NOW(), NOW()),
(6, 'ORD-0006', 6, 'Lim Vannak', '016 222 333', 'vannak@example.com', 'National Road 6, SR', 'Dry Cleaning', 2.00, 3, '2025-09-14 09:30:00', '2025-09-15', '2025-09-17', 22.00, 'Received', 'Inspect cuffs and collar stains.', NOW(), NOW()),
(7, 'ORD-0007', 7, 'Thon Sreynich', '092 777 666', 'sreynich@example.com', 'Taphul, SR', 'Wash & Fold', 3.50, 5, '2025-09-13 16:10:00', '2025-09-14', '2025-09-15', 11.50, 'Cancelled', 'Cancelled per customer phone request.', NOW(), NOW()),
(8, 'ORD-0008', 8, 'Pich Sothy', '012 999 444', 'sothy@example.com', 'Sla Kram, SR', 'Wash & Fold', 7.20, 12, '2025-09-13 10:15:00', '2025-09-14', '2025-09-16', 18.50, 'Completed', 'Regular customer discount applied.', NOW(), NOW()),
(9, 'ORD-0009', 9, 'Chea Ratanak', '097 333 222', 'ratanak@example.com', 'Bakheng, SR', 'Ironing', 3.20, 8, '2025-09-12 15:40:00', '2025-09-13', '2025-09-14', 12.00, 'Ready for Pickup', 'Starch level: medium.', NOW(), NOW()),
(10, 'ORD-0010', 10, 'Va Sovan', '099 666 777', 'sovan@example.com', 'Tor Ang, SR', 'Wash Only', 4.50, 6, '2025-09-12 08:20:00', '2025-09-13', '2025-09-14', 9.00, 'Washing', 'Separate white linens.', NOW(), NOW())
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
(1, 1, 'Wash & Fold (Regular)', '5.2 kg', 2.00, 10.40, NOW(), NOW()),
(2, 1, 'Fabric Softener', '1 pc', 1.10, 1.10, NOW(), NOW()),
(3, 1, 'Express Delivery Fee', '1 pc', 1.00, 1.00, NOW(), NOW()),
(4, 2, 'Suit Dry Cleaning', '2 pcs', 8.00, 16.00, NOW(), NOW()),
(5, 2, 'Silk Dress Cleaning', '1 pc', 7.00, 7.00, NOW(), NOW()),
(6, 2, 'Protective Garment Bag', '2 pcs', 1.00, 2.00, NOW(), NOW()),
(7, 3, 'Shirt Steam Press & Ironing', '5 pcs', 1.30, 6.50, NOW(), NOW()),
(8, 3, 'Trousers Pressing', '1 pc', 2.00, 2.00, NOW(), NOW()),
(9, 4, 'Wash & Fold Regular', '4.8 kg', 2.50, 12.00, NOW(), NOW()),
(10, 4, 'Scent Boost Beads', '1 pc', 2.00, 2.00, NOW(), NOW()),
(11, 5, 'Machine Wash Only', '6.0 kg', 1.50, 9.00, NOW(), NOW()),
(12, 5, 'Antibacterial Rinse', '1 pc', 1.00, 1.00, NOW(), NOW()),
(13, 6, 'Jacket Dry Cleaning', '2 pcs', 9.00, 18.00, NOW(), NOW()),
(14, 6, 'Tie Dry Clean & Press', '1 pc', 4.00, 4.00, NOW(), NOW()),
(15, 7, 'Wash & Fold Regular', '3.5 kg', 2.50, 8.75, NOW(), NOW()),
(16, 7, 'Fabric Softener Premium', '1 pc', 2.75, 2.75, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `service_name` = VALUES(`service_name`),
  `quantity` = VALUES(`quantity`),
  `unit_price` = VALUES(`unit_price`),
  `subtotal` = VALUES(`subtotal`);

-- --------------------------------------------------------
-- Table structure for table `payments` (Payment Management Module)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_initials` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'bg-blue-100 text-blue-700',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COMPLETED',
  `payment_date` datetime NOT NULL,
  `reference_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_id_unique` (`payment_id`),
  KEY `payments_order_number_index` (`order_number`),
  KEY `payments_status_index` (`status`),
  KEY `payments_payment_method_index` (`payment_method`),
  KEY `payments_payment_date_index` (`payment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping sample data for table `payments` (12 Initial Payments)
-- --------------------------------------------------------
INSERT INTO `payments` (`id`, `payment_id`, `order_number`, `customer_name`, `customer_initials`, `avatar_color`, `amount`, `payment_method`, `status`, `payment_date`, `reference_no`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'PAY-001', 'ORD-0001', 'Sokha Dara', 'SD', 'bg-blue-100 text-blue-700', 12.50, 'Cash', 'COMPLETED', '2025-09-15 10:24:00', 'TRX-94821', 'Paid in full with cash', NOW(), NOW()),
(2, 'PAY-002', 'ORD-0002', 'Chan Sreyneath', 'CS', 'bg-purple-100 text-purple-700', 18.00, 'Credit Card', 'COMPLETED', '2025-09-14 15:12:00', 'TRX-94822', 'Visa ending in 4289', NOW(), NOW()),
(3, 'PAY-003', 'ORD-0003', 'Heng Channa', 'HC', 'bg-teal-100 text-teal-700', 16.00, 'Mobile Payment', 'COMPLETED', '2025-09-14 11:45:00', 'TRX-94823', 'ABA PAY transaction', NOW(), NOW()),
(4, 'PAY-004', 'ORD-0004', 'Kim Sovannary', 'KS', 'bg-indigo-100 text-indigo-700', 22.50, 'Bank Transfer', 'COMPLETED', '2025-09-13 16:20:00', 'TRX-94824', 'Direct Wing Bank transfer', NOW(), NOW()),
(5, 'PAY-005', 'ORD-0005', 'Neang Pheaktra', 'NP', 'bg-amber-100 text-amber-700', 14.00, 'Cash', 'PENDING', '2025-09-13 09:15:00', 'TRX-94825', 'Cash payment expected on delivery', NOW(), NOW()),
(6, 'PAY-006', 'ORD-0006', 'Lim Vannak', 'LV', 'bg-sky-100 text-sky-700', 30.00, 'Credit Card', 'COMPLETED', '2025-09-12 14:30:00', 'TRX-94826', 'Mastercard ending in 1102', NOW(), NOW()),
(7, 'PAY-007', 'ORD-0007', 'Thon Sreynich', 'TS', 'bg-fuchsia-100 text-fuchsia-700', 17.50, 'Mobile Payment', 'COMPLETED', '2025-09-12 10:05:00', 'TRX-94827', 'Bakong KHQR payment', NOW(), NOW()),
(8, 'PAY-008', 'ORD-0008', 'Pich Sothy', 'PS', 'bg-pink-100 text-pink-700', 25.00, 'Cash', 'REFUNDED', '2025-09-11 17:40:00', 'TRX-94828', 'Customer requested refund due to duplicate charge', NOW(), NOW()),
(9, 'PAY-009', 'ORD-0009', 'Chea Ratanak', 'CR', 'bg-emerald-100 text-emerald-700', 12.00, 'Bank Transfer', 'COMPLETED', '2025-09-10 13:20:00', 'TRX-94829', 'Canadia Bank swift transfer', NOW(), NOW()),
(10, 'PAY-010', 'ORD-010', 'Va Sovan', 'VS', 'bg-slate-200 text-slate-700', 20.00, 'Mobile Payment', 'COMPLETED', '2025-09-09 11:35:00', 'TRX-94830', 'TrueMoney Mobile transfer', NOW(), NOW()),
(11, 'PAY-011', 'ORD-0011', 'Em Meng', 'EM', 'bg-cyan-100 text-cyan-700', 35.00, 'Credit Card', 'COMPLETED', '2025-09-08 16:15:00', 'TRX-94831', 'Visa ending in 8841', NOW(), NOW()),
(12, 'PAY-012', 'ORD-0012', 'Keo Nisay', 'KN', 'bg-violet-100 text-violet-700', 28.00, 'Bank Transfer', 'COMPLETED', '2025-09-07 09:30:00', 'TRX-94832', 'ACLEDA Unity transfer', NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `order_number` = VALUES(`order_number`),
  `customer_name` = VALUES(`customer_name`),
  `customer_initials` = VALUES(`customer_initials`),
  `avatar_color` = VALUES(`avatar_color`),
  `amount` = VALUES(`amount`),
  `payment_method` = VALUES(`payment_method`),
  `status` = VALUES(`status`),
  `payment_date` = VALUES(`payment_date`),
  `reference_no` = VALUES(`reference_no`),
  `notes` = VALUES(`notes`);

-- --------------------------------------------------------
-- Table structure for table `pickup_deliveries`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pickup_deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pickup_date` date DEFAULT NULL,
  `pickup_time` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_staff_id` bigint(20) unsigned DEFAULT NULL,
  `delivery_staff_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Scheduled',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pd_order_number` (`order_number`),
  KEY `idx_pd_customer_name` (`customer_name`),
  KEY `idx_pd_status` (`status`),
  KEY `idx_pd_pickup_date` (`pickup_date`),
  KEY `idx_pd_delivery_date` (`delivery_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping sample data for table `pickup_deliveries` (12 Initial Logistics Tasks)
-- --------------------------------------------------------
INSERT INTO `pickup_deliveries` (`id`, `order_number`, `customer_name`, `customer_phone`, `service_type`, `total_amount`, `pickup_date`, `pickup_time`, `pickup_address`, `delivery_date`, `delivery_time`, `delivery_address`, `delivery_staff_id`, `delivery_staff_name`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-0003', 'Sokha Dara', '012 345 678', 'Wash & Dry', 15.00, '2025-09-15', '10:00 AM', '#12, Street 63, Siem Reap', '2025-09-16', '02:00 PM', '#45, Pokambor Ave, Siem Reap', 1, 'Sok Chanthy', 'Scheduled', 'Customer requested eco-friendly detergent.', NOW(), NOW()),
(2, 'ORD-0006', 'Chan Sreyneath', '011 234 567', 'Wash Only', 12.00, '2025-09-15', '11:30 AM', '#88, Street 10, Wat Bo, Siem Reap', '2025-09-16', '04:00 PM', '#88, Street 10, Wat Bo, Siem Reap', 5, 'Soum Rern', 'Scheduled', 'Handle delicate fabrics with care.', NOW(), NOW()),
(3, 'ORD-0009', 'Heng Channa', '017 890 123', 'Dry Cleaning', 25.00, '2025-09-16', '09:00 AM', '#14, Charles de Gaulle, Siem Reap', '2025-09-17', '01:00 PM', '#14, Charles de Gaulle, Siem Reap', 1, 'Sok Chanthy', 'Assigned', 'Business suits - extra starch on collars.', NOW(), NOW()),
(4, 'ORD-0012', 'Kim Sovannary', '015 678 901', 'Ironing', 18.50, '2025-09-16', '10:30 AM', '#55, Pub Street Area, Siem Reap', '2025-09-17', '03:00 PM', '#55, Pub Street Area, Siem Reap', 5, 'Soum Rern', 'In Transit', 'On delivery route today.', NOW(), NOW()),
(5, 'ORD-0015', 'Neang Pheaktra', '010 555 888', 'Wash & Fold', 14.00, '2025-09-17', '08:00 AM', '#12, Street 63, Siem Reap', '2025-09-18', '12:00 PM', '#45, Pokambor Ave, Siem Reap', 1, 'Sok Chanthy', 'Scheduled', 'Customer requested contactless delivery.', NOW(), NOW()),
(6, 'ORD-0017', 'Lim Vannak', '016 222 333', 'Blanket Cleaning', 22.00, '2025-09-17', '11:00 AM', '#7, Airport Road, Siem Reap', '2025-09-18', '04:00 PM', '#7, Airport Road, Siem Reap', 5, 'Soum Rern', 'Scheduled', '2 heavy winter blankets.', NOW(), NOW()),
(7, 'ORD-0020', 'Thon Sreynich', '092 777 666', 'Curtain Cleaning', 30.00, '2025-09-18', '09:30 AM', '#99, Ring Road, Siem Reap', '2025-09-19', '02:00 PM', '#99, Ring Road, Siem Reap', 1, 'Sok Chanthy', 'Assigned', 'Living room velvet curtains.', NOW(), NOW()),
(8, 'ORD-0023', 'Pich Sothey', '012 999 444', 'Shoe Cleaning', 16.00, '2025-09-18', '10:00 AM', '#34, Lok Taneuy St, Siem Reap', '2025-09-19', '03:00 PM', '#34, Lok Taneuy St, Siem Reap', 5, 'Soum Rern', 'In Transit', 'Leather white sneakers treatment.', NOW(), NOW()),
(9, 'ORD-0026', 'Chea Ratanak', '097 333 222', 'Carpet Cleaning', 35.00, '2025-09-19', '08:30 AM', '#19, Banteay Chas, Siem Reap', '2025-09-20', '01:00 PM', '#19, Banteay Chas, Siem Reap', NULL, 'Unassigned', 'Pending', 'Awaiting staff assignment.', NOW(), NOW()),
(10, 'ORD-0028', 'Va Sovan', '099 666 777', 'Wash & Dry', 14.00, '2025-09-19', '10:00 AM', '#81, Sivutha Blvd, Siem Reap', '2025-09-20', '02:00 PM', '#81, Sivutha Blvd, Siem Reap', NULL, 'Unassigned', 'Pending', 'Needs quick tumble dry.', NOW(), NOW()),
(11, 'ORD-0030', 'Keo Pisey', '012 445 566', 'Wash & Fold', 20.00, '2025-09-12', '09:00 AM', '#101, River Road, Siem Reap', '2025-09-13', '03:00 PM', '#101, River Road, Siem Reap', 5, 'Soum Rern', 'Delivered', 'Delivered and signed by client.', NOW(), NOW()),
(12, 'ORD-0032', 'Meng Chhay', '015 778 899', 'Dry Cleaning', 28.00, '2025-09-11', '11:00 AM', '#40, Achar Sva St, Siem Reap', '2025-09-12', '04:00 PM', '#40, Achar Sva St, Siem Reap', 1, 'Sok Chanthy', 'Delivered', 'Completed and confirmed.', NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `order_number` = VALUES(`order_number`),
  `customer_name` = VALUES(`customer_name`),
  `customer_phone` = VALUES(`customer_phone`),
  `service_type` = VALUES(`service_type`),
  `total_amount` = VALUES(`total_amount`),
  `pickup_date` = VALUES(`pickup_date`),
  `pickup_time` = VALUES(`pickup_time`),
  `pickup_address` = VALUES(`pickup_address`),
  `delivery_date` = VALUES(`delivery_date`),
  `delivery_time` = VALUES(`delivery_time`),
  `delivery_address` = VALUES(`delivery_address`),
  `delivery_staff_id` = VALUES(`delivery_staff_id`),
  `delivery_staff_name` = VALUES(`delivery_staff_name`),
  `status` = VALUES(`status`),
  `notes` = VALUES(`notes`);




