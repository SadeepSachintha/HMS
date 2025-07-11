-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 08:05 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('success','info','warning','danger') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `loyalty_points`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Sadeep', 'sadeepsachintha98@gmail.com', '+94763928333', '51, Railway Station Rd, Angulana, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 10:23:01', '2025-06-28 10:23:01'),
(2, 'Amali', 'amali@mail.com', '+94763928334', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 11:54:30', '2025-07-01 06:52:11'),
(3, 'Kamali', 'kamali@mail.com', '+94763928338', '51, Railway Station Rd, Kalutara.', 'Kalutara', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-06-28 12:36:45', '2025-07-01 06:53:18'),
(10, 'Sadeep Sachintha', 'sadeep@gmail.com', '+94763922333', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(11, 'Amal Fonseka', 'amal@mail.com', '+94763928334', '51, Railway Station Rd, Moratuwa.', 'Moratuwa', 'Colombo', '10400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(12, 'Kamal Silva', 'kamal@mail.com', '+94763928338', '51, Railway Station Rd, Kalutara.', 'Kalutara', 'Kalutara', '10440', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(13, 'Sunil Perera', 'sunil@gmail.com', '+94722223239', '185 Prince Of Wales Avenue, Colombo 14', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(14, 'Anupa Mewan', 'anupa@gmail.com', '+94722223239', '188 New Chetty Street, Colombo  11', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(15, 'Sunimal Dias', 'sunimal@gmail.com', '+94729130691', '18 Street, Anne\'s Street', 'Kurunegala', 'Kurunegala', '08000', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(16, 'Kasun Fonseka', 'kasun@gmail.com', '+94752327083', '185 Prince Of Wales Avenue, Colombo 14', 'Colombo', 'Colombo', '01400', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(17, 'Kamal Fernando', 'kamalf@mail.com', '+9472432615', '82 Old Moor Street, Colombo 12', 'Colombo', 'Colombo', '01200', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(18, 'Nimal Peiris', 'nimal@gmail.com', '+94722443239', '108 Dam Street, Colombo 12', 'Colombo', 'Colombo', '01200', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(19, 'Sadun Silva', 'sadun@gmail.com', '+94752327083', '99 Maradana Road, Colombo 08', 'Colombo', 'Colombo', '08000', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25'),
(20, 'Anil Dias', 'anil@gmail.com', '+94752327083', '88 New Chetty Street, Colombo  11', 'Colombo', 'Colombo', '01100', 'Sri Lanka', 0, NULL, '2025-07-01 12:23:25', '2025-07-01 12:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_attendees` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('scheduled','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_time`, `end_time`, `location`, `max_attendees`, `price`, `customer_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Grand Opening Ceremony', 'Join us for the grand opening of our new facility. Refreshments will be served.', '2025-07-01 10:00:00', '2025-07-01 13:00:00', 'Conference Room 1', 50, '1000.00', 10, 'completed', 'Please RSVP by June 25th.', '2025-07-01 08:47:38', '2025-07-01 08:47:38'),
(2, 'Summer Networking Mixer', 'An evening of networking for local business professionals. Light snacks and drinks provided.', '2025-08-15 18:30:00', '2025-08-15 21:00:00', 'Rooftop Lounge', 75, '1500.00', 17, 'scheduled', 'Bring business cards for the raffle.', '2025-07-01 08:52:29', '2025-07-01 08:52:29'),
(3, 'Tech Workshop: AI in Business', 'A hands-on workshop exploring the use of AI tools in modern business operations.', '2025-09-10 09:00:00', '2025-09-10 16:00:00', 'Training Room', 30, '2500.00', 19, 'scheduled', 'Lunch and materials included.', '2025-07-01 08:54:51', '2025-07-01 08:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `event_staff`
--

CREATE TABLE `event_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ingredients`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `description`, `category`, `price`, `is_available`, `image_path`, `ingredients`, `created_at`, `updated_at`) VALUES
(1, 'Margherita Pizza', 'Classic Italian pizza with fresh mozzarella, tomatoes, and basil.', 'main_course', '8.99', 1, NULL, NULL, '2025-07-01 08:23:01', '2025-07-01 08:23:01'),
(2, 'Chicken Biryani', 'Aromatic basmati rice cooked with tender chicken and spices.', 'main_course', '10.99', 1, NULL, NULL, '2025-07-01 08:23:49', '2025-07-01 08:23:49'),
(3, 'Caesar Salad', 'Crisp romaine lettuce tossed with Caesar dressing, croutons, and parmesan.', 'appetizer', '5.99', 1, NULL, NULL, '2025-07-01 08:25:07', '2025-07-01 08:25:07'),
(4, 'French Fries', 'Golden, crispy potato fries served with ketchup.', 'appetizer', '3.99', 1, NULL, NULL, '2025-07-01 08:25:40', '2025-07-01 08:25:40'),
(5, 'Grilled Salmon', 'Fresh salmon fillet grilled to perfection, served with lemon butter sauce.', 'main_course', '14.99', 1, NULL, NULL, '2025-07-01 08:26:17', '2025-07-01 08:26:17'),
(6, 'Veggie Burger', 'Grilled vegetable patty with lettuce, tomato, and cheese in a bun.', 'main_course', '7.99', 1, NULL, NULL, '2025-07-01 08:27:01', '2025-07-01 08:27:01'),
(7, 'Chocolate Brownie', 'Rich and fudgy chocolate brownie, served warm.', 'dessert', '4.99', 1, NULL, NULL, '2025-07-01 08:27:33', '2025-07-01 08:27:33'),
(8, 'Ice Cream Sundae', 'Vanilla ice cream topped with chocolate sauce, nuts, and a cherry.', 'dessert', '3.99', 1, NULL, NULL, '2025-07-01 08:28:11', '2025-07-01 08:28:11'),
(9, 'Lemonade', 'Refreshing homemade lemonade.', 'beverage', '2.99', 1, NULL, NULL, '2025-07-01 08:28:52', '2025-07-01 08:28:52'),
(10, 'Coffee', 'Freshly brewed hot coffee.', 'beverage', '1.99', 0, NULL, NULL, '2025-07-01 08:29:39', '2025-07-01 08:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('draft','sent','paid','overdue','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_id`, `event_id`, `invoice_date`, `due_date`, `subtotal`, `tax_rate`, `tax_amount`, `total_amount`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV-000001', 11, 3, '2025-07-02', '2025-07-03', '75000.00', '5.00', '3750.00', '78750.00', 'draft', NULL, '2025-07-02 11:21:42', '2025-07-02 11:21:42'),
(2, 'INV-000002', 11, 3, '2025-07-02', '2025-07-03', '75000.00', '5.00', '3750.00', '78750.00', 'draft', NULL, '2025-07-02 11:31:13', '2025-07-02 11:31:13'),
(3, 'INV-000003', 11, NULL, '2025-07-02', '2025-07-03', '25000.00', '5.00', '1250.00', '26250.00', 'draft', NULL, '2025-07-02 11:34:42', '2025-07-02 11:34:42'),
(4, 'INV-000004', 17, NULL, '2025-07-02', '2025-07-09', '50000.00', '5.00', '2500.00', '52500.00', 'draft', NULL, '2025-07-02 11:39:00', '2025-07-02 11:54:19'),
(6, 'INV-000005', 14, 2, '2025-07-02', '2025-07-16', '22500.00', '5.00', '1125.00', '23625.00', 'draft', NULL, '2025-07-02 12:01:34', '2025-07-02 12:01:34'),
(7, 'INV-000007', 16, 1, '2025-07-02', '2025-07-18', '15000.00', '0.00', '0.00', '15000.00', 'sent', NULL, '2025-07-02 12:05:33', '2025-07-02 12:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 6, 'Event', 15, '1500.00', '2025-07-02 12:01:34', '2025-07-02 12:01:34'),
(3, 7, 'Event', 10, '1500.00', '2025-07-02 12:28:18', '2025-07-02 12:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(33, '2024_06_09_000001_add_invoice_id_to_payments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_id`, `room_id`, `check_in_date`, `check_out_date`, `number_of_guests`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-06-30', '2025-07-09', 1, 'pending', '2025-06-28 12:13:42', '2025-06-28 12:13:42'),
(2, 1, 1, '2025-06-28', '2025-06-30', 1, 'pending', '2025-06-28 12:23:31', '2025-06-28 12:23:31'),
(3, 3, 6, '2025-06-28', '2025-07-05', 2, 'confirmed', '2025-06-28 12:37:27', '2025-06-28 12:37:27'),
(4, 2, 1, '2025-06-30', '2025-07-09', 1, 'pending', '2025-07-01 13:01:34', '2025-07-01 13:01:34'),
(5, 1, 1, '2025-06-28', '2025-06-30', 1, 'cancelled', '2025-07-01 13:01:34', '2025-07-01 13:01:34'),
(6, 3, 6, '2025-06-28', '2025-07-05', 2, 'confirmed', '2025-07-01 13:01:34', '2025-07-01 13:01:34'),
(7, 11, 9, '2025-07-08', '2025-07-17', 4, 'confirmed', '2025-07-01 13:01:34', '2025-07-01 13:01:34'),
(8, 16, 7, '2025-06-29', '2025-06-30', 2, 'checked_out', '2025-07-01 13:01:34', '2025-07-01 09:38:43'),
(9, 10, 8, '2025-07-04', '2025-07-05', 2, 'confirmed', '2025-07-01 13:01:34', '2025-07-01 13:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `floor` int(11) NOT NULL,
  `status` enum('available','occupied','maintenance','reserved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `is_clean` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `room_type_id`, `floor`, `status`, `is_clean`, `notes`, `created_at`, `updated_at`) VALUES
(1, '101', 1, 1, 'available', 1, NULL, '2025-06-28 12:03:40', '2025-06-28 12:03:40'),
(2, '102', 1, 1, 'available', 1, NULL, '2025-06-28 12:11:21', '2025-06-28 12:11:21'),
(3, '103', 1, 1, 'available', 1, NULL, '2025-06-28 12:11:38', '2025-06-28 12:11:38'),
(4, '104', 1, 1, 'available', 1, NULL, '2025-06-28 12:27:01', '2025-06-28 12:27:01'),
(5, '105', 1, 1, 'available', 1, NULL, '2025-06-28 12:34:15', '2025-06-28 12:34:15'),
(6, '201', 2, 2, 'available', 1, NULL, '2025-06-28 12:34:41', '2025-06-28 12:34:41'),
(7, '202', 2, 2, 'available', 1, NULL, '2025-06-28 12:35:12', '2025-06-28 12:35:12'),
(8, '301', 4, 3, 'occupied', 1, NULL, '2025-07-01 07:37:20', '2025-07-01 07:37:20'),
(9, '302', 4, 3, 'available', 1, NULL, '2025-07-01 07:37:37', '2025-07-01 09:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 'Single Room', 'Enjoy a comfortable stay in this well-appointed room featuring a single bed, air conditioning, and complimentary Wi-Fi. The room includes a vanity with a sink for added convenience, while modern hallway bathrooms are easily accessible. Amenities such as a mini refrigerator, LCD TV, work desk, and hair dryer ensure a pleasant and productive stay.\r\n*Single beds are 38\"x79.5\" (96.5cm x 202cm) in size.', 1, '3000.00', '[\"single\",\"bathroom\",\"ac\",\"wifi\",\"hair_dryer\",\"tv\",\"fridge\",\"desk\"]', '2025-06-28 11:50:47', '2025-06-28 11:50:47'),
(2, 'Double Room', 'Relax in comfort with a spacious double bed and private bathroom, perfect for solo travelers or couples. This air-conditioned room features a vanity with sink in the bedroom, free Wi-Fi, LCD TV, mini refrigerator, and a work desk for added convenience. A hair dryer is also provided to make your stay even more comfortable.\r\n*Double beds are 53\"x79.5\" (134.5cm x 202cm) in size.', 2, '5000.00', '[\"double\",\"private_bathroom\",\"ac\",\"wifi\",\"hair_dryer\",\"tv\",\"fridge\",\"desk\"]', '2025-06-28 11:52:33', '2025-06-28 11:52:33'),
(4, 'Deluxe Family Room', 'Designed for families or small groups, this spacious room features two queen beds and a private bathroom for added comfort and privacy. Enjoy modern amenities including air conditioning, free Wi-Fi, an LCD TV, a mini refrigerator, and a coffee maker. A vanity with sink in the bedroom, complimentary toiletries, hair dryer, and a dedicated work desk ensure a relaxing and convenient stay for all guests.\r\n*Queen beds are 60\"x79.5\" (152.5cm x 202cm) in size.', 4, '7000.00', '[\"queen\",\"private_bathroom\",\"toiletries\",\"ac\",\"coffee\",\"wifi\",\"hair_dryer\",\"fridge\",\"desk\"]', '2025-06-28 11:59:36', '2025-06-28 11:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `room_type_images`
--

CREATE TABLE `room_type_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_type_images`
--

INSERT INTO `room_type_images` (`id`, `room_type_id`, `image_path`, `caption`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 4, 'room-types/room_6863dc7c60ffb.jpg', NULL, 0, '2025-07-01 07:32:52', '2025-07-01 07:32:52'),
(2, 4, 'room-types/room_6863dc7cd364c.jpg', NULL, 1, '2025-07-01 07:32:52', '2025-07-01 07:32:52'),
(3, 4, 'room-types/room_6863dc7d4d0d9.jpg', NULL, 2, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(4, 4, 'room-types/room_6863dc7db5745.jpg', NULL, 3, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(5, 2, 'room-types/room_6863dc96c28d2.jpg', NULL, 0, '2025-07-01 07:33:18', '2025-07-01 07:33:18'),
(6, 2, 'room-types/room_6863dc971e49b.jpg', NULL, 1, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(7, 2, 'room-types/room_6863dc9769ca9.jpg', NULL, 2, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(8, 2, 'room-types/room_6863dc97aed28.jpg', NULL, 3, '2025-07-01 07:33:19', '2025-07-01 07:33:19'),
(9, 1, 'room-types/room_6863dcaebce4b.jpg', NULL, 0, '2025-07-01 07:33:42', '2025-07-01 07:33:42'),
(10, 1, 'room-types/room_6863dcaf13ca4.jpg', NULL, 1, '2025-07-01 07:33:43', '2025-07-01 07:33:43'),
(11, 1, 'room-types/room_6863dcaf58ddc.jpg', NULL, 2, '2025-07-01 07:33:43', '2025-07-01 07:33:43'),
(12, 1, 'room-types/room_6863dcaf9c774.jpg', NULL, 3, '2025-07-01 07:33:43', '2025-07-01 07:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notifications` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive','on_leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `name`, `email`, `position`, `department`, `phone`, `address`, `emergency_contact`, `hire_date`, `salary`, `status`, `created_at`, `updated_at`) VALUES
(17, 1, 'Nadeesha Perera', 'nadeesha.perera@gmail.com', 'Receptionist', 'Front Office', '0771234567', 'No. 45, Kandy Road, Colombo', '0745678912', '2025-03-15', '55000.00', 'active', '2025-07-02 09:09:07', '2025-07-02 09:09:07'),
(18, 2, 'Ravindu Senanayake', 'ravindu.s@gmail.com', 'Housekeeping Supervisor', 'Housekeeping', '0779876543', '12 Lake View, Galle', '0751234567', '2021-11-20', '60000.00', 'active', NULL, '2025-07-02 09:29:41'),
(19, 3, 'Chamari Jayasuriya', 'chamari.j@gmail.com', 'Event Coordinator', 'Events', '0712347890', '88 Park Street, Nuwara Eliya', '0774561230', '2023-01-10', '58000.00', 'on_leave', NULL, '2025-07-02 09:29:18'),
(20, 4, 'Thilina Fernando', 'thilina.f@gmail.com', 'Chef', 'Kitchen', '0701122334', '67 Beach Road, Negombo', '0789988776', '2020-06-05', '75000.00', 'active', NULL, '2025-07-02 09:25:05'),
(21, 5, 'Dilani Rajapaksha', 'dilani.r@gmail.com', 'HR Assistant', 'Human Resources', '0722233445', '21 Hill Side, Matara', '0717654321', '2023-09-01', '62000.00', 'inactive', NULL, '2025-07-02 09:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications`
--

CREATE TABLE `system_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('info','success','warning','error') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sadeep', 'manager@gmail.com', NULL, '$2y$10$AFIiYvvTIxLjglXDTAIWzODw1aLbA3u3taWTGimPdnQ8f/IVBiL0.', NULL, NULL, NULL, NULL, '2025-06-28 10:22:23', '2025-06-28 10:22:23'),
(2, 'Ravindu Senanayake', 'ravindu.s@example.com', NULL, 'password2', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Chamari Jayasuriya', 'chamari.j@example.com', NULL, 'password3', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Thilina Fernando', 'thilina.f@example.com', NULL, 'password4', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Dilani Rajapaksha', 'dilani.r@example.com', NULL, 'password5', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
  ADD KEY `events_customer_id_foreign` (`customer_id`);

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
  ADD KEY `invoices_event_id_foreign` (`event_id`);

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
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_staff`
--
ALTER TABLE `event_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_type_images`
--
ALTER TABLE `room_type_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `system_notifications`
--
ALTER TABLE `system_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

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
  ADD CONSTRAINT `invoices_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

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
