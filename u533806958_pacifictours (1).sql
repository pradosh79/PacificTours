-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 18, 2026 at 07:11 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u533806958_pacifictours`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'home_slider',
  `title` varchar(200) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `mobile_image` varchar(255) DEFAULT NULL,
  `button_text` varchar(60) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `booking_number` varchar(32) NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `tour_departure_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_first_name` varchar(100) NOT NULL,
  `customer_last_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(32) DEFAULT NULL,
  `customer_country` varchar(120) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `travel_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `adults` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `children` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `infants` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `adult_unit_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `child_unit_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `infant_unit_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tour_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `coupon_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `service_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deposit_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `refunded_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'CAD',
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(24) NOT NULL DEFAULT 'unpaid',
  `source` varchar(20) NOT NULL DEFAULT 'web',
  `customer_note` text DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_status_histories`
--

CREATE TABLE `booking_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `from_status` varchar(20) DEFAULT NULL,
  `to_status` varchar(20) NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_travelers`
--

CREATE TABLE `booking_travelers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(12) NOT NULL DEFAULT 'adult',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `nationality` varchar(120) DEFAULT NULL,
  `passport_number` varchar(64) DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `dietary_requirement` varchar(160) DEFAULT NULL,
  `special_request` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pacific-tours-canada-cache-11946ff51c9de44ee62fc909ed6cb966c50fba99', 'i:1;', 1786989387),
('pacific-tours-canada-cache-11946ff51c9de44ee62fc909ed6cb966c50fba99:timer', 'i:1786989387;', 1786989387),
('pacific-tours-canada-cache-admin:dashboard', 'a:6:{s:5:\"cards\";a:8:{s:5:\"tours\";i:4;s:8:\"bookings\";i:0;s:14:\"bookings_today\";i:0;s:16:\"bookings_pending\";i:0;s:15:\"tours_completed\";i:0;s:7:\"revenue\";d:0;s:9:\"collected\";d:0;s:9:\"customers\";i:25;}s:15:\"recent_bookings\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:14:\"upcoming_tours\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:16:\"recent_customers\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:29;s:4:\"uuid\";s:36:\"6ed38e23-08b7-4b73-8457-aa8e4d2ccd4d\";s:10:\"first_name\";s:2:\"Jo\";s:9:\"last_name\";s:7:\"Kreiger\";s:5:\"email\";s:25:\"bosco.frankie@example.com\";s:5:\"phone\";s:15:\"+1 604 693 1607\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$to9sK5kHteY4P140xj5JKe/jombSFi5JvOmKV2l6nwZCRpEadu8WC\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:29;s:4:\"uuid\";s:36:\"6ed38e23-08b7-4b73-8457-aa8e4d2ccd4d\";s:10:\"first_name\";s:2:\"Jo\";s:9:\"last_name\";s:7:\"Kreiger\";s:5:\"email\";s:25:\"bosco.frankie@example.com\";s:5:\"phone\";s:15:\"+1 604 693 1607\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$to9sK5kHteY4P140xj5JKe/jombSFi5JvOmKV2l6nwZCRpEadu8WC\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:28;s:4:\"uuid\";s:36:\"60ffa0b8-e56b-455c-90e0-d033f52b4309\";s:10:\"first_name\";s:4:\"Vena\";s:9:\"last_name\";s:5:\"Sauer\";s:5:\"email\";s:19:\"ilehner@example.org\";s:5:\"phone\";s:15:\"+1 604 401 6157\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$3LS.IIP.t4Xx1UrBy0AU4.DJxshQ0MXI.MEooFP13EcV1ATwZLY0G\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:28;s:4:\"uuid\";s:36:\"60ffa0b8-e56b-455c-90e0-d033f52b4309\";s:10:\"first_name\";s:4:\"Vena\";s:9:\"last_name\";s:5:\"Sauer\";s:5:\"email\";s:19:\"ilehner@example.org\";s:5:\"phone\";s:15:\"+1 604 401 6157\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$3LS.IIP.t4Xx1UrBy0AU4.DJxshQ0MXI.MEooFP13EcV1ATwZLY0G\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:27;s:4:\"uuid\";s:36:\"05cc1020-7f53-488f-be70-dd9cd0cd113d\";s:10:\"first_name\";s:9:\"Raphaelle\";s:9:\"last_name\";s:7:\"Jenkins\";s:5:\"email\";s:28:\"camila.daugherty@example.com\";s:5:\"phone\";s:15:\"+1 604 474 8733\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$5rzMa632EpSnj34rBONyeenUBdZ.24Fj8engkTrT1ra8qkXA6IQNy\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:27;s:4:\"uuid\";s:36:\"05cc1020-7f53-488f-be70-dd9cd0cd113d\";s:10:\"first_name\";s:9:\"Raphaelle\";s:9:\"last_name\";s:7:\"Jenkins\";s:5:\"email\";s:28:\"camila.daugherty@example.com\";s:5:\"phone\";s:15:\"+1 604 474 8733\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:08\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$5rzMa632EpSnj34rBONyeenUBdZ.24Fj8engkTrT1ra8qkXA6IQNy\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:26;s:4:\"uuid\";s:36:\"36b955f8-4110-4268-b4f5-78b12992f3b9\";s:10:\"first_name\";s:7:\"Gardner\";s:9:\"last_name\";s:7:\"Gleason\";s:5:\"email\";s:21:\"alfredo66@example.com\";s:5:\"phone\";s:15:\"+1 604 429 0967\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:07\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$VsgT0zDijP5Gdk1ksIx4eu86cMBnsh0T.opHsmc7uctJ44T2iN00S\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:26;s:4:\"uuid\";s:36:\"36b955f8-4110-4268-b4f5-78b12992f3b9\";s:10:\"first_name\";s:7:\"Gardner\";s:9:\"last_name\";s:7:\"Gleason\";s:5:\"email\";s:21:\"alfredo66@example.com\";s:5:\"phone\";s:15:\"+1 604 429 0967\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:07\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$VsgT0zDijP5Gdk1ksIx4eu86cMBnsh0T.opHsmc7uctJ44T2iN00S\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}i:4;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:25;s:4:\"uuid\";s:36:\"4d1de7c1-fa1f-40c4-9827-7e0ad4da362b\";s:10:\"first_name\";s:6:\"Jermey\";s:9:\"last_name\";s:9:\"Gulgowski\";s:5:\"email\";s:19:\"jorge71@example.org\";s:5:\"phone\";s:15:\"+1 604 594 8881\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:07\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$Bt4rfQbcZeWATXhi/jWa8u89fwlVfiDjn65S5wnDh6QUdQpbmCQB2\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:25;s:4:\"uuid\";s:36:\"4d1de7c1-fa1f-40c4-9827-7e0ad4da362b\";s:10:\"first_name\";s:6:\"Jermey\";s:9:\"last_name\";s:9:\"Gulgowski\";s:5:\"email\";s:19:\"jorge71@example.org\";s:5:\"phone\";s:15:\"+1 604 594 8881\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:07\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$Bt4rfQbcZeWATXhi/jWa8u89fwlVfiDjn65S5wnDh6QUdQpbmCQB2\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}i:5;O:15:\"App\\Models\\User\":37:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:24;s:4:\"uuid\";s:36:\"18e24662-0c62-4d45-be8d-43b4de9f080e\";s:10:\"first_name\";s:6:\"Kamren\";s:9:\"last_name\";s:6:\"Muller\";s:5:\"email\";s:27:\"maurine.nicolas@example.org\";s:5:\"phone\";s:15:\"+1 604 260 4488\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:06\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$MtS7m9J6wocIX/hj4eLGzu/w/aiBcDdyj10hELyOUpBT81B.ovF0e\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:24;s:4:\"uuid\";s:36:\"18e24662-0c62-4d45-be8d-43b4de9f080e\";s:10:\"first_name\";s:6:\"Kamren\";s:9:\"last_name\";s:6:\"Muller\";s:5:\"email\";s:27:\"maurine.nicolas@example.org\";s:5:\"phone\";s:15:\"+1 604 260 4488\";s:17:\"email_verified_at\";s:19:\"2026-07-31 06:35:06\";s:17:\"phone_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$MtS7m9J6wocIX/hj4eLGzu/w/aiBcDdyj10hELyOUpBT81B.ovF0e\";s:6:\"avatar\";N;s:6:\"status\";s:6:\"active\";s:6:\"locale\";s:2:\"en\";s:8:\"timezone\";s:17:\"America/Vancouver\";s:17:\"two_factor_secret\";N;s:25:\"two_factor_recovery_codes\";N;s:23:\"two_factor_confirmed_at\";N;s:13:\"last_login_ip\";N;s:13:\"last_login_at\";N;s:10:\"created_by\";N;s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"updated_at\";s:19:\"2026-07-31 06:35:10\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:17:\"email_verified_at\";s:8:\"datetime\";s:17:\"phone_verified_at\";s:8:\"datetime\";s:23:\"two_factor_confirmed_at\";s:8:\"datetime\";s:13:\"last_login_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";s:6:\"status\";s:20:\"App\\Enums\\UserStatus\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:4:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";i:2;s:17:\"two_factor_secret\";i:3;s:25:\"two_factor_recovery_codes\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:4:\"uuid\";i:1;s:10:\"first_name\";i:2;s:9:\"last_name\";i:3;s:5:\"email\";i:4;s:5:\"phone\";i:5;s:8:\"password\";i:6;s:6:\"avatar\";i:7;s:6:\"status\";i:8;s:6:\"locale\";i:9;s:8:\"timezone\";i:10;s:10:\"created_by\";i:11;s:17:\"email_verified_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";s:14:\"\0*\0accessToken\";N;s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:15:\"latest_payments\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:6:\"charts\";a:3:{s:15:\"monthly_revenue\";a:0:{}s:16:\"monthly_bookings\";a:0:{}s:9:\"top_tours\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;a:3:{s:5:\"title\";s:35:\"Vancouver & North Shore Scenie Tour\";s:8:\"bookings\";i:0;s:7:\"revenue\";d:0;}i:1;a:3:{s:5:\"title\";s:27:\"Lower Mainland Village Tour\";s:8:\"bookings\";i:0;s:7:\"revenue\";d:0;}i:2;a:3:{s:5:\"title\";s:32:\"Victoria & Butchart Gardens Tour\";s:8:\"bookings\";i:0;s:7:\"revenue\";d:0;}i:3;a:3:{s:5:\"title\";s:26:\"Whistler & Sea-to-Sky Tour\";s:8:\"bookings\";i:0;s:7:\"revenue\";d:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}}', 1786989928),
('pacific-tours-canada-cache-cms:chrome:en', 'a:3:{s:11:\"header_menu\";O:15:\"App\\Models\\Menu\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:11:\"Header Menu\";s:8:\"location\";s:6:\"header\";s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:50\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:1;s:4:\"name\";s:11:\"Header Menu\";s:8:\"location\";s:6:\"header\";s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:50\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"items\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:19:\"App\\Models\\MenuItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"menu_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:15:{s:2:\"id\";i:1;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:5:\"Tours\";s:4:\"type\";s:6:\"custom\";s:9:\"target_id\";N;s:3:\"url\";s:6:\"/tours\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:50\";}s:11:\"\0*\0original\";a:15:{s:2:\"id\";i:1;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:5:\"Tours\";s:4:\"type\";s:6:\"custom\";s:9:\"target_id\";N;s:3:\"url\";s:6:\"/tours\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:50\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"is_mega\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:7:\"menu_id\";i:1;s:9:\"parent_id\";i:2;s:5:\"label\";i:3;s:4:\"type\";i:4;s:9:\"target_id\";i:5;s:3:\"url\";i:6;s:4:\"icon\";i:7;s:6:\"target\";i:8;s:7:\"is_mega\";i:9;s:11:\"mega_column\";i:10;s:10:\"sort_order\";i:11;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\MenuItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"menu_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:15:{s:2:\"id\";i:2;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:12:\"Destinations\";s:4:\"type\";s:6:\"custom\";s:9:\"target_id\";N;s:3:\"url\";s:13:\"/destinations\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:15:{s:2:\"id\";i:2;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:12:\"Destinations\";s:4:\"type\";s:6:\"custom\";s:9:\"target_id\";N;s:3:\"url\";s:13:\"/destinations\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"is_mega\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:7:\"menu_id\";i:1;s:9:\"parent_id\";i:2;s:5:\"label\";i:3;s:4:\"type\";i:4;s:9:\"target_id\";i:5;s:3:\"url\";i:6;s:4:\"icon\";i:7;s:6:\"target\";i:8;s:7:\"is_mega\";i:9;s:11:\"mega_column\";i:10;s:10:\"sort_order\";i:11;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\MenuItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"menu_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:15:{s:2:\"id\";i:3;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:4:\"Blog\";s:4:\"type\";s:4:\"blog\";s:9:\"target_id\";N;s:3:\"url\";s:5:\"/blog\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:15:{s:2:\"id\";i:3;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:4:\"Blog\";s:4:\"type\";s:4:\"blog\";s:9:\"target_id\";N;s:3:\"url\";s:5:\"/blog\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"is_mega\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:7:\"menu_id\";i:1;s:9:\"parent_id\";i:2;s:5:\"label\";i:3;s:4:\"type\";i:4;s:9:\"target_id\";i:5;s:3:\"url\";i:6;s:4:\"icon\";i:7;s:6:\"target\";i:8;s:7:\"is_mega\";i:9;s:11:\"mega_column\";i:10;s:10:\"sort_order\";i:11;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\MenuItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"menu_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:15:{s:2:\"id\";i:4;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:7:\"Contact\";s:4:\"type\";s:4:\"page\";s:9:\"target_id\";N;s:3:\"url\";s:13:\"/page/contact\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:15:{s:2:\"id\";i:4;s:7:\"menu_id\";i:1;s:9:\"parent_id\";N;s:5:\"label\";s:7:\"Contact\";s:4:\"type\";s:4:\"page\";s:9:\"target_id\";N;s:3:\"url\";s:13:\"/page/contact\";s:4:\"icon\";N;s:6:\"target\";s:5:\"_self\";s:7:\"is_mega\";i:0;s:11:\"mega_column\";i:1;s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"is_mega\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:12:{i:0;s:7:\"menu_id\";i:1;s:9:\"parent_id\";i:2;s:5:\"label\";i:3;s:4:\"type\";i:4;s:9:\"target_id\";i:5;s:3:\"url\";i:6;s:4:\"icon\";i:7;s:6:\"target\";i:8;s:7:\"is_mega\";i:9;s:11:\"mega_column\";i:10;s:10:\"sort_order\";i:11;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:8:\"location\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:11:\"footer_menu\";O:15:\"App\\Models\\Menu\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"menus\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:11:\"Footer Menu\";s:8:\"location\";s:6:\"footer\";s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:2;s:4:\"name\";s:11:\"Footer Menu\";s:8:\"location\";s:6:\"footer\";s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:5:\"items\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:8:\"location\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:7:\"widgets\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{s:8:\"footer_1\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:17:\"App\\Models\\Widget\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:7:\"widgets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:4:\"area\";s:8:\"footer_1\";s:4:\"type\";s:4:\"text\";s:5:\"title\";s:20:\"Pacific Tours Canada\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:4:\"area\";s:8:\"footer_1\";s:4:\"type\";s:4:\"text\";s:5:\"title\";s:20:\"Pacific Tours Canada\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"content\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"area\";i:1;s:4:\"type\";i:2;s:5:\"title\";i:3;s:7:\"content\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"footer_2\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:17:\"App\\Models\\Widget\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:7:\"widgets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:2;s:4:\"area\";s:8:\"footer_2\";s:4:\"type\";s:5:\"links\";s:5:\"title\";s:7:\"Company\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:4:\"area\";s:8:\"footer_2\";s:4:\"type\";s:5:\"links\";s:5:\"title\";s:7:\"Company\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"content\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"area\";i:1;s:4:\"type\";i:2;s:5:\"title\";i:3;s:7:\"content\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"footer_3\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:17:\"App\\Models\\Widget\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:7:\"widgets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:4:\"area\";s:8:\"footer_3\";s:4:\"type\";s:7:\"contact\";s:5:\"title\";s:10:\"Talk to us\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:4:\"area\";s:8:\"footer_3\";s:4:\"type\";s:7:\"contact\";s:5:\"title\";s:10:\"Talk to us\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"content\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"area\";i:1;s:4:\"type\";i:2;s:5:\"title\";i:3;s:7:\"content\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"footer_4\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:17:\"App\\Models\\Widget\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:7:\"widgets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:4:\"area\";s:8:\"footer_4\";s:4:\"type\";s:10:\"newsletter\";s:5:\"title\";s:19:\"Trip ideas by email\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:4:\"area\";s:8:\"footer_4\";s:4:\"type\";s:10:\"newsletter\";s:5:\"title\";s:19:\"Trip ideas by email\";s:7:\"content\";s:2:\"[]\";s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:51\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:7:\"content\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"area\";i:1;s:4:\"type\";i:2;s:5:\"title\";i:3;s:7:\"content\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}', 1787027659);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pacific-tours-canada-cache-home:payload:en', 'a:5:{s:12:\"destinations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:19:\"popularDestinations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:13:\"featuredTours\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:20;s:4:\"uuid\";s:36:\"fe813241-8638-49e1-85f6-17b03a0b907b\";s:4:\"code\";s:11:\"PT-T-954896\";s:5:\"title\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:24:\"whistler-sea-to-sky-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";i:4;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:250:\"Travel along the spectacular Sea-to-Sky Highway to the world-famous resort town of Whistler while enjoying breathtaking coastal and mountain scenery.\r\n\r\nThis tour combines waterfalls, ocean views, alpine landscapes, and free time in Whistler Village.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"250.00\";s:11:\"child_price\";s:6:\"125.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"250.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/dc1aafa5-bb80-4f45-a310-a8403ded8a1c.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/19fc7efc-3e6e-4a1d-9b19-2cc37abdf0fd.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 16:17:29\";s:10:\"updated_at\";s:19:\"2026-08-17 16:18:02\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:20;s:4:\"uuid\";s:36:\"fe813241-8638-49e1-85f6-17b03a0b907b\";s:4:\"code\";s:11:\"PT-T-954896\";s:5:\"title\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:24:\"whistler-sea-to-sky-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";i:4;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:250:\"Travel along the spectacular Sea-to-Sky Highway to the world-famous resort town of Whistler while enjoying breathtaking coastal and mountain scenery.\r\n\r\nThis tour combines waterfalls, ocean views, alpine landscapes, and free time in Whistler Village.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"250.00\";s:11:\"child_price\";s:6:\"125.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"250.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/dc1aafa5-bb80-4f45-a310-a8403ded8a1c.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/19fc7efc-3e6e-4a1d-9b19-2cc37abdf0fd.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 16:17:29\";s:10:\"updated_at\";s:19:\"2026-08-17 16:18:02\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:4;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:4;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:19;s:4:\"uuid\";s:36:\"e87448be-3e55-4981-82fa-2fa6d28ba3fe\";s:4:\"code\";s:11:\"PT-T-954895\";s:5:\"title\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:30:\"victoria-butchart-gardens-tour\";s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:2;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:167:\"Explore the beauty and charm of Vancouver Island with a full-day Victoria sightseeing tour featuring ferry travel, coastal scenery, gardens, and historic architecture.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"300.00\";s:11:\"child_price\";s:6:\"150.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"300.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/8c59d8b5-0ae4-4233-aec7-8cce4dc137cf.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/62e3ace5-2de6-4cb3-8cd7-3d923544e345.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";N;s:10:\"created_at\";s:19:\"2026-08-17 16:08:17\";s:10:\"updated_at\";s:19:\"2026-08-17 22:23:44\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:19;s:4:\"uuid\";s:36:\"e87448be-3e55-4981-82fa-2fa6d28ba3fe\";s:4:\"code\";s:11:\"PT-T-954895\";s:5:\"title\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:30:\"victoria-butchart-gardens-tour\";s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:2;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:167:\"Explore the beauty and charm of Vancouver Island with a full-day Victoria sightseeing tour featuring ferry travel, coastal scenery, gardens, and historic architecture.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"300.00\";s:11:\"child_price\";s:6:\"150.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"300.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/8c59d8b5-0ae4-4233-aec7-8cce4dc137cf.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/62e3ace5-2de6-4cb3-8cd7-3d923544e345.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";N;s:10:\"created_at\";s:19:\"2026-08-17 16:08:17\";s:10:\"updated_at\";s:19:\"2026-08-17 22:23:44\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"2246fe3b-0954-4f6b-b2e1-18198871edfc\";s:4:\"code\";s:11:\"PT-T-536024\";s:5:\"title\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:27:\"lower-mainland-village-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";N;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:142:\"Sed quo necessitatibus nostrum quisquam earum beatae in aspernatur amet aut aspernatur doloribus dolorum id deserunt dolor ut quaerat dolorem.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:5;s:15:\"duration_nights\";i:4;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"220.00\";s:11:\"child_price\";s:6:\"110.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"220.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:39;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/02ef7b0b-d490-4b83-b261-d7cbe05d5235.png\";s:6:\"banner\";s:54:\"tours/2026/08/080d7d8b-e25b-4ac3-abd5-75413a2ecc45.png\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:59:59\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"2246fe3b-0954-4f6b-b2e1-18198871edfc\";s:4:\"code\";s:11:\"PT-T-536024\";s:5:\"title\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:27:\"lower-mainland-village-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";N;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:142:\"Sed quo necessitatibus nostrum quisquam earum beatae in aspernatur amet aut aspernatur doloribus dolorum id deserunt dolor ut quaerat dolorem.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:5;s:15:\"duration_nights\";i:4;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"220.00\";s:11:\"child_price\";s:6:\"110.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"220.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:39;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/02ef7b0b-d490-4b83-b261-d7cbe05d5235.png\";s:6:\"banner\";s:54:\"tours/2026/08/080d7d8b-e25b-4ac3-abd5-75413a2ecc45.png\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:59:59\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"11483456-5e51-4b49-8a12-4bd8317a9f7a\";s:4:\"code\";s:11:\"PT-T-897284\";s:5:\"title\";s:35:\"Vancouver & North Shore Scenie Tour\";s:4:\"slug\";s:28:\"ex-repellendus-et-tour-87834\";s:16:\"tour_category_id\";i:7;s:14:\"destination_id\";i:1;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:235:\"Mountains • Ocean • Suspension Bridges\r\n\r\nExperience the stunning beauty of Vancouver’s North Shore featuring coastal mountains, forests, scenic viewpoints, and famous attractions.\r\n\r\nA perfect mix of nature and city sightseeing.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:6;s:15:\"duration_nights\";i:5;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"150.00\";s:11:\"child_price\";s:5:\"75.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"150.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:17;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/27a491ef-d6d5-4a25-a381-b836c2789372.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/694a0fdb-7f79-460c-a0d7-16972b91465f.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:54:38\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"11483456-5e51-4b49-8a12-4bd8317a9f7a\";s:4:\"code\";s:11:\"PT-T-897284\";s:5:\"title\";s:35:\"Vancouver & North Shore Scenie Tour\";s:4:\"slug\";s:28:\"ex-repellendus-et-tour-87834\";s:16:\"tour_category_id\";i:7;s:14:\"destination_id\";i:1;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:235:\"Mountains • Ocean • Suspension Bridges\r\n\r\nExperience the stunning beauty of Vancouver’s North Shore featuring coastal mountains, forests, scenic viewpoints, and famous attractions.\r\n\r\nA perfect mix of nature and city sightseeing.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:6;s:15:\"duration_nights\";i:5;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"150.00\";s:11:\"child_price\";s:5:\"75.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"150.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:17;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/27a491ef-d6d5-4a25-a381-b836c2789372.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/694a0fdb-7f79-460c-a0d7-16972b91465f.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:54:38\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:12:\"homeFeatures\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:2;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/710faf90-097b-456d-9b9a-d70f5f8e8d8f.png\";s:5:\"title\";s:22:\"Small Group Experience\";s:11:\"description\";s:130:\"Travel in small groups for a more personal, relaxed, and enjoyable tour experience with dedicated attention from our local guides.\";s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:31:51\";s:10:\"updated_at\";s:19:\"2026-08-17 11:40:09\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/710faf90-097b-456d-9b9a-d70f5f8e8d8f.png\";s:5:\"title\";s:22:\"Small Group Experience\";s:11:\"description\";s:130:\"Travel in small groups for a more personal, relaxed, and enjoyable tour experience with dedicated attention from our local guides.\";s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:31:51\";s:10:\"updated_at\";s:19:\"2026-08-17 11:40:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/92554ab3-9f75-400a-b425-6e2b116afbd1.png\";s:5:\"title\";s:20:\"Private Custom Tours\";s:11:\"description\";s:114:\"Create a personalized British Columbia sightseeing itinerary tailored to your interests, schedule, and group size.\";s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:35:16\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:57\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/92554ab3-9f75-400a-b425-6e2b116afbd1.png\";s:5:\"title\";s:20:\"Private Custom Tours\";s:11:\"description\";s:114:\"Create a personalized British Columbia sightseeing itinerary tailored to your interests, schedule, and group size.\";s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:35:16\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:57\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/4dcf03aa-b210-4022-9443-f07c7248a4ae.png\";s:5:\"title\";s:15:\"Safe & Reliable\";s:11:\"description\";s:102:\"Travel with confidence through trusted guides, comfortable transportation, and reliable tour services.\";s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:36:24\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:33\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/4dcf03aa-b210-4022-9443-f07c7248a4ae.png\";s:5:\"title\";s:15:\"Safe & Reliable\";s:11:\"description\";s:102:\"Travel with confidence through trusted guides, comfortable transportation, and reliable tour services.\";s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:36:24\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:5;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/99a93f75-72b6-4c80-9a7d-96324e5e619b.png\";s:5:\"title\";s:27:\"Cruise Passenger Excursions\";s:11:\"description\";s:144:\"Convenient sightseeing tours designed for cruise ship visitors arriving in Vancouver who want to maximize their time exploring British Columbia.\";s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:37:31\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:22\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:5;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/99a93f75-72b6-4c80-9a7d-96324e5e619b.png\";s:5:\"title\";s:27:\"Cruise Passenger Excursions\";s:11:\"description\";s:144:\"Convenient sightseeing tours designed for cruise ship visitors arriving in Vancouver who want to maximize their time exploring British Columbia.\";s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:37:31\";s:10:\"updated_at\";s:19:\"2026-08-17 11:39:22\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:6;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/aa94ac17-4ede-4304-82ae-bc64ef70a102.png\";s:5:\"title\";s:16:\"Flexible Service\";s:11:\"description\";s:70:\"Ideal for families, visitors, cruise passengers, and corporate groups.\";s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:38:22\";s:10:\"updated_at\";s:19:\"2026-08-17 10:19:39\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:6;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/aa94ac17-4ede-4304-82ae-bc64ef70a102.png\";s:5:\"title\";s:16:\"Flexible Service\";s:11:\"description\";s:70:\"Ideal for families, visitors, cruise passengers, and corporate groups.\";s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:38:22\";s:10:\"updated_at\";s:19:\"2026-08-17 10:19:39\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:22:\"App\\Models\\HomeFeature\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"home_features\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:7;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/cfa9fc48-543a-4536-976b-926809eba3ff.png\";s:5:\"title\";s:37:\"Mercedes-Benz Sprinter transportation\";s:11:\"description\";s:59:\"Professional commercial driver with extensive BC experience\";s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:39:32\";s:10:\"updated_at\";s:19:\"2026-08-17 10:18:35\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:7;s:4:\"icon\";s:5:\"check\";s:5:\"image\";s:62:\"home-features/2026/08/cfa9fc48-543a-4536-976b-926809eba3ff.png\";s:5:\"title\";s:37:\"Mercedes-Benz Sprinter transportation\";s:11:\"description\";s:59:\"Professional commercial driver with extensive BC experience\";s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 05:39:32\";s:10:\"updated_at\";s:19:\"2026-08-17 10:18:35\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:9:\"is_active\";s:7:\"boolean\";s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"icon\";i:1;s:5:\"image\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:10:\"sort_order\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:12:\"testimonials\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:22:\"App\\Models\\Testimonial\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"testimonials\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:1;s:4:\"name\";s:14:\"Kamren Kovacek\";s:11:\"designation\";s:23:\"Life Science Technician\";s:6:\"avatar\";s:61:\"testimonials/2026/08/f4a0c015-5f33-4138-aea2-d3304e9b09a7.jpg\";s:6:\"rating\";i:5;s:7:\"content\";s:152:\"Qui enim illo dolorem praesentium harum doloribus ea. Quo iste occaecati dolorem molestias neque. Occaecati et magnam voluptas eum illum quidem laborum.\";s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:03:03\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:1;s:4:\"name\";s:14:\"Kamren Kovacek\";s:11:\"designation\";s:23:\"Life Science Technician\";s:6:\"avatar\";s:61:\"testimonials/2026/08/f4a0c015-5f33-4138-aea2-d3304e9b09a7.jpg\";s:6:\"rating\";i:5;s:7:\"content\";s:152:\"Qui enim illo dolorem praesentium harum doloribus ea. Quo iste occaecati dolorem molestias neque. Occaecati et magnam voluptas eum illum quidem laborum.\";s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:03:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:11:\"designation\";i:2;s:6:\"avatar\";i:3;s:6:\"rating\";i:4;s:7:\"content\";i:5;s:10:\"sort_order\";i:6;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:22:\"App\\Models\\Testimonial\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"testimonials\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:3;s:4:\"name\";s:18:\"Edwardo Wisozk DVM\";s:11:\"designation\";s:18:\"Psychology Teacher\";s:6:\"avatar\";s:61:\"testimonials/2026/08/a6b19fca-e090-46b8-9c48-9d4c58e3e349.jpg\";s:6:\"rating\";i:4;s:7:\"content\";s:135:\"Natus nemo corrupti ab ullam. Reprehenderit voluptatum eligendi eaque veritatis magni dolorem. Sunt alias est itaque in distinctio qui.\";s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:02:31\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:3;s:4:\"name\";s:18:\"Edwardo Wisozk DVM\";s:11:\"designation\";s:18:\"Psychology Teacher\";s:6:\"avatar\";s:61:\"testimonials/2026/08/a6b19fca-e090-46b8-9c48-9d4c58e3e349.jpg\";s:6:\"rating\";i:4;s:7:\"content\";s:135:\"Natus nemo corrupti ab ullam. Reprehenderit voluptatum eligendi eaque veritatis magni dolorem. Sunt alias est itaque in distinctio qui.\";s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:02:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:11:\"designation\";i:2;s:6:\"avatar\";i:3;s:6:\"rating\";i:4;s:7:\"content\";i:5;s:10:\"sort_order\";i:6;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:22:\"App\\Models\\Testimonial\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"testimonials\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:17:\"Prof. Viola Hills\";s:11:\"designation\";s:31:\"Supervisor Fire Fighting Worker\";s:6:\"avatar\";s:61:\"testimonials/2026/08/a4746b27-8699-4627-b24f-3437d9953e38.png\";s:6:\"rating\";i:5;s:7:\"content\";s:171:\"Commodi nostrum qui reiciendis saepe quos suscipit. Ut voluptatem cumque fugiat laborum ab. Rerum numquam nihil et quam. Laborum adipisci aut unde rem repellendus sed est.\";s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:02:09\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:17:\"Prof. Viola Hills\";s:11:\"designation\";s:31:\"Supervisor Fire Fighting Worker\";s:6:\"avatar\";s:61:\"testimonials/2026/08/a4746b27-8699-4627-b24f-3437d9953e38.png\";s:6:\"rating\";i:5;s:7:\"content\";s:171:\"Commodi nostrum qui reiciendis saepe quos suscipit. Ut voluptatem cumque fugiat laborum ab. Rerum numquam nihil et quam. Laborum adipisci aut unde rem repellendus sed est.\";s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:02:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:11:\"designation\";i:2;s:6:\"avatar\";i:3;s:6:\"rating\";i:4;s:7:\"content\";i:5;s:10:\"sort_order\";i:6;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:22:\"App\\Models\\Testimonial\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"testimonials\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:5;s:4:\"name\";s:18:\"Prof. Savion Kiehn\";s:11:\"designation\";s:10:\"Ship Pilot\";s:6:\"avatar\";s:61:\"testimonials/2026/08/b5016c86-a880-40f7-a201-1504f793336c.png\";s:6:\"rating\";i:4;s:7:\"content\";s:152:\"Quia sunt ad error. Veritatis saepe sit aliquid labore quis illum dignissimos. Quisquam ut at odio non illum minima. Praesentium et in et quod ut rerum.\";s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:01:54\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:5;s:4:\"name\";s:18:\"Prof. Savion Kiehn\";s:11:\"designation\";s:10:\"Ship Pilot\";s:6:\"avatar\";s:61:\"testimonials/2026/08/b5016c86-a880-40f7-a201-1504f793336c.png\";s:6:\"rating\";i:4;s:7:\"content\";s:152:\"Quia sunt ad error. Veritatis saepe sit aliquid labore quis illum dignissimos. Quisquam ut at odio non illum minima. Praesentium et in et quod ut rerum.\";s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:01:54\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:11:\"designation\";i:2;s:6:\"avatar\";i:3;s:6:\"rating\";i:4;s:7:\"content\";i:5;s:10:\"sort_order\";i:6;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:22:\"App\\Models\\Testimonial\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"testimonials\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:15:\"Reina Bergstrom\";s:11:\"designation\";s:26:\"Freight and Material Mover\";s:6:\"avatar\";s:61:\"testimonials/2026/08/bf863525-c834-47c8-a2b7-d27e8b972289.png\";s:6:\"rating\";i:5;s:7:\"content\";s:138:\"Necessitatibus dolore beatae sequi cumque omnis facere et. Soluta sit inventore voluptatem qui sunt in. Earum et facere distinctio maxime.\";s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:00:07\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:15:\"Reina Bergstrom\";s:11:\"designation\";s:26:\"Freight and Material Mover\";s:6:\"avatar\";s:61:\"testimonials/2026/08/bf863525-c834-47c8-a2b7-d27e8b972289.png\";s:6:\"rating\";i:5;s:7:\"content\";s:138:\"Necessitatibus dolore beatae sequi cumque omnis facere et. Soluta sit inventore voluptatem qui sunt in. Earum et facere distinctio maxime.\";s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:24\";s:10:\"updated_at\";s:19:\"2026-08-17 15:00:07\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:11:\"designation\";i:2;s:6:\"avatar\";i:3;s:6:\"rating\";i:4;s:7:\"content\";i:5;s:10:\"sort_order\";i:6;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}', 1787024659);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pacific-tours-canada-cache-languages:active', 'a:2:{i:0;s:2:\"en\";i:1;s:2:\"fr\";}', 1787027659),
('pacific-tours-canada-cache-search:facets', 'a:6:{s:10:\"categories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:7:{i:0;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:1;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Day Tours\";s:4:\"slug\";s:9:\"day-tours\";s:4:\"icon\";s:3:\"sun\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:2;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:1;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Day Tours\";s:4:\"slug\";s:9:\"day-tours\";s:4:\"icon\";s:3:\"sun\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:2;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Multi-Day Tours\";s:4:\"slug\";s:15:\"multi-day-tours\";s:4:\"icon\";s:3:\"map\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:2;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Multi-Day Tours\";s:4:\"slug\";s:15:\"multi-day-tours\";s:4:\"icon\";s:3:\"map\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:1;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:3;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Wildlife & Nature\";s:4:\"slug\";s:15:\"wildlife-nature\";s:4:\"icon\";s:4:\"leaf\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:3;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Wildlife & Nature\";s:4:\"slug\";s:15:\"wildlife-nature\";s:4:\"icon\";s:4:\"leaf\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:2;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:4;s:9:\"parent_id\";N;s:4:\"name\";s:14:\"City & Culture\";s:4:\"slug\";s:12:\"city-culture\";s:4:\"icon\";s:8:\"building\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:4;s:9:\"parent_id\";N;s:4:\"name\";s:14:\"City & Culture\";s:4:\"slug\";s:12:\"city-culture\";s:4:\"icon\";s:8:\"building\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:3;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:4;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:5;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Adventure\";s:4:\"slug\";s:9:\"adventure\";s:4:\"icon\";s:8:\"mountain\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:5;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Adventure\";s:4:\"slug\";s:9:\"adventure\";s:4:\"icon\";s:8:\"mountain\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:4;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:5;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:6;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Cruise Excursions\";s:4:\"slug\";s:17:\"cruise-excursions\";s:4:\"icon\";s:4:\"ship\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:6;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Cruise Excursions\";s:4:\"slug\";s:17:\"cruise-excursions\";s:4:\"icon\";s:4:\"ship\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:5;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:6;O:23:\"App\\Models\\TourCategory\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"tour_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:7;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Private Charters\";s:4:\"slug\";s:16:\"private-charters\";s:4:\"icon\";s:4:\"star\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:7;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Private Charters\";s:4:\"slug\";s:16:\"private-charters\";s:4:\"icon\";s:4:\"star\";s:5:\"image\";N;s:11:\"description\";N;s:12:\"show_in_menu\";i:1;s:10:\"sort_order\";i:6;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"updated_at\";s:19:\"2026-07-31 06:34:52\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:9:\"is_active\";s:7:\"boolean\";s:12:\"show_in_menu\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:4:\"icon\";i:4;s:5:\"image\";i:5;s:11:\"description\";i:6;s:12:\"show_in_menu\";i:7;s:10:\"sort_order\";i:8;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:12:\"destinations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:3;s:4:\"uuid\";s:36:\"98e1fb94-e696-4ea0-b555-dc8f4e4814cb\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:4;s:4:\"name\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:16:\"canadian-rockies\";s:17:\"short_description\";s:50:\"Coastal Views • Local Culture • Historic Sites\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png\";s:6:\"banner\";s:61:\"destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:01:55\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"0f274a08-ad16-49e7-915f-1322cea44a54\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";s:17:\"short_description\";s:42:\"Mountains • Ocean • Suspension Bridges\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:44:50\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"82fe1496-edf3-4bf1-ae13-b78697dad377\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";s:17:\"short_description\";s:48:\"Ferry Experience • Gardens • Coastal Scenery\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png\";s:6:\"banner\";s:61:\"destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:1;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:18:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:11:\"\0*\0original\";a:18:{s:2:\"id\";i:4;s:4:\"uuid\";s:36:\"213f4579-cbf9-46df-afa5-4ac2a57bf5aa\";s:10:\"country_id\";i:1;s:7:\"city_id\";i:3;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";s:17:\"short_description\";s:45:\"Mountains • Waterfalls Scenic • Adventure\";s:11:\"description\";N;s:9:\"thumbnail\";s:61:\"destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg\";s:6:\"banner\";s:61:\"destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg\";s:18:\"best_time_to_visit\";N;s:11:\"is_featured\";i:0;s:10:\"sort_order\";i:0;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:34:50\";s:10:\"updated_at\";s:19:\"2026-08-17 09:00:34\";s:10:\"deleted_at\";N;s:11:\"tours_count\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:9:\"countries\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:6:\"cities\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:9:\"durations\";a:4:{i:0;a:3:{s:5:\"label\";s:10:\"1–3 days\";s:3:\"min\";i:1;s:3:\"max\";i:3;}i:1;a:3:{s:5:\"label\";s:10:\"4–7 days\";s:3:\"min\";i:4;s:3:\"max\";i:7;}i:2;a:3:{s:5:\"label\";s:11:\"8–14 days\";s:3:\"min\";i:8;s:3:\"max\";i:14;}i:3;a:3:{s:5:\"label\";s:8:\"15+ days\";s:3:\"min\";i:15;s:3:\"max\";i:365;}}s:11:\"price_range\";a:2:{s:3:\"min\";d:150;s:3:\"max\";d:300;}}', 1787007552),
('pacific-tours-canada-cache-settings:all', 'a:37:{s:20:\"general.company_name\";s:20:\"Pacific Tours Canada\";s:21:\"general.company_email\";s:20:\"info@pacifictours.ca\";s:21:\"general.company_phone\";s:15:\"+1 604 000 0000\";s:23:\"general.company_address\";s:35:\"Vancouver, British Columbia, Canada\";s:24:\"general.invoice_due_days\";i:7;s:32:\"general.unpaid_booking_ttl_hours\";i:48;s:14:\"theme.currency\";s:3:\"CAD\";s:14:\"theme.timezone\";s:17:\"America/Vancouver\";s:14:\"theme.language\";s:2:\"en\";s:22:\"payment.stripe_enabled\";b:1;s:22:\"payment.paypal_enabled\";b:0;s:15:\"social.facebook\";s:33:\"https://facebook.com/pacifictours\";s:16:\"social.instagram\";s:34:\"https://instagram.com/pacifictours\";s:18:\"social.tripadvisor\";s:0:\"\";s:14:\"seo.meta_title\";s:71:\"Pacific Tours Canada · Guided tours across British Columbia and beyond\";s:20:\"seo.meta_description\";s:85:\"Small-group and private guided tours departing from Vancouver, Victoria and Whistler.\";s:20:\"home.hero_title_lead\";s:21:\"never say never alone\";s:22:\"home.hero_title_accent\";N;s:21:\"home.hero_title_trail\";N;s:18:\"home.hero_subtitle\";N;s:19:\"home.hero_cta_label\";N;s:12:\"home.hero_bg\";s:57:\"branding/2026/08/e0811ed9-a65d-4b9d-8163-db85785c59cf.jpg\";s:18:\"home.section_title\";N;s:25:\"home.destinations_heading\";N;s:23:\"home.destinations_intro\";N;s:21:\"home.featured_heading\";N;s:19:\"home.featured_intro\";N;s:16:\"home.why_heading\";N;s:14:\"home.why_intro\";N;s:25:\"home.testimonials_heading\";N;s:23:\"home.testimonials_intro\";N;s:18:\"home.fleet_heading\";s:112:\"Professional commercial driver with extensive BC experience -  Comfortable Mercedes-Benz Sprinter transportation\";s:20:\"home.contact_heading\";N;s:18:\"home.contact_intro\";N;s:18:\"home.map_embed_url\";N;s:19:\"home.fleet_features\";a:8:{i:0;s:16:\"High Roof Design\";i:1;s:16:\"Air Conditioning\";i:2;s:19:\"Comfortable Seating\";i:3;s:13:\"Large Windows\";i:4;s:15:\"Panoramic Views\";i:5;s:16:\"Luggage Capacity\";i:6;s:24:\"Professional Maintenance\";i:7;s:22:\"Modern Safety Features\";}s:13:\"home.fleet_bg\";s:57:\"branding/2026/08/e1841453-5409-4895-b710-05f93fd98fc9.png\";}', 2102349293),
('pacific-tours-canada-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:49:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"tour.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"tour.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"tour.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"tour.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"tour.publish\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"booking.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"booking.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"booking.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"booking.confirm\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"booking.cancel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:14:\"booking.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"payment.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"payment.record\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"payment.refund\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:13:\"customer.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"customer.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:15:\"customer.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"customer.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:9:\"user.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:11:\"user.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"user.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:11:\"user.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"category.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"category.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"category.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:15:\"category.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:16:\"destination.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:18:\"destination.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:18:\"destination.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:18:\"destination.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:11:\"coupon.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:13:\"coupon.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:13:\"coupon.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"coupon.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:11:\"review.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"review.approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:13:\"review.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"review.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:8:\"cms.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:10:\"cms.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:10:\"cms.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"cms.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:11:\"report.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:13:\"report.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"setting.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"setting.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:11:\"ticket.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"ticket.reply\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:12:\"ticket.close\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"sales-executive\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"tour-operator\";s:1:\"c\";s:3:\"web\";}}}', 1787075727);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pacific-tours-canada-cache-tours:featured:8', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:20;s:4:\"uuid\";s:36:\"fe813241-8638-49e1-85f6-17b03a0b907b\";s:4:\"code\";s:11:\"PT-T-954896\";s:5:\"title\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:24:\"whistler-sea-to-sky-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";i:4;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:250:\"Travel along the spectacular Sea-to-Sky Highway to the world-famous resort town of Whistler while enjoying breathtaking coastal and mountain scenery.\r\n\r\nThis tour combines waterfalls, ocean views, alpine landscapes, and free time in Whistler Village.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"250.00\";s:11:\"child_price\";s:6:\"125.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"250.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/dc1aafa5-bb80-4f45-a310-a8403ded8a1c.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/19fc7efc-3e6e-4a1d-9b19-2cc37abdf0fd.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 16:17:29\";s:10:\"updated_at\";s:19:\"2026-08-17 16:18:02\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:20;s:4:\"uuid\";s:36:\"fe813241-8638-49e1-85f6-17b03a0b907b\";s:4:\"code\";s:11:\"PT-T-954896\";s:5:\"title\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:24:\"whistler-sea-to-sky-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";i:4;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:250:\"Travel along the spectacular Sea-to-Sky Highway to the world-famous resort town of Whistler while enjoying breathtaking coastal and mountain scenery.\r\n\r\nThis tour combines waterfalls, ocean views, alpine landscapes, and free time in Whistler Village.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"250.00\";s:11:\"child_price\";s:6:\"125.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"250.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/dc1aafa5-bb80-4f45-a310-a8403ded8a1c.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/19fc7efc-3e6e-4a1d-9b19-2cc37abdf0fd.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-08-17 16:17:29\";s:10:\"updated_at\";s:19:\"2026-08-17 16:18:02\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:4;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:4;s:4:\"name\";s:26:\"Whistler & Sea-to-Sky Tour\";s:4:\"slug\";s:8:\"whistler\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:19;s:4:\"uuid\";s:36:\"e87448be-3e55-4981-82fa-2fa6d28ba3fe\";s:4:\"code\";s:11:\"PT-T-954895\";s:5:\"title\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:30:\"victoria-butchart-gardens-tour\";s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:2;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:167:\"Explore the beauty and charm of Vancouver Island with a full-day Victoria sightseeing tour featuring ferry travel, coastal scenery, gardens, and historic architecture.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"300.00\";s:11:\"child_price\";s:6:\"150.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"300.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/8c59d8b5-0ae4-4233-aec7-8cce4dc137cf.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/62e3ace5-2de6-4cb3-8cd7-3d923544e345.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";N;s:10:\"created_at\";s:19:\"2026-08-17 16:08:17\";s:10:\"updated_at\";s:19:\"2026-08-17 22:23:44\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:19;s:4:\"uuid\";s:36:\"e87448be-3e55-4981-82fa-2fa6d28ba3fe\";s:4:\"code\";s:11:\"PT-T-954895\";s:5:\"title\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:30:\"victoria-butchart-gardens-tour\";s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:2;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:167:\"Explore the beauty and charm of Vancouver Island with a full-day Victoria sightseeing tour featuring ferry travel, coastal scenery, gardens, and historic architecture.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:1;s:15:\"duration_nights\";i:0;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:8:\"moderate\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"300.00\";s:11:\"child_price\";s:6:\"150.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"300.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:8:\"disabled\";s:13:\"deposit_value\";s:4:\"0.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:25;s:11:\"min_booking\";i:5;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:2;s:9:\"thumbnail\";s:54:\"tours/2026/08/8c59d8b5-0ae4-4233-aec7-8cce4dc137cf.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/62e3ace5-2de6-4cb3-8cd7-3d923544e345.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";N;s:10:\"created_by\";i:1;s:10:\"updated_by\";N;s:10:\"created_at\";s:19:\"2026-08-17 16:08:17\";s:10:\"updated_at\";s:19:\"2026-08-17 22:23:44\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:2;s:4:\"name\";s:32:\"Victoria & Butchart Gardens Tour\";s:4:\"slug\";s:16:\"vancouver-island\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"2246fe3b-0954-4f6b-b2e1-18198871edfc\";s:4:\"code\";s:11:\"PT-T-536024\";s:5:\"title\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:27:\"lower-mainland-village-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";N;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:142:\"Sed quo necessitatibus nostrum quisquam earum beatae in aspernatur amet aut aspernatur doloribus dolorum id deserunt dolor ut quaerat dolorem.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:5;s:15:\"duration_nights\";i:4;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"220.00\";s:11:\"child_price\";s:6:\"110.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"220.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:39;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/02ef7b0b-d490-4b83-b261-d7cbe05d5235.png\";s:6:\"banner\";s:54:\"tours/2026/08/080d7d8b-e25b-4ac3-abd5-75413a2ecc45.png\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:59:59\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:5;s:4:\"uuid\";s:36:\"2246fe3b-0954-4f6b-b2e1-18198871edfc\";s:4:\"code\";s:11:\"PT-T-536024\";s:5:\"title\";s:27:\"Lower Mainland Village Tour\";s:4:\"slug\";s:27:\"lower-mainland-village-tour\";s:16:\"tour_category_id\";i:1;s:14:\"destination_id\";N;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:142:\"Sed quo necessitatibus nostrum quisquam earum beatae in aspernatur amet aut aspernatur doloribus dolorum id deserunt dolor ut quaerat dolorem.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:5;s:15:\"duration_nights\";i:4;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"220.00\";s:11:\"child_price\";s:6:\"110.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"220.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:39;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/02ef7b0b-d490-4b83-b261-d7cbe05d5235.png\";s:6:\"banner\";s:54:\"tours/2026/08/080d7d8b-e25b-4ac3-abd5-75413a2ecc45.png\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:0;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:59:59\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:15:\"App\\Models\\Tour\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"tours\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:56:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"11483456-5e51-4b49-8a12-4bd8317a9f7a\";s:4:\"code\";s:11:\"PT-T-897284\";s:5:\"title\";s:35:\"Vancouver & North Shore Scenie Tour\";s:4:\"slug\";s:28:\"ex-repellendus-et-tour-87834\";s:16:\"tour_category_id\";i:7;s:14:\"destination_id\";i:1;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:235:\"Mountains • Ocean • Suspension Bridges\r\n\r\nExperience the stunning beauty of Vancouver’s North Shore featuring coastal mountains, forests, scenic viewpoints, and famous attractions.\r\n\r\nA perfect mix of nature and city sightseeing.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:6;s:15:\"duration_nights\";i:5;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"150.00\";s:11:\"child_price\";s:5:\"75.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"150.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:17;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/27a491ef-d6d5-4a25-a381-b836c2789372.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/694a0fdb-7f79-460c-a0d7-16972b91465f.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:54:38\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:56:{s:2:\"id\";i:2;s:4:\"uuid\";s:36:\"11483456-5e51-4b49-8a12-4bd8317a9f7a\";s:4:\"code\";s:11:\"PT-T-897284\";s:5:\"title\";s:35:\"Vancouver & North Shore Scenie Tour\";s:4:\"slug\";s:28:\"ex-repellendus-et-tour-87834\";s:16:\"tour_category_id\";i:7;s:14:\"destination_id\";i:1;s:10:\"country_id\";N;s:7:\"city_id\";N;s:7:\"summary\";s:235:\"Mountains • Ocean • Suspension Bridges\r\n\r\nExperience the stunning beauty of Vancouver’s North Shore featuring coastal mountains, forests, scenic viewpoints, and famous attractions.\r\n\r\nA perfect mix of nature and city sightseeing.\";s:11:\"description\";N;s:18:\"travel_information\";N;s:20:\"terms_and_conditions\";N;s:19:\"cancellation_policy\";N;s:17:\"visa_requirements\";N;s:13:\"duration_days\";i:6;s:15:\"duration_nights\";i:5;s:9:\"tour_type\";s:5:\"group\";s:10:\"difficulty\";s:4:\"easy\";s:15:\"pickup_location\";N;s:13:\"drop_location\";N;s:13:\"meeting_point\";N;s:10:\"base_price\";s:6:\"150.00\";s:11:\"child_price\";s:5:\"75.00\";s:12:\"infant_price\";s:4:\"0.00\";s:13:\"discount_type\";s:4:\"none\";s:14:\"discount_value\";s:4:\"0.00\";s:10:\"sale_price\";s:6:\"150.00\";s:14:\"tax_percentage\";s:4:\"5.00\";s:11:\"service_fee\";s:4:\"0.00\";s:12:\"deposit_type\";s:10:\"percentage\";s:13:\"deposit_value\";s:5:\"25.00\";s:8:\"currency\";s:3:\"CAD\";s:9:\"max_seats\";i:17;s:11:\"min_booking\";i:1;s:11:\"max_booking\";i:12;s:20:\"booking_cutoff_hours\";i:48;s:9:\"thumbnail\";s:54:\"tours/2026/08/27a491ef-d6d5-4a25-a381-b836c2789372.jpg\";s:6:\"banner\";s:54:\"tours/2026/08/694a0fdb-7f79-460c-a0d7-16972b91465f.jpg\";s:9:\"video_url\";N;s:12:\"map_latitude\";N;s:13:\"map_longitude\";N;s:6:\"status\";s:9:\"published\";s:11:\"is_featured\";i:1;s:10:\"is_popular\";i:1;s:14:\"is_recommended\";i:0;s:14:\"average_rating\";s:4:\"0.00\";s:13:\"reviews_count\";i:0;s:14:\"bookings_count\";i:0;s:11:\"views_count\";i:1;s:12:\"published_at\";s:19:\"2026-07-31 06:35:11\";s:10:\"created_by\";N;s:10:\"updated_by\";i:1;s:10:\"created_at\";s:19:\"2026-07-31 06:35:12\";s:10:\"updated_at\";s:19:\"2026-08-17 06:54:38\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:16:{s:6:\"status\";s:20:\"App\\Enums\\TourStatus\";s:13:\"discount_type\";s:22:\"App\\Enums\\DiscountType\";s:12:\"deposit_type\";s:21:\"App\\Enums\\DepositType\";s:11:\"is_featured\";s:7:\"boolean\";s:10:\"is_popular\";s:7:\"boolean\";s:14:\"is_recommended\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";s:10:\"base_price\";s:9:\"decimal:2\";s:11:\"child_price\";s:9:\"decimal:2\";s:12:\"infant_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"discount_value\";s:9:\"decimal:2\";s:11:\"service_fee\";s:9:\"decimal:2\";s:14:\"tax_percentage\";s:9:\"decimal:2\";s:14:\"average_rating\";s:9:\"decimal:2\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:11:\"destination\";O:22:\"App\\Models\\Destination\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:12:\"destinations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:1;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:2:\"id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";}s:11:\"\0*\0original\";a:3:{s:2:\"id\";i:1;s:4:\"name\";s:35:\"Vancouver & North Shore Scenic Tour\";s:4:\"slug\";s:20:\"vancouver-sea-to-sky\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:4:\"uuid\";i:1;s:10:\"country_id\";i:2;s:7:\"city_id\";i:3;s:4:\"name\";i:4;s:4:\"slug\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:9:\"thumbnail\";i:8;s:6:\"banner\";i:9;s:18:\"best_time_to_visit\";i:10;s:11:\"is_featured\";i:11;s:10:\"sort_order\";i:12;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:48:{i:0;s:4:\"uuid\";i:1;s:4:\"code\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:16:\"tour_category_id\";i:5;s:14:\"destination_id\";i:6;s:10:\"country_id\";i:7;s:7:\"city_id\";i:8;s:7:\"summary\";i:9;s:11:\"description\";i:10;s:18:\"travel_information\";i:11;s:20:\"terms_and_conditions\";i:12;s:19:\"cancellation_policy\";i:13;s:17:\"visa_requirements\";i:14;s:13:\"duration_days\";i:15;s:15:\"duration_nights\";i:16;s:9:\"tour_type\";i:17;s:10:\"difficulty\";i:18;s:15:\"pickup_location\";i:19;s:13:\"drop_location\";i:20;s:13:\"meeting_point\";i:21;s:10:\"base_price\";i:22;s:11:\"child_price\";i:23;s:12:\"infant_price\";i:24;s:13:\"discount_type\";i:25;s:14:\"discount_value\";i:26;s:10:\"sale_price\";i:27;s:14:\"tax_percentage\";i:28;s:11:\"service_fee\";i:29;s:12:\"deposit_type\";i:30;s:13:\"deposit_value\";i:31;s:8:\"currency\";i:32;s:9:\"max_seats\";i:33;s:11:\"min_booking\";i:34;s:11:\"max_booking\";i:35;s:20:\"booking_cutoff_hours\";i:36;s:9:\"thumbnail\";i:37;s:6:\"banner\";i:38;s:9:\"video_url\";i:39;s:12:\"map_latitude\";i:40;s:13:\"map_longitude\";i:41;s:6:\"status\";i:42;s:11:\"is_featured\";i:43;s:10:\"is_popular\";i:44;s:14:\"is_recommended\";i:45;s:12:\"published_at\";i:46;s:10:\"created_by\";i:47;s:10:\"updated_by\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1787024959);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `slug`, `latitude`, `longitude`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Vancouver', 'vancouver', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(2, 1, 'Victoria', 'victoria', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(3, 1, 'Whistler', 'whistler', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(4, 1, 'Banff', 'banff', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(5, 1, 'Calgary', 'calgary', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(6, 1, 'Toronto', 'toronto', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(7, 1, 'Quebec City', 'quebec-city', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(8, 1, 'Jasper', 'jasper', NULL, NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `iso2` char(2) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `slug`, `iso2`, `iso3`, `phone_code`, `currency_code`, `flag`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Canada', 'canada', 'CA', 'CAN', '+1', 'CAD', NULL, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(2, 'United States', 'united-states', 'US', 'USA', '+1', 'USD', NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(3, 'Mexico', 'mexico', 'MX', 'MEX', '+52', 'MXN', NULL, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(40) NOT NULL,
  `name` varchar(160) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'percentage',
  `value` decimal(12,2) NOT NULL,
  `min_spend` decimal(12,2) DEFAULT NULL,
  `max_discount` decimal(12,2) DEFAULT NULL,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL,
  `usage_limit_per_user` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `applicable_tour_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_tour_ids`)),
  `applicable_category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_category_ids`)),
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `code` char(3) NOT NULL,
  `symbol` varchar(8) NOT NULL,
  `exchange_rate` decimal(14,6) NOT NULL DEFAULT 1.000000,
  `position` varchar(10) NOT NULL DEFAULT 'left',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `exchange_rate`, `position`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Canadian Dollar', 'CAD', '$', 1.000000, 'left', 1, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(2, 'US Dollar', 'USD', 'US$', 0.730000, 'left', 0, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(3, 'Euro', 'EUR', '€', 0.680000, 'left', 0, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `customer_profiles`
--

CREATE TABLE `customer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(120) DEFAULT NULL,
  `province` varchar(120) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `passport_number` varchar(64) DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(32) DEFAULT NULL,
  `newsletter_opt_in` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_profiles`
--

INSERT INTO `customer_profiles` (`id`, `user_id`, `date_of_birth`, `gender`, `address_line1`, `address_line2`, `city`, `province`, `postal_code`, `country_id`, `passport_number`, `passport_expiry`, `emergency_contact_name`, `emergency_contact_phone`, `newsletter_opt_in`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:34:48', '2026-07-31 06:34:48'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:34:53', '2026-07-31 06:34:53'),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:34:54', '2026-07-31 06:34:54'),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:34:55', '2026-07-31 06:34:55'),
(5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:08', '2026-07-31 06:35:08'),
(6, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:08', '2026-07-31 06:35:08'),
(7, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(12, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(13, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(14, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(15, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(17, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(18, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(19, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:09', '2026-07-31 06:35:09'),
(20, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(21, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(22, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(23, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(24, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(25, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(26, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(27, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(28, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10'),
(29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 06:35:10', '2026-07-31 06:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `best_time_to_visit` varchar(160) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `uuid`, `country_id`, `city_id`, `name`, `slug`, `short_description`, `description`, `thumbnail`, `banner`, `best_time_to_visit`, `is_featured`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '0f274a08-ad16-49e7-915f-1322cea44a54', 1, 1, 'Vancouver & North Shore Scenic Tour', 'vancouver-sea-to-sky', 'Mountains • Ocean • Suspension Bridges', NULL, 'destinations/2026/08/b55e080f-a270-44e3-b6bc-4e05df40c56a.jpg', 'destinations/2026/08/4503dcef-ba1c-4f34-a4d7-9a29fb65e571.jpg', NULL, 1, 0, 1, '2026-07-31 06:34:50', '2026-08-17 09:44:50', NULL),
(2, '82fe1496-edf3-4bf1-ae13-b78697dad377', 1, 2, 'Victoria & Butchart Gardens Tour', 'vancouver-island', 'Ferry Experience • Gardens • Coastal Scenery', NULL, 'destinations/2026/08/48ac5eb6-790c-4244-9759-13774f467603.png', 'destinations/2026/08/fe6eabb8-19a7-46a2-8598-3fba588f3832.png', NULL, 1, 0, 1, '2026-07-31 06:34:50', '2026-08-17 09:00:34', NULL),
(3, '98e1fb94-e696-4ea0-b555-dc8f4e4814cb', 1, 4, 'Lower Mainland Village Tour', 'canadian-rockies', 'Coastal Views • Local Culture • Historic Sites', NULL, 'destinations/2026/08/6f8b4091-8ee9-4e28-9bd2-b77ea672f198.png', 'destinations/2026/08/df3023a8-6cee-4996-afc9-2b203599dcc0.png', NULL, 1, 0, 1, '2026-07-31 06:34:50', '2026-08-17 09:01:55', NULL),
(4, '213f4579-cbf9-46df-afa5-4ac2a57bf5aa', 1, 3, 'Whistler & Sea-to-Sky Tour', 'whistler', 'Mountains • Waterfalls Scenic • Adventure', NULL, 'destinations/2026/08/bc0a5ba3-a0c8-478d-af5b-83631624b60e.jpg', 'destinations/2026/08/69d2cbca-593f-4a86-9503-e37f96176799.jpg', NULL, 0, 0, 1, '2026-07-31 06:34:50', '2026-08-17 09:00:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(80) NOT NULL DEFAULT 'general',
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'booking', 'When is the balance due?', 'The balance is due 7 days before departure unless the tour page says otherwise.', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(2, 'booking', 'Can I change my travel date?', 'Date changes are free up to 14 days before departure, subject to availability.', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(3, 'payment', 'Which cards do you accept?', 'All major credit and debit cards through Stripe, plus PayPal where enabled.', 0, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52'),
(4, 'visa', 'Do I need a visa for Canada?', 'Most visitors need an eTA or a visitor visa. Check the Visa Information page for details.', 0, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(160) NOT NULL,
  `discount_type` varchar(20) NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(12,2) NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_sale_tour`
--

CREATE TABLE `flash_sale_tour` (
  `flash_sale_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(160) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `destination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `caption` varchar(200) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_features`
--

CREATE TABLE `home_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(40) NOT NULL DEFAULT 'check',
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_features`
--

INSERT INTO `home_features` (`id`, `icon`, `image`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'check', 'home-features/2026/08/710faf90-097b-456d-9b9a-d70f5f8e8d8f.png', 'Small Group Experience', 'Travel in small groups for a more personal, relaxed, and enjoyable tour experience with dedicated attention from our local guides.', 1, 1, '2026-08-17 05:31:51', '2026-08-17 11:40:09'),
(3, 'check', 'home-features/2026/08/92554ab3-9f75-400a-b425-6e2b116afbd1.png', 'Private Custom Tours', 'Create a personalized British Columbia sightseeing itinerary tailored to your interests, schedule, and group size.', 2, 1, '2026-08-17 05:35:16', '2026-08-17 11:39:57'),
(4, 'check', 'home-features/2026/08/4dcf03aa-b210-4022-9443-f07c7248a4ae.png', 'Safe & Reliable', 'Travel with confidence through trusted guides, comfortable transportation, and reliable tour services.', 3, 1, '2026-08-17 05:36:24', '2026-08-17 11:39:33'),
(5, 'check', 'home-features/2026/08/99a93f75-72b6-4c80-9a7d-96324e5e619b.png', 'Cruise Passenger Excursions', 'Convenient sightseeing tours designed for cruise ship visitors arriving in Vancouver who want to maximize their time exploring British Columbia.', 4, 1, '2026-08-17 05:37:31', '2026-08-17 11:39:22'),
(6, 'check', 'home-features/2026/08/aa94ac17-4ede-4304-82ae-bc64ef70a102.png', 'Flexible Service', 'Ideal for families, visitors, cruise passengers, and corporate groups.', 5, 1, '2026-08-17 05:38:22', '2026-08-17 10:19:39'),
(7, 'check', 'home-features/2026/08/cfa9fc48-543a-4536-976b-926809eba3ff.png', 'Mercedes-Benz Sprinter transportation', 'Professional commercial driver with extensive BC experience', 6, 1, '2026-08-17 05:39:32', '2026-08-17 10:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `invoice_number` varchar(32) NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `issued_at` date NOT NULL,
  `due_at` date DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'CAD',
  `status` varchar(20) NOT NULL DEFAULT 'unpaid',
  `pdf_path` varchar(255) DEFAULT NULL,
  `billing_snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_snapshot`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `code` varchar(5) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `direction` varchar(3) NOT NULL DEFAULT 'ltr',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `flag`, `direction`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', NULL, 'ltr', 1, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(2, 'Français', 'fr', NULL, 'ltr', 0, 1, '2026-07-31 06:34:49', '2026-07-31 06:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `location` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Header Menu', 'header', '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(2, 'Footer Menu', 'footer', '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(3, 'Mega Menu', 'mega', '2026-07-31 06:34:51', '2026-07-31 06:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `label` varchar(160) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'custom',
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `target` varchar(12) NOT NULL DEFAULT '_self',
  `is_mega` tinyint(1) NOT NULL DEFAULT 0,
  `mega_column` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `label`, `type`, `target_id`, `url`, `icon`, `target`, `is_mega`, `mega_column`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Tours', 'custom', NULL, '/tours', NULL, '_self', 0, 1, 1, 1, '2026-07-31 06:34:50', '2026-07-31 06:34:50'),
(2, 1, NULL, 'Destinations', 'custom', NULL, '/destinations', NULL, '_self', 0, 1, 2, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(3, 1, NULL, 'Blog', 'blog', NULL, '/blog', NULL, '_self', 0, 1, 3, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(4, 1, NULL, 'Contact', 'page', NULL, '/page/contact', NULL, '_self', 0, 1, 4, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_01_000100_create_geo_tables', 1),
(5, '2025_01_01_000200_create_tour_categories_table', 1),
(6, '2025_01_01_000300_create_tours_table', 1),
(7, '2025_01_01_000400_create_tour_content_tables', 1),
(8, '2025_01_01_000500_create_promotion_tables', 1),
(9, '2025_01_01_000600_create_bookings_table', 1),
(10, '2025_01_01_000700_create_payment_tables', 1),
(11, '2025_01_01_000800_create_review_and_wishlist_tables', 1),
(12, '2025_01_01_000900_create_cms_tables', 1),
(13, '2025_01_01_001000_create_settings_and_localization_tables', 1),
(14, '2025_01_01_001100_create_support_ticket_tables', 1),
(15, '2025_01_01_001200_create_notifications_table', 1),
(16, '2026_07_31_115145_create_permission_tables', 1),
(17, '2026_08_14_000100_create_home_features_table', 2),
(18, '2026_08_17_000100_add_image_to_home_features', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 4),
(6, 'App\\Models\\User', 5),
(6, 'App\\Models\\User', 6),
(6, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 8),
(6, 'App\\Models\\User', 9),
(6, 'App\\Models\\User', 10),
(6, 'App\\Models\\User', 11),
(6, 'App\\Models\\User', 12),
(6, 'App\\Models\\User', 13),
(6, 'App\\Models\\User', 14),
(6, 'App\\Models\\User', 15),
(6, 'App\\Models\\User', 16),
(6, 'App\\Models\\User', 17),
(6, 'App\\Models\\User', 18),
(6, 'App\\Models\\User', 19),
(6, 'App\\Models\\User', 20),
(6, 'App\\Models\\User', 21),
(6, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 23),
(6, 'App\\Models\\User', 24),
(6, 'App\\Models\\User', 25),
(6, 'App\\Models\\User', 26),
(6, 'App\\Models\\User', 27),
(6, 'App\\Models\\User', 28),
(6, 'App\\Models\\User', 29);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `template` varchar(60) NOT NULL DEFAULT 'default',
  `content` longtext DEFAULT NULL,
  `sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sections`)),
  `banner` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `uuid`, `title`, `slug`, `template`, `content`, `sections`, `banner`, `is_system`, `show_in_footer`, `status`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ccdef8a3-075a-4f58-8dc1-0bcf301ef31a', 'About Us', 'about-us', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(2, '3b4ba2d8-81c0-48fc-8dcf-263498b511a9', 'Contact', 'contact', 'contact', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(3, '5943cb08-321c-44c7-9ec1-4459470dab9d', 'Privacy Policy', 'privacy-policy', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(4, '4aa6add4-e25c-4f67-a1f7-3a46a3ea1553', 'Terms & Conditions', 'terms-conditions', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(5, '47da5b74-8113-4f1a-8a4c-4b8a626edceb', 'Cancellation Policy', 'cancellation-policy', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(6, '3f30e937-c9bc-4082-90db-6d631df574a9', 'Visa Information', 'visa-information', 'visa', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(7, 'ab4cd12a-72c8-4bee-8805-d67fc76c672b', 'Travel Insurance', 'travel-insurance', 'insurance', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-07-31 06:34:50', '2026-07-31 06:34:50', NULL),
(8, 'c5303e06-bffc-4533-9f8a-0a545319801b', 'Security Policy', 'security-policy', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-08-14 02:43:32', '2026-08-14 02:43:32', NULL),
(9, 'f0873743-06f2-4f7a-9e82-969a67c8638a', 'Cookie Policy', 'cookie-policy', 'default', '<p>Replace this copy from Admin → CMS → Pages.</p>', NULL, NULL, 1, 1, 'published', NULL, '2026-08-14 02:43:33', '2026-08-14 02:43:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gateway` varchar(32) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'full',
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_reference` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `gateway_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'CAD',
  `exchange_rate` decimal(12,6) NOT NULL DEFAULT 1.000000,
  `status` varchar(20) NOT NULL DEFAULT 'initiated',
  `gateway_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_payload`)),
  `failure_reason` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gateway` varchar(32) NOT NULL,
  `event` varchar(80) NOT NULL,
  `direction` varchar(12) NOT NULL DEFAULT 'outgoing',
  `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_payload`)),
  `response_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_payload`)),
  `http_status` smallint(5) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'tour.view', 'web', '2026-07-31 06:34:41', '2026-07-31 06:34:41'),
(2, 'tour.create', 'web', '2026-07-31 06:34:41', '2026-07-31 06:34:41'),
(3, 'tour.update', 'web', '2026-07-31 06:34:41', '2026-07-31 06:34:41'),
(4, 'tour.delete', 'web', '2026-07-31 06:34:41', '2026-07-31 06:34:41'),
(5, 'tour.publish', 'web', '2026-07-31 06:34:41', '2026-07-31 06:34:41'),
(6, 'booking.view', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(7, 'booking.create', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(8, 'booking.update', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(9, 'booking.confirm', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(10, 'booking.cancel', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(11, 'booking.delete', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(12, 'payment.view', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(13, 'payment.record', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(14, 'payment.refund', 'web', '2026-07-31 06:34:42', '2026-07-31 06:34:42'),
(15, 'customer.view', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(16, 'customer.create', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(17, 'customer.update', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(18, 'customer.delete', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(19, 'user.view', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(20, 'user.create', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(21, 'user.update', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(22, 'user.delete', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(23, 'category.view', 'web', '2026-07-31 06:34:43', '2026-07-31 06:34:43'),
(24, 'category.create', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(25, 'category.update', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(26, 'category.delete', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(27, 'destination.view', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(28, 'destination.create', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(29, 'destination.update', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(30, 'destination.delete', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(31, 'coupon.view', 'web', '2026-07-31 06:34:44', '2026-07-31 06:34:44'),
(32, 'coupon.create', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(33, 'coupon.update', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(34, 'coupon.delete', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(35, 'review.view', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(36, 'review.approve', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(37, 'review.update', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(38, 'review.delete', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(39, 'cms.view', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(40, 'cms.create', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(41, 'cms.update', 'web', '2026-07-31 06:34:45', '2026-07-31 06:34:45'),
(42, 'cms.delete', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(43, 'report.view', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(44, 'report.export', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(45, 'setting.view', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(46, 'setting.update', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(47, 'ticket.view', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(48, 'ticket.reply', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(49, 'ticket.close', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `type` varchar(12) NOT NULL DEFAULT 'blog',
  `post_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `views_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `gateway_refund_id` varchar(255) DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_name` varchar(120) NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `rating_value` tinyint(3) UNSIGNED DEFAULT NULL,
  `rating_service` tinyint(3) UNSIGNED DEFAULT NULL,
  `rating_guide` tinyint(3) UNSIGNED DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `admin_reply` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(2, 'admin', 'web', '2026-07-31 06:34:46', '2026-07-31 06:34:46'),
(3, 'manager', 'web', '2026-07-31 06:34:47', '2026-07-31 06:34:47'),
(4, 'sales-executive', 'web', '2026-07-31 06:34:47', '2026-07-31 06:34:47'),
(5, 'tour-operator', 'web', '2026-07-31 06:34:47', '2026-07-31 06:34:47'),
(6, 'customer', 'web', '2026-07-31 06:34:47', '2026-07-31 06:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(47, 2),
(48, 2),
(49, 2),
(1, 3),
(2, 3),
(3, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(15, 3),
(17, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(47, 3),
(48, 3),
(49, 3),
(1, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(12, 4),
(13, 4),
(15, 4),
(16, 4),
(17, 4),
(31, 4),
(43, 4),
(47, 4),
(48, 4),
(1, 5),
(2, 5),
(3, 5),
(6, 5),
(8, 5),
(23, 5),
(27, 5),
(35, 5);

-- --------------------------------------------------------

--
-- Table structure for table `seo_meta`
--

CREATE TABLE `seo_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seoable_type` varchar(255) NOT NULL,
  `seoable_id` bigint(20) UNSIGNED NOT NULL,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` varchar(300) DEFAULT NULL,
  `meta_keywords` varchar(300) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` varchar(300) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `twitter_card` varchar(40) NOT NULL DEFAULT 'summary_large_image',
  `schema_markup` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schema_markup`)),
  `robots` varchar(60) NOT NULL DEFAULT 'index,follow',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_meta`
--

INSERT INTO `seo_meta` (`id`, `seoable_type`, `seoable_id`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `og_title`, `og_description`, `og_image`, `twitter_card`, `schema_markup`, `robots`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Tour', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', NULL, 'index,follow', '2026-08-17 06:26:13', '2026-08-17 06:26:13'),
(2, 'App\\Models\\Tour', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', NULL, 'index,follow', '2026-08-17 06:54:38', '2026-08-17 06:54:38'),
(3, 'App\\Models\\Tour', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', NULL, 'index,follow', '2026-08-17 06:58:35', '2026-08-17 06:58:35'),
(4, 'App\\Models\\Tour', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', NULL, 'index,follow', '2026-08-17 16:08:17', '2026-08-17 16:08:17'),
(5, 'App\\Models\\Tour', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'summary_large_image', NULL, 'index,follow', '2026-08-17 16:17:29', '2026-08-17 16:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('16gZqW1FNd5zgRu6bcSmZ8YzxOEv3tzrKYBhOXlz', NULL, '2a09:bac5:3ada:16b4::243:95', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVVsb3pzdVpaMFJ3UlNidmxBd2s4Y1l0ZjlBSnZkMHVNRm5wTXFqVyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS90b3VycyI7czo1OiJyb3V0ZSI7czoxMToidG91cnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1787003952),
('1JDFBhvBpn5UHnigzEvNiVaiQbJV3Ao17sQMckKH', NULL, '2a02:4780:40:c0de::2a', 'Go-http-client/2.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHRseUFmRUl4bk14MDhEUTJpTmR0OHhWSE5yNjFLQ2prWXJoeW13TSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787024059),
('1kzFQIVceKh2a20ETtFtMjmVP0q7hxPcRKTUOvzp', NULL, '2001:569:6fb3:57bf:5a4:82ba:cbd4:8140', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibVE4d0p3R3VJTEthZ1ZYbkNZd3lQcGlxbjA3SjlJczUzR2pHWjN3WSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjY5OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS90b3Vycy92aWN0b3JpYS1idXRjaGFydC1nYXJkZW5zLXRvdXIiO3M6NToicm91dGUiO3M6MTA6InRvdXJzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1787005424),
('5kKOhkJ8ZfbISZmhGCwFV0CzcyErBpQqB44eRMgz', NULL, '199.250.251.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmRwbWxXTWVQZ2dFWDBuMHRuSnRKdmtEcUNoVmhOemRoSlNuUzdHZyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787003924),
('5oJtTuYzzARgeLOuOkj7Msos23O06HIcdSmttRcX', NULL, '2401:4900:8828:fecd:60dd:1952:faab:f65b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUU1oVEN2RkdRUGg2cGwyVU1ycWx5WjgzMHBjMDB0MjdkbVhKRkh2QSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786988278),
('Dk4ICy0nLtw4YClHL3MMAyAmJByeHcBMHvs5xsb6', NULL, '45.250.244.140', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidjZEdWN0cXNpbHoyM21QNzZqYkpYVEN2b1hvSmhLSWFzNDlWUGJ4NSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS9ibG9nIjtzOjU6InJvdXRlIjtzOjEwOiJibG9nLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786984212),
('F7E5EsQVIEHFSSgf80eqhdIo1yOzEuU1tkwmRIBO', NULL, '42.105.193.169', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNjRjRWxVY1Q3ZERkUE81OUxNaFQxNExqNWloQUhNSWFZejVWYVZxQSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS9kZXN0aW5hdGlvbnMiO3M6NToicm91dGUiO3M6MTg6ImRlc3RpbmF0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1786984195),
('INQR4uTGSsrfX8wrItXENvYOQ1CCJjKeHX91Uo3F', NULL, '45.250.244.140', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSTUyN0sxWVZjbWNZQzdUclNHYk5HdU9sRUZBWU9obE5wZ3Nncmd2NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1786989919),
('IxUUvCYBGwrhDWIhvZSXt7UjryQRTNfHxUYY8xtS', 1, '2409:4091:33:8a11:fcac:b61d:395c:6fef', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSWRuQXNXa0ZGN1o1cjZHWnBub3hyMzdobUpmZHl6aFp6MjlxVWFqbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ0OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS9hZG1pbi90b3VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udG91cnMuaW5kZXgiO31zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1786985663),
('mlHy9088aRAuEYjQfjVbXRrfBZiHsJXDgykvYbuR', NULL, '42.105.193.169', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWHJNRVMzdEhhTXN3R3NvYzhtSzczNnZKb1RsMTlsWUNyOFRaR05ZSCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbS9kZXN0aW5hdGlvbnMiO3M6NToicm91dGUiO3M6MTg6ImRlc3RpbmF0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1786984195),
('Mts2A5xIOg6pjrFUfcTHFVHj7TeHTelSbv96Qpl8', NULL, '208.54.146.69', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWR2cXhYc1VvNjRlVTlLUE11cXg1U0czSnFXb3BZZnBBeURpV1RlUCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787003949),
('Ni0wO85vSXh9uvjcUgp4sBRgdb5XUK7s8A9pOEJs', NULL, '2401:4900:8828:fecd:8089:2c2c:3b40:c5d7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVRmWjhMcDFHNVhoZmxEQUdhNUFKOVpNZE1hckdmVWhLVEpwOFpseiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786987775),
('rquS1CUpC1hwHQnKPSHLAOR6yK7sDwHlADzWmR7Y', NULL, '2a09:bac5:3ada:16b4::243:95', 'WhatsApp/2.2631.102 W', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmZLM0gwWXIwWWZvaVF5cW5MTmFRSmpxVlJydXRIb3hwMXE1eDcwdSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787004014),
('skXGabbopiG8PRA4rtsXitcLhPYnxAZvN9fNBW4J', NULL, '2409:4091:33:8a11:4dde:798e:d4c9:e7fb', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2tjOG01UDNvbFk3eG03dTF6bzEweHV4OFliY0tnb1RJNjlqTlU4YiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786987694),
('ZCmRDoMnJd4hd2RfOG8nPuLbekdfJkybjzodHxfl', NULL, '2409:4091:33:8a11:4dde:798e:d4c9:e7fb', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkw4SW0wQWdUVVZVQnlRUjFwS0dVRmdHZnUzNlFVMVRwTVFsbDZlNiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL3BhY2lmaWN0b3Vycy50cml2aWlvLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786987694);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group` varchar(40) NOT NULL DEFAULT 'general',
  `key` varchar(120) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'string',
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `key`, `value`, `type`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'general', 'company_name', 'Pacific Tours Canada', 'string', 0, '2026-07-31 06:34:48', '2026-07-31 06:34:48'),
(2, 'general', 'company_email', 'info@pacifictours.ca', 'string', 0, '2026-07-31 06:34:48', '2026-07-31 06:34:48'),
(3, 'general', 'company_phone', '+1 604 000 0000', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(4, 'general', 'company_address', 'Vancouver, British Columbia, Canada', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(5, 'general', 'invoice_due_days', '7', 'int', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(6, 'general', 'unpaid_booking_ttl_hours', '48', 'int', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(7, 'theme', 'currency', 'CAD', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(8, 'theme', 'timezone', 'America/Vancouver', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(9, 'theme', 'language', 'en', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(10, 'payment', 'stripe_enabled', '1', 'bool', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(11, 'payment', 'paypal_enabled', '0', 'bool', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(12, 'social', 'facebook', 'https://facebook.com/pacifictours', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(13, 'social', 'instagram', 'https://instagram.com/pacifictours', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(14, 'social', 'tripadvisor', '', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(15, 'seo', 'meta_title', 'Pacific Tours Canada · Guided tours across British Columbia and beyond', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(16, 'seo', 'meta_description', 'Small-group and private guided tours departing from Vancouver, Victoria and Whistler.', 'string', 0, '2026-07-31 06:34:49', '2026-07-31 06:34:49'),
(17, 'home', 'hero_title_lead', 'never say never alone', 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:17:37'),
(18, 'home', 'hero_title_accent', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(19, 'home', 'hero_title_trail', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(20, 'home', 'hero_subtitle', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(21, 'home', 'hero_cta_label', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(22, 'home', 'hero_bg', 'branding/2026/08/e0811ed9-a65d-4b9d-8163-db85785c59cf.jpg', 'file', 0, '2026-08-15 06:13:11', '2026-08-17 05:53:28'),
(23, 'home', 'section_title', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(24, 'home', 'destinations_heading', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(25, 'home', 'destinations_intro', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(26, 'home', 'featured_heading', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(27, 'home', 'featured_intro', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(28, 'home', 'why_heading', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(29, 'home', 'why_intro', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(30, 'home', 'testimonials_heading', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(31, 'home', 'testimonials_intro', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(32, 'home', 'fleet_heading', 'Professional commercial driver with extensive BC experience -  Comfortable Mercedes-Benz Sprinter transportation', 'string', 0, '2026-08-15 06:13:11', '2026-08-17 15:06:50'),
(33, 'home', 'contact_heading', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(34, 'home', 'contact_intro', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(35, 'home', 'map_embed_url', NULL, 'string', 0, '2026-08-15 06:13:11', '2026-08-15 06:13:11'),
(36, 'home', 'fleet_features', '[\"High Roof Design\",\"Air Conditioning\",\"Comfortable Seating\",\"Large Windows\",\"Panoramic Views\",\"Luggage Capacity\",\"Professional Maintenance\",\"Modern Safety Features\"]', 'json', 0, '2026-08-15 06:13:11', '2026-08-17 15:56:22'),
(37, 'home', 'fleet_bg', 'branding/2026/08/e1841453-5409-4895-b710-05f93fd98fc9.png', 'file', 0, '2026-08-17 15:05:15', '2026-08-17 15:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(160) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'tour',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `designation` varchar(160) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `avatar`, `rating`, `content`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kamren Kovacek', 'Life Science Technician', 'testimonials/2026/08/f4a0c015-5f33-4138-aea2-d3304e9b09a7.jpg', 5, 'Qui enim illo dolorem praesentium harum doloribus ea. Quo iste occaecati dolorem molestias neque. Occaecati et magnam voluptas eum illum quidem laborum.', 1, 1, '2026-07-31 06:35:24', '2026-08-17 15:03:03'),
(3, 'Edwardo Wisozk DVM', 'Psychology Teacher', 'testimonials/2026/08/a6b19fca-e090-46b8-9c48-9d4c58e3e349.jpg', 4, 'Natus nemo corrupti ab ullam. Reprehenderit voluptatum eligendi eaque veritatis magni dolorem. Sunt alias est itaque in distinctio qui.', 3, 1, '2026-07-31 06:35:24', '2026-08-17 15:02:31'),
(4, 'Prof. Viola Hills', 'Supervisor Fire Fighting Worker', 'testimonials/2026/08/a4746b27-8699-4627-b24f-3437d9953e38.png', 5, 'Commodi nostrum qui reiciendis saepe quos suscipit. Ut voluptatem cumque fugiat laborum ab. Rerum numquam nihil et quam. Laborum adipisci aut unde rem repellendus sed est.', 4, 1, '2026-07-31 06:35:24', '2026-08-17 15:02:09'),
(5, 'Prof. Savion Kiehn', 'Ship Pilot', 'testimonials/2026/08/b5016c86-a880-40f7-a201-1504f793336c.png', 4, 'Quia sunt ad error. Veritatis saepe sit aliquid labore quis illum dignissimos. Quisquam ut at odio non illum minima. Praesentium et in et quod ut rerum.', 5, 1, '2026-07-31 06:35:24', '2026-08-17 15:01:54'),
(6, 'Reina Bergstrom', 'Freight and Material Mover', 'testimonials/2026/08/bf863525-c834-47c8-a2b7-d27e8b972289.png', 5, 'Necessitatibus dolore beatae sequi cumque omnis facere et. Soluta sit inventore voluptatem qui sunt in. Earum et facere distinctio maxime.', 6, 1, '2026-07-31 06:35:24', '2026-08-17 15:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `ticket_number` varchar(24) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(220) NOT NULL,
  `department` varchar(60) NOT NULL DEFAULT 'general',
  `priority` varchar(20) NOT NULL DEFAULT 'medium',
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `last_reply_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_message_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `original_name` varchar(200) NOT NULL,
  `mime_type` varchar(120) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_staff_reply` tinyint(1) NOT NULL DEFAULT 0,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `tour_category_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `summary` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `travel_information` longtext DEFAULT NULL,
  `terms_and_conditions` longtext DEFAULT NULL,
  `cancellation_policy` longtext DEFAULT NULL,
  `visa_requirements` longtext DEFAULT NULL,
  `duration_days` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `duration_nights` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `tour_type` varchar(40) NOT NULL DEFAULT 'group',
  `difficulty` varchar(20) NOT NULL DEFAULT 'easy',
  `pickup_location` varchar(255) DEFAULT NULL,
  `drop_location` varchar(255) DEFAULT NULL,
  `meeting_point` varchar(255) DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `child_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `infant_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(20) NOT NULL DEFAULT 'none',
  `discount_value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `service_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deposit_type` varchar(20) NOT NULL DEFAULT 'disabled',
  `deposit_value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'CAD',
  `max_seats` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `min_booking` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `max_booking` int(10) UNSIGNED NOT NULL DEFAULT 20,
  `booking_cutoff_hours` smallint(5) UNSIGNED NOT NULL DEFAULT 48,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `map_latitude` decimal(10,7) DEFAULT NULL,
  `map_longitude` decimal(10,7) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_recommended` tinyint(1) NOT NULL DEFAULT 0,
  `average_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `reviews_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `bookings_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `views_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `uuid`, `code`, `title`, `slug`, `tour_category_id`, `destination_id`, `country_id`, `city_id`, `summary`, `description`, `travel_information`, `terms_and_conditions`, `cancellation_policy`, `visa_requirements`, `duration_days`, `duration_nights`, `tour_type`, `difficulty`, `pickup_location`, `drop_location`, `meeting_point`, `base_price`, `child_price`, `infant_price`, `discount_type`, `discount_value`, `sale_price`, `tax_percentage`, `service_fee`, `deposit_type`, `deposit_value`, `currency`, `max_seats`, `min_booking`, `max_booking`, `booking_cutoff_hours`, `thumbnail`, `banner`, `video_url`, `map_latitude`, `map_longitude`, `status`, `is_featured`, `is_popular`, `is_recommended`, `average_rating`, `reviews_count`, `bookings_count`, `views_count`, `published_at`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'd421d26e-0cce-4dcd-add3-062fc9a110f8', 'PT-T-661640', 'Molestiae Sed Nostrum Tour', 'molestiae-sed-nostrum-tour-12973', 5, 3, NULL, NULL, 'Id et officiis non maiores unde voluptate enim qui nam quidem accusamus velit.', 'Molestiae et corporis est laborum vel molestiae. Magnam autem velit illo ad animi nesciunt. Minus asperiores in odit qui eos eaque.\n\nQui ab sit laborum aut mollitia eligendi dolorem velit. Ex totam minus et deserunt voluptatem consequatur qui. Aut quas delectus minima enim velit qui voluptates officia. Ut officiis explicabo aut voluptatibus tempora qui qui.\n\nEum ipsa velit nesciunt molestiae est. Aut sapiente sunt earum laborum et. Et suscipit tenetur voluptatem itaque distinctio.\n\nTenetur id laudantium ea illum. Magnam perferendis laudantium quaerat dignissimos qui adipisci et nihil. Perferendis praesentium illo tempore sit velit.', NULL, NULL, NULL, NULL, 8, 7, 'group', 'easy', NULL, NULL, NULL, 3187.28, 2231.10, 0.00, 'none', 0.00, 3187.28, 5.00, 0.00, 'percentage', 25.00, 'CAD', 40, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:11', '2026-08-17 07:00:59', '2026-08-17 07:00:59'),
(2, '11483456-5e51-4b49-8a12-4bd8317a9f7a', 'PT-T-897284', 'Vancouver & North Shore Scenie Tour', 'ex-repellendus-et-tour-87834', 7, 1, NULL, NULL, 'Mountains • Ocean • Suspension Bridges\r\n\r\nExperience the stunning beauty of Vancouver’s North Shore featuring coastal mountains, forests, scenic viewpoints, and famous attractions.\r\n\r\nA perfect mix of nature and city sightseeing.', NULL, NULL, NULL, NULL, NULL, 6, 5, 'group', 'easy', NULL, NULL, NULL, 150.00, 75.00, 0.00, 'none', 0.00, 150.00, 5.00, 0.00, 'percentage', 25.00, 'CAD', 17, 1, 12, 48, 'tours/2026/08/27a491ef-d6d5-4a25-a381-b836c2789372.jpg', 'tours/2026/08/694a0fdb-7f79-460c-a0d7-16972b91465f.jpg', NULL, NULL, NULL, 'published', 1, 1, 0, 0.00, 0, 0, 1, '2026-07-31 06:35:11', NULL, 1, '2026-07-31 06:35:12', '2026-08-17 06:54:38', NULL),
(3, '0fe0e6af-ead6-4e78-8676-a3da76975988', 'PT-T-655488', 'Assumenda Quidem Exercitationem Tour', 'assumenda-quidem-exercitationem-tour-27412', 7, 3, NULL, NULL, 'Eos qui facilis distinctio fugiat iste qui ut soluta nesciunt ut.', 'Iste itaque voluptatibus quod quibusdam modi. Et atque enim natus et quaerat quis. Deserunt eligendi reprehenderit aut et aut et facilis.\n\nPorro sit in velit eaque. Corrupti quasi cumque alias placeat consequatur. Maiores error distinctio maiores ad soluta quasi omnis.\n\nAsperiores enim et non iure quas et sit. Blanditiis perferendis sit aut asperiores. Hic error tempore voluptatem. Earum magni maxime ratione aut quae voluptate corrupti.\n\nFugit voluptates temporibus est. Deserunt perferendis tempora quaerat assumenda. Numquam debitis voluptatem harum neque. Eligendi sint totam est atque sed quia.', NULL, NULL, NULL, NULL, 1, 0, 'group', 'easy', NULL, NULL, NULL, 1900.15, 1330.11, 0.00, 'none', 0.00, 1900.15, 5.00, 0.00, 'percentage', 25.00, 'CAD', 18, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 07:00:59', '2026-08-17 07:00:59'),
(4, '5da525d6-393e-445e-8723-e92e9daf5d8b', 'PT-T-672773', 'Eligendi Sed Et Tour', 'eligendi-sed-et-tour-77358', 1, 3, NULL, NULL, 'Quia ut et quia eaque delectus natus et quo voluptas distinctio repudiandae quas consequatur dolorem.', 'Fugiat reiciendis id deserunt dolores aut. Placeat dicta commodi ut voluptas fugit. Qui voluptatem sit quia voluptatem sed fugiat omnis. Minus sapiente saepe voluptates et earum.\n\nMinima neque reprehenderit esse eos. Nulla possimus voluptates inventore eaque a facere vel sit. Ducimus ex perferendis quo saepe.\n\nFacilis et veritatis est alias voluptatum mollitia placeat. Nihil fugit aut dolor ipsam consequatur exercitationem corrupti ut. Qui quod et quia distinctio. Reprehenderit libero laboriosam explicabo id nisi neque quasi atque.\n\nSed eveniet nihil tempora quas fugit iste asperiores. Quia reiciendis necessitatibus aut vel. Eligendi minima occaecati est. Ab dolore in aliquid aut.', NULL, NULL, NULL, NULL, 2, 1, 'group', 'easy', NULL, NULL, NULL, 2659.79, 1861.85, 0.00, 'none', 0.00, 2659.79, 5.00, 0.00, 'percentage', 25.00, 'CAD', 9, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 07:00:59', '2026-08-17 07:00:59'),
(5, '2246fe3b-0954-4f6b-b2e1-18198871edfc', 'PT-T-536024', 'Lower Mainland Village Tour', 'lower-mainland-village-tour', 1, NULL, NULL, NULL, 'Sed quo necessitatibus nostrum quisquam earum beatae in aspernatur amet aut aspernatur doloribus dolorum id deserunt dolor ut quaerat dolorem.', NULL, NULL, NULL, NULL, NULL, 5, 4, 'group', 'easy', NULL, NULL, NULL, 220.00, 110.00, 0.00, 'none', 0.00, 220.00, 5.00, 0.00, 'percentage', 25.00, 'CAD', 39, 1, 12, 48, 'tours/2026/08/02ef7b0b-d490-4b83-b261-d7cbe05d5235.png', 'tours/2026/08/080d7d8b-e25b-4ac3-abd5-75413a2ecc45.png', NULL, NULL, NULL, 'published', 1, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, 1, '2026-07-31 06:35:12', '2026-08-17 06:59:59', NULL),
(6, 'fcfd69d4-69eb-4bb1-8a41-7af5381480b6', 'PT-T-867952', 'Expedita Omnis Provident Tour', 'expedita-omnis-provident-tour-6425', 3, 4, NULL, NULL, 'Cupiditate vel omnis consequatur illo explicabo natus necessitatibus quia sunt qui minima nemo voluptatem consequatur.', 'Similique omnis ad blanditiis officiis hic. Consequatur enim error assumenda. Eum consequatur omnis non debitis. Possimus eos aliquid harum est eaque.\n\nNumquam nemo quas et. Dolor sed ut officiis in atque. Consequatur cum ut eius sunt. Excepturi in qui blanditiis quidem est explicabo quo illo.\n\nEos ullam harum ut perspiciatis quis et in. Nobis laboriosam rem explicabo ipsam. Quod repellat et maiores ea iusto explicabo voluptas. Dignissimos ut quibusdam inventore.\n\nEst consequatur quo atque in dignissimos. Corrupti fugit ut possimus similique reiciendis quia. Similique omnis veritatis alias nihil et minima aut. Et tempore vitae qui est.', NULL, NULL, NULL, NULL, 4, 3, 'group', 'easy', NULL, NULL, NULL, 1087.36, 761.15, 0.00, 'none', 0.00, 1087.36, 5.00, 0.00, 'percentage', 25.00, 'CAD', 31, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 07:00:59', '2026-08-17 07:00:59'),
(7, '751023fb-8bb3-4de6-b891-53c406297642', 'PT-T-361579', 'Et Vero Sint Tour', 'et-vero-sint-tour-12864', 1, 1, NULL, NULL, 'Cum exercitationem velit est est accusamus reprehenderit ducimus id corporis ipsum quia enim vero ipsa.', 'Consectetur eaque sunt cum magnam blanditiis quia. Aperiam in ullam modi dolore sit. Nisi voluptatum dolore rerum corrupti cupiditate. Quasi voluptatem sit et soluta molestias corporis.\n\nVoluptate dolorem quod corrupti quia nam animi. Laudantium culpa illo velit dolorem autem eos quis. Occaecati impedit quia occaecati quas dolorem. Saepe pariatur maxime quia rerum minus maiores.\n\nBlanditiis deleniti nobis dolores velit dolor non non et. Deserunt nesciunt recusandae velit iure. Rerum eius iusto dolores odio quam quam earum aut. Saepe nemo repellendus veritatis dolores eveniet.\n\nPariatur ducimus ut sit suscipit. Voluptatem earum distinctio et et.', NULL, NULL, NULL, NULL, 7, 6, 'group', 'easy', NULL, NULL, NULL, 1873.21, 1311.25, 0.00, 'none', 0.00, 1873.21, 5.00, 0.00, 'percentage', 25.00, 'CAD', 27, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 1, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 07:00:59', '2026-08-17 07:00:59'),
(8, '45be0bcb-0af2-4c24-8262-912c47289372', 'PT-T-758997', 'Neque Nihil Et Tour', 'neque-nihil-et-tour-14297', 6, 2, NULL, NULL, 'Aut tempora fuga sed necessitatibus et est doloremque alias facilis ut laboriosam consequuntur omnis expedita vero.', 'Corrupti sed magnam non perspiciatis rerum quo. Ut animi omnis ipsa. Sunt sint saepe eum ea molestiae.\n\nAccusantium ut qui nobis aut et fugiat natus aliquid. Voluptatem necessitatibus repellat iste aspernatur. Provident numquam aut nemo consequatur est molestias animi. Molestiae dolores ipsam molestiae quia at.\n\nSed suscipit vitae blanditiis libero non sit omnis. Amet sunt fuga velit vel eos. Consequatur eveniet nemo veniam enim.\n\nCum sed animi perspiciatis accusantium velit. Repellendus velit aliquam ullam autem et deleniti. Aut culpa id omnis. Veritatis quo consequatur ullam qui.', NULL, NULL, NULL, NULL, 1, 0, 'group', 'easy', NULL, NULL, NULL, 1971.28, 1379.90, 0.00, 'none', 0.00, 1971.28, 5.00, 0.00, 'percentage', 25.00, 'CAD', 25, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(9, 'a8852f30-e42a-45a2-b0fa-98bd2173e665', 'PT-T-954894', 'Eum Velit Voluptatibus Tour', 'eum-velit-voluptatibus-tour-4147', 4, 3, NULL, NULL, 'Vel aut quod quam aperiam ut numquam vel aut quo eum neque doloremque id dolor ea excepturi distinctio repellat illum.', 'Non quo voluptatem quo rerum magnam veritatis occaecati. Perferendis pariatur expedita voluptas odit et omnis nobis. Voluptatem numquam assumenda harum sit ea nesciunt.\n\nIste fugiat pariatur natus magni iste omnis unde atque. Reiciendis soluta et omnis debitis. Officia rerum aut nihil hic impedit.\n\nEos mollitia totam perferendis repudiandae nostrum ut. Voluptas dolores aut sint eaque architecto qui. Mollitia sed ut totam ut deserunt voluptates iure.\n\nAd sapiente laborum numquam quia ut debitis quas. Similique sit doloribus ratione odit natus. At nulla qui qui. Vero dolores repudiandae est laudantium eveniet quisquam non.', NULL, NULL, NULL, NULL, 1, 0, 'group', 'easy', NULL, NULL, NULL, 1032.20, 722.54, 0.00, 'none', 0.00, 1032.20, 5.00, 0.00, 'percentage', 25.00, 'CAD', 8, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 1, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(10, '46a19300-deb8-40e4-9fd7-1d86af57a33f', 'PT-T-274586', 'Aut Ut Sed Tour', 'aut-ut-sed-tour-16882', 6, 4, NULL, NULL, 'Laudantium quo quas consectetur voluptatem omnis incidunt exercitationem velit neque est facere.', 'Totam cum et perferendis dignissimos sit. Animi eveniet id sint placeat. Tenetur similique sit numquam fugiat et. Molestiae illum sit est dolores consectetur at vel. Sequi rerum dolorem commodi.\n\nEst exercitationem dolorem ut nisi. Consequatur accusantium ipsa quia quos. Ipsa corrupti ad est quia qui rem.\n\nSequi ipsa eum omnis et deserunt ut voluptatem. Nihil in sint inventore exercitationem magni delectus laboriosam velit. Hic velit veniam quia atque corrupti voluptas voluptate.\n\nRerum aliquam repellat impedit quia. Quos autem ut est sint itaque.', NULL, NULL, NULL, NULL, 4, 3, 'group', 'easy', NULL, NULL, NULL, 215.47, 150.83, 0.00, 'none', 0.00, 215.47, 5.00, 0.00, 'percentage', 25.00, 'CAD', 16, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:12', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(11, '1f386e61-7e95-452e-93ce-3e0d0e3c37d7', 'PT-T-317079', 'Sequi Culpa Id Tour', 'sequi-culpa-id-tour-48631', 2, 3, NULL, NULL, 'Voluptatibus voluptatem unde veritatis quo voluptas delectus voluptas nam.', 'Quo omnis quasi laudantium sed nihil. Sed consectetur ipsam dolorum nam nam. Cumque voluptatibus alias nihil. Aliquam non sit iste tempore sed.\n\nIn earum repellendus neque porro. Ut nemo minus quo aut aut consequatur. Autem tenetur iste veritatis qui.\n\nEsse doloremque ut id velit mollitia. Officia itaque nulla voluptatem illo nulla natus temporibus sint. Fugit quidem quae iure. Facere inventore molestias autem.\n\nBlanditiis dolores vero illum mollitia nemo. Beatae nisi dolore aliquam molestias. Est officia fuga quasi necessitatibus dolore a aut ut. Iusto distinctio quia dolore dolores non accusantium.', NULL, NULL, NULL, NULL, 7, 6, 'group', 'easy', NULL, NULL, NULL, 2415.51, 1690.86, 0.00, 'none', 0.00, 2415.51, 5.00, 0.00, 'percentage', 25.00, 'CAD', 38, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 0, 0, 0.00, 0, 0, 8, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(12, '044ea6ce-582c-49be-9d0e-945b805c2007', 'PT-T-388230', 'Velit Voluptatem Voluptas Tour', 'velit-voluptatem-voluptas-tour-63134', 5, 3, NULL, NULL, 'Nam dicta ut sunt necessitatibus vero repudiandae iusto ut cum aut occaecati laborum corrupti quia.', 'Id odit quidem vero aut. Assumenda maiores ipsum totam delectus numquam possimus. Omnis tenetur enim explicabo accusamus est rerum ea. Tempore facilis rerum molestiae. Hic amet nemo sequi est voluptas.\n\nAdipisci velit cupiditate eaque. Occaecati in suscipit omnis tempore. Sequi harum saepe qui excepturi sunt culpa.\n\nVero mollitia eligendi possimus optio. Id autem sit reiciendis amet. Ea sit dolores qui fugiat. Aut iusto in id odio id.\n\nDolorem repudiandae dignissimos non eum omnis ab sunt quo. Ducimus ullam modi a fugit. Maxime eum itaque vel itaque numquam. Sequi ratione tenetur ratione numquam.', NULL, NULL, NULL, NULL, 3, 2, 'group', 'easy', NULL, NULL, NULL, 1221.72, 855.20, 0.00, 'none', 0.00, 1221.72, 5.00, 0.00, 'percentage', 25.00, 'CAD', 12, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(13, 'ba59abc2-a3e1-4d24-91a3-37a6da351291', 'PT-T-181562', 'Possimus Corrupti Consectetur Tour', 'possimus-corrupti-consectetur-tour-72936', 6, 2, NULL, NULL, 'Eius aliquid id laborum ut beatae dolorem qui sunt nihil aut omnis excepturi nobis porro officia adipisci in voluptatem id.', 'Molestiae est ea aut fuga itaque. Sed in reiciendis adipisci et. Eaque id dolorum voluptatem. Ipsa ut perferendis et dolorem rerum.\n\nPossimus qui sit accusamus quia. Quas voluptatem ducimus officiis possimus totam. Atque quis provident molestiae dolor quia provident sed.\n\nMollitia in sit dolorum. Sunt sed a mollitia error placeat nostrum temporibus. Quia aut sunt qui eos sit non omnis. Sed mollitia velit modi nesciunt aliquid doloremque.\n\nNatus atque minima animi. Ut voluptatem harum voluptatibus doloribus. Sint illo quia consequatur reiciendis quisquam et nihil tenetur.', NULL, NULL, NULL, NULL, 10, 9, 'group', 'easy', NULL, NULL, NULL, 2717.64, 1902.35, 0.00, 'none', 0.00, 2717.64, 5.00, 0.00, 'percentage', 25.00, 'CAD', 34, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 1, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(14, '3667ddb6-f51b-4795-894f-813053a0dd45', 'PT-T-526623', 'Vitae Fugit Ipsum Tour', 'vitae-fugit-ipsum-tour-41033', 1, 2, NULL, NULL, 'Repudiandae saepe eius id eum eius odit adipisci molestiae tempore doloremque fugit earum veritatis quisquam nesciunt id aut ratione.', 'Quisquam totam aliquid dolore et voluptatem non omnis. Quaerat fugiat vel ut voluptas ipsa. Suscipit blanditiis numquam amet qui itaque omnis.\n\nRepellendus natus aperiam odit officia animi assumenda omnis. Quisquam optio sit dolores accusamus eius aliquid. Minima debitis minus sint ad beatae et. Autem incidunt mollitia cupiditate tempore vel quis.\n\nEaque ut tempore corrupti laboriosam eum debitis quia. A repudiandae eaque maxime quia aut non et. Molestias laborum voluptas necessitatibus quo.\n\nQui aut cupiditate autem magni consectetur vero dolorem. Molestiae expedita ut nisi sit rerum rerum quaerat. Alias ducimus impedit tenetur non qui perferendis.', NULL, NULL, NULL, NULL, 8, 7, 'group', 'easy', NULL, NULL, NULL, 710.79, 497.55, 0.00, 'none', 0.00, 710.79, 5.00, 0.00, 'percentage', 25.00, 'CAD', 21, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(15, 'ca3116e9-b9bf-4036-961c-9d7eeca0af5b', 'PT-T-914938', 'Dolorum Dicta Ratione Tour', 'dolorum-dicta-ratione-tour-85010', 2, 3, NULL, NULL, 'Distinctio omnis distinctio pariatur vel molestiae ut voluptatem architecto autem aut vitae qui ut sint fugiat illum magni excepturi voluptas.', 'Et velit hic at veniam rerum beatae et. Itaque culpa odio id delectus eveniet ipsam sed dolores. Dolore accusantium voluptatem possimus.\n\nIllo eum consequatur iste sint laboriosam odio ut. Aut non ut sunt sequi aliquid et. Rerum ullam alias non sed repellat.\n\nUt et in praesentium rem numquam voluptatum rem et. Quod pariatur in quasi molestiae. Et ut pariatur porro. Amet voluptatem voluptate blanditiis et et alias.\n\nUllam omnis earum ipsa qui praesentium minus ut. Culpa eum sed vel corporis. Qui officiis reprehenderit occaecati aut repellendus id ipsa.', NULL, NULL, NULL, NULL, 7, 6, 'group', 'easy', NULL, NULL, NULL, 1314.30, 920.01, 0.00, 'none', 0.00, 1314.30, 5.00, 0.00, 'percentage', 25.00, 'CAD', 34, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 1, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(16, '4751ca43-8abe-4ea7-9e1a-d9debca79c0c', 'PT-T-403370', 'Qui Nihil Aspernatur Tour', 'qui-nihil-aspernatur-tour-22071', 7, 4, NULL, NULL, 'Aperiam repellendus molestiae fugit sit qui occaecati maiores beatae explicabo sequi qui facilis reprehenderit velit.', 'Minima velit distinctio porro quo dolore provident quam. Aut sint excepturi aut rerum debitis corporis. Eum omnis alias modi et recusandae. Ut repellendus animi porro iure odit unde consequatur. Quasi saepe quibusdam sint.\n\nUt ex ea ullam placeat ut. Impedit molestiae sed illo sunt. Vitae saepe quia porro omnis. Optio quos est deleniti error qui ut exercitationem.\n\nRepellendus in suscipit quia vero. Recusandae commodi pariatur vitae culpa fugiat odio. Ducimus dicta vel eum voluptatem. In in nisi rem minima.\n\nNesciunt cum non autem sed vero quis eveniet. Omnis alias omnis sunt. Ipsa assumenda qui aspernatur nulla sunt. Sit non tenetur inventore et alias.', NULL, NULL, NULL, NULL, 8, 7, 'group', 'easy', NULL, NULL, NULL, 1788.07, 1251.65, 0.00, 'none', 0.00, 1788.07, 5.00, 0.00, 'percentage', 25.00, 'CAD', 38, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(17, 'f81426de-bcf9-4f03-a789-d328d4835c80', 'PT-T-856739', 'Fuga A Delectus Tour', 'fuga-a-delectus-tour-69398', 7, 2, NULL, NULL, 'Ut commodi et praesentium unde tempora molestias qui est omnis velit nihil distinctio sunt explicabo.', 'Incidunt voluptatem itaque est libero ipsam aut est pariatur. Neque nisi harum autem placeat. Sint dolorem distinctio corrupti vel consequuntur sunt qui mollitia. Quam voluptatem temporibus architecto suscipit sequi velit reiciendis est.\n\nLaborum maxime molestiae nisi deleniti non et officiis. Et sunt odit debitis et. Corporis enim ad sit aspernatur rerum magni. Sed quam provident ut nulla ut facilis sit.\n\nSimilique itaque aut et et officiis. Sit non quia rerum officia accusamus deleniti et. Iusto reiciendis eum porro aliquid beatae aut aut sed. Ut similique soluta id perferendis at eligendi corrupti.\n\nArchitecto est dignissimos qui accusantium nisi repudiandae recusandae. Nemo dicta vel perspiciatis ipsam illum laborum ea explicabo. Quo quasi nulla commodi. Vitae eum fuga sunt ullam consequatur fugit et pariatur.', NULL, NULL, NULL, NULL, 4, 3, 'group', 'easy', NULL, NULL, NULL, 2988.49, 2091.94, 0.00, 'none', 0.00, 2988.49, 5.00, 0.00, 'percentage', 25.00, 'CAD', 9, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 1, 0, 0, 0.00, 0, 0, 0, '2026-07-31 06:35:11', NULL, NULL, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(18, 'bd2736de-d771-4e3d-8dd8-0b35a101b7bd', 'PT-T-173513', 'Id Aspernatur Ratione Tour', 'id-aspernatur-ratione-tour-7599', 1, 2, NULL, NULL, 'Occaecati omnis ut velit ducimus et ea quia id.', 'Est ut ipsa eos accusamus. Est sed similique et et ut. Et excepturi ut et reiciendis. Impedit facilis nam vel excepturi consectetur. Veniam atque non tempore sed consectetur est.\r\n\r\nSequi sapiente possimus quidem consectetur. Provident dolores suscipit eum non cumque maxime eius. Aliquam mollitia similique sed ullam dolores officia et ea. Facere vitae nisi dolores minima consectetur non.\r\n\r\nError numquam cum est officia eius incidunt. Natus vitae recusandae consequatur ducimus odit. Aut impedit ipsum placeat dolorem nostrum quis sint earum. Recusandae rem aut natus accusantium ex natus.\r\n\r\nEos sed voluptatem impedit veniam. Dolorem praesentium accusamus eos possimus unde quia.', NULL, NULL, NULL, NULL, 2, 1, 'group', 'easy', NULL, NULL, NULL, 2633.52, 1843.46, 0.00, 'none', 0.00, 2633.52, 5.00, 0.00, 'percentage', 25.00, 'CAD', 11, 1, 12, 48, NULL, NULL, NULL, NULL, NULL, 'published', 0, 1, 0, 0.00, 0, 0, 1, '2026-07-31 06:35:11', NULL, 1, '2026-07-31 06:35:13', '2026-08-17 06:55:44', '2026-08-17 06:55:44'),
(19, 'e87448be-3e55-4981-82fa-2fa6d28ba3fe', 'PT-T-954895', 'Victoria & Butchart Gardens Tour', 'victoria-butchart-gardens-tour', 5, 2, NULL, NULL, 'Explore the beauty and charm of Vancouver Island with a full-day Victoria sightseeing tour featuring ferry travel, coastal scenery, gardens, and historic architecture.', NULL, NULL, NULL, NULL, NULL, 1, 0, 'group', 'moderate', NULL, NULL, NULL, 300.00, 150.00, 0.00, 'none', 0.00, 300.00, 5.00, 0.00, 'disabled', 0.00, 'CAD', 25, 5, 12, 2, 'tours/2026/08/8c59d8b5-0ae4-4233-aec7-8cce4dc137cf.jpg', 'tours/2026/08/62e3ace5-2de6-4cb3-8cd7-3d923544e345.jpg', NULL, NULL, NULL, 'published', 1, 1, 0, 0.00, 0, 0, 1, NULL, 1, NULL, '2026-08-17 16:08:17', '2026-08-17 22:23:44', NULL),
(20, 'fe813241-8638-49e1-85f6-17b03a0b907b', 'PT-T-954896', 'Whistler & Sea-to-Sky Tour', 'whistler-sea-to-sky-tour', 1, 4, NULL, NULL, 'Travel along the spectacular Sea-to-Sky Highway to the world-famous resort town of Whistler while enjoying breathtaking coastal and mountain scenery.\r\n\r\nThis tour combines waterfalls, ocean views, alpine landscapes, and free time in Whistler Village.', NULL, NULL, NULL, NULL, NULL, 1, 0, 'group', 'moderate', NULL, NULL, NULL, 250.00, 125.00, 0.00, 'none', 0.00, 250.00, 5.00, 0.00, 'disabled', 0.00, 'CAD', 25, 5, 12, 2, 'tours/2026/08/dc1aafa5-bb80-4f45-a310-a8403ded8a1c.jpg', 'tours/2026/08/19fc7efc-3e6e-4a1d-9b19-2cc37abdf0fd.jpg', NULL, NULL, NULL, 'published', 1, 1, 0, 0.00, 0, 0, 0, NULL, 1, 1, '2026-08-17 16:17:29', '2026-08-17 16:18:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour_categories`
--

CREATE TABLE `tour_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `icon` varchar(80) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_categories`
--

INSERT INTO `tour_categories` (`id`, `parent_id`, `name`, `slug`, `icon`, `image`, `description`, `show_in_menu`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Day Tours', 'day-tours', 'sun', NULL, NULL, 1, 0, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(2, NULL, 'Multi-Day Tours', 'multi-day-tours', 'map', NULL, NULL, 1, 1, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(3, NULL, 'Wildlife & Nature', 'wildlife-nature', 'leaf', NULL, NULL, 1, 2, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(4, NULL, 'City & Culture', 'city-culture', 'building', NULL, NULL, 1, 3, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(5, NULL, 'Adventure', 'adventure', 'mountain', NULL, NULL, 1, 4, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(6, NULL, 'Cruise Excursions', 'cruise-excursions', 'ship', NULL, NULL, 1, 5, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL),
(7, NULL, 'Private Charters', 'private-charters', 'star', NULL, NULL, 1, 6, 1, '2026-07-31 06:34:52', '2026-07-31 06:34:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tour_departures`
--

CREATE TABLE `tour_departures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `price_override` decimal(12,2) DEFAULT NULL,
  `child_price_override` decimal(12,2) DEFAULT NULL,
  `seats_total` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seats_booked` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seats_blocked` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `guide_name` varchar(160) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_departures`
--

INSERT INTO `tour_departures` (`id`, `uuid`, `tour_id`, `start_date`, `end_date`, `departure_time`, `price_override`, `child_price_override`, `seats_total`, `seats_booked`, `seats_blocked`, `status`, `guide_name`, `note`, `created_at`, `updated_at`) VALUES
(1, '6219d099-ed78-4555-ae8e-edab857dca09', 1, '2026-08-05', '2026-08-12', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(2, '2d2910f3-9683-46c2-8fa3-eeabf81cdbd4', 1, '2026-08-12', '2026-08-19', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(3, '1a41e09f-e7a2-4107-9036-a917e9ff1363', 1, '2026-08-19', '2026-08-26', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(4, 'ca6c6490-4adf-4c8c-be1f-2f3d2d6a0ba1', 1, '2026-08-26', '2026-09-02', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(5, 'b7bd5006-3c14-4fc0-b305-7988960a8e97', 1, '2026-09-02', '2026-09-09', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(6, '82a08714-1e9c-428d-a2d4-a2359cfb7a00', 1, '2026-09-09', '2026-09-16', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(7, '74ec4f18-7ddb-434d-b2ae-2e38f3631b90', 1, '2026-09-16', '2026-09-23', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(8, 'cf0a40ed-a8bf-46ac-9963-9d9a41fabcc7', 1, '2026-09-23', '2026-09-30', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(9, '0e489815-77de-40ec-a81c-d75f8495c986', 1, '2026-09-30', '2026-10-07', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(10, '94cec03f-59b5-4acc-9f87-fd63d9b1f4e3', 1, '2026-10-07', '2026-10-14', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(11, 'f5cec1c7-0552-481e-9133-543f21d9fd58', 1, '2026-10-14', '2026-10-21', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(12, '78405444-5b22-4bda-9869-274b8c07eb7f', 1, '2026-10-21', '2026-10-28', NULL, NULL, NULL, 40, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(13, 'b5217dbe-e561-49df-8084-e02516dd561e', 2, '2026-08-05', '2026-08-10', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(14, '6725c31e-41f4-4a9f-b134-715983360cd1', 2, '2026-08-12', '2026-08-17', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(15, 'f17c76a1-f283-4691-9ad2-529efc700ccd', 2, '2026-08-19', '2026-08-24', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(16, 'bcdd9c2d-fd49-4dca-809a-acc58a18f403', 2, '2026-08-26', '2026-08-31', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(17, '209d98b6-9bf2-42bd-8b3d-a630b5a3f82f', 2, '2026-09-02', '2026-09-07', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(18, 'f9795ccd-8f99-4716-b34d-48b14962cb16', 2, '2026-09-09', '2026-09-14', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(19, '625e4b4c-c995-4066-98d5-784733661e96', 2, '2026-09-16', '2026-09-21', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(20, '86833a15-8a66-4c8b-b1f7-ba3c1cace315', 2, '2026-09-23', '2026-09-28', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(21, '22cfa1e7-ce37-4e96-9944-fb98637f8eaf', 2, '2026-09-30', '2026-10-05', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(22, 'fc0b29fd-6a8f-4402-8258-df2cac68ef79', 2, '2026-10-07', '2026-10-12', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(23, 'fa8b9f62-d1d2-4e4d-bc19-1fb74557217b', 2, '2026-10-14', '2026-10-19', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(24, '1e26e1f1-f010-4286-9177-677fb370eb0e', 2, '2026-10-21', '2026-10-26', NULL, NULL, NULL, 17, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(25, '850ef7b4-2eaa-458d-acbe-6c339ca0731d', 3, '2026-08-05', '2026-08-05', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(26, 'eb71f47d-9d06-4fcd-bcba-b2a1e34257c7', 3, '2026-08-12', '2026-08-12', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(27, 'd103a31d-91b6-4f64-9063-b07c7f2538d9', 3, '2026-08-19', '2026-08-19', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(28, 'f595c529-3717-409a-a618-ea23beea912a', 3, '2026-08-26', '2026-08-26', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(29, 'daa79d91-4cfc-44d4-b7bc-82307c57ef1b', 3, '2026-09-02', '2026-09-02', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(30, 'a618be27-15cc-4cec-ae11-d7892fc523de', 3, '2026-09-09', '2026-09-09', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(31, 'ea668ae3-1ee2-4ee5-b12b-6a80ce85f87f', 3, '2026-09-16', '2026-09-16', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(32, 'bf805496-beec-4826-856d-af9d27b01ed1', 3, '2026-09-23', '2026-09-23', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(33, '40c3775b-01f6-4c09-817b-d414e72bfc8f', 3, '2026-09-30', '2026-09-30', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(34, '9d28e141-10f3-4bbf-8f75-60f2d9fada19', 3, '2026-10-07', '2026-10-07', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(35, '325a2f9a-9430-4f72-8cf4-af4e6b04d285', 3, '2026-10-14', '2026-10-14', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(36, '062fc660-ac21-4da8-83fb-5cebc2d9ea6a', 3, '2026-10-21', '2026-10-21', NULL, NULL, NULL, 18, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(37, '9073e76c-0a93-4771-8b92-0785f9541aee', 4, '2026-08-05', '2026-08-06', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(38, '1525a491-9c35-4d64-8a0e-84b25ab91d89', 4, '2026-08-12', '2026-08-13', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(39, '3f928fa0-da7c-4e99-9fce-ebb82e61dde4', 4, '2026-08-19', '2026-08-20', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(40, '03e46ea2-0457-476d-b54c-e5c9d0367864', 4, '2026-08-26', '2026-08-27', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(41, '1d61cbc7-99df-41a9-b8b0-271c73a29128', 4, '2026-09-02', '2026-09-03', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(42, 'ac6ec2cc-269f-40be-b91d-d7af31951807', 4, '2026-09-09', '2026-09-10', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(43, 'd15e824d-2f17-4738-8a73-a2e4ef6ac5f0', 4, '2026-09-16', '2026-09-17', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(44, '0f963816-4c30-4d94-b5ca-cf67867d71ca', 4, '2026-09-23', '2026-09-24', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(45, '4c21f5b5-7ca4-474b-a29c-78d0acfc49ab', 4, '2026-09-30', '2026-10-01', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(46, 'ba56aca3-b86f-48cb-bc2a-05134fc9fb7f', 4, '2026-10-07', '2026-10-08', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(47, '7756381d-991c-45a0-b749-69ffe8a1a668', 4, '2026-10-14', '2026-10-15', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(48, '65da1468-f2c2-4b3c-910b-234205703fb3', 4, '2026-10-21', '2026-10-22', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(49, '9b43e723-7316-448d-9162-24c4dcb03029', 5, '2026-08-05', '2026-08-09', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(50, 'e53b4da7-a382-4c05-a32b-cf8c588236c5', 5, '2026-08-12', '2026-08-16', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(51, 'f5bb1224-a19e-4c39-ae74-3282e8d8cddd', 5, '2026-08-19', '2026-08-23', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(52, '013470ad-00c5-4617-88fb-88331740a597', 5, '2026-08-26', '2026-08-30', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(53, '6f95491b-0a2b-4b66-9858-a63ee581fe7c', 5, '2026-09-02', '2026-09-06', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(54, 'db277fba-1752-4623-85d3-97503ea8bd38', 5, '2026-09-09', '2026-09-13', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(55, '6333cb6f-a028-47e0-b287-8a7ace7552bf', 5, '2026-09-16', '2026-09-20', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(56, '3d493005-3310-40bf-9ff9-ac7f0ebde463', 5, '2026-09-23', '2026-09-27', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(57, '8a1e1314-419d-439b-b481-352456e1e2d9', 5, '2026-09-30', '2026-10-04', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(58, '1ef41fa8-3580-4e2d-aed7-3c1d317895d5', 5, '2026-10-07', '2026-10-11', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(59, '5ed96e54-4850-4037-80a8-9d381b18953a', 5, '2026-10-14', '2026-10-18', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(60, 'aa5143fe-2db8-4bfc-95b2-fcd10fd04d01', 5, '2026-10-21', '2026-10-25', NULL, NULL, NULL, 39, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(61, 'f19e8579-aa6f-45b6-be44-1c70adb79f8d', 6, '2026-08-05', '2026-08-08', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(62, 'd698dc3c-5072-49e0-a5a9-cbfb2db751ab', 6, '2026-08-12', '2026-08-15', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(63, '657c992e-4f0e-4071-96a7-44c955d5755e', 6, '2026-08-19', '2026-08-22', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(64, 'd11b4e01-de99-4ae9-afb0-2bd90c24787a', 6, '2026-08-26', '2026-08-29', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(65, '068218fc-db52-40fc-b18e-124dbf8cbf2b', 6, '2026-09-02', '2026-09-05', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(66, '38eae16e-bce8-4d37-951d-062ea7d607a3', 6, '2026-09-09', '2026-09-12', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(67, '93641d61-d56e-4f08-8f5a-84d4cef0fb62', 6, '2026-09-16', '2026-09-19', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(68, '21337daf-2f39-41e6-b367-cd6de7ffee35', 6, '2026-09-23', '2026-09-26', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(69, '4ce39885-656d-44e9-892d-8fc838f9aa5d', 6, '2026-09-30', '2026-10-03', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(70, 'a21bbafd-984c-4eec-8e75-e41f7c3e73ed', 6, '2026-10-07', '2026-10-10', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(71, '5b5c7a0c-26ab-4769-9114-b4b3f0239a41', 6, '2026-10-14', '2026-10-17', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(72, '059a7501-65d7-4bc3-87e7-c1b058d61c93', 6, '2026-10-21', '2026-10-24', NULL, NULL, NULL, 31, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(73, 'b1a63386-4f89-46e1-93b5-d0faa1960071', 7, '2026-08-05', '2026-08-11', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(74, 'ff67506c-ff45-404e-b701-809d64122c50', 7, '2026-08-12', '2026-08-18', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(75, '19b27670-d712-4128-831c-7953c3c6288a', 7, '2026-08-19', '2026-08-25', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(76, '59c3a4ba-4af3-4711-b05c-d878ddbde2bf', 7, '2026-08-26', '2026-09-01', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(77, '0abbbbf9-da50-4bae-8ab1-3b632e04c040', 7, '2026-09-02', '2026-09-08', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(78, 'acc0b5c8-12bf-4135-8c07-219828837aae', 7, '2026-09-09', '2026-09-15', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(79, '9e32a18f-3513-48e5-8f59-1dbd969fabff', 7, '2026-09-16', '2026-09-22', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(80, 'ee108665-3699-4edf-8deb-3920da154ef4', 7, '2026-09-23', '2026-09-29', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(81, '8c3cdb9d-0d0a-4b7a-ac49-39e4c6e67e58', 7, '2026-09-30', '2026-10-06', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(82, 'a78357b9-1ceb-40cd-ba65-ba39c5e66fc7', 7, '2026-10-07', '2026-10-13', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(83, '11223bbf-727f-453c-8553-c1937559da02', 7, '2026-10-14', '2026-10-20', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(84, '4b7ff276-9d86-444e-bb89-f7d57f2d9df8', 7, '2026-10-21', '2026-10-27', NULL, NULL, NULL, 27, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(85, 'ce9cf1f5-02e7-42eb-93a8-b97ada6b61e5', 8, '2026-08-05', '2026-08-05', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(86, '1601324c-a020-4180-b8f0-662f4e7c010b', 8, '2026-08-12', '2026-08-12', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(87, 'f8f4a0ef-1bd8-47e8-bb6d-2d7f4a879393', 8, '2026-08-19', '2026-08-19', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(88, '422916a1-fe2f-45ab-9ef1-c388914ce5b7', 8, '2026-08-26', '2026-08-26', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(89, 'a16be89a-abf2-4f7f-9569-2336a819f665', 8, '2026-09-02', '2026-09-02', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(90, '6452f563-325e-45a8-9022-413cb436cdbf', 8, '2026-09-09', '2026-09-09', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(91, '15a91b5e-8f90-4484-9658-8d7116387300', 8, '2026-09-16', '2026-09-16', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(92, 'c4a0a3e7-e9f3-4b65-8d02-ff8357353ef3', 8, '2026-09-23', '2026-09-23', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(93, 'bbc27534-3612-4dc4-a405-e4aa3584558e', 8, '2026-09-30', '2026-09-30', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(94, 'fb98558c-5fbf-4a87-8c99-4feb9a5abf97', 8, '2026-10-07', '2026-10-07', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(95, '2099c0ff-53d9-44d4-8786-26e702bab9d0', 8, '2026-10-14', '2026-10-14', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(96, '5624463c-1f03-402d-9c14-f5b921ca1b7d', 8, '2026-10-21', '2026-10-21', NULL, NULL, NULL, 25, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(97, '04287d4e-fc07-4168-a6ad-f3bf5be34ce0', 9, '2026-08-05', '2026-08-05', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(98, '20845717-198d-41a4-84ae-131152f02fd8', 9, '2026-08-12', '2026-08-12', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(99, '497bce52-3dbb-4c9a-9f24-99bca80a29fd', 9, '2026-08-19', '2026-08-19', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(100, '1987a2d3-c15a-44bd-a873-1798b4cf1a71', 9, '2026-08-26', '2026-08-26', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(101, 'a9f3b959-f157-4dfb-b785-a74a349cb98d', 9, '2026-09-02', '2026-09-02', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(102, 'a260b266-4a84-4f81-bf39-a83ef9b6fdd7', 9, '2026-09-09', '2026-09-09', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(103, '03bbb23d-e304-49bc-875e-a3ef251dc6c8', 9, '2026-09-16', '2026-09-16', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(104, 'e71bd302-beeb-466c-868a-837645c14be1', 9, '2026-09-23', '2026-09-23', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(105, '1967f5f5-6091-40d8-a068-7e3e0c6f645d', 9, '2026-09-30', '2026-09-30', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(106, '97b0e90f-97ed-4737-9c40-ca71c2d68f15', 9, '2026-10-07', '2026-10-07', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(107, 'c94c94df-3e88-4bc8-8250-114b4468d6d2', 9, '2026-10-14', '2026-10-14', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(108, 'ee85f201-58fe-4a87-b6f5-72efb6c54edf', 9, '2026-10-21', '2026-10-21', NULL, NULL, NULL, 8, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(109, 'ad57d535-4b63-4e82-b66a-fe6bdb14511c', 10, '2026-08-05', '2026-08-08', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(110, '1d2753d9-c5b0-43b1-aab1-620c900ca701', 10, '2026-08-12', '2026-08-15', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(111, '1513fe01-9717-4a5c-a071-a3c6e863363d', 10, '2026-08-19', '2026-08-22', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(112, '67179fc9-6a49-414d-95f5-3e81fcb14a04', 10, '2026-08-26', '2026-08-29', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(113, '64e9866a-1202-4809-8ba9-32311359ba81', 10, '2026-09-02', '2026-09-05', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(114, '47c317a0-9587-4a52-adfd-d7f860bbed42', 10, '2026-09-09', '2026-09-12', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(115, '47ddfca8-9699-4960-b63e-09f15db65990', 10, '2026-09-16', '2026-09-19', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(116, 'c7a45065-efb1-41f4-a532-70d99fb039a0', 10, '2026-09-23', '2026-09-26', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(117, '3c451795-dec3-4b2c-9148-ca29f78f094a', 10, '2026-09-30', '2026-10-03', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(118, '6847718c-4695-4080-b7eb-0846741fa154', 10, '2026-10-07', '2026-10-10', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(119, 'd47d778a-8d13-4581-9381-3fb596c511a9', 10, '2026-10-14', '2026-10-17', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(120, 'a104298e-905b-46a3-82d3-150d3a2f62e0', 10, '2026-10-21', '2026-10-24', NULL, NULL, NULL, 16, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(121, '1ee640ae-67b4-4d96-bdb5-2b1e65a4b814', 11, '2026-08-05', '2026-08-11', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(122, 'eb0ed471-c4f4-416d-936f-0b77d7372a77', 11, '2026-08-12', '2026-08-18', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(123, '6315b495-1949-4128-99f9-9e69e1dc0204', 11, '2026-08-19', '2026-08-25', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(124, 'be8add78-43ba-471d-836e-be3f2f97f5c0', 11, '2026-08-26', '2026-09-01', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(125, '8a187bc1-a4b4-4053-8daa-394e552fdac1', 11, '2026-09-02', '2026-09-08', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(126, '8e6ad387-62d0-4f48-ae90-2d25b331235f', 11, '2026-09-09', '2026-09-15', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(127, '8e296a72-4244-4d2f-ac1b-cd8935b9ca35', 11, '2026-09-16', '2026-09-22', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(128, '6b6d9805-f9e8-4b3e-908c-25a6af04ee4e', 11, '2026-09-23', '2026-09-29', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(129, '633e6c65-6b40-4930-bb8c-32559e6d3125', 11, '2026-09-30', '2026-10-06', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(130, '6c05a9ab-f858-476a-b70a-cf1e8c8ad6ef', 11, '2026-10-07', '2026-10-13', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(131, '02ef8657-324d-480d-8045-2d4620068707', 11, '2026-10-14', '2026-10-20', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(132, '8e98b65e-53f0-4d31-869b-3d4667d6c6bd', 11, '2026-10-21', '2026-10-27', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(133, 'b356239c-dd8d-4636-974c-0b7da7bfef1a', 12, '2026-08-05', '2026-08-07', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(134, 'f48f9288-45e3-4b2e-ac20-a3b237b8bef5', 12, '2026-08-12', '2026-08-14', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(135, '60132e6e-83aa-483e-9781-3bd29b89d83d', 12, '2026-08-19', '2026-08-21', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(136, 'debc8cf2-9430-4534-9d1e-0b1803388a57', 12, '2026-08-26', '2026-08-28', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(137, '476ba887-3913-43dc-9023-ea23c4a7f10c', 12, '2026-09-02', '2026-09-04', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(138, 'f05c62e8-d6d0-49b1-9ed4-5527e422a633', 12, '2026-09-09', '2026-09-11', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(139, '1a2bb789-ac8b-49eb-b10b-e45d15a8890c', 12, '2026-09-16', '2026-09-18', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(140, '64b71331-b6fb-482a-891f-3725d5b10fab', 12, '2026-09-23', '2026-09-25', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(141, 'b9e3a153-f3dc-4b48-bba8-fff4197aab1e', 12, '2026-09-30', '2026-10-02', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(142, 'cb648d7f-ac38-4664-8ff0-a1fcdba22b79', 12, '2026-10-07', '2026-10-09', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(143, '3d83271d-5031-4217-a990-dca2b9d8ca7e', 12, '2026-10-14', '2026-10-16', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(144, 'f87cf8af-be7a-46f2-a9fb-7806b7cef7fb', 12, '2026-10-21', '2026-10-23', NULL, NULL, NULL, 12, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(145, 'c5150f2e-d72c-45cf-a232-8b1ffbaa1e9b', 13, '2026-08-05', '2026-08-14', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(146, '2871d406-d0b5-4ef4-99cf-d898c71de36e', 13, '2026-08-12', '2026-08-21', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(147, 'eadc2979-13d6-475b-b0bd-3174055ef2f8', 13, '2026-08-19', '2026-08-28', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(148, 'db3affc4-6a54-46fa-80c7-119a85c96da8', 13, '2026-08-26', '2026-09-04', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(149, 'd47e31e4-273f-4303-8f62-d675f4de8d3b', 13, '2026-09-02', '2026-09-11', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(150, '12b2125c-d629-4ed6-9761-4f923860f5d0', 13, '2026-09-09', '2026-09-18', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(151, '3d4846de-0d90-4441-a697-b4408e9a5d3f', 13, '2026-09-16', '2026-09-25', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(152, 'e7d7c2f1-f604-4da1-970e-56f03ec4d334', 13, '2026-09-23', '2026-10-02', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(153, 'b31ef19d-a70e-41b5-9cd2-e0778f153170', 13, '2026-09-30', '2026-10-09', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(154, '35de04d7-9cfa-4ec7-8827-cea7e34825ef', 13, '2026-10-07', '2026-10-16', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(155, 'c0754fd9-6072-4072-ac25-6beef09e3d20', 13, '2026-10-14', '2026-10-23', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(156, 'f3ad1abb-7bd2-4b53-817b-a69bb591404a', 13, '2026-10-21', '2026-10-30', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(157, 'a35d3661-ca78-4211-bb23-97097120b1f0', 14, '2026-08-05', '2026-08-12', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(158, 'e9a00f95-93d1-43d1-be60-60ca351ae06a', 14, '2026-08-12', '2026-08-19', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(159, 'd7f68b4e-0f92-451d-b3cc-dbbe9ceb0239', 14, '2026-08-19', '2026-08-26', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(160, 'f4052581-98da-435b-aeff-750ee8fc982f', 14, '2026-08-26', '2026-09-02', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(161, 'bf23f97a-1e51-495f-9494-18236111a33d', 14, '2026-09-02', '2026-09-09', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(162, '7f9112cf-623c-4b88-bb6f-a79354ef93ba', 14, '2026-09-09', '2026-09-16', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(163, '2aedcd51-44df-4359-98c7-c5d5ff62e026', 14, '2026-09-16', '2026-09-23', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(164, '6449a383-8c0e-454a-a340-0ee9025b7328', 14, '2026-09-23', '2026-09-30', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(165, 'd9a104d2-3bfe-454d-9e30-13bd89811668', 14, '2026-09-30', '2026-10-07', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(166, '8b86309f-580f-4041-a637-2a740e66ae78', 14, '2026-10-07', '2026-10-14', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(167, '7b4339a2-5c13-419b-8d1f-9a49d9805a66', 14, '2026-10-14', '2026-10-21', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(168, '4a18648e-6ec4-4c28-9443-30068bcab116', 14, '2026-10-21', '2026-10-28', NULL, NULL, NULL, 21, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(169, '1c2f4df9-0e4b-4463-953f-6c6ecd2e4169', 15, '2026-08-05', '2026-08-11', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(170, 'cf4faedd-f24a-4727-9e27-84eb38669870', 15, '2026-08-12', '2026-08-18', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(171, '72c1327d-e25d-4b89-a426-88b301711600', 15, '2026-08-19', '2026-08-25', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(172, 'c4c0db31-7b01-459a-a453-18adb45589ad', 15, '2026-08-26', '2026-09-01', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(173, '69e83ac0-8804-4c53-833c-2b494fe058b2', 15, '2026-09-02', '2026-09-08', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(174, 'd9a65001-e288-48ff-87e8-6699299d4f1f', 15, '2026-09-09', '2026-09-15', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(175, 'bdc7fc3b-242b-4c8e-b437-1963a2db3913', 15, '2026-09-16', '2026-09-22', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(176, '41ad6ac8-e891-41f1-9b75-f307b86ad15f', 15, '2026-09-23', '2026-09-29', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(177, '2fac3eb2-655c-444f-8c20-bf56effcc387', 15, '2026-09-30', '2026-10-06', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(178, '7380d097-7707-431a-9a39-5bfbc1d39ff7', 15, '2026-10-07', '2026-10-13', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(179, '6e514540-3b9b-4f6b-9b36-2832bb0f5388', 15, '2026-10-14', '2026-10-20', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(180, 'a4992891-c845-4a8f-a720-a25a9ed06627', 15, '2026-10-21', '2026-10-27', NULL, NULL, NULL, 34, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(181, '7fa56b84-b4a7-49ed-aff5-fb8236cbc06c', 16, '2026-08-05', '2026-08-12', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(182, '95041e73-355c-469b-b0c1-fd2cb109e335', 16, '2026-08-12', '2026-08-19', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(183, 'e03d247d-acf9-4d60-a9c2-ceee476d5805', 16, '2026-08-19', '2026-08-26', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(184, '0f5cc1cc-00c9-4aad-846f-3cf912864539', 16, '2026-08-26', '2026-09-02', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(185, '0ad7a972-f19b-4731-9537-098ce705d85c', 16, '2026-09-02', '2026-09-09', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(186, '3d7193fb-1c73-4aea-8853-a9932c97c675', 16, '2026-09-09', '2026-09-16', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(187, '77bd51eb-003c-43dd-9585-0b61d0121825', 16, '2026-09-16', '2026-09-23', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(188, 'decdbf01-c075-4b4b-8d21-64322c82402e', 16, '2026-09-23', '2026-09-30', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(189, '260b9bb2-2313-406b-a02c-e31ba160eed2', 16, '2026-09-30', '2026-10-07', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(190, '56c5f72e-96f6-4b74-aa16-86f956d1d226', 16, '2026-10-07', '2026-10-14', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(191, '3406dded-e4d5-436b-aaae-951aeceeb25c', 16, '2026-10-14', '2026-10-21', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(192, 'fcbb6e08-2538-4ffa-bc7b-cbb35a9fdc9f', 16, '2026-10-21', '2026-10-28', NULL, NULL, NULL, 38, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(193, '9026a7be-91f5-4552-83d4-cefc48e16d55', 17, '2026-08-05', '2026-08-08', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(194, '3023dfe8-7562-4e43-8b2d-af18066ab0d6', 17, '2026-08-12', '2026-08-15', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(195, '9ec2fa74-10f3-4c66-a360-0de40781f8f0', 17, '2026-08-19', '2026-08-22', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(196, '83b208e9-4851-4f1f-b800-958184fdc412', 17, '2026-08-26', '2026-08-29', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(197, '684902d8-3371-4ca2-ad5b-ef385a6e0e02', 17, '2026-09-02', '2026-09-05', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(198, '5080606a-8627-4eb6-a30c-2cc282871a33', 17, '2026-09-09', '2026-09-12', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(199, 'ae4bae86-f62b-4279-8afb-14b91181a129', 17, '2026-09-16', '2026-09-19', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(200, '02ddedd7-2732-4e3d-ad28-6acb478d424d', 17, '2026-09-23', '2026-09-26', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(201, '8d5bb2c8-3282-4a0d-8e39-fa2836393c46', 17, '2026-09-30', '2026-10-03', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(202, '41757420-d825-48b5-a88a-400cae4cef51', 17, '2026-10-07', '2026-10-10', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(203, '3a60a7a7-171e-40ba-95bb-f7d39b91d4b1', 17, '2026-10-14', '2026-10-17', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(204, 'd65db65c-a5fa-4405-8d9f-4be67101cd06', 17, '2026-10-21', '2026-10-24', NULL, NULL, NULL, 9, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(205, 'f44c7aa0-84f3-4d3b-9a75-3d3bf78812ac', 18, '2026-08-05', '2026-08-06', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(206, '83671f4e-7425-4baa-a2d7-8d950157cc21', 18, '2026-08-12', '2026-08-13', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(207, '2e0181dd-ada4-4f54-aaba-8a7f977771b3', 18, '2026-08-19', '2026-08-20', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(208, 'd3033362-f0ab-4b61-a223-b87108a3826b', 18, '2026-08-26', '2026-08-27', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(209, 'f9b4055d-a563-4e66-81b6-5c0991bcb560', 18, '2026-09-02', '2026-09-03', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(210, '237673b5-e422-444e-9564-2d0d7dd17693', 18, '2026-09-09', '2026-09-10', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(211, 'e828472c-5a64-46ea-be34-9ce1858af9d6', 18, '2026-09-16', '2026-09-17', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(212, '961557ab-4f72-4ef6-a389-860b45c79059', 18, '2026-09-23', '2026-09-24', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:24', '2026-07-31 06:35:24'),
(213, '53a40ebd-ceb9-4679-8876-214571530f43', 18, '2026-09-30', '2026-10-01', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:24', '2026-07-31 06:35:24'),
(214, '0a2c0e0f-fe21-4c67-a0dc-8d3ccd348159', 18, '2026-10-07', '2026-10-08', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:24', '2026-07-31 06:35:24'),
(215, '42c9cd81-7399-4c05-bc1d-87eecb36ab46', 18, '2026-10-14', '2026-10-15', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:24', '2026-07-31 06:35:24'),
(216, '6456f920-e4d3-43b6-9143-a3ac9cfebe61', 18, '2026-10-21', '2026-10-22', NULL, NULL, NULL, 11, 0, 0, 'open', NULL, NULL, '2026-07-31 06:35:24', '2026-07-31 06:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `tour_faqs`
--

CREATE TABLE `tour_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_highlights`
--

CREATE TABLE `tour_highlights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_images`
--

CREATE TABLE `tour_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `alt_text` varchar(160) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_inclusions`
--

CREATE TABLE `tour_inclusions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(12) NOT NULL DEFAULT 'included',
  `content` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_inclusions`
--

INSERT INTO `tour_inclusions` (`id`, `tour_id`, `type`, `content`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(2, 1, 'included', 'Licensed guide', 1, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(3, 1, 'included', 'All park fees', 2, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(4, 1, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(5, 1, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(6, 2, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(7, 2, 'included', 'Licensed guide', 1, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(8, 2, 'included', 'All park fees', 2, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(9, 2, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(10, 2, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(11, 3, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(12, 3, 'included', 'Licensed guide', 1, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(13, 3, 'included', 'All park fees', 2, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(14, 3, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(15, 3, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(16, 4, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(17, 4, 'included', 'Licensed guide', 1, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(18, 4, 'included', 'All park fees', 2, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(19, 4, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(20, 4, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(21, 5, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(22, 5, 'included', 'Licensed guide', 1, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(23, 5, 'included', 'All park fees', 2, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(24, 5, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(25, 5, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(26, 6, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(27, 6, 'included', 'Licensed guide', 1, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(28, 6, 'included', 'All park fees', 2, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(29, 6, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(30, 6, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(31, 7, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(32, 7, 'included', 'Licensed guide', 1, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(33, 7, 'included', 'All park fees', 2, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(34, 7, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(35, 7, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(36, 8, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(37, 8, 'included', 'Licensed guide', 1, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(38, 8, 'included', 'All park fees', 2, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(39, 8, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(40, 8, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(41, 9, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(42, 9, 'included', 'Licensed guide', 1, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(43, 9, 'included', 'All park fees', 2, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(44, 9, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(45, 9, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(46, 10, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(47, 10, 'included', 'Licensed guide', 1, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(48, 10, 'included', 'All park fees', 2, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(49, 10, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(50, 10, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(51, 11, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(52, 11, 'included', 'Licensed guide', 1, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(53, 11, 'included', 'All park fees', 2, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(54, 11, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(55, 11, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(56, 12, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(57, 12, 'included', 'Licensed guide', 1, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(58, 12, 'included', 'All park fees', 2, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(59, 12, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(60, 12, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(61, 13, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(62, 13, 'included', 'Licensed guide', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(63, 13, 'included', 'All park fees', 2, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(64, 13, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(65, 13, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(66, 14, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(67, 14, 'included', 'Licensed guide', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(68, 14, 'included', 'All park fees', 2, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(69, 14, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(70, 14, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(71, 15, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(72, 15, 'included', 'Licensed guide', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(73, 15, 'included', 'All park fees', 2, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(74, 15, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(75, 15, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(76, 16, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(77, 16, 'included', 'Licensed guide', 1, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(78, 16, 'included', 'All park fees', 2, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(79, 16, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(80, 16, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(81, 17, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(82, 17, 'included', 'Licensed guide', 1, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(83, 17, 'included', 'All park fees', 2, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(84, 17, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(85, 17, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(86, 18, 'included', 'Hotel pickup and drop-off', 0, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(87, 18, 'included', 'Licensed guide', 1, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(88, 18, 'included', 'All park fees', 2, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(89, 18, 'excluded', 'Gratuities', 0, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(90, 18, 'excluded', 'Travel insurance', 1, '2026-07-31 06:35:23', '2026-07-31 06:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `tour_itineraries`
--

CREATE TABLE `tour_itineraries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `day_number` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` longtext DEFAULT NULL,
  `accommodation` varchar(200) DEFAULT NULL,
  `meals` varchar(120) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_itineraries`
--

INSERT INTO `tour_itineraries` (`id`, `tour_id`, `day_number`, `title`, `description`, `accommodation`, `meals`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(2, 1, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(3, 1, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(4, 1, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(5, 1, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(6, 1, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(7, 1, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(8, 1, 8, 'Day 8', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:13', '2026-07-31 06:35:13'),
(9, 2, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(10, 2, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(11, 2, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(12, 2, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(13, 2, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(14, 2, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(15, 3, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:14', '2026-07-31 06:35:14'),
(16, 4, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(17, 4, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:15', '2026-07-31 06:35:15'),
(18, 5, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(19, 5, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(20, 5, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(21, 5, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(22, 5, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(23, 6, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(24, 6, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(25, 6, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:16', '2026-07-31 06:35:16'),
(26, 6, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(27, 7, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(28, 7, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(29, 7, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:17', '2026-07-31 06:35:17'),
(30, 7, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(31, 7, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(32, 7, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(33, 7, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(34, 8, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:18', '2026-07-31 06:35:18'),
(35, 9, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(36, 10, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(37, 10, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(38, 10, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(39, 10, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(40, 11, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(41, 11, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(42, 11, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(43, 11, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:19', '2026-07-31 06:35:19'),
(44, 11, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(45, 11, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(46, 11, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(47, 12, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(48, 12, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(49, 12, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(50, 13, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(51, 13, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(52, 13, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(53, 13, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(54, 13, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:20', '2026-07-31 06:35:20'),
(55, 13, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(56, 13, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(57, 13, 8, 'Day 8', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(58, 13, 9, 'Day 9', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(59, 13, 10, 'Day 10', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(60, 14, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(61, 14, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(62, 14, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(63, 14, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(64, 14, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(65, 14, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(66, 14, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(67, 14, 8, 'Day 8', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(68, 15, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(69, 15, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(70, 15, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(71, 15, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(72, 15, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(73, 15, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(74, 15, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:21', '2026-07-31 06:35:21'),
(75, 16, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(76, 16, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(77, 16, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(78, 16, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(79, 16, 5, 'Day 5', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(80, 16, 6, 'Day 6', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(81, 16, 7, 'Day 7', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(82, 16, 8, 'Day 8', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(83, 17, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(84, 17, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(85, 17, 3, 'Day 3', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(86, 17, 4, 'Day 4', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:22', '2026-07-31 06:35:22'),
(87, 18, 1, 'Day 1', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:23', '2026-07-31 06:35:23'),
(88, 18, 2, 'Day 2', 'Sample itinerary copy — replace from Admin → Tours.', NULL, 'Breakfast', NULL, 0, '2026-07-31 06:35:23', '2026-07-31 06:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `tour_tag`
--

CREATE TABLE `tour_tag` (
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translatable_type` varchar(255) NOT NULL,
  `translatable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(5) NOT NULL,
  `field` varchar(60) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `locale` varchar(5) NOT NULL DEFAULT 'en',
  `timezone` varchar(64) NOT NULL DEFAULT 'America/Vancouver',
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `last_name`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `status`, `locale`, `timezone`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `last_login_ip`, `last_login_at`, `created_by`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '74d52173-a632-4bb7-84f0-de83382634fc', 'Pacific', 'Admin', 'admin@pacifictours.ca', NULL, '2026-07-31 06:34:48', NULL, '$2y$12$RZUdredHljFbPT91pOUj0uZhiJjhSUw25lLIziNSTHjgQrDuwO3TK', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, '45.250.244.140', '2026-08-17 17:55:27', NULL, NULL, '2026-07-31 06:34:48', '2026-08-17 17:55:27', NULL),
(2, 'd73b4fac-8eb9-44f9-a6f0-9d70a3f4e135', 'Manager', 'Demo', 'manager@pacifictours.ca', NULL, '2026-07-31 06:34:53', NULL, '$2y$12$4aHsrlCnKo6I65s9JPskF.Vy59.mlUnJ4B/u84S0qr.WXptqs7xTy', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:34:53', '2026-07-31 06:34:53', NULL),
(3, '605afdcd-8793-4580-a3d1-e6bb3f6a7f74', 'Sales', 'Demo', 'sales@pacifictours.ca', NULL, '2026-07-31 06:34:54', NULL, '$2y$12$owClJNe2y/iBzVwQPHE7xefazDmiBDDuGZg2NdROQkiGTJfi.gqZe', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:34:54', '2026-07-31 06:34:54', NULL),
(4, '39d64ee9-70cd-4ed2-9644-573791d07dbf', 'Operator', 'Demo', 'operator@pacifictours.ca', NULL, '2026-07-31 06:34:55', NULL, '$2y$12$IUF0BbfuL8Ag4X0HM3Ri7.mNjgUjjoro2yImuEjwK91IATNGlmTpi', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:34:55', '2026-07-31 06:34:55', NULL),
(5, '320d46d8-a5dd-447c-9a6d-464c7d12c0d0', 'Everette', 'Satterfield', 'abernathy.krystina@example.com', '+1 604 742 3582', '2026-07-31 06:34:55', NULL, '$2y$12$OCWPVuEYo6FpYxxwCmKsY.n5YnzdcemCtBudeM/zLpB6rM5pddOPW', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:08', '2026-07-31 06:35:08', NULL),
(6, '8538574f-16e7-4624-b804-e33c93719e7e', 'Rhiannon', 'DuBuque', 'kgrant@example.org', '+1 604 434 4189', '2026-07-31 06:34:56', NULL, '$2y$12$1hP.e3VEsj/yxuhoF72GwOeE7I0HJE5pCm0yLSXfHQbuQ5qQo7Z12', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:08', '2026-07-31 06:35:08', NULL),
(7, '329ee8ac-9874-44cc-8aa9-8a9dbaaf6b3a', 'Kendra', 'Veum', 'yoconner@example.org', '+1 604 063 7772', '2026-07-31 06:34:56', NULL, '$2y$12$K0pz5amEIXpMHBPag2C6RuUDApWko0ttj03cU8VfRxricF4gOQ7em', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(8, '452d9299-d2c1-48cb-861e-fc7adeff7da2', 'Jadon', 'Wiza', 'zsenger@example.net', '+1 604 904 7577', '2026-07-31 06:34:57', NULL, '$2y$12$85BJf.Rsjm8AMJDqE90Vbu/HobvgVaRB/VveLR4XEOilU5OOaSjkO', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(9, '711966a6-15ae-4f12-809e-cb6b6ecf44ea', 'Elfrieda', 'Heaney', 'vgottlieb@example.com', '+1 604 925 6405', '2026-07-31 06:34:58', NULL, '$2y$12$M3Deh4lu18uL4lJbKyJjaO1dtpjYXxVZ4sl.vcLwMlDgZqCIkYNdm', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(10, '0a7af7ed-17e4-470d-bc54-0b682486038f', 'Ronny', 'Ullrich', 'lewis82@example.net', '+1 604 823 7110', '2026-07-31 06:34:58', NULL, '$2y$12$LJJ46gwJRa1jQBkt0KzJEuEabvTh/Y1vcx67f6DJAY5an/t8HcClK', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(11, 'e292a1b4-823a-472a-9e42-6c639f08f1ae', 'Dayton', 'Medhurst', 'ibailey@example.org', '+1 604 788 3497', '2026-07-31 06:34:59', NULL, '$2y$12$P.bhOMvS2Oz2/ucoQwX5V.2uuUs4AD9pqp5zz5FrZaLvbsyGEOpwW', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(12, '46a8c134-b1b8-41a9-96d0-b8f0dceaf879', 'Bella', 'Balistreri', 'sjakubowski@example.com', '+1 604 804 9718', '2026-07-31 06:34:59', NULL, '$2y$12$am7qyfL0B46iF3pG7Wu5U.OFnn89f/.Apy99gxK3cUcLEIe1wy9Eu', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(13, '19023681-cd7d-4f21-9250-1d8f812e5306', 'Cheyenne', 'Parker', 'dabshire@example.net', '+1 604 522 0560', '2026-07-31 06:35:00', NULL, '$2y$12$Wxi3EKZlPQ2dxZ54WAiaD.btD9mefuDOrXw2sngXZynAHjvH.jZ4K', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(14, '18349546-4893-4585-b263-6b98eda61020', 'Emelie', 'Simonis', 'jayce66@example.org', '+1 604 224 6880', '2026-07-31 06:35:01', NULL, '$2y$12$b.MhG8Wt/8lj0qW5G78OAO7U2aXgG2x8LBBernnTHbmpW7tIkgWue', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(15, 'b23fb087-354c-496d-9eb9-01c3f47462a2', 'Jordy', 'Wisoky', 'treutel.lina@example.com', '+1 604 271 6289', '2026-07-31 06:35:01', NULL, '$2y$12$i4/L0nY/1aGkYl3IiLM0VeIIVQ0DAL.MeglRIe3M0M1AZHiydy.nm', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(16, '11332bac-dda0-4cf2-8f19-a5e2b16f68a1', 'Pearline', 'Orn', 'ferry.cristobal@example.net', '+1 604 526 6510', '2026-07-31 06:35:02', NULL, '$2y$12$9rloStm6i/Rzz8RZR/9kgeoyP95SRulXi8fOqkzKdyBOK.jVvlnwG', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(17, '1d47b605-3588-403d-9ecd-78a40d0140d8', 'Gabriel', 'Russel', 'jennie.koelpin@example.org', '+1 604 588 3326', '2026-07-31 06:35:02', NULL, '$2y$12$gaXsAakgmHVa1H6lQERzgO6Uly7zGvuPbpH/hOHChaVRu/RLCczXy', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(18, '8b0017c1-1958-4ebe-8442-1015c15740b6', 'Jamil', 'Stark', 'hane.will@example.org', '+1 604 111 0223', '2026-07-31 06:35:03', NULL, '$2y$12$aBurxL50fknOjqTsO5jOi.eqVRqOhKDc8Fk6sZV90crb4Zb/NqmK.', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(19, 'a94041da-2deb-46ab-b79f-81b972af7039', 'Colby', 'Gutkowski', 'mmosciski@example.org', '+1 604 851 4688', '2026-07-31 06:35:04', NULL, '$2y$12$1u.AhU/7NSabBpjoasm6iOuM1vEpu7.h1eZ2gWYqFBxx8I7SR0RfO', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:09', '2026-07-31 06:35:09', NULL),
(20, '97e302b3-3741-40d6-9ca5-7d41428a895b', 'Terrence', 'Jones', 'wisozk.emmalee@example.org', '+1 604 805 3617', '2026-07-31 06:35:04', NULL, '$2y$12$ZIncnoCsXL8NS366Xa23U.HEp48542B4Xu4BEM8knMRbMOeVlGC1G', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(21, '3267ff89-2889-4e18-a8c2-85f0e545322c', 'Avis', 'Nicolas', 'kiehn.pasquale@example.com', '+1 604 120 3736', '2026-07-31 06:35:05', NULL, '$2y$12$7tVO/8t9bIis34qZhkmeSuUyfeknBDKXdz.Rn7GfpyN4QxbSEe5km', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(22, 'eef83921-13c5-460a-a1e0-cb63ca7fc77f', 'Marjorie', 'Mann', 'zkreiger@example.org', '+1 604 426 0124', '2026-07-31 06:35:05', NULL, '$2y$12$m1uA.gPbsp.F8CgvQalr7ul/l5tVqsh/T4gaQxIqpm0wTNrjARV5q', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(23, 'c915d00c-8e4a-4c7d-9160-44482b0ce104', 'Arnaldo', 'Torphy', 'smitham.dedrick@example.org', '+1 604 465 2298', '2026-07-31 06:35:06', NULL, '$2y$12$XAB41KvgJuiAzwkxcnZCOuDhDgD3dfeUUiMZW7DSHVZ.mPb/t3ziG', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(24, '18e24662-0c62-4d45-be8d-43b4de9f080e', 'Kamren', 'Muller', 'maurine.nicolas@example.org', '+1 604 260 4488', '2026-07-31 06:35:06', NULL, '$2y$12$MtS7m9J6wocIX/hj4eLGzu/w/aiBcDdyj10hELyOUpBT81B.ovF0e', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(25, '4d1de7c1-fa1f-40c4-9827-7e0ad4da362b', 'Jermey', 'Gulgowski', 'jorge71@example.org', '+1 604 594 8881', '2026-07-31 06:35:07', NULL, '$2y$12$Bt4rfQbcZeWATXhi/jWa8u89fwlVfiDjn65S5wnDh6QUdQpbmCQB2', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(26, '36b955f8-4110-4268-b4f5-78b12992f3b9', 'Gardner', 'Gleason', 'alfredo66@example.com', '+1 604 429 0967', '2026-07-31 06:35:07', NULL, '$2y$12$VsgT0zDijP5Gdk1ksIx4eu86cMBnsh0T.opHsmc7uctJ44T2iN00S', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(27, '05cc1020-7f53-488f-be70-dd9cd0cd113d', 'Raphaelle', 'Jenkins', 'camila.daugherty@example.com', '+1 604 474 8733', '2026-07-31 06:35:08', NULL, '$2y$12$5rzMa632EpSnj34rBONyeenUBdZ.24Fj8engkTrT1ra8qkXA6IQNy', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(28, '60ffa0b8-e56b-455c-90e0-d033f52b4309', 'Vena', 'Sauer', 'ilehner@example.org', '+1 604 401 6157', '2026-07-31 06:35:08', NULL, '$2y$12$3LS.IIP.t4Xx1UrBy0AU4.DJxshQ0MXI.MEooFP13EcV1ATwZLY0G', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL),
(29, '6ed38e23-08b7-4b73-8457-aa8e4d2ccd4d', 'Jo', 'Kreiger', 'bosco.frankie@example.com', '+1 604 693 1607', '2026-07-31 06:35:08', NULL, '$2y$12$to9sK5kHteY4P140xj5JKe/jombSFi5JvOmKV2l6nwZCRpEadu8WC', NULL, 'active', 'en', 'America/Vancouver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 06:35:10', '2026-07-31 06:35:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webhook_events`
--

CREATE TABLE `webhook_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway` varchar(32) NOT NULL,
  `event_id` varchar(255) NOT NULL,
  `type` varchar(120) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `processed_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'received',
  `error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'text',
  `title` varchar(160) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `area`, `type`, `title`, `content`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'footer_1', 'text', 'Pacific Tours Canada', '[]', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(2, 'footer_2', 'links', 'Company', '[]', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(3, 'footer_3', 'contact', 'Talk to us', '[]', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51'),
(4, 'footer_4', 'newsletter', 'Trip ideas by email', '[]', 0, 1, '2026-07-31 06:34:51', '2026-07-31 06:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_type_index` (`type`),
  ADD KEY `banners_is_active_index` (`is_active`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `bookings_booking_number_unique` (`booking_number`),
  ADD KEY `bookings_tour_id_foreign` (`tour_id`),
  ADD KEY `bookings_tour_departure_id_foreign` (`tour_departure_id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_coupon_id_foreign` (`coupon_id`),
  ADD KEY `bookings_created_by_foreign` (`created_by`),
  ADD KEY `bookings_status_travel_date_index` (`status`,`travel_date`),
  ADD KEY `bookings_created_at_status_index` (`created_at`,`status`),
  ADD KEY `bookings_travel_date_index` (`travel_date`),
  ADD KEY `bookings_status_index` (`status`),
  ADD KEY `bookings_payment_status_index` (`payment_status`);

--
-- Indexes for table `booking_status_histories`
--
ALTER TABLE `booking_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_status_histories_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_status_histories_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_travelers_booking_id_type_index` (`booking_id`,`type`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_country_id_slug_unique` (`country_id`,`slug`),
  ADD KEY `cities_is_active_index` (`is_active`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_messages_is_read_index` (`is_read`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_slug_unique` (`slug`),
  ADD UNIQUE KEY `countries_iso2_unique` (`iso2`),
  ADD KEY `countries_is_active_index` (`is_active`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_created_by_foreign` (`created_by`),
  ADD KEY `coupons_expires_at_index` (`expires_at`),
  ADD KEY `coupons_is_active_index` (`is_active`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_coupon_id_user_id_index` (`coupon_id`,`user_id`),
  ADD KEY `coupon_usages_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Indexes for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `destinations_slug_unique` (`slug`),
  ADD KEY `destinations_country_id_foreign` (`country_id`),
  ADD KEY `destinations_city_id_foreign` (`city_id`),
  ADD KEY `destinations_is_featured_index` (`is_featured`),
  ADD KEY `destinations_is_active_index` (`is_active`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_category_index` (`category`);

--
-- Indexes for table `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flash_sales_ends_at_index` (`ends_at`),
  ADD KEY `flash_sales_is_active_index` (`is_active`);

--
-- Indexes for table `flash_sale_tour`
--
ALTER TABLE `flash_sale_tour`
  ADD PRIMARY KEY (`flash_sale_id`,`tour_id`),
  ADD KEY `flash_sale_tour_tour_id_foreign` (`tour_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `galleries_slug_unique` (`slug`),
  ADD KEY `galleries_destination_id_foreign` (`destination_id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_images_gallery_id_foreign` (`gallery_id`);

--
-- Indexes for table `home_features`
--
ALTER TABLE `home_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_features_is_active_sort_order_index` (`is_active`,`sort_order`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_booking_id_foreign` (`booking_id`),
  ADD KEY `invoices_status_index` (`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_location_unique` (`location`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_items_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_updated_by_foreign` (`updated_by`),
  ADD KEY `pages_status_index` (`status`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `payments_gateway_transaction_id_unique` (`gateway`,`transaction_id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_gateway_index` (`gateway`),
  ADD KEY `payments_transaction_id_index` (`transaction_id`),
  ADD KEY `payments_status_index` (`status`),
  ADD KEY `payments_paid_at_index` (`paid_at`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_logs_payment_id_foreign` (`payment_id`),
  ADD KEY `payment_logs_gateway_index` (`gateway`),
  ADD KEY `payment_logs_event_index` (`event`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_post_category_id_foreign` (`post_category_id`),
  ADD KEY `posts_author_id_foreign` (`author_id`),
  ADD KEY `posts_type_index` (`type`),
  ADD KEY `posts_status_index` (`status`),
  ADD KEY `posts_published_at_index` (`published_at`);
ALTER TABLE `posts` ADD FULLTEXT KEY `posts_title_excerpt_content_fulltext` (`title`,`excerpt`,`content`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_categories_slug_unique` (`slug`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `refunds_uuid_unique` (`uuid`),
  ADD KEY `refunds_payment_id_foreign` (`payment_id`),
  ADD KEY `refunds_booking_id_foreign` (`booking_id`),
  ADD KEY `refunds_requested_by_foreign` (`requested_by`),
  ADD KEY `refunds_processed_by_foreign` (`processed_by`),
  ADD KEY `refunds_status_index` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_uuid_unique` (`uuid`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_booking_id_foreign` (`booking_id`),
  ADD KEY `reviews_approved_by_foreign` (`approved_by`),
  ADD KEY `reviews_tour_id_status_index` (`tour_id`,`status`),
  ADD KEY `reviews_status_index` (`status`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_images_review_id_foreign` (`review_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `seo_meta`
--
ALTER TABLE `seo_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_meta_seoable_type_seoable_id_index` (`seoable_type`,`seoable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_group_key_unique` (`group`,`key`),
  ADD KEY `settings_group_index` (`group`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`),
  ADD KEY `tags_type_index` (`type`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_is_active_index` (`is_active`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_booking_id_foreign` (`booking_id`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_priority_index` (`priority`),
  ADD KEY `tickets_status_index` (`status`);

--
-- Indexes for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_attachments_ticket_message_id_foreign` (`ticket_message_id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tours_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `tours_code_unique` (`code`),
  ADD UNIQUE KEY `tours_slug_unique` (`slug`),
  ADD KEY `tours_tour_category_id_foreign` (`tour_category_id`),
  ADD KEY `tours_destination_id_foreign` (`destination_id`),
  ADD KEY `tours_country_id_foreign` (`country_id`),
  ADD KEY `tours_city_id_foreign` (`city_id`),
  ADD KEY `tours_created_by_foreign` (`created_by`),
  ADD KEY `tours_updated_by_foreign` (`updated_by`),
  ADD KEY `tours_status_is_featured_sale_price_index` (`status`,`is_featured`,`sale_price`),
  ADD KEY `tours_sale_price_index` (`sale_price`),
  ADD KEY `tours_status_index` (`status`),
  ADD KEY `tours_is_featured_index` (`is_featured`),
  ADD KEY `tours_is_popular_index` (`is_popular`),
  ADD KEY `tours_is_recommended_index` (`is_recommended`),
  ADD KEY `tours_average_rating_index` (`average_rating`),
  ADD KEY `tours_published_at_index` (`published_at`);
ALTER TABLE `tours` ADD FULLTEXT KEY `tours_title_summary_description_fulltext` (`title`,`summary`,`description`);

--
-- Indexes for table `tour_categories`
--
ALTER TABLE `tour_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tour_categories_slug_unique` (`slug`),
  ADD KEY `tour_categories_parent_id_foreign` (`parent_id`),
  ADD KEY `tour_categories_is_active_index` (`is_active`);

--
-- Indexes for table `tour_departures`
--
ALTER TABLE `tour_departures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tour_departures_tour_id_start_date_unique` (`tour_id`,`start_date`),
  ADD UNIQUE KEY `tour_departures_uuid_unique` (`uuid`),
  ADD KEY `tour_departures_start_date_index` (`start_date`),
  ADD KEY `tour_departures_status_index` (`status`);

--
-- Indexes for table `tour_faqs`
--
ALTER TABLE `tour_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_faqs_tour_id_foreign` (`tour_id`);

--
-- Indexes for table `tour_highlights`
--
ALTER TABLE `tour_highlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_highlights_tour_id_foreign` (`tour_id`);

--
-- Indexes for table `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_images_tour_id_foreign` (`tour_id`);

--
-- Indexes for table `tour_inclusions`
--
ALTER TABLE `tour_inclusions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_inclusions_tour_id_type_index` (`tour_id`,`type`);

--
-- Indexes for table `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tour_itineraries_tour_id_day_number_unique` (`tour_id`,`day_number`);

--
-- Indexes for table `tour_tag`
--
ALTER TABLE `tour_tag`
  ADD PRIMARY KEY (`tour_id`,`tag_id`),
  ADD KEY `tour_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_unique` (`translatable_type`,`translatable_id`,`locale`,`field`),
  ADD KEY `translations_translatable_type_translatable_id_index` (`translatable_type`,`translatable_id`),
  ADD KEY `translations_locale_index` (`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_phone_index` (`phone`),
  ADD KEY `users_status_index` (`status`);

--
-- Indexes for table `webhook_events`
--
ALTER TABLE `webhook_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `webhook_events_gateway_event_id_unique` (`gateway`,`event_id`),
  ADD KEY `webhook_events_gateway_index` (`gateway`),
  ADD KEY `webhook_events_event_id_index` (`event_id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `widgets_area_index` (`area`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_tour_id_unique` (`user_id`,`tour_id`),
  ADD KEY `wishlists_tour_id_foreign` (`tour_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_status_histories`
--
ALTER TABLE `booking_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_features`
--
ALTER TABLE `home_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seo_meta`
--
ALTER TABLE `seo_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tour_departures`
--
ALTER TABLE `tour_departures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `tour_faqs`
--
ALTER TABLE `tour_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_highlights`
--
ALTER TABLE `tour_highlights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_inclusions`
--
ALTER TABLE `tour_inclusions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `webhook_events`
--
ALTER TABLE `webhook_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_tour_departure_id_foreign` FOREIGN KEY (`tour_departure_id`) REFERENCES `tour_departures` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_status_histories`
--
ALTER TABLE `booking_status_histories`
  ADD CONSTRAINT `booking_status_histories_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_status_histories_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD CONSTRAINT `booking_travelers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD CONSTRAINT `customer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `destinations_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `destinations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flash_sale_tour`
--
ALTER TABLE `flash_sale_tour`
  ADD CONSTRAINT `flash_sale_tour_flash_sale_id_foreign` FOREIGN KEY (`flash_sale_id`) REFERENCES `flash_sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flash_sale_tour_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `refunds_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_ticket_message_id_foreign` FOREIGN KEY (`ticket_message_id`) REFERENCES `ticket_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tours_tour_category_id_foreign` FOREIGN KEY (`tour_category_id`) REFERENCES `tour_categories` (`id`),
  ADD CONSTRAINT `tours_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tour_categories`
--
ALTER TABLE `tour_categories`
  ADD CONSTRAINT `tour_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tour_departures`
--
ALTER TABLE `tour_departures`
  ADD CONSTRAINT `tour_departures_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_faqs`
--
ALTER TABLE `tour_faqs`
  ADD CONSTRAINT `tour_faqs_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_highlights`
--
ALTER TABLE `tour_highlights`
  ADD CONSTRAINT `tour_highlights_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `tour_images_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_inclusions`
--
ALTER TABLE `tour_inclusions`
  ADD CONSTRAINT `tour_inclusions_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  ADD CONSTRAINT `tour_itineraries_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_tag`
--
ALTER TABLE `tour_tag`
  ADD CONSTRAINT `tour_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_tag_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
