-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2026 at 12:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:20:08', '2026-07-19 06:20:08'),
(2, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:31:49', '2026-07-19 06:31:49'),
(3, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:37:16', '2026-07-19 06:37:16'),
(4, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:40:01', '2026-07-19 06:40:01'),
(5, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:40:09', '2026-07-19 06:40:09'),
(6, 1, 'logout', NULL, NULL, 'User Sadeep logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:45:50', '2026-07-19 06:45:50'),
(7, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:46:00', '2026-07-19 06:46:00'),
(8, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:46:30', '2026-07-19 06:46:30'),
(9, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:46:36', '2026-07-19 06:46:36'),
(10, 10, 'updated', 'App\\Models\\User', 11, 'Updated User #11 (Fields changed: password)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:50:14', '2026-07-19 06:50:14'),
(11, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:50:20', '2026-07-19 06:50:20'),
(12, 11, 'login', NULL, NULL, 'User Ravindu Senanayake logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 06:50:32', '2026-07-19 06:50:32'),
(13, 11, 'logout', NULL, NULL, 'User Ravindu Senanayake logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 07:00:19', '2026-07-19 07:00:19'),
(14, 11, 'login', NULL, NULL, 'User Ravindu Senanayake logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 07:00:38', '2026-07-19 07:00:38'),
(15, 11, 'created', 'App\\Models\\Customer', 23, 'Created Customer #23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 07:07:51', '2026-07-19 07:07:51'),
(16, 11, 'logout', NULL, NULL, 'User Ravindu Senanayake logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 07:08:34', '2026-07-19 07:08:34'),
(17, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 07:08:43', '2026-07-19 07:08:43'),
(18, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 13:36:09', '2026-07-19 13:36:09'),
(19, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@hms.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 13:45:09', '2026-07-19 13:45:09'),
(20, 10, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 13:46:21', '2026-07-19 13:46:21'),
(21, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 13:46:45', '2026-07-19 13:46:45'),
(22, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 13:48:12', '2026-07-19 13:48:12'),
(23, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:12:52', '2026-07-19 14:12:52'),
(24, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:37:35', '2026-07-19 14:37:35'),
(25, 10, 'created', 'App\\Models\\Reservation', 17, 'Created Reservation #17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:40:38', '2026-07-19 14:40:38'),
(26, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:40:54', '2026-07-19 14:40:54'),
(27, 11, 'login', NULL, NULL, 'User Ravindu Senanayake logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:41:04', '2026-07-19 14:41:04'),
(28, 11, 'logout', NULL, NULL, 'User Ravindu Senanayake logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:44:04', '2026-07-19 14:44:04'),
(29, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:44:18', '2026-07-19 14:44:18'),
(30, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@example.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:57:53', '2026-07-19 14:57:53'),
(31, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@admin.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:58:07', '2026-07-19 14:58:07'),
(32, 3, 'failed_login', NULL, NULL, 'Failed login attempt for email: chamari.j@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 14:59:56', '2026-07-19 14:59:56'),
(33, 3, 'login', NULL, NULL, 'User Chamari Jayasuriya logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:00:42', '2026-07-19 15:00:42'),
(34, 4, 'created', 'App\\Models\\Invoice', 21, 'Created Invoice #21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(35, 4, 'created', 'App\\Models\\Payment', 27, 'Created Payment #27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(36, 4, 'updated', 'App\\Models\\Invoice', 21, 'Updated Invoice #21 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(37, 4, 'updated', 'App\\Models\\Reservation', 17, 'Updated Reservation #17 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(38, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:34', '2026-07-19 15:08:34'),
(39, 11, 'login', NULL, NULL, 'User Ravindu Senanayake logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:08:41', '2026-07-19 15:08:41'),
(40, 11, 'logout', NULL, NULL, 'User Ravindu Senanayake logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:09:12', '2026-07-19 15:09:12'),
(41, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:09:23', '2026-07-19 15:09:23'),
(42, 10, 'updated', 'App\\Models\\Staff', 19, 'Updated Staff #19 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:10:34', '2026-07-19 15:10:34'),
(43, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:49:48', '2026-07-19 15:49:48'),
(44, 11, 'login', NULL, NULL, 'User Ravindu Senanayake logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:52:07', '2026-07-19 15:52:07'),
(45, 11, 'created', 'App\\Models\\Reservation', 18, 'Created Reservation #18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:52:28', '2026-07-19 15:52:28'),
(46, 11, 'logout', NULL, NULL, 'User Ravindu Senanayake logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:52:57', '2026-07-19 15:52:57'),
(47, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:04', '2026-07-19 15:53:04'),
(48, 4, 'created', 'App\\Models\\Invoice', 22, 'Created Invoice #22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(49, 4, 'created', 'App\\Models\\Payment', 28, 'Created Payment #28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(50, 4, 'updated', 'App\\Models\\Invoice', 22, 'Updated Invoice #22 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(51, 4, 'updated', 'App\\Models\\Reservation', 18, 'Updated Reservation #18 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(52, 4, 'updated', 'App\\Models\\Invoice', 22, 'Updated Invoice #22 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(53, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 16:10:20', '2026-07-19 16:10:20'),
(54, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 16:10:42', '2026-07-19 16:10:42'),
(55, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 16:11:02', '2026-07-19 16:11:02'),
(56, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 16:11:12', '2026-07-19 16:11:12'),
(57, 1, 'logout', NULL, NULL, 'User Sadeep logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-19 16:32:35', '2026-07-19 16:32:35'),
(58, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 03:59:52', '2026-07-20 03:59:52'),
(59, 1, 'created', 'App\\Models\\Reservation', 19, 'Created Reservation #19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:06', '2026-07-20 04:01:06'),
(60, 1, 'created', 'App\\Models\\Invoice', 23, 'Created Invoice #23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(61, 1, 'created', 'App\\Models\\Payment', 29, 'Created Payment #29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(62, 1, 'updated', 'App\\Models\\Invoice', 23, 'Updated Invoice #23 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(63, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(64, 1, 'updated', 'App\\Models\\Invoice', 23, 'Updated Invoice #23 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(65, 1, 'updated', 'App\\Models\\Customer', 23, 'Updated Customer #23 (Fields changed: phone, address, city, postal_code, country)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:03:10', '2026-07-20 04:03:10'),
(66, 1, 'updated', 'App\\Models\\Room', 8, 'Updated Room #8 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:10:31', '2026-07-20 04:10:31'),
(67, NULL, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:11:37', '2026-07-20 04:11:37'),
(68, NULL, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:11:37', '2026-07-20 04:11:37'),
(69, NULL, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:11:44', '2026-07-20 04:11:44'),
(70, NULL, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:11:44', '2026-07-20 04:11:44'),
(71, NULL, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:11:59', '2026-07-20 04:11:59'),
(72, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:15:20', '2026-07-20 04:15:20'),
(73, 1, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:15:20', '2026-07-20 04:15:20'),
(74, NULL, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: check_out_date)', '127.0.0.1', 'Symfony', '2026-07-20 04:19:21', '2026-07-20 04:19:21'),
(75, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '127.0.0.1', 'Symfony', '2026-07-20 04:19:21', '2026-07-20 04:19:21'),
(76, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:19:21', '2026-07-20 04:19:21'),
(77, 1, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:19:21', '2026-07-20 04:19:21'),
(78, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:19:21', '2026-07-20 04:19:21'),
(79, NULL, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:22:24', '2026-07-20 04:22:24'),
(80, NULL, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:22:24', '2026-07-20 04:22:24'),
(81, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '127.0.0.1', 'Symfony', '2026-07-20 04:22:24', '2026-07-20 04:22:24'),
(82, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 07:30:00', '2026-07-20 07:30:00'),
(83, 1, 'updated', 'App\\Models\\Room', 2, 'Updated Room #2 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 07:30:00', '2026-07-20 07:30:00'),
(84, 1, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '127.0.0.1', 'Symfony', '2026-07-20 04:22:24', '2026-07-20 04:22:24'),
(85, 1, 'logout', NULL, NULL, 'User Sadeep logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 04:43:32', '2026-07-20 04:43:32'),
(86, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 13:28:10', '2026-07-20 13:28:10'),
(87, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 13:46:17', '2026-07-20 13:46:17'),
(88, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:15:25', '2026-07-20 14:15:25'),
(89, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:16:39', '2026-07-20 14:16:39'),
(90, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@hms.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:22:33', '2026-07-20 14:22:33'),
(91, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@hms.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:22:54', '2026-07-20 14:22:54'),
(92, NULL, 'failed_login', NULL, NULL, 'Failed login attempt for email: admin@hms.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:24:02', '2026-07-20 14:24:02'),
(93, NULL, 'created', 'App\\Models\\User', 13, 'Created User #13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:25:15', '2026-07-20 14:25:15'),
(94, NULL, 'created', 'App\\Models\\Customer', 24, 'Created Customer #24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:25:15', '2026-07-20 14:25:15'),
(95, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:25:15', '2026-07-20 14:25:15'),
(96, 13, 'logout', NULL, NULL, 'User Admin User logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 14:46:14', '2026-07-20 14:46:14'),
(97, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:10:02', '2026-07-20 15:10:02'),
(98, 10, 'updated', 'App\\Models\\User', 13, 'Updated User #13 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:10:19', '2026-07-20 15:10:19'),
(99, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:26:26', '2026-07-20 15:26:26'),
(100, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:39:10', '2026-07-20 15:39:10'),
(101, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:43:08', '2026-07-20 15:43:08'),
(102, 4, 'login', NULL, NULL, 'User Thilina Fernando logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:43:17', '2026-07-20 15:43:17'),
(103, 4, 'logout', NULL, NULL, 'User Thilina Fernando logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:43:30', '2026-07-20 15:43:30'),
(104, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:43:38', '2026-07-20 15:43:38'),
(105, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:49:49', '2026-07-20 15:49:49'),
(106, 1, 'logout', NULL, NULL, 'User Sadeep logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:49:51', '2026-07-20 15:49:51'),
(107, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:49:59', '2026-07-20 15:49:59'),
(108, 10, 'updated', 'App\\Models\\User', 13, 'Updated User #13 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:50:08', '2026-07-20 15:50:08'),
(109, 10, 'updated', 'App\\Models\\User', 13, 'Updated User #13 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:50:09', '2026-07-20 15:50:09'),
(110, 10, 'updated', 'App\\Models\\User', 13, 'Updated User #13 (Fields changed: role)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 15:50:30', '2026-07-20 15:50:30'),
(111, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-23 09:04:01', '2026-07-23 09:04:01'),
(112, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-23 09:16:25', '2026-07-23 09:16:25'),
(113, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-23 13:13:51', '2026-07-23 13:13:51'),
(114, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-23 13:46:10', '2026-07-23 13:46:10'),
(115, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 15:04:18', '2026-07-24 15:04:18'),
(116, 13, 'logout', NULL, NULL, 'User Admin User logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 15:06:39', '2026-07-24 15:06:39'),
(117, 1, 'login', NULL, NULL, 'User Sadeep logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 15:07:04', '2026-07-24 15:07:04'),
(118, 1, 'logout', NULL, NULL, 'User Sadeep logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 15:24:08', '2026-07-24 15:24:08'),
(119, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:19:39', '2026-07-27 04:19:39'),
(120, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:19:39', '2026-07-27 04:19:39'),
(121, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:34:53', '2026-07-27 04:34:53'),
(122, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:35:31', '2026-07-27 04:35:31'),
(123, 10, 'updated', 'App\\Models\\Customer', 24, 'Updated Customer #24 (Fields changed: name, email, phone, address, city, postal_code, country)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:37:07', '2026-07-27 04:37:07'),
(124, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:52:20', '2026-07-27 04:52:20'),
(125, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:55:44', '2026-07-27 04:55:44'),
(126, 13, 'created', 'App\\Models\\Customer', 25, 'Created Customer #25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 04:56:27', '2026-07-27 04:56:27'),
(127, 13, 'updated', 'App\\Models\\Customer', 25, 'Updated Customer #25 (Fields changed: nic_passport)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 05:01:15', '2026-07-27 05:01:15'),
(128, 13, 'logout', NULL, NULL, 'User Admin User logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 05:16:19', '2026-07-27 05:16:19'),
(129, NULL, 'updated', 'App\\Models\\Customer', 1, 'Updated Customer #1 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(130, NULL, 'updated', 'App\\Models\\Customer', 2, 'Updated Customer #2 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(131, NULL, 'updated', 'App\\Models\\Customer', 3, 'Updated Customer #3 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(132, NULL, 'updated', 'App\\Models\\Customer', 10, 'Updated Customer #10 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(133, NULL, 'updated', 'App\\Models\\Customer', 11, 'Updated Customer #11 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(134, NULL, 'updated', 'App\\Models\\Customer', 12, 'Updated Customer #12 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(135, NULL, 'updated', 'App\\Models\\Customer', 13, 'Updated Customer #13 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(136, NULL, 'updated', 'App\\Models\\Customer', 14, 'Updated Customer #14 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(137, NULL, 'updated', 'App\\Models\\Customer', 15, 'Updated Customer #15 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(138, NULL, 'updated', 'App\\Models\\Customer', 16, 'Updated Customer #16 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(139, NULL, 'updated', 'App\\Models\\Customer', 17, 'Updated Customer #17 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(140, NULL, 'updated', 'App\\Models\\Customer', 18, 'Updated Customer #18 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(141, NULL, 'updated', 'App\\Models\\Customer', 19, 'Updated Customer #19 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(142, NULL, 'updated', 'App\\Models\\Customer', 20, 'Updated Customer #20 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(143, NULL, 'updated', 'App\\Models\\Customer', 21, 'Updated Customer #21 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(144, NULL, 'updated', 'App\\Models\\Customer', 23, 'Updated Customer #23 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(145, NULL, 'updated', 'App\\Models\\Customer', 24, 'Updated Customer #24 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(146, NULL, 'updated', 'App\\Models\\Customer', 25, 'Updated Customer #25 (Fields changed: nic_passport)', '127.0.0.1', 'Symfony', '2026-07-27 09:51:54', '2026-07-27 09:51:54'),
(147, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 09:54:01', '2026-07-27 09:54:01'),
(148, NULL, 'updated', 'App\\Models\\Staff', 17, 'Updated Staff #17 (Fields changed: nic)', '127.0.0.1', 'Symfony', '2026-07-27 09:59:17', '2026-07-27 09:59:17'),
(149, NULL, 'updated', 'App\\Models\\Staff', 19, 'Updated Staff #19 (Fields changed: nic)', '127.0.0.1', 'Symfony', '2026-07-27 09:59:17', '2026-07-27 09:59:17'),
(150, NULL, 'updated', 'App\\Models\\Staff', 20, 'Updated Staff #20 (Fields changed: nic)', '127.0.0.1', 'Symfony', '2026-07-27 09:59:17', '2026-07-27 09:59:17'),
(151, NULL, 'updated', 'App\\Models\\Staff', 21, 'Updated Staff #21 (Fields changed: nic)', '127.0.0.1', 'Symfony', '2026-07-27 09:59:17', '2026-07-27 09:59:17'),
(152, NULL, 'updated', 'App\\Models\\Staff', 22, 'Updated Staff #22 (Fields changed: nic)', '127.0.0.1', 'Symfony', '2026-07-27 09:59:17', '2026-07-27 09:59:17'),
(153, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:00:13', '2026-07-27 10:00:13'),
(154, 13, 'login', NULL, NULL, 'User Admin User logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:01:39', '2026-07-27 10:01:39'),
(155, 13, 'created', 'App\\Models\\Staff', 23, 'Created Staff #23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:02:52', '2026-07-27 10:02:52'),
(156, 13, 'logout', NULL, NULL, 'User Admin User logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:03:36', '2026-07-27 10:03:36'),
(157, NULL, 'created', 'App\\Models\\User', 14, 'Created User #14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:04:46', '2026-07-27 10:04:46'),
(158, NULL, 'created', 'App\\Models\\Customer', 26, 'Created Customer #26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:04:46', '2026-07-27 10:04:46'),
(159, 14, 'login', NULL, NULL, 'User Charlie Guest logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:04:46', '2026-07-27 10:04:46'),
(160, 14, 'logout', NULL, NULL, 'User Charlie Guest logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:09:27', '2026-07-27 10:09:27'),
(161, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:09:47', '2026-07-27 10:09:47'),
(162, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:13:38', '2026-07-27 10:13:38'),
(163, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:15:51', '2026-07-27 10:15:51'),
(164, NULL, 'created', 'App\\Models\\Setting', 1, 'Created Setting #1', '127.0.0.1', 'Symfony', '2026-07-27 10:18:21', '2026-07-27 10:18:21'),
(165, NULL, 'created', 'App\\Models\\RoomType', 7, 'Created RoomType #7', '127.0.0.1', 'Symfony', '2026-07-27 10:18:21', '2026-07-27 10:18:21'),
(166, NULL, 'created', 'App\\Models\\RoomType', 8, 'Created RoomType #8', '127.0.0.1', 'Symfony', '2026-07-27 10:18:21', '2026-07-27 10:18:21'),
(167, NULL, 'created', 'App\\Models\\RoomType', 9, 'Created RoomType #9', '127.0.0.1', 'Symfony', '2026-07-27 10:18:21', '2026-07-27 10:18:21'),
(168, 10, 'logout', NULL, NULL, 'User Sachintha Soysa logged out.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:21:01', '2026-07-27 10:21:01'),
(169, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-27 10:21:54', '2026-07-27 10:21:54'),
(170, 10, 'login', NULL, NULL, 'User Sachintha Soysa logged in successfully.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 09:43:09', '2026-08-01 09:43:09'),
(171, 10, 'created', 'App\\Models\\Invoice', 24, 'Created Invoice #24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(172, 10, 'created', 'App\\Models\\Payment', 30, 'Created Payment #30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(173, 10, 'updated', 'App\\Models\\Invoice', 24, 'Updated Invoice #24 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(174, 10, 'updated', 'App\\Models\\Invoice', 24, 'Updated Invoice #24 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(175, 10, 'updated', 'App\\Models\\Reservation', 8, 'Updated Reservation #8 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:12:20', '2026-08-01 10:12:20'),
(176, 10, 'updated', 'App\\Models\\Reservation', 8, 'Updated Reservation #8 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:13:22', '2026-08-01 10:13:22'),
(177, 10, 'updated', 'App\\Models\\Reservation', 7, 'Updated Reservation #7 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(178, 10, 'updated', 'App\\Models\\Reservation', 7, 'Updated Reservation #7 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(179, 10, 'updated', 'App\\Models\\Reservation', 11, 'Updated Reservation #11 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(180, 10, 'updated', 'App\\Models\\Reservation', 11, 'Updated Reservation #11 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(181, 10, 'updated', 'App\\Models\\Reservation', 12, 'Updated Reservation #12 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(182, 10, 'updated', 'App\\Models\\Reservation', 12, 'Updated Reservation #12 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(183, 10, 'updated', 'App\\Models\\Reservation', 13, 'Updated Reservation #13 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(184, 10, 'updated', 'App\\Models\\Reservation', 13, 'Updated Reservation #13 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(185, 10, 'updated', 'App\\Models\\Reservation', 18, 'Updated Reservation #18 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(186, 10, 'updated', 'App\\Models\\Reservation', 18, 'Updated Reservation #18 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(187, 10, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(188, 10, 'updated', 'App\\Models\\Reservation', 19, 'Updated Reservation #19 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:15:52', '2026-08-01 10:15:52'),
(189, 10, 'created', 'App\\Models\\Invoice', 25, 'Created Invoice #25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(190, 10, 'created', 'App\\Models\\Payment', 31, 'Created Payment #31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(191, 10, 'updated', 'App\\Models\\Invoice', 25, 'Updated Invoice #25 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(192, 10, 'updated', 'App\\Models\\Invoice', 25, 'Updated Invoice #25 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(193, 10, 'updated', 'App\\Models\\Reservation', 2, 'Updated Reservation #2 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(194, 10, 'created', 'App\\Models\\Invoice', 26, 'Created Invoice #26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(195, 10, 'created', 'App\\Models\\Payment', 32, 'Created Payment #32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(196, 10, 'updated', 'App\\Models\\Invoice', 26, 'Updated Invoice #26 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(197, 10, 'updated', 'App\\Models\\Invoice', 26, 'Updated Invoice #26 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(198, 10, 'updated', 'App\\Models\\Reservation', 3, 'Updated Reservation #3 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(199, 10, 'created', 'App\\Models\\Invoice', 27, 'Created Invoice #27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(200, 10, 'created', 'App\\Models\\Payment', 33, 'Created Payment #33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(201, 10, 'updated', 'App\\Models\\Invoice', 27, 'Updated Invoice #27 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(202, 10, 'updated', 'App\\Models\\Invoice', 27, 'Updated Invoice #27 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(203, 10, 'updated', 'App\\Models\\Reservation', 6, 'Updated Reservation #6 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(204, 10, 'created', 'App\\Models\\Invoice', 28, 'Created Invoice #28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(205, 10, 'created', 'App\\Models\\Payment', 34, 'Created Payment #34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(206, 10, 'updated', 'App\\Models\\Invoice', 28, 'Updated Invoice #28 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(207, 10, 'updated', 'App\\Models\\Invoice', 28, 'Updated Invoice #28 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(208, 10, 'updated', 'App\\Models\\Reservation', 9, 'Updated Reservation #9 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(209, 10, 'created', 'App\\Models\\Invoice', 29, 'Created Invoice #29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:59', '2026-08-01 10:28:59'),
(210, 10, 'created', 'App\\Models\\Payment', 35, 'Created Payment #35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:59', '2026-08-01 10:28:59'),
(211, 10, 'updated', 'App\\Models\\Invoice', 29, 'Updated Invoice #29 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:59', '2026-08-01 10:28:59'),
(212, 10, 'updated', 'App\\Models\\Invoice', 29, 'Updated Invoice #29 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:28:59', '2026-08-01 10:28:59'),
(213, 10, 'updated', 'App\\Models\\Reservation', 10, 'Updated Reservation #10 (Fields changed: status)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-01 10:29:00', '2026-08-01 10:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('success','info','warning','danger') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `link`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Notification', 'This is a test notification to verify the alerts dropdown.', 'info', 1, NULL, '2026-07-24 15:03:27', '2026-07-24 15:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nic_passport` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `nic_passport`, `address`, `city`, `state`, `postal_code`, `country`, `loyalty_points`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Sadeep', 'sadeepsachintha98@gmail.com', '+94763928333', '948608529V', '51, Railway Station Rd, Angulana, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 10:23:01', '2026-07-27 09:51:54'),
(2, 'Amali', 'amali@mail.com', '+94763928334', '199260142672', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 11:54:30', '2026-07-27 09:51:54'),
(3, 'Kamali', 'kamali@mail.com', '+94763928338', '926256113V', '51, Railway Station Rd, Kalutara.', 'Kalutara', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 12:36:45', '2026-07-27 09:51:54'),
(10, 'Sadeep Sachintha', 'sadeep@gmail.com', '+94763922333', '199966510114', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(11, 'Amal Fonseka', 'amal@mail.com', '+94763928334', '959540876V', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(12, 'Kamal Silva', 'kamal@mail.com', '+94763928338', '199529835679', '51, Railway Station Rd, Kalutara.', 'Kalutara', 'Kalutara', '10440', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(13, 'Sunil Perera', 'sunil@gmail.com', '+94722223239', '971696581V', '185 Prince Of Wales Avenue, Colombo 14', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(14, 'Anupa Mewan', 'anupa@gmail.com', '+94722223239', '199118970783', '188 New Chetty Street, Colombo  11', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(15, 'Sunimal Dias', 'sunimal@gmail.com', '+94729130691', '931669536V', '18 Street, Anne\'s Street', 'Kurunegala', 'Kurunegala', '08000', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(16, 'Kasun Fonseka', 'kasun@gmail.com', '+94752327083', '199054505333', '185 Prince Of Wales Avenue, Colombo 14', 'Colombo', 'Colombo', '01400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(17, 'Kamal Fernando', 'kamalf@mail.com', '+9472432615', '989705792V', '82 Old Moor Street, Colombo 12', 'Colombo', 'Colombo', '01200', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(18, 'Nimal Peiris', 'nimal@gmail.com', '+94722443239', '199139733843', '108 Dam Street, Colombo 12', 'Colombo', 'Colombo', '01200', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(19, 'Sadun Silva', 'sadun@gmail.com', '+94752327083', '916807869V', '99 Maradana Road, Colombo 08', 'Colombo', 'Colombo', '08000', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(20, 'Anil Dias', 'anil@gmail.com', '+94752327083', '199868329777', '88 New Chetty Street, Colombo  11', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2026-07-27 09:51:54'),
(21, 'Poodini', 'poodini@gmail.com', '+94770492690', '984428104V', '71,Station Rd,', 'Moratuwa', NULL, '10400', 'Sri Lanka', 0, NULL, '2026-07-17 05:50:06', '2026-07-27 09:51:54'),
(23, 'Ravindu Senanayake', 'ravindu.s@gmail.com', '+94770492690', '199332383394', '51,Station Rd,', 'Nittambuwa', NULL, '11880', 'Sri Lanka', 0, NULL, '2026-07-19 07:07:51', '2026-07-27 09:51:54'),
(24, 'Nadun Perera', 'nadun@gmail.com', '+94763921212', '951892825V', '60 Dangollawatta, Samagi Mawatha', 'Nittambuwa', NULL, '11880', 'Sri Lanka', 0, NULL, '2026-07-20 14:25:15', '2026-07-27 09:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `max_attendees` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('scheduled','in_progress','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_time`, `end_time`, `location`, `location_id`, `max_attendees`, `price`, `customer_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Grand Opening Ceremony', 'Join us for the grand opening of our new facility. Refreshments will be served.', '2025-07-01 10:00:00', '2025-07-01 13:00:00', 'Conference Room 1', 3, 50, 1000.00, 10, 'completed', 'Please RSVP by June 25th.', '2025-07-01 08:47:38', '2026-07-07 15:48:17'),
(2, 'Summer Networking Mixer', 'An evening of networking for local business professionals. Light snacks and drinks provided.', '2025-08-15 18:30:00', '2025-08-15 21:00:00', 'Rooftop Lounge', 2, 75, 1500.00, 17, 'completed', 'Bring business cards for the raffle.', '2025-07-01 08:52:29', '2026-07-07 15:43:55'),
(3, 'Tech Workshop: AI in Business', 'A hands-on workshop exploring the use of AI tools in modern business operations.', '2025-09-10 09:00:00', '2025-09-10 16:00:00', 'Training Room', 1, 30, 2500.00, 19, 'cancelled', 'Lunch and materials included.', '2025-07-01 08:54:51', '2026-07-07 15:44:08'),
(4, 'Annual Gala Dinner 2026', 'Join us for a luxurious evening of fine dining, live orchestra performance, and celebration at our grand ballroom.', '2026-11-20 19:00:00', '2026-11-20 23:00:00', 'Conference Room 1', 3, 200, 15000.00, 1, 'scheduled', NULL, NULL, NULL),
(5, 'New Year Eve Countdown Party', 'Celebrate the transition into the new year with gourmet food stations, premium cocktails, and a grand laser show under the stars.', '2026-12-31 21:00:00', '2027-01-01 01:00:00', 'Rooftop Lounge', 2, 150, 12000.00, 1, 'scheduled', NULL, NULL, NULL),
(6, 'Luxury Wedding Expo 2027', 'Meet the top wedding planners, florists, and designers in the region. Features a live runway show showcasing the latest bridal couture.', '2027-02-14 10:00:00', '2027-02-14 18:00:00', 'Conference Room 1', 3, 300, 2500.00, 1, 'scheduled', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_locations`
--

CREATE TABLE `event_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_locations`
--

INSERT INTO `event_locations` (`id`, `name`, `capacity`, `description`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Training Room', 100, 'A state-of-the-art training space equipped with modern audiovisual facilities, ergonomic seating, and high-speed connectivity. Perfect for seminars, workshops, and business presentations.', 'event-locations/training_room.png', 'active', '2026-07-07 15:41:31', '2026-07-17 06:10:11'),
(2, 'Rooftop Lounge', 150, 'An exquisite open-air sky lounge offering breathtaking panoramic views of the city skyline. Features ambient lighting, cozy lounge seating, and an upscale bar. Ideal for networking mixers, cocktail parties, and evening socials.', 'event-locations/rooftop_lounge.png', 'active', '2026-07-07 15:41:59', '2026-07-17 06:10:11'),
(3, 'Conference Room', 200, 'A grand and spacious venue boasting high ceilings, luxurious decor, and customizable layouts. Equipped with advanced sound systems and presentation screens. Designed for corporate conferences, banquets, and formal gatherings.', 'event-locations/conference_room.png', 'active', '2026-07-07 15:42:19', '2026-07-17 06:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `event_staff`
--

CREATE TABLE `event_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ingredients`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `description`, `category`, `price`, `is_available`, `image_path`, `ingredients`, `created_at`, `updated_at`) VALUES
(1, 'Margherita Pizza', 'An authentic Italian masterpiece featuring a thin, crispy crust topped with our slow-simmered Roma tomato sauce, fresh buffalo mozzarella slices, a drizzle of premium extra virgin olive oil, and fresh aromatic basil leaves.', 'main_course', 2700.00, 1, 'food-items/room_6871318fb2af0.jpg', '[\"Fresh Buffalo Mozzarella\",\"Roma Tomatoes\",\"Slow-Simmered Tomato Sauce\",\"Extra Virgin Olive Oil\",\"Fresh Basil Leaves\",\"Artisan Dough\"]', '2025-07-01 08:23:01', '2026-07-17 04:38:23'),
(2, 'Chicken Biryani', 'A majestic dish of fragrant basmati rice layered with juicy, tender chicken marinated in a rich blend of traditional Sri Lankan and Indian spices, slow-cooked in a sealed pot to lock in the rich flavors. Served with mint raita.', 'main_course', 3300.00, 1, 'food-items/room_6871311ee22b0.jpg', '[\"Basmati Rice\",\"Marinated Chicken\",\"Caramelized Onions\",\"Ghee\",\"Cardamom & Cloves\",\"Saffron\",\"Fresh Cilantro\",\"Mint Leaves\"]', '2025-07-01 08:23:49', '2026-07-17 04:38:23'),
(3, 'Caesar Salad', 'Crisp, fresh romaine lettuce tossed in our signature creamy garlic Caesar dressing, topped with hand-torn crunchy garlic croutons, crispy bacon bits, and generously finished with shaved aged Parmesan cheese.', 'appetizer', 1800.00, 1, 'food-items/room_68713072dc7a1.jpg', '[\"Crisp Romaine Lettuce\",\"Creamy Garlic Caesar Dressing\",\"Aged Parmesan Cheese\",\"Garlic Croutons\",\"Smoked Bacon Bits\",\"Black Pepper\"]', '2025-07-01 08:25:07', '2026-07-17 04:38:23'),
(4, 'French Fries', 'Thick-cut golden potatoes fried to a perfect crisp on the outside while remaining light and fluffy on the inside. Lightly seasoned with fine sea salt and served hot with fresh tomato ketchup.', 'appetizer', 1200.00, 1, 'food-items/room_6871302c81049.jpg', '[\"Premium Potatoes\",\"Vegetable Oil\",\"Sea Salt\",\"Classic Tomato Ketchup\"]', '2025-07-01 08:25:40', '2026-07-17 04:38:23'),
(5, 'Grilled Salmon', 'Premium Atlantic salmon fillet expertly flame-grilled to keep it moist and flaky. Served on a bed of fresh steamed asparagus and baby potatoes, drizzled with a decadent garlic herb lemon butter sauce.', 'main_course', 4500.00, 1, 'food-items/room_68712fcda25fb.jpg', '[\"Atlantic Salmon Fillet\",\"Fresh Asparagus\",\"Baby Potatoes\",\"Garlic Herb Butter\",\"Lemon Juice\",\"Dill\"]', '2025-07-01 08:26:17', '2026-07-17 04:38:23'),
(6, 'Veggie Burger', 'A hearty, grilled house-made vegetable patty crafted from black beans, quinoa, roasted sweet potatoes, and sweet corn. Served on a toasted brioche bun with crispy lettuce, sliced tomatoes, mature cheddar cheese, and signature burger sauce.', 'main_course', 2400.00, 1, 'food-items/room_68712ef6913e2.jpg', '[\"Quinoa & Bean Patty\",\"Toasted Brioche Bun\",\"Lettuce & Tomato Slices\",\"Mature Cheddar Cheese\",\"Avocado Spread\",\"Signature Burger Sauce\"]', '2025-07-01 08:27:01', '2026-07-17 04:38:23'),
(7, 'Chocolate Brownie', 'A rich, decadent chocolate fudge brownie baked to a chewy perfection. Served warm, topped with a scoop of premium vanilla bean ice cream and drizzled with warm dark chocolate ganache.', 'dessert', 1500.00, 1, 'food-items/room_68712d9682acd.jpg', '[\"Dark Belgian Chocolate\",\"Premium Cocoa Powder\",\"Butter\",\"Vanilla Bean Extract\",\"Walnuts\",\"Vanilla Bean Ice Cream\"]', '2025-07-01 08:27:33', '2026-07-17 04:38:23'),
(8, 'Ice Cream Sundae', 'A delightful tower of chocolate, strawberry, and vanilla bean ice cream scoops, layered with fresh whipped cream, rich chocolate sauce, roasted almond slivers, and topped with a sweet maraschino cherry.', 'dessert', 1200.00, 1, 'food-items/room_68712d7cb0605.jpg', '[\"Vanilla Bean Ice Cream\",\"Chocolate Ice Cream\",\"Strawberry Ice Cream\",\"Whipped Cream\",\"Chocolate Sauce\",\"Roasted Almonds\",\"Maraschino Cherry\"]', '2025-07-01 08:28:11', '2026-07-17 04:38:23'),
(9, 'Lemonade', 'Freshly squeezed lemons blended with pure sugar cane syrup and chilled mineral water, served over crushed ice with fresh mint leaves and lemon wheels for the ultimate refreshing cooler.', 'beverage', 900.00, 1, 'food-items/room_68712bd715bc0.jpg', '[\"Freshly Squeezed Lemon Juice\",\"Pure Sugar Cane Syrup\",\"Chilled Mineral Water\",\"Fresh Mint Leaves\",\"Lemon Wheels\"]', '2025-07-01 08:28:52', '2026-07-17 04:38:23'),
(10, 'Coffee', 'A rich, full-bodied aromatic coffee brewed from freshly ground single-origin Arabica beans. Finished with a velvety micro-foam and served hot.', 'beverage', 600.00, 1, 'food-items/room_68712b8beec33.jpg', '[\"Single-Origin Arabica Coffee Beans\",\"Chilled Fresh Milk\",\"Water\"]', '2025-07-01 08:29:39', '2026-07-17 04:39:47'),
(11, 'Ice Coffee', 'Our double-shot espresso poured over ice and blended with sweet condensed milk and chilled fresh milk, topped with a light dusting of cocoa powder.', 'beverage', 600.00, 1, 'food-items/room_6871296ff04ef.jpg', '[\"Double-Shot Espresso\",\"Condensed Milk\",\"Fresh Whole Milk\",\"Ice Cubes\",\"Cocoa Powder\"]', '2025-07-11 14:56:42', '2026-07-17 04:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('draft','sent','paid','overdue','cancelled') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `base_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `service_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sscl_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tdl_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_id`, `event_id`, `reservation_id`, `invoice_date`, `due_date`, `subtotal`, `tax_rate`, `tax_amount`, `total_amount`, `status`, `notes`, `base_amount`, `service_charge`, `sscl_amount`, `tdl_amount`, `vat_amount`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 'INV-000001', 11, 3, NULL, '2025-07-02', '2025-07-03', 75000.00, 5.00, 3750.00, 78750.00, 'cancelled', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-02 11:21:42', '2025-07-10 18:54:47'),
(2, 'INV-000002', 11, 3, NULL, '2025-07-02', '2025-07-03', 75000.00, 5.00, 3750.00, 78750.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-02 11:31:13', '2025-07-10 08:38:58'),
(3, 'INV-000003', 11, NULL, NULL, '2025-07-02', '2025-07-03', 25000.00, 5.00, 1250.00, 26250.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-02 11:34:42', '2025-07-10 08:37:13'),
(4, 'INV-000004', 17, 2, NULL, '2025-07-02', '2025-07-09', 50000.00, 5.00, 2500.00, 52500.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-02 11:39:00', '2025-07-10 07:47:49'),
(7, 'INV-000007', 16, 3, NULL, '2025-07-02', '2025-07-18', 15000.00, 0.00, 0.00, 15000.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-02 12:05:33', '2025-07-10 07:43:12'),
(8, 'INV-000008', 12, 3, NULL, '2025-07-10', '2025-07-31', 37500.00, 18.00, 6750.00, 44250.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-10 18:26:15', '2026-07-17 05:38:41'),
(12, 'INV-000012', 10, NULL, NULL, '2025-07-11', '2025-07-12', 11500.00, 5.00, 575.00, 12075.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-11 12:51:00', '2025-07-11 12:51:26'),
(13, 'INV-000013', 18, NULL, 11, '2025-07-11', '2025-07-12', 14000.00, 0.00, 0.00, 14000.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-07-11 13:23:45', '2026-07-17 05:38:10'),
(14, 'INV-000014', 11, NULL, 12, '2026-07-17', '2026-07-18', 21000.00, 0.00, 0.00, 21000.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2026-07-17 05:09:35', '2026-07-17 05:34:49'),
(16, 'INV-000015', 11, NULL, 7, '2026-07-17', '2026-07-24', 63000.00, 0.00, 0.00, 63000.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2026-07-17 05:29:54', '2026-07-17 05:34:23'),
(17, 'INV-000017', 20, NULL, 13, '2026-07-17', '2026-07-18', 6000.00, 0.00, 0.00, 6000.00, 'paid', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2026-07-17 05:48:50', '2026-07-17 05:53:12'),
(19, 'INV-000018', 14, NULL, 15, '2026-07-18', '2026-07-19', 21000.00, 31.50, 6615.00, 27615.00, 'paid', NULL, 21000.00, 2100.00, 525.00, 210.00, 3780.00, 27615.00, '2026-07-18 05:57:19', '2026-07-18 06:12:30'),
(20, 'INV-000020', 21, NULL, 16, '2026-07-18', '2026-07-25', 35000.00, 31.50, 11025.00, 46025.00, 'paid', NULL, 35000.00, 3500.00, 875.00, 350.00, 6300.00, 46025.00, '2026-07-18 06:09:14', '2026-07-18 06:12:30'),
(21, 'INV-000021', 23, NULL, 17, '2026-07-19', '2026-07-26', 6000.00, 31.50, 1890.00, 7890.00, 'paid', NULL, 6000.00, 600.00, 150.00, 60.00, 1080.00, 7890.00, '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(22, 'INV-000022', 23, NULL, 18, '2026-07-19', '2026-07-26', 10000.00, 31.50, 3150.00, 13150.00, 'paid', NULL, 10000.00, 1000.00, 250.00, 100.00, 1800.00, 13150.00, '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(23, 'INV-000023', 17, NULL, 19, '2026-07-20', '2026-07-27', 6000.00, 31.50, 1890.00, 7890.00, 'paid', NULL, 6000.00, 600.00, 150.00, 60.00, 1080.00, 7890.00, '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(24, 'INV-000024', 16, NULL, 8, '2026-08-01', '2026-08-08', 5000.00, 31.50, 1575.00, 6575.00, 'paid', NULL, 5000.00, 500.00, 125.00, 50.00, 900.00, 6575.00, '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(25, 'INV-000025', 1, NULL, 2, '2026-08-01', '2026-08-08', 6000.00, 31.50, 1890.00, 7890.00, 'paid', NULL, 6000.00, 600.00, 150.00, 60.00, 1080.00, 7890.00, '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(26, 'INV-000026', 3, NULL, 3, '2026-08-01', '2026-08-08', 35000.00, 31.50, 11025.00, 46025.00, 'paid', NULL, 35000.00, 3500.00, 875.00, 350.00, 6300.00, 46025.00, '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(27, 'INV-000027', 3, NULL, 6, '2026-08-01', '2026-08-08', 35000.00, 31.50, 11025.00, 46025.00, 'paid', NULL, 35000.00, 3500.00, 875.00, 350.00, 6300.00, 46025.00, '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(28, 'INV-000028', 10, NULL, 9, '2026-08-01', '2026-08-08', 7000.00, 31.50, 2205.00, 9205.00, 'paid', NULL, 7000.00, 700.00, 175.00, 70.00, 1260.00, 9205.00, '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(29, 'INV-000029', 1, NULL, 10, '2026-08-01', '2026-08-08', 10000.00, 31.50, 3150.00, 13150.00, 'paid', NULL, 10000.00, 1000.00, 250.00, 100.00, 1800.00, 13150.00, '2026-08-01 10:28:59', '2026-08-01 10:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(4, 7, 'Event', 10, 1500.00, '2025-07-08 16:43:52', '2025-07-08 16:43:52'),
(5, 8, 'Tech workshop 5', 15, 2500.00, '2025-07-10 18:26:15', '2025-07-10 18:26:15'),
(6, 14, '#12 - Amal Fonseka (Room 302) - 3 nights - LKR 21,000.00', 3, 7000.00, '2026-07-17 05:30:33', '2026-07-17 05:30:33'),
(7, 17, '#13 - Anil Dias (Room:                                                101) - 2 nights - LKR 6,000.00', 2, 3000.00, '2026-07-17 05:48:50', '2026-07-17 05:48:50'),
(8, 19, '#15 - Anupa Mewan (Room:                                                101) - 7 nights - LKR 21,000.00', 7, 3000.00, '2026-07-18 05:57:20', '2026-07-18 05:57:20'),
(9, 20, '#16 - Poodini (Room:                                                201) - 7 nights - LKR 35,000.00', 7, 5000.00, '2026-07-18 06:09:14', '2026-07-18 06:09:14'),
(10, 21, '#17 - Ravindu Senanayake (Room:                                                104) - 2 nights - LKR 6,000.00', 2, 3000.00, '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(11, 22, '#18 - Ravindu Senanayake (Room:                                                202) - 2 nights - LKR 10,000.00', 2, 5000.00, '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(12, 23, '#19 - Kamal Fernando (Room:                                                102) - 2 nights - LKR 6,000.00', 2, 3000.00, '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(13, 24, '#8 - Kasun Fonseka (Room:                                                202) - 1 nights - LKR 5,000.00', 1, 5000.00, '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(14, 25, '#2 - Sadeep (Room:                                                101) - 2 nights - LKR 6,000.00', 2, 3000.00, '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(15, 26, '#3 - Kamali (Room:                                                201) - 7 nights - LKR 35,000.00', 7, 5000.00, '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(16, 27, '#6 - Kamali (Room:                                                201) - 7 nights - LKR 35,000.00', 7, 5000.00, '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(17, 28, '#9 - Sadeep Sachintha (Room:                                                301) - 1 nights - LKR 7,000.00', 1, 7000.00, '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(18, 29, '#10 - Sadeep (Room:                                                201) - 2 nights - LKR 10,000.00', 2, 5000.00, '2026-08-01 10:28:59', '2026-08-01 10:28:59');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_05_18_000001_create_customers_table', 1),
(7, '2023_05_18_000002_create_room_types_table', 1),
(8, '2023_05_18_000003_create_rooms_table', 1),
(9, '2023_05_18_000004_create_reservations_table', 1),
(10, '2023_05_18_000005_create_food_items_table', 1),
(11, '2023_05_18_000006_create_events_table', 1),
(12, '2023_05_18_000007_create_staff_table', 1),
(13, '2023_05_18_000008_create_payments_table', 1),
(14, '2023_05_18_000009_create_event_staff_table', 1),
(15, '2024_03_19_000000_create_settings_table', 1),
(16, '2024_03_20_000001_create_room_type_images_table', 1),
(17, '2024_03_20_000001_create_system_notifications_table', 1),
(18, '2024_03_20_000002_create_invoices_table', 1),
(19, '2024_03_20_000003_create_invoice_items_table', 1),
(20, '2025_03_16_124020_create_sessions_table', 1),
(21, '2025_06_08_053011_create_alerts_table', 1),
(22, '2024_06_09_000001_add_invoice_id_to_payments_table', 2),
(23, '2023_05_18_000007_create_staff_table', 2),
(24, '2023_05_18_000008_create_payments_table', 2),
(25, '2023_05_18_000009_create_event_staff_table', 2),
(26, '2024_03_19_000000_create_settings_table', 2),
(27, '2024_03_20_000001_create_room_type_images_table', 2),
(28, '2024_03_20_000001_create_system_notifications_table', 2),
(29, '2024_03_20_000002_create_invoices_table', 2),
(30, '2024_03_20_000003_create_invoice_items_table', 2),
(31, '2025_03_16_124020_create_sessions_table', 2),
(32, '2025_06_08_053011_create_alerts_table', 2),
(33, '2024_06_09_000001_add_invoice_id_to_payments_table', 3),
(34, '2024_06_10_000001_add_role_to_users_table', 4),
(35, 'add_reservation_id_to_invoices_table', 4),
(36, '2024_06_14_000001_add_status_to_users_table', 5),
(37, '2026_07_17_113209_add_image_path_to_event_locations_table', 6),
(38, '2026_07_18_100741_add_tax_rates_to_settings_table', 7),
(39, '2026_07_18_100749_add_detailed_tax_fields_to_invoices_table', 8),
(40, '2024_03_20_000004_create_payments_table', 9),
(41, '2026_05_04_144031_create_event_locations_table', 9),
(42, '2026_05_04_144057_add_location_id_to_events_table', 9),
(43, '2026_07_19_114411_create_activity_logs_table', 10),
(44, '2026_07_27_100915_add_nic_passport_to_customers_table', 11),
(45, '2026_07_27_152625_add_nic_to_staff_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reservation_id`, `invoice_id`, `amount`, `payment_date`, `payment_method`, `transaction_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(7, NULL, 7, 15000.00, '2025-07-10 00:00:00', 'cash', NULL, 'completed', NULL, '2025-07-10 07:43:12', '2025-07-10 07:43:12'),
(9, NULL, 4, 52500.00, '2025-07-10 00:00:00', 'bank_transfer', 'sds1245', 'completed', NULL, '2025-07-10 07:47:06', '2025-07-10 07:47:49'),
(10, NULL, 3, 26250.00, '2025-07-10 00:00:00', 'credit_card', 'aadxS123', 'completed', NULL, '2025-07-10 07:50:05', '2025-07-10 08:37:13'),
(12, NULL, 2, 78750.00, '2025-07-10 00:00:00', 'cheque', 'asxda12', 'completed', NULL, '2025-07-10 08:37:41', '2025-07-10 08:40:15'),
(13, NULL, 1, 78750.00, '2025-07-10 00:00:00', 'credit_card', 'adacd', 'refunded', NULL, '2025-07-10 18:11:42', '2025-07-10 18:54:47'),
(14, NULL, 8, 44250.00, '2025-07-10 00:00:00', 'credit_card', 'sdf123', 'failed', NULL, '2025-07-10 18:26:52', '2025-07-10 18:27:48'),
(18, NULL, 12, 12075.00, '2025-07-11 00:00:00', 'cash', NULL, 'completed', NULL, '2025-07-11 12:51:26', '2025-07-11 12:51:26'),
(19, 7, 16, 63000.00, '2026-07-17 00:00:00', 'debit_card', NULL, 'completed', NULL, '2026-07-17 05:31:33', '2026-07-17 05:34:23'),
(20, 12, 14, 21000.00, '2026-07-17 00:00:00', 'cash', NULL, 'completed', NULL, '2026-07-17 05:34:49', '2026-07-17 05:34:49'),
(21, 11, 13, 14000.00, '2026-07-17 00:00:00', 'cash', NULL, 'completed', NULL, '2026-07-17 05:38:10', '2026-07-17 05:38:10'),
(22, NULL, 8, 44250.00, '2026-07-17 00:00:00', 'cash', NULL, 'completed', NULL, '2026-07-17 05:38:41', '2026-07-17 05:38:41'),
(23, 13, 17, 6000.00, '2026-07-17 11:18:50', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-17 05:48:50', '2026-07-17 05:53:12'),
(25, NULL, 19, 27615.00, '2026-07-18 11:27:20', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-18 05:57:20', '2026-07-18 05:57:20'),
(26, NULL, 20, 46025.00, '2026-07-18 11:39:14', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-18 06:09:14', '2026-07-18 06:09:14'),
(27, 17, 21, 7890.00, '2026-07-19 20:38:18', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-19 15:08:18', '2026-07-19 15:08:18'),
(28, 18, 22, 13150.00, '2026-07-19 21:23:36', 'credit_card', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-19 15:53:36', '2026-07-19 15:53:36'),
(29, 19, 23, 7890.00, '2026-07-20 09:31:36', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-07-20 04:01:36', '2026-07-20 04:01:36'),
(30, 8, 24, 6575.00, '2026-08-01 15:41:23', 'debit_card', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:11:23', '2026-08-01 10:11:23'),
(31, 2, 25, 7890.00, '2026-08-01 15:56:48', 'credit_card', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:26:48', '2026-08-01 10:26:48'),
(32, 3, 26, 46025.00, '2026-08-01 15:57:26', 'bank_transfer', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:27:26', '2026-08-01 10:27:26'),
(33, 6, 27, 46025.00, '2026-08-01 15:58:04', 'debit_card', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:28:04', '2026-08-01 10:28:04'),
(34, 9, 28, 9205.00, '2026-08-01 15:58:33', 'cash', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:28:33', '2026-08-01 10:28:33'),
(35, 10, 29, 13150.00, '2026-08-01 15:58:59', 'credit_card', NULL, 'completed', 'Auto-recorded during invoice creation.', '2026-08-01 10:28:59', '2026-08-01 10:28:59');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `number_of_guests` int(11) NOT NULL DEFAULT 1,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_id`, `room_id`, `check_in_date`, `check_out_date`, `number_of_guests`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-06-30', '2025-07-09', 1, 'cancelled', '2025-06-28 12:13:42', '2025-07-10 08:07:52'),
(2, 1, 1, '2025-06-28', '2025-06-30', 1, 'checked_out', '2025-06-28 12:23:31', '2026-08-01 10:26:48'),
(3, 3, 6, '2025-06-28', '2025-07-05', 2, 'checked_out', '2025-06-28 12:37:27', '2026-08-01 10:27:26'),
(4, 2, 1, '2025-06-30', '2025-07-09', 1, 'cancelled', '2025-07-01 13:01:34', '2025-07-10 08:07:15'),
(5, 1, 1, '2025-06-28', '2025-06-30', 1, 'cancelled', '2025-07-01 13:01:34', '2025-07-01 13:01:34'),
(6, 3, 6, '2025-06-28', '2025-07-05', 2, 'checked_out', '2025-07-01 13:01:34', '2026-08-01 10:28:04'),
(7, 11, 9, '2025-07-08', '2025-07-17', 4, 'checked_out', '2025-07-01 13:01:34', '2026-08-01 10:15:52'),
(8, 16, 7, '2025-06-29', '2025-06-30', 2, 'checked_out', '2025-07-01 13:01:34', '2026-08-01 10:13:22'),
(9, 10, 8, '2025-07-04', '2025-07-05', 2, 'checked_out', '2025-07-01 13:01:34', '2026-08-01 10:28:33'),
(10, 1, 6, '2025-07-10', '2025-07-12', 1, 'checked_out', '2025-07-08 16:11:40', '2026-08-01 10:28:59'),
(11, 18, 9, '2025-07-17', '2025-07-19', 4, 'checked_out', '2025-07-08 16:12:25', '2026-08-01 10:15:52'),
(12, 11, 9, '2026-07-28', '2026-07-31', 2, 'checked_out', '2026-07-17 03:06:06', '2026-08-01 10:15:52'),
(13, 20, 1, '2026-07-29', '2026-07-31', 1, 'checked_out', '2026-07-17 05:15:22', '2026-08-01 10:15:52'),
(15, 14, 1, '2026-07-31', '2026-08-07', 1, 'confirmed', '2026-07-18 05:56:22', '2026-07-18 06:12:30'),
(16, 21, 6, '2026-08-04', '2026-08-11', 2, 'confirmed', '2026-07-18 06:08:47', '2026-07-18 06:12:30'),
(17, 23, 4, '2026-08-31', '2026-09-02', 1, 'confirmed', '2026-07-19 14:40:38', '2026-07-19 15:08:18'),
(18, 23, 7, '2026-07-22', '2026-07-24', 2, 'checked_out', '2026-07-19 15:52:28', '2026-08-01 10:15:52'),
(19, 17, 2, '2026-07-20', '2026-07-20', 1, 'checked_out', '2026-07-20 04:01:06', '2026-08-01 10:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `floor` int(11) NOT NULL,
  `status` enum('available','occupied','maintenance','reserved') NOT NULL DEFAULT 'available',
  `is_clean` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `room_type_id`, `floor`, `status`, `is_clean`, `notes`, `created_at`, `updated_at`) VALUES
(1, '101', 1, 1, 'available', 1, NULL, '2025-06-28 12:03:40', '2025-06-28 12:03:40'),
(2, '102', 1, 1, 'available', 1, NULL, '2025-06-28 12:11:21', '2026-07-20 07:30:00'),
(3, '103', 1, 1, 'available', 1, NULL, '2025-06-28 12:11:38', '2025-06-28 12:11:38'),
(4, '104', 1, 1, 'available', 1, NULL, '2025-06-28 12:27:01', '2025-06-28 12:27:01'),
(5, '105', 1, 1, 'available', 1, NULL, '2025-06-28 12:34:15', '2025-06-28 12:34:15'),
(6, '201', 2, 2, 'available', 1, NULL, '2025-06-28 12:34:41', '2025-06-28 12:34:41'),
(7, '202', 2, 2, 'available', 1, NULL, '2025-06-28 12:35:12', '2025-06-28 12:35:12'),
(8, '301', 4, 3, 'available', 1, NULL, '2025-07-01 07:37:20', '2026-07-20 04:10:31'),
(9, '302', 4, 3, 'available', 1, NULL, '2025-07-01 07:37:37', '2025-07-01 09:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `description`, `capacity`, `price_per_night`, `amenities`, `created_at`, `updated_at`) VALUES
(1, 'Single Room', 'Enjoy a comfortable stay in this well-appointed room featuring a single bed, air conditioning, and complimentary Wi-Fi. The room includes a vanity with a sink for added convenience, while modern hallway bathrooms are easily accessible. Amenities such as a mini refrigerator, LCD TV, work desk, and hair dryer ensure a pleasant and productive stay.\r\n*Single beds are 38\"x79.5\" (96.5cm x 202cm) in size.', 1, 3000.00, '[\"single\",\"bathroom\",\"ac\",\"wifi\",\"hair_dryer\",\"tv\",\"fridge\",\"desk\"]', '2025-06-28 11:50:47', '2025-06-28 11:50:47'),
(2, 'Double Room', 'Relax in comfort with a spacious double bed and private bathroom, perfect for solo travelers or couples. This air-conditioned room features a vanity with sink in the bedroom, free Wi-Fi, LCD TV, mini refrigerator, and a work desk for added convenience. A hair dryer is also provided to make your stay even more comfortable.\r\n*Double beds are 53\"x79.5\" (134.5cm x 202cm) in size.', 2, 5000.00, '[\"double\",\"private_bathroom\",\"ac\",\"wifi\",\"hair_dryer\",\"tv\",\"fridge\",\"desk\"]', '2025-06-28 11:52:33', '2025-06-28 11:52:33'),
(4, 'Deluxe Family Room', 'Designed for families or small groups, this spacious room features two queen beds and a private bathroom for added comfort and privacy. Enjoy modern amenities including air conditioning, free Wi-Fi, an LCD TV, a mini refrigerator, and a coffee maker. A vanity with sink in the bedroom, complimentary toiletries, hair dryer, and a dedicated work desk ensure a relaxing and convenient stay for all guests.\r\n*Queen beds are 60\"x79.5\" (152.5cm x 202cm) in size.', 4, 7000.00, '[\"queen\",\"private_bathroom\",\"toiletries\",\"ac\",\"coffee\",\"wifi\",\"hair_dryer\",\"fridge\",\"desk\"]', '2025-06-28 11:59:36', '2025-06-28 11:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `room_type_images`
--

CREATE TABLE `room_type_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_type_images`
--

INSERT INTO `room_type_images` (`id`, `room_type_id`, `image_path`, `caption`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 4, 'rooms/suite.png', NULL, 0, '2025-07-01 07:32:52', '2025-07-01 07:32:52'),
(2, 4, 'room-types/room_6863dc7cd364c.jpg', NULL, 1, '2025-07-01 07:32:52', '2025-07-01 07:32:52'),
(3, 4, 'room-types/room_6863dc7d4d0d9.jpg', NULL, 2, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(4, 4, 'room-types/room_6863dc7db5745.jpg', NULL, 3, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(5, 2, 'rooms/deluxe.png', NULL, 0, '2025-07-01 07:33:18', '2025-07-01 07:33:18'),
(6, 2, 'room-types/room_6863dc971e49b.jpg', NULL, 1, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(7, 2, 'room-types/room_6863dc9769ca9.jpg', NULL, 2, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(8, 2, 'room-types/room_6863dc97aed28.jpg', NULL, 3, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(9, 1, 'rooms/standard.png', NULL, 0, '2025-07-01 07:33:42', '2025-07-01 07:33:42'),
(10, 1, 'room-types/room_6863dcaf13ca4.jpg', NULL, 1, '2025-07-01 07:33:43', '2025-07-01 07:33:43'),
(11, 1, 'room-types/room_6863dcaf58ddc.jpg', NULL, 2, '2025-07-01 07:33:43', '2025-07-01 07:33:43'),
(12, 1, 'room-types/room_6863dcaf9c774.jpg', NULL, 3, '2025-07-01 07:33:43', '2025-07-01 07:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notifications` tinyint(1) NOT NULL DEFAULT 0,
  `service_charge_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
  `sscl_rate` decimal(5,2) NOT NULL DEFAULT 2.50,
  `tdl_rate` decimal(5,2) NOT NULL DEFAULT 1.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 18.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `hotel_name`, `contact_email`, `contact_phone`, `check_in_time`, `check_out_time`, `email_notifications`, `sms_notifications`, `service_charge_rate`, `sscl_rate`, `tdl_rate`, `vat_rate`, `created_at`, `updated_at`) VALUES
(1, 'Hotel Grand Palace', 'info@grandpalace.com', '+94112345678', '14:00:00', '12:00:00', 1, 0, 10.00, 2.50, 1.00, 18.00, '2026-07-27 10:18:21', '2026-07-27 10:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive','on_leave') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `name`, `email`, `position`, `department`, `phone`, `nic`, `address`, `emergency_contact`, `hire_date`, `salary`, `status`, `created_at`, `updated_at`) VALUES
(17, 1, 'Nadeesha Perera', 'nadeesha.perera@gmail.com', 'Receptionist', 'Front Office', '0771234567', '947701029V', 'No. 45, Kandy Road, Colombo', '0745678912', '2025-03-15', 55000.00, 'active', '2025-07-02 09:09:07', '2026-07-27 09:59:17'),
(19, 3, 'Chamari Jayasuriya', 'chamari.j@gmail.com', 'Event Coordinator', 'Events', '0712347890', '199927249557', '88 Park Street, Nuwara Eliya', '0774561230', '2023-01-10', 58000.00, 'inactive', NULL, '2026-07-27 09:59:17'),
(20, 4, 'Thilina Fernando', 'thilina.f@gmail.com', 'Chef', 'Kitchen', '0701122334', '994058311V', '67 Beach Road, Negombo', '0789988776', '2020-06-05', 75000.00, 'active', NULL, '2026-07-27 09:59:17'),
(21, 5, 'Dilani Rajapaksha', 'dilani.r@gmail.com', 'HR Assistant', 'Human Resources', '0722233445', '199813573474', '21 Hill Side, Matara', '0717654321', '2023-09-01', 62000.00, 'inactive', NULL, '2026-07-27 09:59:17'),
(22, 1, 'Ravindu Senanayake', 'ravindu.s@gmail.com', 'Housekeeping Supervisor', 'Housekeeping', '0779876543', '956210725V', '12 Lake View, Galle', '751234567', '2021-11-09', 60000.00, 'active', '2025-07-11 06:53:23', '2026-07-27 09:59:17'),
(23, 13, 'Bob Staff', 'bob.staff@example.com', 'Receptionist', 'Front Office', '+94777654321', '951042754V', '456 Staff Rd', NULL, '2005-02-02', NULL, 'active', '2026-07-27 10:02:52', '2026-07-27 10:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications`
--

CREATE TABLE `system_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `role`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sadeep', 'manager@gmail.com', NULL, '$2y$10$S0KcDklENqcrfwy/q//JleI.VRI8rHGTANUxiBClY.ZR4LCgT7V2q', 1, 'manager', NULL, NULL, NULL, NULL, '2025-06-28 10:22:23', '2026-05-04 06:03:33'),
(3, 'Chamari Jayasuriya', 'chamari.j@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 'staff', NULL, NULL, NULL, NULL, NULL, '2025-07-10 07:52:20'),
(4, 'Thilina Fernando', 'thilina.f@gmail.com', NULL, '$2y$10$Psr/xo1RXSFj/F.Lm2bqCuiaf8V9n7lIDBxaKyshDoCjsN0LaF1ee', 1, 'staff', NULL, NULL, NULL, NULL, NULL, '2026-07-18 06:16:39'),
(5, 'Dilani Rajapaksha', 'dilani.r@gmail.com', NULL, '$2y$10$XheS3ITU9VTWcASfgw.yPeUSy1lEAakPhn9DS1MIa.N0x9488QlhO', 0, 'staff', NULL, NULL, NULL, NULL, NULL, '2025-07-10 07:51:04'),
(10, 'Sachintha Soysa', 'admin@gmail.com', NULL, '$2y$10$2NnEtuUmB5BxTJf/.FRt7.AxiTHuJ4U8m0Hf1.7gv5tpmo8EOKxfe', 1, 'admin', NULL, NULL, NULL, NULL, '2025-07-08 03:05:24', '2026-07-17 04:07:14'),
(11, 'Ravindu Senanayake', 'ravindu.s@gmail.com', NULL, '$2y$10$xjT69sn4W.XnZinB7cwwaOOKKa7fovsD1XbzWn8QGPy.R/5BOB7J.', 1, 'guest', NULL, NULL, NULL, NULL, '2025-07-11 06:36:48', '2026-07-19 06:50:14'),
(12, 'Test User', 'test@example.com', NULL, '$2y$10$LOt63fD1op5df5DGDcK78e0fKFUHYb7yY389uWLLhxPou2JnH.sPu', 0, 'guest', NULL, NULL, NULL, NULL, '2026-05-04 06:01:27', '2026-07-17 04:13:02'),
(13, 'Admin User', 'admin@hms.com', NULL, '$2y$10$Pomkd6iuQUi1u3DKSfDIvu/4eudVZA.P50xKZDK/qSq.35JOEZk7y', 0, 'admin', NULL, NULL, NULL, NULL, '2026-07-20 14:25:15', '2026-07-20 15:50:30'),
(14, 'Charlie Guest', 'charlie.guest@example.com', NULL, '$2y$10$Zd032UihDPPPxacQgMLy0.E6.t.KJs3Do6x85zwK1PRYTeT64PZ3i', 1, 'guest', NULL, NULL, NULL, NULL, '2026-07-27 10:04:46', '2026-07-27 10:04:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alerts_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_customer_id_foreign` (`customer_id`),
  ADD KEY `events_location_id_foreign` (`location_id`);

--
-- Indexes for table `event_locations`
--
ALTER TABLE `event_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_staff`
--
ALTER TABLE `event_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_staff_event_id_foreign` (`event_id`),
  ADD KEY `event_staff_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_event_id_foreign` (`event_id`),
  ADD KEY `invoices_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_reservation_id_foreign` (`reservation_id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_number_unique` (`number`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type_images`
--
ALTER TABLE `room_type_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_type_images_room_type_id_foreign` (`room_type_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD KEY `staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_locations`
--
ALTER TABLE `event_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_staff`
--
ALTER TABLE `event_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_type_images`
--
ALTER TABLE `room_type_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `system_notifications`
--
ALTER TABLE `system_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `events_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `event_locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_staff`
--
ALTER TABLE `event_staff`
  ADD CONSTRAINT `event_staff_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `room_type_images`
--
ALTER TABLE `room_type_images`
  ADD CONSTRAINT `room_type_images_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD CONSTRAINT `system_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
