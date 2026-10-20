-- ====================================================================
-- Laundry Management System - Employees Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive','On Leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `work_schedule` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Full Time (08:00 AM - 05:00 PM)',
  `job_role_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_status` enum('Present','Absent','Late','On Leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Present',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old test records before inserting official roster
TRUNCATE TABLE `employees`;

-- 3. Insert Exactly the 7 Employees Requested
-- Total Employees: 7 | Active: 6 | Inactive: 1
INSERT INTO `employees` (
  `id`, 
  `employee_id`, 
  `name`, 
  `email`, 
  `role`, 
  `phone`, 
  `address`, 
  `password`, 
  `status`, 
  `work_schedule`, 
  `job_role_details`, 
  `avatar`, 
  `attendance_status`, 
  `created_at`, 
  `updated_at`
) VALUES
(
  1, 
  'EMP001', 
  'Hoem Chen', 
  'chen@laundry.com', 
  'Manager', 
  '014848014', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Full Time (08:00 AM - 05:00 PM)', 
  'Overall management of laundry store operations, employee shifts, attendance tracking, and finance reports.', 
  'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  2, 
  'EMP002', 
  'Heng Simean', 
  'simean@laundry.com', 
  'Receptionist', 
  '0975264069', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Morning Shift (07:00 AM - 03:00 PM)', 
  'Front counter customer service, receiving laundry drops, billing & payment receipts.', 
  'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  3, 
  'EMP003', 
  'Phy YongJea', 
  'yongje@laundry.com', 
  'Laundry Staff', 
  '0964672731', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Morning Shift (07:00 AM - 03:00 PM)', 
  'Sorting garments by color/fabric, running washing cycles and detergent monitoring.', 
  'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  4, 
  'EMP004', 
  'Kat Ky', 
  'ky@laundry.com', 
  'Delivery Staff', 
  '0972166964', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Flexible Shift', 
  'Customer door-to-door laundry pickups, package deliveries, route logistics.', 
  'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  5, 
  'EMP005', 
  'Rern Chamrorng', 
  'chamrong@laundry.com', 
  'Laundry Staff', 
  '089 579 971', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Afternoon Shift (01:00 PM - 09:00 PM)', 
  'Drying machine maintenance, delicate fabrics cleaning, and fold staging.', 
  'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  6, 
  'EMP006', 
  'Soum Rern', 
  'rern@laundry.com', 
  'Ironing Staff', 
  '068320160', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Active', 
  'Morning Shift (07:00 AM - 03:00 PM)', 
  'Professional steam pressing, garment ironing, hanger packaging and barcode tagging.', 
  'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&h=200&q=80', 
  'Present', 
  NOW(), 
  NOW()
),
(
  7, 
  'EMP007', 
  'Chan Sokha', 
  'sokha@laundry.com', 
  'Ironing Staff', 
  '069848014', 
  'Phnom Penh, Cambodia', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'Inactive', 
  'Night Shift (09:00 PM - 05:00 AM)', 
  'Heavy steam ironing & curtain pressing. Status currently set to Inactive.', 
  'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&h=200&q=80', 
  'Absent', 
  NOW(), 
  NOW()
);

SET FOREIGN_KEY_CHECKS = 1;
