-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2022 at 01:55 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pointofsale`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area`, `area_status`, `created_at`, `updated_at`) VALUES
(1, 'Gujranwala', 'Y', '2022-08-05 00:00:30', '2022-08-05 00:00:30'),
(2, 'khiyali', 'Y', '2022-08-17 08:06:54', '2022-08-17 08:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `party` int(11) NOT NULL,
  `cash_in` double(8,2) NOT NULL,
  `cash_out` double(8,2) NOT NULL,
  `balance` double(8,2) NOT NULL,
  `cf_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_flows`
--

INSERT INTO `cash_flows` (`id`, `party`, `cash_in`, `cash_out`, `balance`, `cf_date`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 1000.00, 1000.00, '2022-08-18', '2022-08-31 06:37:58', '2022-08-31 06:37:58'),
(2, 1, 1000.00, 0.00, -1000.00, '2022-08-24', '2022-08-31 06:46:46', '2022-08-31 06:46:46'),
(3, 1, 0.00, 1234.00, 1234.00, '2022-08-18', '2022-08-31 06:47:17', '2022-08-31 06:47:17'),
(4, 1, 0.00, 5000.00, 5000.00, '2022-08-31', '2022-08-31 06:47:24', '2022-08-31 06:47:24'),
(5, 1, 0.00, 5000.00, 5000.00, '2022-08-11', '2022-08-31 06:48:36', '2022-08-31 06:48:36'),
(6, 2, 0.00, 1000.00, 1000.00, '2022-06-30', '2022-08-31 06:48:54', '2022-08-31 06:48:54'),
(7, 2, 0.00, 2000.00, 2000.00, '2022-08-31', '2022-08-31 06:49:04', '2022-08-31 06:49:04'),
(8, 1, 0.00, 2000.00, 2000.00, '2022-09-10', '2022-08-31 06:49:13', '2022-08-31 06:49:13'),
(9, 1, 1000.00, 0.00, -1000.00, '2020-07-26', '2022-09-01 00:18:37', '2022-09-01 00:18:37'),
(10, 1, 0.00, 5000.00, 5000.00, '2022-09-01', '2022-09-01 00:24:52', '2022-09-01 00:24:52'),
(11, 2, 0.00, 10000.00, 10000.00, '2022-09-05', '2022-09-05 03:25:11', '2022-09-05 03:25:11'),
(12, 2, 1200.00, 0.00, -1200.00, '2022-09-13', '2022-09-13 02:46:27', '2022-09-13 02:46:27'),
(13, 1, 0.00, 500.00, 500.00, '2022-09-13', '2022-09-13 02:46:51', '2022-09-13 02:46:51'),
(14, 1, 0.00, 500.00, 500.00, '2022-09-13', '2022-09-13 02:47:29', '2022-09-13 02:47:29'),
(15, 1, 1000.00, 0.00, -1000.00, '2022-09-13', '2022-09-13 02:50:45', '2022-09-13 02:50:45'),
(16, 1, 1000.00, 0.00, -1000.00, '2022-09-14', '2022-09-14 02:41:04', '2022-09-14 02:41:04'),
(17, 1, 1000.00, 0.00, -1000.00, '2022-09-14', '2022-09-14 02:42:23', '2022-09-14 02:42:23'),
(18, 2, 0.00, 2000.00, 2000.00, '2022-09-14', '2022-09-14 02:43:09', '2022-09-14 02:43:09'),
(19, 2, 1000.00, 0.00, -1000.00, '2022-09-14', '2022-09-14 02:52:19', '2022-09-14 02:52:19'),
(20, 2, 0.00, 200.00, 200.00, '2022-09-14', '2022-09-14 02:54:39', '2022-09-14 02:54:39'),
(21, 2, 200.00, 0.00, -200.00, '2022-09-14', '2022-09-14 02:58:03', '2022-09-14 02:58:03'),
(22, 3, 1000.00, 0.00, -1000.00, '2022-09-14', '2022-09-14 04:15:03', '2022-09-14 04:15:03'),
(23, 1, 0.00, 2000.00, 2000.00, '2022-09-14', '2022-09-14 04:29:53', '2022-09-14 04:29:53'),
(24, 2, 0.00, 1000.00, 1000.00, '2022-09-14', '2022-09-14 04:32:46', '2022-09-14 04:32:46'),
(25, 3, 0.00, 500.00, 500.00, '2022-09-14', '2022-09-14 04:34:25', '2022-09-14 04:34:25'),
(26, 1, 0.00, 1000.00, 1000.00, '2022-09-14', '2022-09-14 04:44:32', '2022-09-14 04:44:32'),
(27, 1, 2000.00, 0.00, -2000.00, '2022-09-14', '2022-09-14 04:46:53', '2022-09-14 04:46:53'),
(28, 1, 0.00, 1500.00, 1500.00, '2022-09-14', '2022-09-14 04:52:44', '2022-09-14 04:52:44'),
(29, 1, 1002.00, 0.00, -1002.00, '2022-09-14', '2022-09-14 04:53:38', '2022-09-14 04:53:38'),
(30, 1, 0.00, 1200.00, 1200.00, '2022-09-14', '2022-09-14 05:00:16', '2022-09-14 05:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `opening_date` date DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  `cash_in_hand` int(11) DEFAULT NULL,
  `total_sale` int(11) NOT NULL DEFAULT 0,
  `total_return` int(11) NOT NULL DEFAULT 0,
  `closing_amount` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_registers`
--

INSERT INTO `cash_registers` (`id`, `user_id`, `opening_date`, `closing_date`, `cash_in_hand`, `total_sale`, `total_return`, `closing_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-09-05', '2022-09-05', 1000, 1325, 190, 12135, 'Close', '2022-09-05 03:22:45', '2022-09-05 03:26:42'),
(2, 1, '2022-09-05', NULL, 1000, 0, 0, 0, 'Open', '2022-09-05 03:31:59', '2022-09-05 03:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `cat_status`, `created_at`, `updated_at`) VALUES
(1, 'pents', 'Y', '2022-08-11 05:00:47', '2022-08-11 06:29:23'),
(2, 'cars', 'Y', '2022-08-11 06:29:12', '2022-08-11 06:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `cheque_infos`
--

CREATE TABLE `cheque_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `chq_number` int(11) NOT NULL,
  `chq_amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `clear_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chq_date` date DEFAULT NULL,
  `clear_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cheque_infos`
--

INSERT INTO `cheque_infos` (`id`, `cust_id`, `chq_number`, `chq_amount`, `status`, `note`, `supp_id`, `user_id`, `clear_note`, `payment_method`, `chq_date`, `clear_date`, `created_at`, `updated_at`) VALUES
(1, 1, 100, 1000, 'Cleared', 'dsfgsdfg', NULL, 1, 'ert', 'received_in_company', '2022-08-24', '2022-09-05', '2022-08-31 06:46:46', '2022-09-05 03:02:55'),
(2, 2, 45213, 10000, 'Cleared', 'dfgsdfgdsfg', NULL, 1, 'sdfgsdfg', 'paid_by_company', '2022-09-05', '2022-09-05', '2022-09-05 03:25:11', '2022-09-05 03:25:51'),
(3, 1, 15532135, 2000, 'Due', 'asdasdf', NULL, 1, NULL, 'paid_by_company', '2022-09-14', NULL, '2022-09-14 04:29:53', '2022-09-14 04:29:53'),
(4, 2, 1524245, 1000, 'Due', 'sdfgsdg', NULL, 1, NULL, 'paid_by_company', '2022-09-14', NULL, '2022-09-14 04:32:46', '2022-09-14 04:32:46'),
(5, 3, 654564, 500, 'Due', 'sdgsdfg', NULL, 1, NULL, 'paid_by_company', '2022-09-14', NULL, '2022-09-14 04:34:25', '2022-09-14 04:34:25'),
(6, NULL, 452120, 1500, 'Due', 'sdfgsdfg', 1, 1, NULL, 'received_in_company', '2022-09-14', NULL, '2022-09-14 04:52:44', '2022-09-14 04:52:44'),
(7, NULL, 485215245, 1002, 'Due', 'sfdgdfg', 1, 1, NULL, 'paid_by_company', '2022-09-14', NULL, '2022-09-14 04:53:38', '2022-09-14 04:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `client_details`
--

CREATE TABLE `client_details` (
  `id` int(255) NOT NULL,
  `Bus_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Logo_Invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Logo_Header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Watermark_Report` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Name_Ur` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Address` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Address_Ur` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Contact1` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Contact2` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Contact3` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Vat_Reg` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bus_Language` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `comp_name`, `comp_email`, `comp_contact`, `comp_address`, `comp_status`, `created_at`, `updated_at`) VALUES
(1, 'Bin Dawood', 'bindawood@gmail.com', '0390-2189381', 'Area Baghbanpura, Gujranwala', 'Y', '2022-07-14 04:23:48', '2022-07-14 04:23:48'),
(2, 'Gif Beauties', 'gift@gmail.com', '0321-8931827', 'Company Address', 'N', '2022-07-14 04:24:15', '2022-07-14 04:27:05'),
(3, 'Chase Up', 'chaseup@gmail.com', '0300-0000001', 'Mumtaz Market,Gujranwala', 'Y', '2022-07-14 04:24:42', '2022-07-14 04:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cust_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint(255) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_id` bigint(20) DEFAULT NULL,
  `witness1` int(11) DEFAULT NULL,
  `witness2` int(11) DEFAULT NULL,
  `witness3` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `cust_name`, `address`, `contact`, `cnic`, `email`, `cust_image`, `fathername`, `area_id`, `status`, `supp_id`, `witness1`, `witness2`, `witness3`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 'walk_in_customer', 'Nill', '0300-0000000', '00000-0000000-0', NULL, '1658914793.webp', 'Nill', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2022-07-27 04:39:53', '2022-07-27 04:39:53'),
(2, 'Khizran', 'Gujranwala city', '0312-1212121', NULL, 'khizran@gmail.com', '1659675647.JPG', NULL, 1, 'Y', 1, NULL, NULL, NULL, NULL, '2022-07-27 04:42:19', '2022-08-05 00:04:47'),
(3, 'Danish', 'Bagbanpura Town ,Block haji Kareem', '0331-8769683', '34101-1234567-8', 'dmughal908@gmail.com', '1659183099.jpg', 'Iqbal', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2022-07-30 07:11:39', '2022-07-30 07:11:39'),
(4, 'Zubair hashmi', 'Kachi Fatomand', '0300-1010101', NULL, NULL, '1659605277.jpg', 'Sayed Hakeem uLLah Hashmi', 3, 'Y', NULL, NULL, NULL, NULL, 4, '2022-08-04 04:27:57', '2022-08-04 04:35:04'),
(5, 'Haram', 'Bagbanpura Town ,Block Unchi masjid', '0312-1212121', '12121-2121212-1', 'haramashraf123@gmail.com', '1659606227.jpg', 'Ashraf', 3, 'Y', NULL, NULL, NULL, NULL, 1, '2022-08-04 04:43:47', '2022-08-04 04:43:47'),
(6, 'Khizran', 'Gujranwala', '0312-1212121', NULL, 'khizran@gmail.com', '1659675647.JPG', NULL, 1, 'Y', 1, NULL, NULL, NULL, NULL, '2022-08-05 00:00:47', '2022-08-05 00:00:47'),
(7, 'Hadeed ul Hassan Hadi', 'lahore', '0345-4545455', '32132-1321321-3', NULL, '', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2022-08-17 07:11:45', '2022-08-17 07:11:45'),
(8, 'iqra', 'gujranwala', '0312-5825842', '16543-2135743-5', NULL, '', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2022-08-17 07:15:50', '2022-08-17 07:15:50'),
(9, 'Hannan', 'St # 3 Muhallah sultanpura hafizabada road gujranwala', '0365-4654654', '65465-4654654-6', NULL, '1660741668.jpg', NULL, 1, 'Y', NULL, NULL, NULL, NULL, 2, '2022-08-17 08:07:48', '2022-08-17 08:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

CREATE TABLE `customer_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_bill_amount` double(8,2) NOT NULL,
  `paid_amount` double(8,2) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `balance` double(8,2) NOT NULL,
  `cust_acc_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`id`, `total_bill_amount`, `paid_amount`, `payment_type`, `cust_invoice_no`, `cust_id`, `payment_method`, `supp_id`, `balance`, `cust_acc_date`, `created_at`, `updated_at`) VALUES
(1, 270.00, 70.00, 'received_in_company', 'SL-212', 2, 'By Cash', NULL, 200.00, '2022-09-13', '2022-09-13 01:58:48', '2022-09-13 01:58:48'),
(2, 270.00, 370.00, 'received_in_company', 'SL-215', 2, 'By Cash', NULL, -100.00, '2022-09-13', '2022-09-13 02:23:25', '2022-09-13 02:23:25'),
(3, 90.00, 100.00, 'received_in_company', 'SL-216', 2, 'By Cash', NULL, -10.00, '2022-09-13', '2022-09-13 02:32:17', '2022-09-13 02:32:17'),
(4, 0.00, 1200.00, 'received_in_company', 'CP-12', 2, 'By Cash', NULL, -1200.00, '2022-09-13', '2022-09-13 02:46:27', '2022-09-13 02:46:27'),
(5, 500.00, 0.00, 'paid_by_company', 'CP-13', 1, 'By Cash', NULL, 500.00, '2022-09-13', '2022-09-13 02:46:51', '2022-09-13 02:46:51'),
(6, 500.00, 0.00, 'paid_by_company', 'CP-14', 1, 'By Cash', NULL, 500.00, '2022-09-13', '2022-09-13 02:47:29', '2022-09-13 02:47:29'),
(7, 270.00, 0.00, 'received_in_company', 'SL-218', 2, 'By Cash', NULL, 270.00, '2022-09-13', '2022-09-13 02:48:44', '2022-09-13 02:48:44'),
(8, 0.00, 1000.00, 'received_in_company', 'CP-15', 1, 'By Cash', NULL, -1000.00, '2022-09-13', '2022-09-13 02:50:45', '2022-09-13 02:50:45'),
(9, 1990.00, 1600.00, 'received_in_company', 'SL-220', 4, 'By Cash', NULL, 390.00, '2022-09-13', '2022-09-13 02:57:53', '2022-09-13 02:57:53'),
(10, 360.00, 400.00, 'received_in_company', 'SL-224', 1, 'By Cash', NULL, -40.00, '2022-09-13', '2022-09-13 06:32:35', '2022-09-13 06:32:35'),
(11, 450.00, 1520.00, 'received_in_company', 'SL-227', 1, 'By Cash', NULL, -1070.00, '2022-09-13', '2022-09-13 06:37:21', '2022-09-13 06:37:21'),
(12, 160.00, 500.00, 'received_in_company', 'SL-268', 4, 'By Cash', NULL, -340.00, '2022-09-14', '2022-09-14 01:17:47', '2022-09-14 01:17:47'),
(13, 0.00, 1000.00, 'received_in_company', 'CP-17', 1, 'By Cash', NULL, -1000.00, '2022-09-14', '2022-09-14 02:41:04', '2022-09-14 02:41:04'),
(14, 0.00, 1000.00, 'received_in_company', 'CP-18', 1, 'By Cash', NULL, -1000.00, '2022-09-14', '2022-09-14 02:42:23', '2022-09-14 02:42:23'),
(15, 2000.00, 0.00, 'paid_by_company', 'CP-19', 2, 'By Cash', NULL, 2000.00, '2022-09-14', '2022-09-14 02:43:09', '2022-09-14 02:43:09'),
(16, 0.00, 1000.00, 'received_in_company', 'CP-20', 2, 'By Cash', NULL, -1000.00, '2022-09-14', '2022-09-14 02:52:19', '2022-09-14 02:52:19'),
(17, 200.00, 0.00, 'paid_by_company', 'CP-21', 2, 'By Cash', NULL, 200.00, '2022-09-14', '2022-09-14 02:54:39', '2022-09-14 02:54:39'),
(18, 0.00, 200.00, 'received_in_company', 'CP-22', 2, 'By Cash', NULL, -200.00, '2022-09-14', '2022-09-14 02:58:03', '2022-09-14 02:58:03'),
(19, 0.00, 1000.00, 'received_in_company', 'CP-23', 3, 'By Cash', NULL, -1000.00, '2022-09-14', '2022-09-14 04:15:03', '2022-09-14 04:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_name`, `address`, `contact`, `cnic`, `email`, `status`, `emp_image`, `emp_type`, `created_at`, `updated_at`) VALUES
(1, 'Maham darakhshan', 'Gujranwala city', '0302-0202020', '12123-1312313-2', 'maham@gmail.com', 'Y', '1658921210.jpg', 'sweeper', '2022-07-27 06:23:06', '2022-07-27 06:26:50'),
(2, 'Jarrar', 'Gujranwala', '0301-0101010', '34101-0101010-1', NULL, 'Y', '', 'Office boy', '2022-08-12 02:54:26', '2022-08-12 02:54:26'),
(3, 'Muhammad Bilal', 'gujranwala', '0387-8978798', '78687-6876786-8', NULL, 'Y', '1661427140.jpg', 'Worker', '2022-08-25 06:32:20', '2022-08-25 06:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE `employee_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emp_earning` double(8,2) NOT NULL,
  `emp_withdraw_amount` double(8,2) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processed_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double(8,2) NOT NULL,
  `emp_acc_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` int(11) NOT NULL,
  `exp_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_addedby` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_desc` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `cat_id`, `exp_amount`, `exp_addedby`, `exp_desc`, `exp_date`, `exp_status`, `created_at`, `updated_at`) VALUES
(1, 2, '2500', 'Mehak', 'BBQ', '2022-07-12', 'Y', '2022-07-13 04:02:26', '2022-07-13 06:12:37'),
(2, 2, '2000', 'Nadeem', 'Samose', '2022-07-13', 'Y', '2022-07-13 04:06:30', '2022-07-13 06:22:42'),
(3, 1, '20000', 'Hadeed ul Hassan', 'Electricity Bill', '2022-07-13', 'Y', '2022-07-13 06:06:16', '2022-07-13 06:06:16'),
(4, 1, '6000', 'Hadeed ul Hassan', 'Water Bill', '2022-07-13', 'N', '2022-07-13 06:07:46', '2022-07-13 06:22:23'),
(5, 2, '500', 'Abdul Hannan', 'Biriyani', '2022-07-14', 'Y', '2022-07-14 04:06:33', '2022-07-14 04:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `cat_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bills', 'Y', '2022-07-13 00:32:42', '2022-07-13 01:28:49'),
(2, 'Food Expense', 'Y', '2022-07-13 01:28:59', '2022-07-13 01:28:59'),
(3, 'Salaraies', 'Y', '2022-07-13 01:29:11', '2022-07-13 01:29:11'),
(4, 'Electronics', 'N', '2022-07-13 01:29:19', '2022-07-13 01:43:01');

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
-- Table structure for table `invoice_configs`
--

CREATE TABLE `invoice_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_inv_language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `sale_inv_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_nos`
--

CREATE TABLE `invoice_nos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` int(255) NOT NULL DEFAULT 0,
  `purchase_invoice_no` int(255) NOT NULL DEFAULT 0,
  `cust_acc_invoice_no` int(255) NOT NULL DEFAULT 0,
  `supp_acc_invoice_no` int(255) NOT NULL DEFAULT 0,
  `empp_acc_invoice_no` int(255) NOT NULL DEFAULT 0,
  `sale_return_invoice` int(255) DEFAULT 0,
  `purch_return_invoice` int(255) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_nos`
--

INSERT INTO `invoice_nos` (`id`, `invoice_no`, `purchase_invoice_no`, `cust_acc_invoice_no`, `supp_acc_invoice_no`, `empp_acc_invoice_no`, `sale_return_invoice`, `purch_return_invoice`, `created_at`, `updated_at`) VALUES
(1, 269, 5, 26, 7, 4, 3, 1, '2022-05-13 02:23:21', '2022-09-14 05:00:16');

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
(53, '2014_10_12_000000_create_users_table', 1),
(54, '2014_10_12_100000_create_password_resets_table', 1),
(55, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(56, '2019_08_19_000000_create_failed_jobs_table', 1),
(57, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(58, '2022_04_25_064636_create_sessions_table', 1),
(59, '2022_04_25_071836_create_categories_table', 1),
(60, '2022_04_25_071903_create_u_o_m_s_table', 1),
(61, '2022_04_25_072036_create_products_table', 1),
(62, '2022_04_25_074234_create_customers_table', 1),
(63, '2022_04_25_074301_create_suppliers_table', 1),
(64, '2022_04_25_095326_create_employees_table', 1),
(65, '2022_04_26_093428_create_areas_table', 1),
(66, '2022_04_26_093444_create_types_table', 1),
(69, '2022_05_12_112415_create_sales_table', 2),
(70, '2022_05_12_112434_create_sale_details_table', 2),
(72, '2022_05_13_065854_create_invoice_nos_table', 3),
(73, '2022_05_16_102014_create_client_details_table', 4),
(74, '2022_06_21_071847_create_purchases_table', 5),
(75, '2022_06_21_073603_create_purchase_details_table', 6),
(76, '2022_06_21_114354_create_cash_registers_table', 7),
(80, '2022_06_23_095400_create_customer_accounts_table', 8),
(81, '2022_06_23_095416_create_supplier_accounts_table', 8),
(82, '2022_06_23_095534_create_employee_accounts_table', 8),
(83, '2022_06_24_072331_create_cash_flows_table', 9),
(85, '2022_06_25_094922_create_cheque_infos_table', 10),
(88, '2022_07_13_115604_create_sale_returns_table', 11),
(89, '2022_07_13_115639_create_sale_return_details_table', 11),
(94, '2022_08_05_072138_create_purchase_returns_table', 12),
(95, '2022_08_05_073229_create_purchase_return_details_table', 12),
(96, '2022_08_06_073333_create_stock_movements_table', 13),
(97, '2022_09_05_125718_create_invoice_configs_table', 14);

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generic_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UPC_EAN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `product_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manage_stock` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` bigint(20) DEFAULT NULL,
  `uom_id` bigint(20) DEFAULT NULL,
  `costprice` double(10,2) DEFAULT NULL,
  `retailprice` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `fretailprice` double(10,2) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reorder_qty` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `generic_name`, `UPC_EAN`, `inventory`, `supp_id`, `product_status`, `product_type`, `manage_stock`, `product_image`, `cat_id`, `uom_id`, `costprice`, `retailprice`, `discount`, `fretailprice`, `qty`, `expirydate`, `created_at`, `updated_at`, `reorder_qty`) VALUES
(1, 'head&sholder', '_head&sholder', '10001', 'Y', 1, 'Y', '', 'N', '1659012838.JPG', 1, 1, 290.00, 390.00, 0.00, 300.00, 131, NULL, NULL, '2022-09-05 03:23:21', NULL),
(2, 'clear', '_clear', '10002', 'Y', NULL, 'Y', '', 'N', '', 1, 1, 100.00, 0.00, 10.00, 0.00, NULL, '2022-12-29', NULL, '2022-08-26 01:04:19', NULL),
(4, 'Lux', '_Lux', '10003', 'Y', NULL, 'Y', '', 'Y', '', 2, 1, 80.00, 100.00, 5.00, 95.00, 420, '2022-08-20', NULL, '2022-09-05 03:23:21', 2),
(5, 'Dettol', '_Dettol', '10004', 'Y', NULL, 'Y', '', 'Y', '', 2, 1, 70.00, 90.00, 0.00, 90.00, 1012, NULL, NULL, '2022-09-14 01:17:47', 2),
(6, 'goldenpearl', '_goldenpearl', '10005', 'Y', 1, 'Y', '', 'Y', '1659013483.jpg', 1, 1, 120.00, 150.00, 10.00, 140.00, 81, '2022-06-14', NULL, '2022-09-12 07:43:44', 2),
(7, 'fair&lovely', '_fair&lovely', '10006', 'Y', NULL, 'Y', '', 'Y', '', 2, 1, 120.00, 150.00, 10.00, 140.00, 1854, '2022-08-31', NULL, '2022-09-12 07:43:44', 2),
(8, 'faizabeaauty', '_faizabeauty', '10007', 'Y', NULL, 'Y', '', 'Y', '', 1, 1, 120.00, 150.00, 10.00, 140.00, 100, '2022-06-21', NULL, '2022-09-12 07:43:44', 2),
(9, 'nikeshirt', '_nikeshirt', '10008', 'Y', NULL, 'Y', '', 'Y', '', 2, 1, 1200.00, 1500.00, 50.00, 1450.00, 30, '2022-08-31', NULL, '2022-09-13 02:57:53', 2),
(10, 'kaishirt', '_kaishirt', '10009', 'Y', 1, 'Y', '', 'Y', '1659014055.jpg', 2, 1, 600.00, 900.00, 0.00, 900.00, 5, '2022-08-31', NULL, '2022-09-13 01:44:10', 2),
(11, 'nikeshoes', '_nikeshoes', '10010', 'Y', NULL, 'Y', '', 'Y', '', 2, 1, 1600.00, 1900.00, 0.00, 1900.00, 43, '2022-05-26', NULL, '2022-06-03 07:44:40', 2),
(13, 'tulsi supari', 'tulsi', '252915', 'Y', NULL, 'Y', NULL, 'Y', '1659012923.jpg', 1, 1, 250.00, 350.00, 1.00, 350.00, 0, '2022-12-27', '2022-07-27 06:55:28', '2022-09-13 02:57:53', 2),
(14, 'test', '_test', '304139', 'Y', NULL, 'Y', NULL, 'Y', '1661493212.jpeg', 1, 1, 200.00, 200.00, 2.00, 196.00, 0, NULL, '2022-08-26 00:53:32', '2022-09-13 02:57:53', 0),
(15, 'check2', '_check2', '223297', 'Y', NULL, 'Y', NULL, 'Y', '1661494085.jpg', 1, 2, 15.00, 12.00, NULL, 12.00, 0, NULL, '2022-08-26 01:08:05', '2022-08-26 01:08:05', 0),
(16, 'check3', '_check3', '125163', 'Y', 1, 'Y', NULL, 'Y', '1661494844.jpeg', 2, 3, 2.00, 2.00, NULL, 2.00, 1, '2023-02-28', '2022-08-26 01:20:44', '2022-08-26 01:20:44', 0),
(17, 'check3', '_check3', '309902', 'Y', 1, 'Y', NULL, 'Y', '1663071580.jpeg', 1, 3, 50.00, 90.00, 10.00, 81.00, 100, NULL, '2022-09-13 07:19:40', '2022-09-13 07:19:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_id` int(11) NOT NULL,
  `refrence_no` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `order_total` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `invoice_no`, `supp_id`, `refrence_no`, `user_id`, `purchase_date`, `order_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PU-1', 1, NULL, 1, '2022-09-01', 1610, 'Completed', '2022-09-01 00:25:31', '2022-09-01 00:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL,
  `supp_id` int(11) NOT NULL,
  `Invoice_no` varchar(257) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UPC_EAN` int(11) NOT NULL,
  `QTY` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `prod_id`, `supp_id`, `Invoice_no`, `prod_name`, `UPC_EAN`, `QTY`, `cost_price`, `total_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'PU-1', 'Dettol', 10004, 23, 70, 1610, 'Completed', '2022-09-01 00:25:31', '2022-09-01 00:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `return_amount` double(8,2) DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `user_id`, `return_amount`, `supp_id`, `status`, `return_invoice_no`, `created_at`, `updated_at`) VALUES
(1, 1, 380.00, NULL, 'Completed', 'PR-2', '2022-08-27 04:25:48', '2022-08-27 04:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_qty` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `total_price` double(8,2) DEFAULT NULL,
  `return_detail_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `prod_id`, `user_id`, `supp_id`, `invoice`, `return_qty`, `price`, `total_price`, `return_detail_status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 'PR-2', 2.00, 70.00, 140.00, 'Complete', '2022-08-27 04:25:48', '2022-08-27 04:25:48'),
(2, 4, 1, 1, 'PR-2', 3.00, 80.00, 240.00, 'Complete', '2022-08-27 04:25:48', '2022-08-27 04:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `order_total` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `invoice_no` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_amount` int(11) DEFAULT NULL,
  `change_amount` int(11) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `cust_id`, `user_id`, `sale_date`, `order_total`, `discount`, `invoice_no`, `total_amount`, `payment_amount`, `change_amount`, `payment_method`, `status`, `profit`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2022-09-01', 3270, 0, 'SL-19', 3270, 2500, -770, 'Cash', 'Complete', 970, '2022-09-01 02:14:26', '2022-09-01 02:14:26'),
(2, 2, 1, '2022-09-01', 190, 0, 'SL-21', 190, 300, 110, 'Cash', 'Complete', 30, '2022-09-01 02:16:26', '2022-09-05 03:18:11'),
(3, 2, 1, '2022-09-05', 1325, 0, 'SL-89', 1325, 1400, 75, 'Cash', 'Complete', 165, '2022-09-05 03:23:21', '2022-09-05 03:23:21'),
(4, 3, 1, '2022-09-12', 790, 0, 'SL-187', 790, 600, -190, 'Cash', 'Complete', 120, '2022-09-12 07:43:44', '2022-09-12 07:43:44'),
(5, 2, 1, '2022-09-13', 90, 0, 'SL-201', 13675, 1000, -12675, 'Cash', 'Complete', 13605, '2022-09-13 01:07:59', '2022-09-13 01:07:59'),
(6, 2, 1, '2022-09-13', 1350, 0, 'SL-210', 27610, 1520, -26090, 'Cash', 'Complete', 26660, '2022-09-13 01:44:10', '2022-09-13 01:44:10'),
(7, 1, 1, '2022-09-13', 90, 0, 'SL-211', 13324, 13324, 0, 'Cash', 'Complete', 13254, '2022-09-13 01:48:31', '2022-09-13 01:48:31'),
(8, 2, 1, '2022-09-13', 270, 0, 'SL-212', 270, 70, -200, 'Cash', 'Complete', 60, '2022-09-13 01:58:48', '2022-09-13 01:58:48'),
(9, 2, 1, '2022-09-13', 270, 0, 'SL-215', 270, 370, 100, 'Cash', 'Complete', 60, '2022-09-13 02:23:25', '2022-09-13 02:23:25'),
(10, 2, 1, '2022-09-13', 90, 0, 'SL-216', 90, 100, 10, 'Cash', 'Complete', 20, '2022-09-13 02:32:17', '2022-09-13 02:32:17'),
(11, 2, 1, '2022-09-13', 270, 0, 'SL-218', 270, 0, -270, 'Cash', 'Complete', 60, '2022-09-13 02:48:44', '2022-09-13 02:48:44'),
(12, 4, 1, '2022-09-13', 1996, 6, 'SL-220', 1990, 1600, -390, 'Cash', 'Complete', 340, '2022-09-13 02:57:53', '2022-09-13 02:57:53'),
(13, 1, 1, '2022-09-13', 360, 0, 'SL-224', 360, 400, 40, 'Cash', 'Complete', 80, '2022-09-13 06:32:35', '2022-09-13 06:32:35'),
(14, 1, 1, '2022-09-13', 450, 0, 'SL-227', 450, 1520, 1070, 'Cash', 'Complete', 100, '2022-09-13 06:37:21', '2022-09-13 06:37:21'),
(15, 4, 1, '2022-09-14', 160, 0, 'SL-268', 160, 500, 340, 'Cash', 'Complete', 20, '2022-09-14 01:17:47', '2022-09-14 01:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_no` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `cost_price` int(11) DEFAULT NULL,
  `retail_price` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_costprice` int(11) DEFAULT NULL,
  `total_fretailprice` int(11) DEFAULT NULL,
  `fretail_price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `profit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `product_name`, `invoice_no`, `user_id`, `customer_id`, `product_id`, `qty`, `cost_price`, `retail_price`, `status`, `total_costprice`, `total_fretailprice`, `fretail_price`, `discount`, `profit`, `created_at`, `updated_at`) VALUES
(1, 'Dettol', 'SL-19', 1, 2, 5, 3, 70, 90, 'Complete', 210, 270, 90, 0, 60, '2022-09-01 02:14:26', '2022-09-01 02:14:26'),
(2, 'kaishirt', 'SL-19', 1, 2, 10, 3, 600, 900, 'Complete', 1800, 2700, 900, 0, 900, '2022-09-01 02:14:26', '2022-09-01 02:14:26'),
(3, 'head&sholder', 'SL-19', 1, 2, 1, 1, 290, 390, 'Complete', 290, 300, 300, 0, 10, '2022-09-01 02:14:26', '2022-09-01 02:14:26'),
(4, 'Lux', 'SL-21', 1, 2, 4, 2, 80, 100, 'Complete', 320, 190, 95, 5, 30, '2022-09-01 02:16:26', '2022-09-05 03:18:11'),
(5, 'head&sholder', 'SL-89', 1, 2, 1, 1, 290, 390, 'Complete', 290, 300, 300, 0, 10, '2022-09-05 03:23:21', '2022-09-05 03:23:21'),
(6, 'goldenpearl', 'SL-89', 1, 2, 6, 6, 120, 150, 'Complete', 720, 840, 140, 10, 120, '2022-09-05 03:23:21', '2022-09-05 03:23:21'),
(7, 'Lux', 'SL-89', 1, 2, 4, 1, 80, 100, 'Complete', 80, 95, 95, 5, 15, '2022-09-05 03:23:21', '2022-09-05 03:23:21'),
(8, 'Dettol', 'SL-89', 1, 2, 5, 1, 70, 90, 'Complete', 70, 90, 90, 0, 20, '2022-09-05 03:23:21', '2022-09-05 03:23:21'),
(9, 'goldenpearl', 'SL-187', 1, 3, 6, 2, 120, 150, 'Complete', 240, 280, 140, 10, 40, '2022-09-12 07:43:44', '2022-09-12 07:43:44'),
(10, 'fair&lovely', 'SL-187', 1, 3, 7, 2, 120, 150, 'Complete', 240, 280, 140, 10, 40, '2022-09-12 07:43:44', '2022-09-12 07:43:44'),
(11, 'faizabeaauty', 'SL-187', 1, 3, 8, 1, 120, 150, 'Complete', 120, 140, 140, 10, 20, '2022-09-12 07:43:44', '2022-09-12 07:43:44'),
(12, 'Dettol', 'SL-187', 1, 3, 5, 1, 70, 90, 'Complete', 70, 90, 90, 0, 20, '2022-09-12 07:43:44', '2022-09-12 07:43:44'),
(13, 'Dettol', 'SL-201', 1, 2, 5, 1, 70, 90, 'Complete', 70, 90, 90, 0, 20, '2022-09-13 01:07:59', '2022-09-13 01:07:59'),
(14, 'Dettol', 'SL-210', 1, 2, 5, 5, 70, 90, 'Complete', 350, 450, 90, 0, 100, '2022-09-13 01:44:10', '2022-09-13 01:44:10'),
(15, 'kaishirt', 'SL-210', 1, 2, 10, 1, 600, 900, 'Complete', 600, 900, 900, 0, 300, '2022-09-13 01:44:10', '2022-09-13 01:44:10'),
(16, 'Dettol', 'SL-211', 1, 1, 5, 1, 70, 90, 'Complete', 70, 90, 90, 0, 20, '2022-09-13 01:48:31', '2022-09-13 01:48:31'),
(17, 'Dettol', 'SL-212', 1, 2, 5, 3, 70, 90, 'Complete', 210, 270, 90, 0, 60, '2022-09-13 01:58:48', '2022-09-13 01:58:48'),
(18, 'Dettol', 'SL-215', 1, 2, 5, 3, 70, 90, 'Complete', 210, 270, 90, 0, 60, '2022-09-13 02:23:25', '2022-09-13 02:23:25'),
(19, 'Dettol', 'SL-216', 1, 2, 5, 1, 70, 90, 'Complete', 70, 90, 90, 0, 20, '2022-09-13 02:32:17', '2022-09-13 02:32:17'),
(20, 'Dettol', 'SL-218', 1, 2, 5, 3, 70, 90, 'Complete', 210, 270, 90, 0, 60, '2022-09-13 02:48:44', '2022-09-13 02:48:44'),
(21, 'nikeshirt', 'SL-220', 1, 4, 9, 1, 1200, 1500, 'Complete', 1200, 1450, 1450, 50, 250, '2022-09-13 02:57:53', '2022-09-13 02:57:53'),
(22, 'tulsi supari', 'SL-220', 1, 4, 13, 1, 250, 350, 'Complete', 250, 350, 350, 1, 100, '2022-09-13 02:57:53', '2022-09-13 02:57:53'),
(23, 'test', 'SL-220', 1, 4, 14, 1, 200, 200, 'Complete', 200, 196, 196, 2, -4, '2022-09-13 02:57:53', '2022-09-13 02:57:53'),
(24, 'Dettol', 'SL-224', 1, 1, 5, 4, 70, 90, 'Complete', 280, 360, 90, 0, 80, '2022-09-13 06:32:35', '2022-09-13 06:32:35'),
(25, 'Dettol', 'SL-227', 1, 1, 5, 5, 70, 90, 'Complete', 350, 450, 90, 0, 100, '2022-09-13 06:37:21', '2022-09-13 06:37:21'),
(26, 'Dettol', 'SL-268', 1, 4, 5, 2, 70, 80, 'Complete', 140, 160, 80, 0, 20, '2022-09-14 01:17:47', '2022-09-14 01:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `return_amount` double(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_returns`
--

INSERT INTO `sale_returns` (`id`, `user_id`, `return_amount`, `status`, `return_invoice_no`, `created_at`, `updated_at`) VALUES
(1, 1, 190.00, 'Completed', 'SR-1', '2022-09-05 03:18:11', '2022-09-05 03:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_qty` double(8,2) NOT NULL,
  `price` float NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `return_detail_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_return_details`
--

INSERT INTO `sale_return_details` (`id`, `prod_id`, `user_id`, `invoice`, `return_qty`, `price`, `total_price`, `return_detail_status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'SR-1', 2.00, 95, 190.00, 'Complete', '2022-09-05 03:18:11', '2022-09-05 03:18:11');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RCCDAiheD6APRlxAFCvkz56lcYGeYLhkqlASPZjI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRTd0d2xQendhU0pubmZUdGpack1OaWxuVTY4SlFwZTBreHkxaVRJMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBwbGllcmFkZHBheXZpZXciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJDNNRm1KTS5EN21rSEJtMkZXSGxZN3VJcGFEME1yd1ZYTWVkenIvellxUnd1MDVSaFo0R29PIjt9', 1663149616);

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL,
  `supp_id` int(11) NOT NULL,
  `qty` double(8,2) NOT NULL,
  `cost_price` double(8,2) NOT NULL,
  `total_cost` double(8,2) NOT NULL,
  `fretail_price` double(8,2) NOT NULL,
  `total_fretail` double(8,2) NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `prod_id`, `supp_id`, `qty`, `cost_price`, `total_cost`, `fretail_price`, `total_fretail`, `invoice_no`, `stock_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 5.00, 70.00, 350.00, 90.00, 450.00, 'PR-11', 'Stock Out', 'Y', '2022-08-06 06:35:56', '2022-08-06 06:35:56'),
(2, 4, 1, 5.00, 80.00, 400.00, 95.00, 475.00, 'PR-11', 'Stock Out', 'Y', '2022-08-06 06:35:56', '2022-08-06 06:35:56'),
(3, 4, 1, 200.00, 80.00, 16000.00, 95.00, 7600.00, 'PU-4', 'Stock In', 'Y', '2022-08-06 06:59:57', '2022-08-06 06:59:57'),
(4, 5, 1, 34.00, 70.00, 2380.00, 90.00, 6300.00, 'PU-7', 'Stock In', 'Y', '2022-08-10 02:21:16', '2022-08-10 02:21:16'),
(5, 7, 1, 23.00, 120.00, 2760.00, 140.00, 16800.00, 'PU-7', 'Stock In', 'Y', '2022-08-10 02:21:16', '2022-08-10 02:21:16'),
(6, 1, 1, 100.00, 290.00, 29000.00, 300.00, 87000.00, 'PU-7', 'Stock In', 'Y', '2022-08-10 02:21:16', '2022-08-10 02:21:16'),
(7, 5, 1, 14.00, 70.00, 980.00, 0.00, 0.00, 'PR-41', 'Stock Out', 'Y', '2022-08-10 06:40:05', '2022-08-10 06:40:05'),
(8, 7, 1, 3.00, 120.00, 360.00, 0.00, 0.00, 'PR-41', 'Stock Out', 'Y', '2022-08-10 06:40:05', '2022-08-10 06:40:05'),
(9, 1, 1, 10.00, 290.00, 2900.00, 0.00, 0.00, 'PR-41', 'Stock Out', 'Y', '2022-08-10 06:40:06', '2022-08-10 06:40:06'),
(10, 5, 1, 10.00, 70.00, 700.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:44:57', '2022-08-10 06:44:57'),
(11, 7, 1, 5.00, 120.00, 600.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:44:57', '2022-08-10 06:44:57'),
(12, 1, 1, 5.00, 290.00, 1450.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:44:57', '2022-08-10 06:44:57'),
(13, 5, 1, 10.00, 70.00, 700.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:45:04', '2022-08-10 06:45:04'),
(14, 7, 1, 5.00, 120.00, 600.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:45:04', '2022-08-10 06:45:04'),
(15, 1, 1, 5.00, 290.00, 1450.00, 0.00, 0.00, 'PR-43', 'Stock Out', 'Y', '2022-08-10 06:45:04', '2022-08-10 06:45:04'),
(16, 7, 1, 3.00, 120.00, 360.00, 0.00, 0.00, 'PR-44', 'Stock Out', 'Y', '2022-08-10 06:47:49', '2022-08-10 06:47:49'),
(17, 1, 1, 5.00, 290.00, 1450.00, 0.00, 0.00, 'PR-44', 'Stock Out', 'Y', '2022-08-10 06:47:49', '2022-08-10 06:47:49'),
(18, 5, 1, 100.00, 70.00, 7000.00, 90.00, 6300.00, 'PU-9', 'Stock In', 'Y', '2022-08-10 07:02:50', '2022-08-10 07:02:50'),
(19, 7, 1, 154.00, 120.00, 18480.00, 140.00, 16800.00, 'PU-9', 'Stock In', 'Y', '2022-08-10 07:02:50', '2022-08-10 07:02:50'),
(20, 1, 1, 90.00, 290.00, 26100.00, 300.00, 87000.00, 'PU-9', 'Stock In', 'Y', '2022-08-10 07:02:50', '2022-08-10 07:02:50'),
(21, 5, 1, 10.00, 70.00, 700.00, 0.00, 0.00, 'PR-45', 'Stock Out', 'Y', '2022-08-10 07:10:14', '2022-08-10 07:10:14'),
(22, 7, 1, 4.00, 120.00, 480.00, 0.00, 0.00, 'PR-45', 'Stock Out', 'Y', '2022-08-10 07:10:14', '2022-08-10 07:10:14'),
(23, 1, 1, 3.00, 290.00, 870.00, 0.00, 0.00, 'PR-45', 'Stock Out', 'Y', '2022-08-10 07:10:14', '2022-08-10 07:10:14'),
(24, 5, 1, 12.00, 70.00, 840.00, 90.00, 6300.00, 'PU-1', 'Stock In', 'Y', '2022-08-15 04:38:45', '2022-08-15 04:38:45'),
(25, 4, 1, 23.00, 80.00, 1840.00, 95.00, 7600.00, 'PU-1', 'Stock In', 'Y', '2022-08-15 04:38:45', '2022-08-15 04:38:45'),
(26, 5, 1, 2.00, 70.00, 140.00, 0.00, 0.00, 'PR-2', 'Stock Out', 'Y', '2022-08-27 04:25:48', '2022-08-27 04:25:48'),
(27, 4, 1, 3.00, 80.00, 240.00, 0.00, 0.00, 'PR-2', 'Stock Out', 'Y', '2022-08-27 04:25:48', '2022-08-27 04:25:48'),
(28, 5, 1, 23.00, 70.00, 1610.00, 90.00, 6300.00, 'PU-1', 'Stock In', 'Y', '2022-09-01 00:25:31', '2022-09-01 00:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agancy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_customer` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supp_name`, `company_name`, `agancy_name`, `address`, `contact`, `email`, `status`, `is_customer`, `supp_image`, `area`, `created_at`, `updated_at`) VALUES
(1, 'Khizran', 'IT Solutions', 'Gujranwala agency', 'Gujranwala city', '0312-1212121', 'khizran@gmail.com', 'Y', 'Y', '1659675647.JPG', 1, '2022-08-05 00:00:47', '2022-08-05 00:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_accounts`
--

CREATE TABLE `supplier_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_bill_amount` double(8,2) DEFAULT NULL,
  `paid_amount` double(8,2) DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `balance` double(8,2) DEFAULT NULL,
  `supp_acc_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_accounts`
--

INSERT INTO `supplier_accounts` (`id`, `total_bill_amount`, `paid_amount`, `payment_type`, `supp_invoice_no`, `cust_id`, `payment_method`, `supp_id`, `balance`, `supp_acc_date`, `created_at`, `updated_at`) VALUES
(1, 1000.00, 0.00, 'received_in_company', 'SP-3', NULL, 'By Cash', 1, 1000.00, '2022-09-14', '2022-09-14 04:44:32', '2022-09-14 04:44:32'),
(2, 0.00, 2000.00, 'paid_by_company', 'SP-4', NULL, 'By Cash', 1, -2000.00, '2022-09-14', '2022-09-14 04:46:53', '2022-09-14 04:46:53'),
(3, 1200.00, 0.00, 'received_in_company', 'SP-7', NULL, 'By Cash', 1, 1200.00, '2022-09-14', '2022-09-14 05:00:16', '2022-09-14 05:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`, `type_status`, `created_at`, `updated_at`) VALUES
(1, 'type d', 'Y', '2022-04-28 00:10:51', '2022-04-28 00:10:51'),
(2, 'type d', 'Y', '2022-04-28 00:11:53', '2022-04-28 00:11:53'),
(3, 'typ2', 'Y', '2022-04-28 00:12:43', '2022-04-28 00:12:43'),
(4, 'typecheck', 'Y', '2022-04-28 00:13:04', '2022-04-28 00:13:04'),
(5, 'type extra', 'Y', '2022-04-28 00:53:47', '2022-04-28 00:53:47'),
(6, 'Special', 'Y', '2022-04-28 02:29:24', '2022-04-28 02:29:24'),
(7, 'supplier', 'Y', '2022-04-28 02:57:06', '2022-04-28 02:57:06'),
(8, 'khjkhjkh\\', 'Y', '2022-04-28 05:17:34', '2022-04-28 05:17:34'),
(9, 'ultraspecial', 'Y', '2022-04-28 23:59:52', '2022-04-28 23:59:52'),
(10, 'type a', 'Y', '2022-04-29 06:07:57', '2022-04-29 06:07:57'),
(11, 'jaranwala', 'Y', '2022-08-17 08:06:34', '2022-08-17 08:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `cnic`, `pic`, `user_status`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Bilal Yousaf', 'bilalmughal1309@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$3MFmJM.D7mkHBm2FWHlY7uIpaD0MrwVXMedzr/zYqRwu05RhZ4GoO', NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-02 06:36:26', '2022-08-02 06:36:26'),
(2, 'Technic Mentors', 'pos.technicmentors@gmail.com', '0300-0000000', '00000-0000000-0', '1660280622.webp', 'Y', 'Admin', NULL, '$2y$10$wMKlfKeaeI4WqtGE3JgNg.5H5mwSfESg8p/7D0yym2EkTpTF6HMLm', NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-12 00:03:42', '2022-08-12 00:03:42');

-- --------------------------------------------------------

--
-- Table structure for table `u_o_m_s`
--

CREATE TABLE `u_o_m_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uom_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `u_o_m_s`
--

INSERT INTO `u_o_m_s` (`id`, `uom_name`, `uom_status`, `created_at`, `updated_at`) VALUES
(1, 'Pieces', 'Y', NULL, NULL),
(2, 'kg', 'Y', '2022-07-07 04:07:58', '2022-07-07 04:07:58'),
(3, 'kg-1', 'Y', '2022-08-11 07:59:14', '2022-08-11 07:59:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheque_infos`
--
ALTER TABLE `cheque_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chq_number` (`chq_number`);

--
-- Indexes for table `client_details`
--
ALTER TABLE `client_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice_configs`
--
ALTER TABLE `invoice_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_nos`
--
ALTER TABLE `invoice_nos`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_accounts`
--
ALTER TABLE `supplier_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `u_o_m_s`
--
ALTER TABLE `u_o_m_s`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cheque_infos`
--
ALTER TABLE `cheque_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client_details`
--
ALTER TABLE `client_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_configs`
--
ALTER TABLE `invoice_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_nos`
--
ALTER TABLE `invoice_nos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_accounts`
--
ALTER TABLE `supplier_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `u_o_m_s`
--
ALTER TABLE `u_o_m_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
