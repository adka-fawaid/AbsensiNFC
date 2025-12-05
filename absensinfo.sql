-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2025 at 02:49 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensinfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `peserta_id` bigint UNSIGNED NOT NULL,
  `kegiatan_id` bigint UNSIGNED NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_absen` datetime NOT NULL,
  `status` enum('tepat_waktu','telat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `peserta_id`, `kegiatan_id`, `uid`, `waktu_absen`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 62, 1, '2917439351', '2025-12-03 21:04:50', 'telat', NULL, '2025-12-03 14:04:50', '2025-12-03 14:04:50'),
(3, 61, 1, '2920300055', '2025-12-03 21:05:12', 'telat', NULL, '2025-12-03 14:05:12', '2025-12-03 14:05:12'),
(4, 60, 1, '2918465127', '2025-12-03 21:05:21', 'telat', NULL, '2025-12-03 14:05:21', '2025-12-03 14:05:21'),
(5, 59, 1, '2920014007', '2025-12-03 21:05:30', 'telat', NULL, '2025-12-03 14:05:30', '2025-12-03 14:05:30'),
(6, 58, 1, '2917271319', '2025-12-03 21:05:36', 'telat', NULL, '2025-12-03 14:05:36', '2025-12-03 14:05:36'),
(7, 57, 1, '2918327431', '2025-12-03 21:05:43', 'telat', NULL, '2025-12-03 14:05:43', '2025-12-03 14:05:43'),
(8, 56, 1, '2918132455', '2025-12-03 21:05:52', 'telat', NULL, '2025-12-03 14:05:52', '2025-12-03 14:05:52'),
(9, 78, 1, '2920337399', '2025-12-03 21:30:34', 'telat', NULL, '2025-12-03 14:30:34', '2025-12-03 14:30:34'),
(10, 76, 1, '2919536167', '2025-12-03 21:30:41', 'telat', NULL, '2025-12-03 14:30:41', '2025-12-03 14:30:41'),
(11, 77, 1, '2918465591', '2025-12-03 21:30:46', 'telat', NULL, '2025-12-03 14:30:46', '2025-12-03 14:30:46'),
(12, 79, 1, '2919309927', '2025-12-03 21:30:51', 'telat', NULL, '2025-12-03 14:30:51', '2025-12-03 14:30:51'),
(13, 80, 1, '2917517895', '2025-12-03 21:30:58', 'telat', NULL, '2025-12-03 14:30:58', '2025-12-03 14:30:58'),
(14, 81, 1, '2920854695', '2025-12-03 21:31:01', 'telat', NULL, '2025-12-03 14:31:01', '2025-12-03 14:31:01'),
(15, 82, 1, '2920559303', '2025-12-03 21:31:08', 'telat', NULL, '2025-12-03 14:31:08', '2025-12-03 14:31:08'),
(16, 75, 1, '2921325623', '2025-12-03 21:31:25', 'telat', NULL, '2025-12-03 14:31:25', '2025-12-03 14:31:25'),
(17, 74, 1, '2921023111', '2025-12-03 21:31:29', 'telat', NULL, '2025-12-03 14:31:29', '2025-12-03 14:31:29'),
(18, 73, 1, '2921480167', '2025-12-03 21:31:33', 'telat', NULL, '2025-12-03 14:31:33', '2025-12-03 14:31:33'),
(19, 72, 1, '2917932935', '2025-12-03 21:31:35', 'telat', NULL, '2025-12-03 14:31:35', '2025-12-03 14:31:35'),
(20, 70, 1, '2921428919', '2025-12-03 21:31:45', 'telat', NULL, '2025-12-03 14:31:45', '2025-12-03 14:31:45'),
(21, 39, 1, '2919334087', '2025-12-03 21:33:15', 'telat', NULL, '2025-12-03 14:33:15', '2025-12-03 14:33:15'),
(22, 43, 1, '2918277463', '2025-12-03 21:33:42', 'telat', NULL, '2025-12-03 14:33:42', '2025-12-03 14:33:42'),
(23, 40, 1, '2920950183', '2025-12-03 21:34:02', 'telat', NULL, '2025-12-03 14:34:02', '2025-12-03 14:34:02'),
(24, 42, 1, '2920668775', '2025-12-03 21:34:05', 'telat', NULL, '2025-12-03 14:34:05', '2025-12-03 14:34:05'),
(25, 41, 1, '2918247127', '2025-12-03 21:34:07', 'telat', NULL, '2025-12-03 14:34:07', '2025-12-03 14:34:07'),
(26, 10, 1, '2918322007', '2025-12-03 21:34:48', 'telat', NULL, '2025-12-03 14:34:48', '2025-12-03 14:34:48'),
(27, 9, 1, '2918167815', '2025-12-03 21:35:01', 'telat', NULL, '2025-12-03 14:35:01', '2025-12-03 14:35:01'),
(28, 8, 1, '2917306087', '2025-12-03 21:35:03', 'telat', NULL, '2025-12-03 14:35:03', '2025-12-03 14:35:03'),
(29, 7, 1, '2921053927', '2025-12-03 21:35:07', 'telat', NULL, '2025-12-03 14:35:07', '2025-12-03 14:35:07'),
(30, 6, 1, '2919681607', '2025-12-03 21:35:12', 'telat', NULL, '2025-12-03 14:35:12', '2025-12-03 14:35:12'),
(31, 5, 1, '2919882231', '2025-12-03 21:35:15', 'telat', NULL, '2025-12-03 14:35:15', '2025-12-03 14:35:15'),
(32, 4, 1, '2917117223', '2025-12-03 21:35:18', 'telat', NULL, '2025-12-03 14:35:18', '2025-12-03 14:35:18'),
(33, 3, 1, '2920189655', '2025-12-03 21:35:21', 'telat', NULL, '2025-12-03 14:35:21', '2025-12-03 14:35:21'),
(34, 63, 1, '2918597159', '2025-12-03 21:35:28', 'telat', NULL, '2025-12-03 14:35:28', '2025-12-03 14:35:28'),
(35, 64, 1, '2918917815', '2025-12-03 21:35:32', 'telat', NULL, '2025-12-03 14:35:32', '2025-12-03 14:35:32'),
(36, 65, 1, '2919835879', '2025-12-03 21:35:49', 'telat', NULL, '2025-12-03 14:35:49', '2025-12-03 14:35:49'),
(37, 83, 1, '2919894199', '2025-12-03 21:38:21', 'telat', NULL, '2025-12-03 14:38:21', '2025-12-03 14:38:21'),
(38, 66, 1, '2917786471', '2025-12-03 21:38:26', 'telat', NULL, '2025-12-03 14:38:26', '2025-12-03 14:38:26'),
(39, 67, 1, '2920504375', '2025-12-03 21:38:30', 'telat', NULL, '2025-12-03 14:38:30', '2025-12-03 14:38:30'),
(40, 68, 1, '2919983351', '2025-12-03 21:38:35', 'telat', NULL, '2025-12-03 14:38:35', '2025-12-03 14:38:35'),
(41, 69, 1, '2921300103', '2025-12-03 21:38:38', 'telat', NULL, '2025-12-03 14:38:38', '2025-12-03 14:38:38'),
(42, 51, 1, '2920632359', '2025-12-03 21:38:52', 'telat', NULL, '2025-12-03 14:38:52', '2025-12-03 14:38:52'),
(43, 52, 1, '2919567351', '2025-12-03 21:39:14', 'telat', NULL, '2025-12-03 14:39:14', '2025-12-03 14:39:14'),
(44, 53, 1, '2918602759', '2025-12-03 21:39:23', 'telat', NULL, '2025-12-03 14:39:23', '2025-12-03 14:39:23'),
(45, 54, 1, '2917308231', '2025-12-03 21:39:27', 'telat', NULL, '2025-12-03 14:39:27', '2025-12-03 14:39:27'),
(46, 55, 1, '2917608455', '2025-12-03 21:39:32', 'telat', NULL, '2025-12-03 14:39:32', '2025-12-03 14:39:32'),
(47, 44, 1, '2917962391', '2025-12-03 21:39:45', 'telat', NULL, '2025-12-03 14:39:45', '2025-12-03 14:39:45'),
(48, 45, 1, '2918409239', '2025-12-03 21:39:58', 'telat', NULL, '2025-12-03 14:39:58', '2025-12-03 14:39:58'),
(49, 46, 1, '2920790023', '2025-12-03 21:40:01', 'telat', NULL, '2025-12-03 14:40:01', '2025-12-03 14:40:01'),
(50, 47, 1, '2917874023', '2025-12-03 21:40:05', 'telat', NULL, '2025-12-03 14:40:05', '2025-12-03 14:40:05'),
(51, 48, 1, '2921296375', '2025-12-03 21:40:08', 'telat', NULL, '2025-12-03 14:40:08', '2025-12-03 14:40:08'),
(52, 49, 1, '2919111495', '2025-12-03 21:40:11', 'telat', NULL, '2025-12-03 14:40:11', '2025-12-03 14:40:11'),
(53, 50, 1, '2919288567', '2025-12-03 21:40:15', 'telat', NULL, '2025-12-03 14:40:15', '2025-12-03 14:40:15'),
(54, 18, 1, '2919004535', '2025-12-03 21:41:14', 'telat', NULL, '2025-12-03 14:41:14', '2025-12-03 14:41:14'),
(55, 19, 1, '2919322727', '2025-12-03 21:41:26', 'telat', NULL, '2025-12-03 14:41:26', '2025-12-03 14:41:26'),
(56, 25, 1, '2919581591', '2025-12-03 21:41:32', 'telat', NULL, '2025-12-03 14:41:32', '2025-12-03 14:41:32'),
(57, 24, 1, '2919633047', '2025-12-03 21:41:35', 'telat', NULL, '2025-12-03 14:41:35', '2025-12-03 14:41:35'),
(58, 20, 1, '2918551607', '2025-12-03 21:41:40', 'telat', NULL, '2025-12-03 14:41:40', '2025-12-03 14:41:40'),
(59, 21, 1, '2917776231', '2025-12-03 21:41:45', 'telat', NULL, '2025-12-03 14:41:45', '2025-12-03 14:41:45'),
(60, 22, 1, '2919632983', '2025-12-03 21:41:52', 'telat', NULL, '2025-12-03 14:41:52', '2025-12-03 14:41:52'),
(61, 23, 1, '2917285831', '2025-12-03 21:41:58', 'telat', NULL, '2025-12-03 14:41:58', '2025-12-03 14:41:58'),
(62, 17, 1, '2919062711', '2025-12-03 21:42:10', 'telat', NULL, '2025-12-03 14:42:10', '2025-12-03 14:42:10'),
(63, 11, 1, '2917563063', '2025-12-03 21:42:18', 'telat', NULL, '2025-12-03 14:42:18', '2025-12-03 14:42:18'),
(64, 12, 1, '2918877223', '2025-12-03 21:42:26', 'telat', NULL, '2025-12-03 14:42:26', '2025-12-03 14:42:26'),
(65, 13, 1, '2919570423', '2025-12-03 21:42:29', 'telat', NULL, '2025-12-03 14:42:29', '2025-12-03 14:42:29'),
(66, 14, 1, '2919720151', '2025-12-03 21:42:32', 'telat', NULL, '2025-12-03 14:42:32', '2025-12-03 14:42:32'),
(67, 15, 1, '2917588503', '2025-12-03 21:42:36', 'telat', NULL, '2025-12-03 14:42:36', '2025-12-03 14:42:36'),
(68, 16, 1, '2918744519', '2025-12-03 21:42:39', 'telat', NULL, '2025-12-03 14:42:39', '2025-12-03 14:42:39'),
(69, 26, 1, '2919200311', '2025-12-03 21:42:54', 'telat', NULL, '2025-12-03 14:42:54', '2025-12-03 14:42:54'),
(70, 27, 1, '2919595015', '2025-12-03 21:42:59', 'telat', NULL, '2025-12-03 14:42:59', '2025-12-03 14:42:59'),
(71, 28, 1, '2921056871', '2025-12-03 21:43:04', 'telat', NULL, '2025-12-03 14:43:04', '2025-12-03 14:43:04'),
(72, 29, 1, '2919165607', '2025-12-03 21:43:08', 'telat', NULL, '2025-12-03 14:43:08', '2025-12-03 14:43:08'),
(73, 30, 1, '2921053063', '2025-12-03 21:43:16', 'telat', NULL, '2025-12-03 14:43:16', '2025-12-03 14:43:16'),
(74, 31, 1, '2920635095', '2025-12-03 21:43:29', 'telat', NULL, '2025-12-03 14:43:29', '2025-12-03 14:43:29'),
(75, 32, 1, '2917407511', '2025-12-03 21:43:32', 'telat', NULL, '2025-12-03 14:43:32', '2025-12-03 14:43:32'),
(76, 34, 1, '2919569383', '2025-12-03 21:43:40', 'telat', NULL, '2025-12-03 14:43:40', '2025-12-03 14:43:40'),
(77, 33, 1, '2919858999', '2025-12-03 21:43:43', 'telat', NULL, '2025-12-03 14:43:43', '2025-12-03 14:43:43'),
(78, 35, 1, '2917557223', '2025-12-03 21:43:59', 'telat', NULL, '2025-12-03 14:43:59', '2025-12-03 14:43:59'),
(79, 36, 1, '2920845735', '2025-12-03 21:44:07', 'telat', NULL, '2025-12-03 14:44:07', '2025-12-03 14:44:07'),
(80, 37, 1, '2920193575', '2025-12-03 21:44:11', 'telat', NULL, '2025-12-03 14:44:11', '2025-12-03 14:44:11'),
(81, 38, 1, '2918296983', '2025-12-03 21:44:22', 'telat', NULL, '2025-12-03 14:44:22', '2025-12-03 14:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'kreasi', 'kreasi@bemkm.com', '$2y$12$RjMpHPSBW2SGMiJkHxWoreAdlAKBEeRpz60pZQ2xlVQ9nnDkdh7r.', '2025-12-03 11:02:54', '2025-12-03 11:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_batas_tepat` time NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `nama`, `tanggal`, `jam_mulai`, `jam_batas_tepat`, `lokasi`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'wgwgwg', '2025-12-03', '08:00:00', '07:00:00', 'gegegeg', 'gege', '2025-12-03 11:05:04', '2025-12-03 11:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_12_01_163123_create_admins_table', 1),
(6, '2025_12_01_163132_create_kegiatans_table', 1),
(7, '2025_12_01_163141_create_pesertas_table', 1),
(8, '2025_12_01_163149_create_absensis_table', 1),
(9, '2025_12_02_131948_add_nim_fakultas_to_pesertas_table', 1),
(10, '2025_12_02_132321_add_nim_and_fakultas_to_pesertas', 1),
(11, '2025_12_02_134319_make_uid_nullable_in_pesertas_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesertas`
--

CREATE TABLE `pesertas` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesertas`
--

INSERT INTO `pesertas` (`id`, `uid`, `nama`, `nim`, `fakultas`, `jabatan`, `created_at`, `updated_at`) VALUES
(3, '2920189655', 'Moh Adzka Fawaid', 'A11.2022.14656', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Menteri', '2025-12-03 12:47:11', '2025-12-03 12:47:11'),
(4, '2917117223', 'Ady Chandra', 'A11.2024.16070', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:48:32', '2025-12-03 12:48:32'),
(5, '2919882231', 'Syella Novita Amelia', 'A11.2024.16043', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:49:41', '2025-12-03 12:49:41'),
(6, '2919681607', 'Rafly Ramadhani', 'A11.2024.16066', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:51:13', '2025-12-03 12:51:13'),
(7, '2921053927', 'Wahyu Nur Setyono', 'A11.2022.14633', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:52:11', '2025-12-03 12:52:11'),
(8, '2917306087', 'Akbar Putra Jalu Lastino', 'A11.2024.16044', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Eksekutif Muda', '2025-12-03 12:53:05', '2025-12-03 12:53:05'),
(9, '2918167815', 'Fuad Anwar Ibrahim Shidiq', 'A11.2024.16047', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:53:45', '2025-12-03 12:53:45'),
(10, '2918322007', 'Najwa Handaria Suparna', 'A11.2024.16039', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Eksekutif Muda', '2025-12-03 12:55:15', '2025-12-03 12:55:15'),
(11, '2917563063', 'Firdaus Hakiki', 'C11.2022.02536', 'Bahasa Inggris / Fakultas Ilmu Budaya', 'Menteri', '2025-12-03 12:56:28', '2025-12-03 12:56:28'),
(12, '2918877223', 'Auliya Tegar Panji Budiyono', 'E11.2022.01145', 'Teknik Elektro / Fakultas Teknik', 'Staff Ahli', '2025-12-03 12:57:36', '2025-12-03 12:57:36'),
(13, '2919570423', 'Parani Wildhiyanaufaldi', 'A11.2023.15370', 'Teknik Informatika/ Fakultas Ilmu Komputer', 'Staff Ahli', '2025-12-03 12:58:39', '2025-12-03 12:58:39'),
(14, '2919720151', 'Langit Maajid Asy-Syahiidu', 'C12.2022.01099', 'Sastra Jepang/Fakultas Ilmu Budaya', 'Staff Ahli', '2025-12-03 12:59:28', '2025-12-03 12:59:28'),
(15, '2917588503', 'Dimas Maulana Majid', 'E11.2024.01269', 'Teknik Elektro / Fakultas Teknik', 'Staff Ahli', '2025-12-03 13:00:05', '2025-12-03 13:00:05'),
(16, '2918744519', 'Chela Jesica', 'D22.2024.03790', 'Rekam Medis/Fakultas Kesehatan', 'Staff Ahli Kementerian Sosial Politik', '2025-12-03 13:01:27', '2025-12-03 13:01:27'),
(17, '2919062711', 'Kesia Aphrodite Gabriella Ardianie', 'A15.2025.03329', 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Sosial Masyarakat', '2025-12-03 13:03:14', '2025-12-03 13:03:14'),
(18, '2919004535', 'Muhammad Rasha Mahdavikia', 'E11.2023.01202', 'Teknik Elektro / Fakultas Teknik', 'Menteri Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:04:56', '2025-12-03 13:04:56'),
(19, '2919322727', 'Danish Ara Zafir Ayesha', 'D22.2024.03792', 'Rekam Medis & Informasi Kesehatan/Fakultas Kesehatan', 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:06:02', '2025-12-03 13:06:02'),
(20, '2918551607', 'Kennard Owen Umbu Riada', 'A11. 2024.16054', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:07:12', '2025-12-03 13:07:12'),
(21, '2917776231', 'Ardra Khansa Danendra Daffa Akhmad', 'A11.2024.15927', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:08:47', '2025-12-03 13:08:47'),
(22, '2919632983', 'Muhamad Amirul Hassan Waluyo', 'E12.2022.01629', 'Teknik Industri / Fakultas Teknik', 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:09:57', '2025-12-03 13:09:57'),
(23, '2917285831', 'Isa Mahardika Sadino', 'A11.2024.16061', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:11:11', '2025-12-03 13:11:11'),
(24, '2919633047', 'Najwa Alya Putri Rahmadhani', 'A15.2024.03087', 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:12:44', '2025-12-03 13:12:44'),
(25, '2919581591', 'Reynavi Ahmadinejad Sulistyo', 'E12. 2025. 02202', 'Teknik Industri/Fakuktas Teknik', 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga', '2025-12-03 13:14:05', '2025-12-03 13:14:05'),
(26, '2919200311', 'Luklu\'un Aula', 'B11.2022.07879', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Presiden Mahasiswa', '2025-12-03 13:15:21', '2025-12-03 13:15:21'),
(27, '2919595015', 'Callista Widyaranti', 'B11.2022.07907', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Wakil Presiden Mahasiswa', '2025-12-03 13:16:08', '2025-12-03 13:16:08'),
(28, '2921056871', 'Nofa Setianto', 'A15.2022.02334', 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'Sekretaris Jenderal', '2025-12-03 13:16:55', '2025-12-03 13:16:55'),
(29, '2919165607', 'Fahrunnisa Amalia Putri', 'B11.2022.07883', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Staf Biro Administrasi', '2025-12-03 13:18:43', '2025-12-03 13:18:43'),
(30, '2921053063', 'Fathya Anindita', 'B11.2022.07873', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Kepala Biro Keuangan', '2025-12-03 13:20:18', '2025-12-03 13:20:18'),
(31, '2920635095', 'Pinkan Ayu Wijaya', 'C11.2022.02510', 'Bahasa Inggris/Fakultas Ilmu Budaya', 'Staf Biro Keuangan', '2025-12-03 13:21:20', '2025-12-03 13:21:20'),
(32, '2917407511', 'Tatagh Herawan Santoso', 'E11.2022.01147', 'Teknik Elektro / Fakultas Teknik', 'Menteri Koordinator Pergerakan', '2025-12-03 13:23:17', '2025-12-03 13:23:17'),
(33, '2919858999', 'Meydika Angga Adi Nugraha', 'E12.2022.01688', 'Teknik Industri / Fakultas Teknik', 'Menteri Koordinator Penaungan dan Kesejahteraan', '2025-12-03 13:24:41', '2025-12-03 13:24:41'),
(34, '2919569383', 'Alya Rahmadina', 'K11.2023.00011', 'Kedokteran / Fakultas Kedokteran', 'Menteri Koordinator Relasi dan Inovasi', '2025-12-03 13:26:20', '2025-12-03 13:26:20'),
(35, '2917557223', 'Yasmin Layyinatul Izza', 'E12.2024.01908', 'Teknik Industri/Fakultas Teknik', 'Menteri Advokasi dan Kesejahteraan Mahasiswa', '2025-12-03 13:28:20', '2025-12-03 13:28:20'),
(36, '2920845735', 'Renaldi alta pramudia', 'B11.2025.09478', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Eksekutif Muda Kementerian Advokasi dan Kesejahteraan Mahasiswa', '2025-12-03 13:29:47', '2025-12-03 13:31:38'),
(37, '2920193575', 'Nabeel Raza Destama', 'D11.2025.04315', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Eksekutif Muda Kementerian Advokasi dan Kesejahteraan Mahasiswa', '2025-12-03 13:31:09', '2025-12-03 13:31:09'),
(38, '2918296983', 'Ulya Noviana', 'D11.2024.04101', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Staf Ahli Kementerian Advokasi dan Kesejahteraan Mahasiswa', '2025-12-03 13:32:53', '2025-12-03 13:32:53'),
(39, '2919334087', 'Vika Aulia Rahma', 'K11.2023.00007', 'Kedokteran/Fakultas Kedokteran', 'Menteri Kementerian Pengembangan Perempuan dan Inklusifitas', '2025-12-03 13:34:51', '2025-12-03 13:34:51'),
(40, '2920950183', 'Rizka Amalia Dewi', 'D11.2024.04038', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Eksekutif Muda Kementerian Pengembangan Perempuan dan Inklusifitas', '2025-12-03 13:36:04', '2025-12-03 13:36:04'),
(41, '2918247127', 'Melani', 'D11.2023.03732', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas', '2025-12-03 13:37:30', '2025-12-03 13:37:30'),
(42, '2920668775', 'Rikha Maharani', 'B12.2024.05010', 'Teknik Industri/Fakultas Teknik', 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas', '2025-12-03 13:39:08', '2025-12-03 13:39:08'),
(43, '2918277463', 'Aqilla Yumna Imtiyas', 'K11.2023.00004', 'Kedokteran/Fakultas Kedokteran', 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas', '2025-12-03 13:40:09', '2025-12-03 13:40:09'),
(44, '2917962391', 'Ramadhani Artidinata Abiansah', 'A11.2023.15236', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Menteri Kementerian Luar Negeri', '2025-12-03 13:41:11', '2025-12-03 13:41:11'),
(45, '2918409239', 'Ardhi Azizzul Hakiem', 'A12.2025.07426', 'Sistem Informasi / Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Luar Negeri', '2025-12-03 13:42:17', '2025-12-03 13:42:17'),
(46, '2920790023', 'Tika Nur Firdausiana', 'A12.2023.07080', 'Sistem Informasi / Fakultas Ilmu Komputer', 'Staff Ahli Kementerian Luar Negeri', '2025-12-03 13:43:46', '2025-12-03 13:43:46'),
(47, '2917874023', 'Marssa Lu\'luil Khusna', 'E12.2025.02196', 'Sistem Informasi / Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Luar Negeri', '2025-12-03 13:45:18', '2025-12-03 13:45:18'),
(48, '2921296375', 'Faqih Rizqian Mahardika', 'E13.2022.00203', 'Teknik Biomedis / Fakultas Teknik', 'Staff Ahli Kementerian Luar Negeri', '2025-12-03 13:46:54', '2025-12-03 13:46:54'),
(49, '2919111495', 'Ayu Wijaya Mukti Kusumaningrum', 'B11.2023.08610', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Eksekutif Muda Kementerian Luar Negeri', '2025-12-03 13:48:01', '2025-12-03 13:48:01'),
(50, '2919288567', 'Theresia Angelina Hungan', 'A15.2025.03155', 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Luar Negeri', '2025-12-03 13:49:39', '2025-12-03 13:49:39'),
(51, '2920632359', 'Ichlasul Hadi', 'E12.2022.01655', 'Teknik Industri/Fakultas Teknik', 'Staf Ahli Kementerian Badan Usaha Milik Keluarga Mahasiswa', '2025-12-03 13:50:59', '2025-12-03 13:50:59'),
(52, '2919567351', 'Muhammad Riko Ivan Habibi', 'E12.2023.01803', 'Teknik Industri/Fakultas Teknik', 'Menteri Kementerian Badan Usaha Milik Keluarga Mahasiswa', '2025-12-03 13:51:50', '2025-12-03 13:51:50'),
(53, '2918602759', 'Nabilla Luthfia Khairunnisa', 'A15.2024.02885', 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa', '2025-12-03 13:52:42', '2025-12-03 13:52:42'),
(54, '2917308231', 'Nabila wahyuningsih', 'E12.2023.01817', 'Teknik Industri/Fakultas Teknik', 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa', '2025-12-03 13:53:55', '2025-12-03 13:53:55'),
(55, '2917608455', 'Agung Aprilyanto', 'E12.2024.02025', 'Teknik Industri/Fakultas Teknik', 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa', '2025-12-03 13:55:02', '2025-12-03 13:55:02'),
(56, '2918132455', 'Rafi Eka Pratama', 'E12.2022.01671', 'Teknik Industri/Fakultas Teknik', 'Kepala Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 13:56:38', '2025-12-03 13:56:38'),
(57, '2918327431', 'Dahlan Agestya Zarkasi', 'E12.2022.01683', 'Teknik Industri / Fakultas Teknik', 'Staf Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 13:58:38', '2025-12-03 13:58:38'),
(58, '2917271319', 'Trisha Putri Priyandari', 'A15.2024.02875', 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 13:59:39', '2025-12-03 13:59:39'),
(59, '2920014007', 'Eagle Robby Irmawan', 'E13.2022.00205', 'Teknik Biomedis / Fakultas Teknik', 'Staf Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 14:00:56', '2025-12-03 14:00:56'),
(60, '2918465127', 'Yola Enova Sabilla', 'A11.2024.16049', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 14:01:50', '2025-12-03 14:01:50'),
(61, '2920300055', 'Hilal Sya\'ban Syarif', 'A11.2024.15931', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 14:02:54', '2025-12-03 14:02:54'),
(62, '2917439351', 'Dawam Al Firdaus', 'E12.2022.01702', 'Teknik Industri / Fakultas Teknik', 'Staf Biro Pengembangan Sumber Daya Mahasiswa', '2025-12-03 14:03:55', '2025-12-03 14:03:55'),
(63, '2918597159', 'Tiara Sekar Rahmawati', 'A14.2022.04131', 'Desain Komunikasi Visual/Fakultas Ilmu Komputer', 'Menteri Biro Media Komunikasi dan Informasi', '2025-12-03 14:07:49', '2025-12-03 14:07:49'),
(64, '2918917815', 'Alexander Bangkit Sugiharto Pranoto', 'A11.2024.16046', 'Teknik Informatika / Fakultas Ilmu Komputer', 'Staff Ahli Biro Media Komunikasi dan Informasi', '2025-12-03 14:08:49', '2025-12-03 14:08:49'),
(65, '2919835879', 'Pasha Regita', 'A15.2024.02888', 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'Kepala Biro Biro Media Komunikasi dan Informasi', '2025-12-03 14:10:43', '2025-12-03 14:10:43'),
(66, '2917786471', 'Rohmatun Nabila', 'A14.2022.04142', 'Desain Komunikasi Visual / Fakultas Ilmu Komputer', 'Staff Biro Media Komunikasi dan Informasi', '2025-12-03 14:12:55', '2025-12-03 14:12:55'),
(67, '2920504375', 'Sylvana Anggi Putri br Silalahi', 'A14.2022.04126', 'Desain Komunikasi Visual /Fakultas Ilmu Komputer', 'Staff Biro Media Komunikasi dan Informasi', '2025-12-03 14:15:07', '2025-12-03 14:15:07'),
(68, '2919983351', 'Ayu Kirania Putri', 'D11.2025.04366', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Eksekutif Muda Biro Media Komunikasi dan Informasi', '2025-12-03 14:16:24', '2025-12-03 14:16:24'),
(69, '2921300103', 'Surya Putra Adhi Prastya', 'A11.2025.16223', 'Teknik Informatika/Fakultas Ilmu Komputer', 'Eksekutif Muda Biro Media Komunikasi dan Informasi', '2025-12-03 14:17:08', '2025-12-03 14:17:08'),
(70, '2921428919', 'Aufa Haziq Zahirul Haq', 'E12.2023.01838', 'Teknik Industri / Fakultas Teknik', 'Menteri Kementerian Dalam Negeri', '2025-12-03 14:18:46', '2025-12-03 14:18:46'),
(71, '2921044679', 'Dwi Rahma Anggreani', 'E12.2024.01995', 'Teknik Industri/Fakuktas Teknik', 'Staff Ahli Kementerian Dalam Negeri', '2025-12-03 14:20:08', '2025-12-03 14:20:08'),
(72, '2917932935', 'Anninda Arum Bhakti', 'A15.2024.03035', 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'Staff Ahli Kementerian Dalam Negeri', '2025-12-03 14:20:54', '2025-12-03 14:20:54'),
(73, '2921480167', 'Vania Angwen Salsabila', 'B11.2025.09234', 'Manajemen/Fakultas Ekonomi dan Bisnis', 'Eksekutif Muda Kementerian Luar Negeri', '2025-12-03 14:21:49', '2025-12-03 14:21:49'),
(74, '2921023111', 'Prince Ostheo Ednor', 'A15.2024.03094', 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'Staff Ahli Kementerian Dalam Negeri', '2025-12-03 14:23:13', '2025-12-03 14:23:13'),
(75, '2921325623', 'Alsya Artha Alghifari', 'E12.2023.01859', 'Teknik Industri/Fakultas Teknik', 'Staff Ahli Kementerian Dalam Negeri', '2025-12-03 14:24:06', '2025-12-03 14:24:06'),
(76, '2919536167', 'Muhammad Iqbal Tsabit', 'E12.2023.01807', 'Teknik Industri/Fakultas Teknik', 'Menteri Kementerian Sosial Masyarakat', '2025-12-03 14:25:31', '2025-12-03 14:25:31'),
(77, '2918465591', 'Qonita Rifdah Nur Wanna', 'B12.2023.04806', 'Akuntansi/Fakultas Ekonomi dan Bisnis', 'Staff Ahli Kementerian Sosial Masyarakat', '2025-12-03 14:26:15', '2025-12-03 14:26:15'),
(78, '2920337399', 'Nabila Amara Safira', 'D11.2024.04062', 'Kesehatan Masyarakat/Fakultas Kesehatan', 'Staff Ahli Kementerian Sosial Masyarakat', '2025-12-03 14:27:06', '2025-12-03 14:27:06'),
(79, '2919309927', 'Hazma Insaana Najuda', 'E12.2024.02003', 'Teknik Industri/Fakultas Teknik', 'Staff Ahli Kementerian Sosial Masyarakat', '2025-12-03 14:27:52', '2025-12-03 14:27:52'),
(80, '2917517895', 'Nuripin Subkhan', 'E11.2024.01255', 'Teknik Elektro/Fakultas Teknik', 'Staff Ahli Kementerian Sosial Masyarakat', '2025-12-03 14:28:39', '2025-12-03 14:28:39'),
(81, '2920854695', 'Navisha Adha Primasari', 'D12.2024.00300', 'Kesehatan Lingkungan/Fakultas Kesehatan', 'Eksekutif Muda Kementerian Sosial Masyarakat', '2025-12-03 14:29:28', '2025-12-03 14:29:28'),
(82, '2920559303', 'Annisa Amalia Shofa', 'E12.2023.01845', 'Teknik Industri/Fakultas Teknik', 'Eksekutif Muda Kementerian Sosial Masyarakat', '2025-12-03 14:30:22', '2025-12-03 14:30:22'),
(83, '2919894199', 'Ramadhan Putra Ardiansyah', 'E12.2022.01618', 'Teknik Industri/Fakultas Teknik', 'Eksekutif Muda Biro Media Komunikasi dan Informasi', '2025-12-03 14:38:10', '2025-12-03 14:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensis_peserta_id_kegiatan_id_unique` (`peserta_id`,`kegiatan_id`),
  ADD KEY `absensis_kegiatan_id_foreign` (`kegiatan_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesertas`
--
ALTER TABLE `pesertas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesertas_nim_unique` (`nim`),
  ADD UNIQUE KEY `pesertas_uid_unique` (`uid`);

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
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesertas`
--
ALTER TABLE `pesertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensis_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `pesertas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
