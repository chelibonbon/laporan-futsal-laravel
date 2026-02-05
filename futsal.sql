-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 08:56 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(2, 1, 'user_created', 'Membuat user baru: Derpyus', '127.0.0.1', '2026-02-03 09:36:57', '2026-02-03 09:36:57'),
(3, 1, 'user_deleted', 'Menghapus user: ada', '127.0.0.1', '2026-02-03 09:37:06', '2026-02-03 09:37:06'),
(4, 1, 'user_status_toggled', 'Mengubah status user: Mr. Donald Sipes', '127.0.0.1', '2026-02-03 09:37:10', '2026-02-03 09:37:10'),
(5, 1, 'user_updated', 'Mengupdate user: Pantai', '127.0.0.1', '2026-02-03 09:37:19', '2026-02-03 09:37:19'),
(6, 1, 'lapangan_created', 'Membuat lapangan baru: ATC FUTSAL', '127.0.0.1', '2026-02-03 09:38:00', '2026-02-03 09:38:00'),
(7, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-04 08:18:50', '2026-02-04 08:18:50'),
(8, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-04 08:23:12', '2026-02-04 08:23:12'),
(9, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-04 08:23:21', '2026-02-04 08:23:21'),
(10, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-04 08:23:25', '2026-02-04 08:23:25'),
(11, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSAL', '127.0.0.1', '2026-02-04 08:31:56', '2026-02-04 08:31:56'),
(12, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:33:55', '2026-02-04 08:33:55'),
(13, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:36:20', '2026-02-04 08:36:20'),
(14, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:39:31', '2026-02-04 08:39:31'),
(15, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:39:46', '2026-02-04 08:39:46'),
(16, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:43:34', '2026-02-04 08:43:34'),
(17, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 08:43:41', '2026-02-04 08:43:41'),
(18, 1, 'lapangan_created', 'Membuat lapangan baru: AAAA', '127.0.0.1', '2026-02-04 08:44:14', '2026-02-04 08:44:14'),
(19, 1, 'lapangan_updated', 'Mengupdate lapangan: AAAA', '127.0.0.1', '2026-02-04 08:44:23', '2026-02-04 08:44:23'),
(20, 1, 'lapangan_updated', 'Mengupdate lapangan: AAAA', '127.0.0.1', '2026-02-04 08:55:55', '2026-02-04 08:55:55'),
(21, 1, 'lapangan_created', 'Membuat lapangan baru: SWDWd', '127.0.0.1', '2026-02-04 08:56:16', '2026-02-04 08:56:16'),
(22, 1, 'lapangan_updated', 'Mengupdate lapangan: SWDWd', '127.0.0.1', '2026-02-04 08:56:33', '2026-02-04 08:56:33'),
(23, 1, 'lapangan_updated', 'Mengupdate lapangan: SWDWd', '127.0.0.1', '2026-02-04 09:06:09', '2026-02-04 09:06:09'),
(24, 1, 'lapangan_updated', 'Mengupdate lapangan: SWDWd', '127.0.0.1', '2026-02-04 09:46:42', '2026-02-04 09:46:42'),
(25, 1, 'lapangan_created', 'Membuat lapangan baru: swdfwwfwwf', '127.0.0.1', '2026-02-04 11:02:57', '2026-02-04 11:02:57'),
(26, 1, 'lapangan_updated', 'Mengupdate lapangan: swdfwwfwwf', '127.0.0.1', '2026-02-04 11:03:50', '2026-02-04 11:03:50'),
(27, 1, 'lapangan_updated', 'Mengupdate lapangan: swdfwwfwwf', '127.0.0.1', '2026-02-04 11:06:40', '2026-02-04 11:06:40'),
(28, 1, 'lapangan_updated', 'Mengupdate lapangan: swdfwwfwwf', '127.0.0.1', '2026-02-04 11:09:05', '2026-02-04 11:09:05'),
(29, 1, 'lapangan_created', 'Membuat lapangan baru: defe', '127.0.0.1', '2026-02-04 11:09:27', '2026-02-04 11:09:27'),
(30, 1, 'lapangan_status_toggled', 'Mengubah status lapangan: defe', '127.0.0.1', '2026-02-04 11:10:19', '2026-02-04 11:10:19'),
(31, 1, 'lapangan_deleted', 'Menghapus lapangan: defe', '127.0.0.1', '2026-02-04 11:10:28', '2026-02-04 11:10:28'),
(32, 1, 'lapangan_deleted', 'Menghapus lapangan: SWDWd', '127.0.0.1', '2026-02-04 11:10:44', '2026-02-04 11:10:44'),
(33, 1, 'lapangan_status_toggled', 'Mengubah status lapangan: swdfwwfwwf', '127.0.0.1', '2026-02-04 12:00:04', '2026-02-04 12:00:04'),
(34, 1, 'user_created', 'Membuat user baru: Chelsica', '127.0.0.1', '2026-02-04 12:03:58', '2026-02-04 12:03:58'),
(35, 1, 'user_updated', 'Mengupdate user: Chelsicaa', '127.0.0.1', '2026-02-04 12:04:26', '2026-02-04 12:04:26'),
(36, 1, 'user_status_toggled', 'Mengubah status user: Dr. Theo Leuschke DVM', '127.0.0.1', '2026-02-04 12:04:40', '2026-02-04 12:04:40'),
(37, 1, 'user_status_toggled', 'Mengubah status user: Dr. Theo Leuschke DVM', '127.0.0.1', '2026-02-04 12:04:43', '2026-02-04 12:04:43'),
(38, 1, 'user_status_toggled', 'Mengubah status user: Dr. Theo Leuschke DVM', '127.0.0.1', '2026-02-04 12:04:45', '2026-02-04 12:04:45'),
(39, 1, 'user_deleted', 'Menghapus user: Lamar McGlynn', '127.0.0.1', '2026-02-04 12:04:50', '2026-02-04 12:04:50'),
(40, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:06:10', '2026-02-04 12:06:10'),
(41, 17, 'booking_cancelled', 'Membatalkan booking 1', '127.0.0.1', '2026-02-04 12:17:23', '2026-02-04 12:17:23'),
(42, 3, 'payment_verified', 'Memverifikasi pembayaran untuk booking 1', '127.0.0.1', '2026-02-04 12:19:34', '2026-02-04 12:19:34'),
(43, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:25:46', '2026-02-04 12:25:46'),
(44, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:34:27', '2026-02-04 12:34:27'),
(45, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:40:09', '2026-02-04 12:40:09'),
(46, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:49:53', '2026-02-04 12:49:53'),
(47, 3, 'booking_completed', 'Menyelesaikan booking 5', '127.0.0.1', '2026-02-04 12:51:21', '2026-02-04 12:51:21'),
(48, 17, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 12:52:44', '2026-02-04 12:52:44'),
(49, 3, 'payment_verified', 'Memverifikasi pembayaran untuk booking 6', '127.0.0.1', '2026-02-04 12:54:37', '2026-02-04 12:54:37'),
(50, 3, 'payment_verified', 'Memverifikasi pembayaran untuk booking 4', '127.0.0.1', '2026-02-04 12:55:37', '2026-02-04 12:55:37'),
(51, 3, 'booking_completed', 'Menyelesaikan booking 4', '127.0.0.1', '2026-02-04 12:55:40', '2026-02-04 12:55:40'),
(52, 3, 'booking_completed', 'Menyelesaikan booking 6', '127.0.0.1', '2026-02-04 12:55:43', '2026-02-04 12:55:43'),
(53, 3, 'payment_verified', 'Memverifikasi pembayaran untuk booking 3', '127.0.0.1', '2026-02-04 12:55:46', '2026-02-04 12:55:46'),
(54, 3, 'booking_completed', 'Menyelesaikan booking 1', '127.0.0.1', '2026-02-04 12:55:49', '2026-02-04 12:55:49'),
(55, 2, 'user_deleted', 'Menghapus user: Rick Schultz IV', '127.0.0.1', '2026-02-04 13:23:19', '2026-02-04 13:23:19'),
(56, 2, 'user_deleted', 'Menghapus user: Prof. Daren Johnston', '127.0.0.1', '2026-02-04 13:23:22', '2026-02-04 13:23:22'),
(57, 2, 'user_deleted', 'Menghapus user: Fae Wintheiser', '127.0.0.1', '2026-02-04 13:23:25', '2026-02-04 13:23:25'),
(58, 2, 'user_deleted', 'Menghapus user: Retta Christiansen', '127.0.0.1', '2026-02-04 13:23:28', '2026-02-04 13:23:28'),
(59, 2, 'user_deleted', 'Menghapus user: Derpyus', '127.0.0.1', '2026-02-04 13:23:35', '2026-02-04 13:23:35'),
(60, 2, 'user_deleted', 'Menghapus user: Pantai', '127.0.0.1', '2026-02-04 13:23:39', '2026-02-04 13:23:39'),
(61, 2, 'user_deleted', 'Menghapus user: Dr. Theo Leuschke DVM', '127.0.0.1', '2026-02-04 13:23:41', '2026-02-04 13:23:41'),
(62, 2, 'user_deleted', 'Menghapus user: Archibald Veum', '127.0.0.1', '2026-02-04 13:23:44', '2026-02-04 13:23:44'),
(63, 2, 'user_deleted', 'Menghapus user: Dr. Buck Smitham', '127.0.0.1', '2026-02-04 13:23:47', '2026-02-04 13:23:47'),
(64, 19, 'booking_created', 'Membuat booking baru untuk ATC FUTSALL', '127.0.0.1', '2026-02-04 17:41:14', '2026-02-04 17:41:14'),
(65, 3, 'payment_verified', 'Memverifikasi pembayaran untuk booking 7', '127.0.0.1', '2026-02-04 17:42:39', '2026-02-04 17:42:39'),
(66, 2, 'lapangan_updated', 'Mengupdate lapangan: lapangan', '127.0.0.1', '2026-02-04 17:44:23', '2026-02-04 17:44:23'),
(67, 2, 'lapangan_status_toggled', 'Mengubah status lapangan: lapangan', '127.0.0.1', '2026-02-04 17:44:28', '2026-02-04 17:44:28'),
(68, 2, 'lapangan_deleted', 'Menghapus lapangan: lapangan', '127.0.0.1', '2026-02-04 17:44:33', '2026-02-04 17:44:33'),
(69, 2, 'lapangan_created', 'Membuat lapangan baru: aaaaa', '127.0.0.1', '2026-02-04 17:45:01', '2026-02-04 17:45:01'),
(70, 2, 'user_updated', 'Mengupdate user: runiii', '127.0.0.1', '2026-02-04 17:45:26', '2026-02-04 17:45:26'),
(71, 1, 'settings_updated', 'Mengupdate pengaturan web', '127.0.0.1', '2026-02-04 17:46:09', '2026-02-04 17:46:09'),
(72, 1, 'lapangan_updated', 'Mengupdate lapangan: aaaaa', '127.0.0.1', '2026-02-04 20:55:47', '2026-02-04 20:55:47'),
(73, 1, 'lapangan_created', 'Membuat lapangan baru: lapangan bola', '127.0.0.1', '2026-02-04 20:56:47', '2026-02-04 20:56:47'),
(74, 1, 'lapangan_updated', 'Mengupdate lapangan: ATC FUTSALL', '127.0.0.1', '2026-02-04 20:57:01', '2026-02-04 20:57:01'),
(75, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:31:41', '2026-02-04 21:31:41'),
(76, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:36:12', '2026-02-04 21:36:12'),
(77, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:36:22', '2026-02-04 21:36:22'),
(78, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:39:10', '2026-02-04 21:39:10'),
(79, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:39:15', '2026-02-04 21:39:15'),
(80, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:39:39', '2026-02-04 21:39:39'),
(81, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:39:47', '2026-02-04 21:39:47'),
(82, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:42:11', '2026-02-04 21:42:11'),
(83, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-04 21:42:33', '2026-02-04 21:42:33'),
(84, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-05 00:55:32', '2026-02-05 00:55:32'),
(85, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-05 00:55:47', '2026-02-05 00:55:47'),
(86, 1, 'menu_access_updated', 'Memperbarui hak akses menu', '127.0.0.1', '2026-02-05 00:55:57', '2026-02-05 00:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lapangan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','rejected','completed','cancelled') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `lapangan_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `total_harga`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 17, 1, '2026-02-06', '10:00:00', '12:00:00', 200000.00, 'completed', 'aaaaa', '2026-02-04 12:06:10', '2026-02-04 12:55:49'),
(2, 17, 1, '2026-02-07', '12:00:00', '14:00:00', 200000.00, 'pending', 'k', '2026-02-04 12:25:46', '2026-02-04 12:25:46'),
(3, 17, 1, '2026-02-14', '15:00:00', '16:00:00', 100000.00, 'confirmed', 'a', '2026-02-04 12:34:27', '2026-02-04 12:55:46'),
(4, 17, 1, '2026-02-14', '16:00:00', '18:00:00', 200000.00, 'completed', NULL, '2026-02-04 12:40:09', '2026-02-04 12:55:40'),
(5, 17, 1, '2026-02-13', '08:00:00', '10:00:00', 200000.00, 'completed', 'a', '2026-02-04 12:49:53', '2026-02-04 12:51:21'),
(6, 17, 1, '2026-02-06', '15:00:00', '17:00:00', 200000.00, 'completed', NULL, '2026-02-04 12:52:44', '2026-02-04 12:55:43'),
(7, 19, 1, '2026-02-10', '12:00:00', '13:00:00', 100000.00, 'confirmed', 'aaaa', '2026-02-04 17:41:13', '2026-02-04 17:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `custom_menus`
--

CREATE TABLE `custom_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_key` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_menus`
--

INSERT INTO `custom_menus` (`id`, `menu_key`, `menu_name`, `description`, `icon`, `route`, `url`, `is_active`, `created_at`, `updated_at`) VALUES
(16, 'dashboard', 'Dashboard', 'Halaman utama dashboard', 'fas fa-tachometer-alt', 'dashboard', '/dashboard', 1, NULL, NULL),
(17, 'bookings', 'Bookings', 'Manajemen booking lapangan', 'fas fa-calendar', 'bookings.index', '/bookings', 1, NULL, NULL),
(18, 'lapangans', 'Lapangans', 'Manajemen lapangan futsal', 'fas fa-map', 'lapangans.index', '/lapangans', 1, NULL, NULL),
(19, 'users', 'Kelola User', 'Manajemen pengguna sistem', 'fas fa-users', 'users.index', '/users', 1, NULL, NULL),
(20, 'keuangan', 'Keuangan', 'Laporan keuangan dan pembayaran', 'fas fa-money-bill-wave', 'keuangan.index', '/keuangan', 1, NULL, NULL),
(21, 'settings', 'Web Setting', 'Pengaturan sistem', 'fas fa-cog', 'settings.index', '/settings', 1, NULL, NULL),
(22, 'hakakses', 'Hak Akses', 'Manajemen hak akses menu', 'fas fa-user-shield', 'hakakses.index', '/hakakses', 1, NULL, NULL),
(23, 'activities', 'Log Activity', 'Log aktivitas sistem', 'fas fa-history', 'activities.index', '/activities', 1, NULL, NULL);

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
-- Table structure for table `lapangans`
--

CREATE TABLE `lapangans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `daerah` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `harga_per_jam` decimal(10,2) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lapangans`
--

INSERT INTO `lapangans` (`id`, `nama`, `lokasi`, `daerah`, `kapasitas`, `harga_per_jam`, `fasilitas`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ATC FUTSALL', 'Jakarta', 'Jakarta', 10, 100000.00, 'Lampu', 'lapangan/7YM9lxID4MVM2qpWtcl8Ha1vws2KR1GIARrQsFQx.jpg', 'aktif', '2026-02-03 09:38:00', '2026-02-04 20:57:01'),
(2, 'AAAA', '222esadw', 'Bandung', 2, 34000.00, 'dwdw', 'lapangan/c97fw4euT5VcdRZyVVYCM3pfJ1CLmPYCuuQ3YNPs.png', 'aktif', '2026-02-04 08:44:14', '2026-02-04 08:55:55'),
(6, 'aaaaa', 'aaa', 'Yogyakarta', 23, 23000.00, 'aaa', 'lapangan/Rl8s8VoaPW0SPhXIV99HzYwv40Yb08BedNbcbVJq.jpg', 'aktif', '2026-02-04 17:45:01', '2026-02-04 20:55:47'),
(7, 'lapangan bola', 'aaaa', 'Medan', 1, 56000.00, 'gatau', 'lapangan/WYvBR862IpVg1G514NjlzmKJSoMxo0lrGlZZ9wdr.png', 'aktif', '2026-02-04 20:56:47', '2026-02-04 20:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `menu_accesses`
--

CREATE TABLE `menu_accesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `can_access` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_accesses`
--

INSERT INTO `menu_accesses` (`id`, `role`, `menu_name`, `can_access`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'dashboard', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(2, 'superadmin', 'bookings', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(3, 'superadmin', 'lapangans', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(4, 'superadmin', 'users', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(5, 'superadmin', 'keuangan', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(6, 'superadmin', 'settings', 1, '2026-02-04 21:27:01', '2026-02-05 00:55:47'),
(7, 'superadmin', 'hakakses', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(8, 'superadmin', 'activities', 1, '2026-02-04 21:27:01', '2026-02-05 00:55:57'),
(9, 'admin', 'dashboard', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(10, 'admin', 'bookings', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(11, 'admin', 'lapangans', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(12, 'admin', 'users', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(13, 'admin', 'keuangan', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(14, 'admin', 'settings', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(15, 'admin', 'hakakses', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(16, 'admin', 'activities', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(17, 'manager', 'dashboard', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(18, 'manager', 'bookings', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(19, 'manager', 'lapangans', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(20, 'manager', 'users', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(21, 'manager', 'keuangan', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(22, 'manager', 'settings', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(23, 'manager', 'hakakses', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(24, 'manager', 'activities', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(25, 'customer', 'dashboard', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(26, 'customer', 'bookings', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(27, 'customer', 'lapangans', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(28, 'customer', 'users', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(29, 'customer', 'keuangan', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(30, 'customer', 'settings', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(31, 'customer', 'hakakses', 0, '2026-02-04 21:27:01', '2026-02-04 21:27:01'),
(32, 'customer', 'activities', 1, '2026-02-04 21:27:01', '2026-02-04 21:27:01');

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
(4, '2024_01_01_000003_create_lapangan_table', 1),
(5, '2024_01_01_000004_create_bookings_table', 1),
(6, '2024_01_01_000005_create_payments_table', 1),
(7, '2024_01_01_000006_create_activities_table', 1),
(8, '2026_02_03_154826_create_web_settings_table', 2),
(9, '2024_01_01_000001_create_custom_menus_table', 3),
(10, '2026_01_27_140741_create_menu_accesses_table', 3),
(11, '2026_01_27_145043_create_role_permissions_table', 3);

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
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `jumlah`, `metode_pembayaran`, `bukti_pembayaran`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 200000.00, 'transfer_bank', NULL, 'verified', NULL, '2026-02-04 12:06:10', '2026-02-04 12:19:34'),
(2, 2, 200000.00, 'transfer_bank', NULL, 'pending', NULL, '2026-02-04 12:25:46', '2026-02-04 12:25:46'),
(3, 3, 100000.00, 'transfer_bank', NULL, 'verified', NULL, '2026-02-04 12:34:27', '2026-02-04 12:55:46'),
(4, 4, 200000.00, 'transfer_bank', 'payments/1770234009_bfcaf22b743b06fa30be934d393da533.jpg', 'verified', NULL, '2026-02-04 12:40:09', '2026-02-04 12:55:37'),
(5, 5, 200000.00, 'cash', NULL, 'verified', NULL, '2026-02-04 12:49:53', '2026-02-04 12:49:53'),
(6, 6, 200000.00, 'ewallet', 'payments/1770234764_Screenshot_2026-01-27_181009.png', 'verified', NULL, '2026-02-04 12:52:44', '2026-02-04 12:54:37'),
(7, 7, 100000.00, 'transfer_bank', 'payments/1770252073_Screenshot_2026-02-05_015437.png', 'verified', NULL, '2026-02-04 17:41:14', '2026-02-04 17:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('bmgpqJyNRs49BKTrHSPNsqw4OxyPD9y3KieSGXC9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN0Z3ZTVzTlFMMWFEWW9OYjlQSjRBbWFHWXdYWDJXNEVMbm5WTENBeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZXVhbmdhbiI7czo1OiJyb3V0ZSI7czoxNDoia2V1YW5nYW4uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1770278160);

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
  `role` enum('customer','manager','admin','superadmin') NOT NULL DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `profile_photo`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@manfutsal.com', NULL, '$2y$12$DP5zcWthD6UPrJ0Yd4iPZes8thGAMMdfeT7ThVU8rLOmYviudOrAO', 'superadmin', '08123456789', 'Jakarta, Indonesia', NULL, 1, NULL, '2026-02-02 23:57:51', '2026-02-02 23:57:51'),
(2, 'Admin User', 'admin@manfutsal.com', NULL, '$2y$12$r/gIl79/x3J4bUODl4TYT.DMagDD9rwZ7MIlc7n//YgzmengYfm9C', 'admin', '08123456788', 'Jakarta, Indonesia', NULL, 1, NULL, '2026-02-02 23:57:52', '2026-02-02 23:57:52'),
(3, 'Manager User', 'manager@manfutsal.com', NULL, '$2y$12$zQs7EnUuFuFY463rP3dMfeFUWo/L1fimVo4FKIpIoJRFTi3R5UydO', 'manager', '08123456787', 'Jakarta, Indonesia', NULL, 1, NULL, '2026-02-02 23:57:52', '2026-02-02 23:57:52'),
(10, 'Stefanie Carroll', 'breanne.casper@example.com', '2026-02-02 23:57:53', '$2y$12$TJWYBB1wKf33RuWTC.Ucqe0ZutDc2yFe0Ht2uXKx.lUFnUVp2ggHu', 'customer', '(843) 606-0149', '507 Sister Heights Suite 792\nWest Otis, UT 66749-8307', NULL, 1, 'wdFMjgqrCT', '2026-02-02 23:57:54', '2026-02-02 23:57:54'),
(17, 'Chelsicaa', 'chelsica@gmail.com', NULL, '$2y$12$1GcnCp.kSpPUgpOMS5znEexwWhVxtrGNUI04N1.qQ4u7rGepf1eAi', 'customer', '0912912112', 'jakarta', NULL, 1, NULL, '2026-02-04 12:03:58', '2026-02-04 12:04:26'),
(18, 'lily', 'lily@gmail.com', NULL, '$2y$12$ViFJ.MSbcaiIPo0CrNM7i.7uH5X/etuGQYID76YWEHqLJHWASekCK', 'customer', '113132', '121', NULL, 1, NULL, '2026-02-04 13:26:15', '2026-02-04 13:26:15'),
(19, 'runiii', 'runi@Gmail.com', NULL, '$2y$12$jad.CQgmup7cNW1bJ3CDzup8wdhyaz4TI37DoWX3GymVjgCQmHXki', 'customer', '1322', '321', NULL, 1, NULL, '2026-02-04 17:40:32', '2026-02-04 17:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `key`, `value`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'Soccerrr', 'string', 'Nama aplikasi', '2026-02-03 09:20:53', '2026-02-04 17:46:09'),
(2, 'app_description', 'Sistem Manajemen Futsal', 'string', 'Deskripsi aplikasi', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(3, 'app_email', 'soccer@email.com', 'string', 'Email aplikasi', '2026-02-03 09:20:53', '2026-02-04 08:23:12'),
(4, 'app_phone', '+62 9223 212', 'string', 'Nomor telepon', '2026-02-03 09:20:53', '2026-02-04 08:23:12'),
(5, 'app_address', 'Jakarta, Indonesia', 'string', 'Alamat', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(6, 'social_facebook', '', 'string', 'Facebook URL', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(7, 'social_instagram', '', 'string', 'Instagram URL', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(8, 'social_twitter', '', 'string', 'Twitter URL', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(9, 'maintenance_mode', '0', 'boolean', 'Mode maintenance', '2026-02-03 09:20:53', '2026-02-04 08:23:25'),
(10, 'allow_registration', '1', 'boolean', 'Izinkan registrasi', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(11, 'email_notifications', '1', 'boolean', 'Notifikasi email', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(12, 'sms_notifications', '0', 'boolean', 'Notifikasi SMS', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(13, 'max_booking_per_day', '3', 'integer', 'Maksimal booking per hari', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(14, 'max_booking_hours', '4', 'integer', 'Maksimal jam booking', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(15, 'auto_confirm_booking', '0', 'boolean', 'Auto konfirmasi booking', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(16, 'payment_timeout', '60', 'integer', 'Timeout pembayaran (menit)', '2026-02-03 09:20:53', '2026-02-03 09:20:53'),
(17, 'app_logo', 'uploads/logo_1770218592.jpg', 'string', 'Logo aplikasi', '2026-02-04 08:23:12', '2026-02-04 08:23:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_user_id_index` (`user_id`),
  ADD KEY `activities_action_index` (`action`),
  ADD KEY `activities_created_at_index` (`created_at`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_lapangan_id_foreign` (`lapangan_id`),
  ADD KEY `bookings_tanggal_lapangan_id_index` (`tanggal`,`lapangan_id`),
  ADD KEY `bookings_user_id_status_index` (`user_id`,`status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `custom_menus`
--
ALTER TABLE `custom_menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `custom_menus_menu_key_unique` (`menu_key`),
  ADD KEY `custom_menus_menu_key_index` (`menu_key`),
  ADD KEY `custom_menus_is_active_index` (`is_active`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `lapangans`
--
ALTER TABLE `lapangans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_accesses`
--
ALTER TABLE `menu_accesses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_accesses_role_menu_name_unique` (`role`,`menu_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `payments_booking_id_index` (`booking_id`),
  ADD KEY `payments_status_index` (`status`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_name_unique` (`role_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `web_settings_key_unique` (`key`),
  ADD KEY `web_settings_key_index` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `custom_menus`
--
ALTER TABLE `custom_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lapangans`
--
ALTER TABLE `lapangans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_accesses`
--
ALTER TABLE `menu_accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
