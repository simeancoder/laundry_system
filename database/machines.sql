-- ====================================================================
-- Laundry Management System - Machines Database SQL Script
-- Designed for Navicat / phpMyAdmin / MySQL CLI / MariaDB
-- Target Database: laundry_management_system
-- Date: 2026-10-04
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create Table Structure for machines
CREATE TABLE IF NOT EXISTS `machines` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `machine_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Laundry Room 1',
  `status` enum('Available','In Use','Under Maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Available',
  `last_maintenance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_maintenance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`maintenance_history`)),
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `machines_machine_id_unique` (`machine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clear old machine records before inserting the official 12 machines
TRUNCATE TABLE `machines`;

-- 3. Insert Exactly the 12 Machine Units from Screenshot
-- Total Machines: 12 | Available: 8 | In Use: 3 | Under Maintenance: 1
INSERT INTO `machines` (
  `id`,
  `machine_id`,
  `name`,
  `type`,
  `capacity`,
  `model`,
  `location`,
  `status`,
  `last_maintenance`,
  `next_maintenance`,
  `maintenance_history`,
  `notes`,
  `created_at`,
  `updated_at`
) VALUES
(
  1,
  'WM-001',
  'Washer 1',
  'Front Load',
  '10',
  'LG WD-10',
  'Laundry Room 1',
  'In Use',
  '2025-09-12',
  '2025-10-12',
  '[{"date":"2025-09-12","type":"Routine Check","note":"Normal"},{"date":"2025-08-10","type":"Cleaning","note":"Cleaned filter"},{"date":"2025-07-05","type":"Repair","note":"Replaced belt"}]',
  'Heavy duty front load commercial washing unit.',
  NOW(),
  NOW()
),
(
  2,
  'WM-002',
  'Washer 2',
  'Front Load',
  '10',
  'LG WD-10',
  'Laundry Room 1',
  'Available',
  '2025-09-10',
  '2025-10-10',
  '[{"date":"2025-09-10","type":"Routine Check","note":"Normal"},{"date":"2025-08-01","type":"Cleaning","note":"Drum sanitization"}]',
  'Standard daily commercial washer.',
  NOW(),
  NOW()
),
(
  3,
  'WM-003',
  'Washer 3',
  'Front Load',
  '15',
  'Samsung WF-15',
  'Laundry Room 2',
  'Available',
  '2025-09-08',
  '2025-10-08',
  '[{"date":"2025-09-08","type":"Routine Check","note":"Normal"},{"date":"2025-07-15","type":"Inspection","note":"Water inlet checked"}]',
  'Large capacity washing machine for bedsheets and blankets.',
  NOW(),
  NOW()
),
(
  4,
  'WM-004',
  'Washer 4',
  'Front Load',
  '15',
  'Samsung WF-15',
  'Laundry Room 2',
  'In Use',
  '2025-09-13',
  '2025-10-13',
  '[{"date":"2025-09-13","type":"Routine Check","note":"Normal"}]',
  'Running express wash cycle.',
  NOW(),
  NOW()
),
(
  5,
  'WM-005',
  'Washer 5',
  'Top Load',
  '20',
  'Whirlpool Heavy',
  'Main Laundry Bay',
  'Available',
  '2025-09-09',
  '2025-10-09',
  '[{"date":"2025-09-09","type":"Routine Check","note":"Normal"},{"date":"2025-07-20","type":"Cleaning","note":"Agitator cleaned"}]',
  'Industrial bulk washing machine.',
  NOW(),
  NOW()
),
(
  6,
  'WM-006',
  'Dryer 1',
  'Dryer',
  '15',
  'Electrolux Dry',
  'Drying Zone A',
  'In Use',
  '2025-09-13',
  '2025-10-13',
  '[{"date":"2025-09-13","type":"Routine Check","note":"Heating coil tested"},{"date":"2025-08-15","type":"Cleaning","note":"Lint trap cleared"}]',
  'Gas-powered high-efficiency tumbling dryer.',
  NOW(),
  NOW()
),
(
  7,
  'WM-007',
  'Dryer 2',
  'Dryer',
  '15',
  'Electrolux Dry',
  'Drying Zone A',
  'Available',
  '2025-09-11',
  '2025-10-11',
  '[{"date":"2025-09-11","type":"Routine Check","note":"Normal"}]',
  'Commercial dryer ready for cycle.',
  NOW(),
  NOW()
),
(
  8,
  'WM-008',
  'Dryer 3',
  'Dryer',
  '20',
  'SpeedQueen Pro',
  'Drying Zone B',
  'Under Maintenance',
  '2025-09-05',
  '2025-09-20',
  '[{"date":"2025-09-05","type":"Repair","note":"Drum bearing replacement scheduled"},{"date":"2025-08-01","type":"Inspection","note":"Bearing noise detected"}]',
  'Awaiting replacement parts from technician.',
  NOW(),
  NOW()
),
(
  9,
  'WM-009',
  'Ironing Machine 1',
  'Ironing',
  '-',
  'Rowenta ProPress',
  'Finishing Area',
  'Available',
  '2025-09-10',
  '2025-10-10',
  '[{"date":"2025-09-10","type":"Routine Check","note":"Plate temperature verified"}]',
  'Roller iron press for bed sheets and shirts.',
  NOW(),
  NOW()
),
(
  10,
  'WM-010',
  'Ironing Machine 2',
  'Ironing',
  '-',
  'Rowenta ProPress',
  'Finishing Area',
  'Available',
  '2025-09-09',
  '2025-10-09',
  '[{"date":"2025-09-09","type":"Routine Check","note":"Steam nozzle descaled"}]',
  'Secondary ironing press station.',
  NOW(),
  NOW()
),
(
  11,
  'WM-011',
  'Ironing Machine 3',
  'Ironing',
  '-',
  'Rowenta ProPress',
  'Finishing Area',
  'Available',
  '2025-09-13',
  '2025-10-13',
  '[{"date":"2025-09-13","type":"Routine Check","note":"Normal"}]',
  'Finishing garment station.',
  NOW(),
  NOW()
),
(
  12,
  'WM-012',
  'Boiler',
  'Steam',
  '-',
  'Karcher SteamMax',
  'Utility Room',
  'Available',
  '2025-09-08',
  '2025-10-08',
  '[{"date":"2025-09-08","type":"Safety Inspection","note":"Pressure valve certified"},{"date":"2025-07-10","type":"Routine Check","note":"Descaling completed"}]',
  'Central steam generator boiler unit.',
  NOW(),
  NOW()
);

SET FOREIGN_KEY_CHECKS = 1;
