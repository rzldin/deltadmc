-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2021 at 10:47 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deltadmc`
--

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
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2019_08_19_000000_create_failed_jobs_table', 1),
(20, '2021_06_19_173115_add_column_to_users_table', 1);

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
-- Table structure for table `t_maccess_control`
--

CREATE TABLE `t_maccess_control` (
  `id` int(11) NOT NULL,
  `t_mresponsibility_id` int(11) NOT NULL,
  `t_mapps_menu_id` int(11) NOT NULL,
  `active_flag` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_maccess_control`
--

INSERT INTO `t_maccess_control` (`id`, `t_mresponsibility_id`, `t_mapps_menu_id`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 1, 1, 1, 'admin', '2021-06-22 04:00:16'),
(2, 1, 2, 1, 'admin', '2021-06-22 04:00:12'),
(3, 1, 4, 1, 'admin', '2021-06-22 04:00:08'),
(4, 1, 5, 1, 'admin', '2021-06-22 04:00:05'),
(5, 1, 6, 1, 'admin', '2021-06-20 08:23:14'),
(6, 1, 7, 1, 'admin', '2021-06-20 12:05:55'),
(7, 1, 8, 1, 'admin', '2021-06-20 15:22:20'),
(8, 1, 9, 1, 'admin', '2021-06-22 03:59:52'),
(9, 1, 10, 1, 'admin', '2021-06-22 03:59:52'),
(10, 1, 11, 1, 'admin', '2021-06-22 07:27:53'),
(11, 1, 12, 1, 'admin', '2021-06-24 01:54:09'),
(12, 1, 13, 1, 'admin', '2021-06-24 04:43:35'),
(13, 1, 14, 1, 'admin', '2021-06-24 10:43:30'),
(14, 1, 15, 1, 'admin', '2021-06-24 10:47:55'),
(15, 1, 16, 1, 'admin', '2021-06-24 11:26:01'),
(16, 1, 17, 1, 'admin', '2021-06-24 11:26:01'),
(17, 1, 18, 1, 'admin', '2021-06-24 11:26:01'),
(18, 1, 19, 1, 'admin', '2021-06-24 12:12:38'),
(19, 1, 20, 1, 'admin', '2021-06-24 12:24:01'),
(20, 1, 21, 1, 'admin', '2021-06-24 12:33:19'),
(21, 1, 22, 1, 'admin', '2021-07-02 07:55:14'),
(22, 1, 23, 1, 'admin', '2021-07-02 07:55:14'),
(23, 1, 24, 1, 'admin', '2021-07-02 09:07:16'),
(24, 1, 25, 1, 'admin', '2021-07-02 09:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `t_maccount`
--

CREATE TABLE `t_maccount` (
  `id` int(11) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `account_type` varchar(50) NOT NULL,
  `segment_no` int(1) NOT NULL,
  `parent_account` varchar(30) DEFAULT NULL,
  `beginning_ballance` double DEFAULT 0,
  `start_date` date NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_maccount`
--

INSERT INTO `t_maccount` (`id`, `account_number`, `account_name`, `account_type`, `segment_no`, `parent_account`, `beginning_ballance`, `start_date`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, '1100', 'KAS ATAU SETARA KAS', 'Cash/Bank', 1, NULL, 20000, '2021-06-23', 1, 'admin', '2021-06-23 14:45:49', NULL, NULL),
(2, '1100.1', 'TEST', 'Cash/Bank', 2, '1100', 20000, '2021-06-24', 1, 'admin', '2021-06-24 17:08:01', 'admin', '2021-06-24 17:22:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_macc_segment`
--

CREATE TABLE `t_macc_segment` (
  `id` int(11) NOT NULL,
  `segment_name` varchar(100) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_macc_segment`
--

INSERT INTO `t_macc_segment` (`id`, `segment_name`, `created_by`, `created_on`) VALUES
(1, 'Segment 1', 'admin', '2021-06-24 11:51:05'),
(2, 'Segment 2', 'admin', '2021-06-24 11:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `t_maddress`
--

CREATE TABLE `t_maddress` (
  `id` int(11) NOT NULL,
  `t_mcompany_id` int(11) NOT NULL,
  `address_type` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `t_mcountry_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `province` varchar(100) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_maddress`
--

INSERT INTO `t_maddress` (`id`, `t_mcompany_id`, `address_type`, `address`, `t_mcountry_id`, `city`, `postal_code`, `province`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 2, 'UTAMA', 'FSADSF', 8, 'TEST COY', 'FDSDF', 'TEST LAGIXX', 1, 'admin', '2021-06-24 00:22:00', 'admin', '2021-06-24 13:41:07'),
(4, 2, 'GUDANG', 'ASDASD', 6, 'ASDAS', 'ASDAS', 'ASDAS', 1, 'admin', '2021-06-24 13:41:20', NULL, NULL),
(5, 8, 'GUDANG', 'DASDASDA', 2, 'TEST CITY', '12312', 'TEST PROVINSI', 1, 'admin', '2021-07-02 19:43:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mapps_menu`
--

CREATE TABLE `t_mapps_menu` (
  `id` int(11) NOT NULL,
  `apps_menu_name` varchar(100) NOT NULL,
  `apps_menu_level` varchar(150) NOT NULL,
  `apps_menu_parent` int(11) DEFAULT 0,
  `apps_menu_url` varchar(50) NOT NULL,
  `desc` varchar(150) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mapps_menu`
--

INSERT INTO `t_mapps_menu` (`id`, `apps_menu_name`, `apps_menu_level`, `apps_menu_parent`, `apps_menu_url`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'Master', 'main menu', 0, 'master', '', 1, '', '2021-06-20 02:01:52'),
(2, 'Company', 'sub menu', 1, 'master/company', '', 1, '', '2021-06-20 14:05:20'),
(4, 'User Management', 'main menu', 0, 'user', '', 1, '', '2021-06-20 14:14:02'),
(5, 'User Access', 'sub menu', 4, 'user/access', '', 1, '', '2021-06-20 14:16:40'),
(6, 'Country', 'sub menu', 1, 'master/country', '', 1, 'admin', '2021-06-20 15:18:35'),
(7, 'Carrier', 'sub menu', 1, 'master/carrier', '', 1, 'admin', '2021-06-20 19:04:38'),
(8, 'Charge Code', 'sub menu', 1, 'master/charge', '', 1, 'admin', '2021-06-20 22:21:02'),
(9, 'Port', 'sub menu', 1, 'master/port', '', 1, 'admin', '2021-06-22 10:48:40'),
(10, 'Vehicle', 'sub menu', 1, 'master/vehicle', '', 1, 'admin', '2021-06-22 10:56:37'),
(11, 'Currency', 'sub menu', 1, 'master/currency', '', 1, 'admin', '2021-06-22 14:25:18'),
(12, 'Users', 'sub menu', 1, 'master/user', '', 1, 'admin', '2021-06-24 06:11:24'),
(13, 'Account', 'sub menu', 1, 'master/account', '', 1, 'admin', '2021-06-24 11:38:50'),
(14, 'User Role', 'sub menu', 4, 'user/roles', '', 1, 'admin', '2021-06-24 17:42:20'),
(15, 'Schedule Type', 'sub menu', 1, 'master/schedule', '', 1, 'admin', '2021-06-24 17:46:15'),
(16, 'Loaded Type', 'sub menu', 1, 'master/loaded', '', 1, 'admin', '2021-06-24 18:23:01'),
(17, 'Freight Charges', 'sub menu', 1, 'master/freight', '', 1, 'admin', '2021-06-24 18:23:52'),
(18, 'Incoterms', 'sub menu', 1, 'master/incoterms', '', 1, 'admin', '2021-06-24 18:24:49'),
(19, 'Container Type', 'sub menu', 1, 'master/container', '', 1, 'admin', '2021-06-24 19:11:47'),
(20, 'Service Type', 'sub menu', 1, 'master/service', '', 1, 'admin', '2021-06-24 19:23:14'),
(21, 'Vehicle Type', 'sub menu', 1, 'master/vehicleType', '', 1, 'admin', '2021-06-24 19:32:23'),
(22, 'Quotation', 'main menu', 0, 'quotation', '', 1, 'admin', '2021-07-02 14:51:29'),
(23, 'List Qoute', 'sub menu', 22, 'quotation/list', '', 1, 'admin', '2021-07-02 14:53:22'),
(24, 'Charge Group', 'sub menu', 1, 'master/charge_group', '', 1, 'admin', '2021-07-02 16:04:25'),
(25, 'uom', 'sub menu', 1, 'master/uom', '', 1, 'admin', '2021-07-02 16:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `t_mbl_issued`
--

CREATE TABLE `t_mbl_issued` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_mcarrier`
--

CREATE TABLE `t_mcarrier` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `t_mcountry_id` int(11) NOT NULL,
  `lloyds_code` varchar(100) NOT NULL,
  `active_flag` int(11) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcarrier`
--

INSERT INTO `t_mcarrier` (`id`, `code`, `name`, `t_mcountry_id`, `lloyds_code`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'ZXZXZXZ', 'ADMIN', 2, 'TEST11', 1, 'admin', NULL, 'admin', '2021-06-25 13:20:45'),
(2, 'ASDSADSS', 'MAZMURAJA', 2, 'DAWDW', 1, 'admin', '2021-06-22 10:03:59', 'admin', '2021-06-22 10:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `t_mcharge_code`
--

CREATE TABLE `t_mcharge_code` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(225) NOT NULL,
  `t_mcharge_group_id` int(11) NOT NULL,
  `active_flag` int(1) NOT NULL DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcharge_code`
--

INSERT INTO `t_mcharge_code` (`id`, `code`, `name`, `t_mcharge_group_id`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'M3LSO7UX', 'RALDIN', 0, 1, 'admin', '2021-06-20 03:47:13', NULL, NULL),
(4, 'ASDSAD', 'ADMIN', 0, 1, 'admin', '2021-06-22 10:45:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mcharge_group`
--

CREATE TABLE `t_mcharge_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcharge_group`
--

INSERT INTO `t_mcharge_group` (`id`, `name`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'TEST AJAX', 'asjdgahsgdajs', 1, 'admin', '2021-07-02 16:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `t_mcompany`
--

CREATE TABLE `t_mcompany` (
  `id` int(11) NOT NULL,
  `client_code` varchar(50) NOT NULL,
  `client_name` varchar(250) NOT NULL,
  `npwp` varchar(50) NOT NULL,
  `status_account` int(11) DEFAULT NULL,
  `t_maccount_id` int(11) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `sales_by` varchar(50) NOT NULL,
  `customer_flag` int(1) DEFAULT NULL,
  `vendor_flag` int(1) DEFAULT NULL,
  `buyer_flag` int(1) DEFAULT NULL,
  `seller_flag` int(1) DEFAULT NULL,
  `shipping_line_flag` int(1) DEFAULT NULL,
  `agent_flag` int(1) DEFAULT NULL,
  `ppjk_flag` int(1) DEFAULT NULL,
  `active_flag` int(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcompany`
--

INSERT INTO `t_mcompany` (`id`, `client_code`, `client_name`, `npwp`, `status_account`, `t_maccount_id`, `tax_id`, `sales_by`, `customer_flag`, `vendor_flag`, `buyer_flag`, `seller_flag`, `shipping_line_flag`, `agent_flag`, `ppjk_flag`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 'TEST UPDATE', 'PT TEST', 'TEST231313', NULL, 1, NULL, '1', 1, 1, 0, 0, 1, 0, 1, 1, 'admin', '2021-06-23 16:09:48', 'admin', '2021-06-25 13:18:03'),
(8, 'CMPNY001', 'CV. MEKAR JAYA', '187218927198', NULL, 1, NULL, '1', 1, 1, 1, 0, 1, 1, 1, 1, 'admin', '2021-07-02 19:40:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mcontainer_type`
--

CREATE TABLE `t_mcontainer_type` (
  `id` int(11) NOT NULL,
  `container_type` varchar(100) NOT NULL,
  `size` varchar(50) NOT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcontainer_type`
--

INSERT INTO `t_mcontainer_type` (`id`, `container_type`, `size`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, '20 FEET', '', NULL, 1, 'admin', '2021-06-24 19:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `t_mcountry`
--

CREATE TABLE `t_mcountry` (
  `id` int(11) NOT NULL,
  `country_code` varchar(25) NOT NULL,
  `country_phone_code` varchar(25) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcountry`
--

INSERT INTO `t_mcountry` (`id`, `country_code`, `country_phone_code`, `country_name`, `created_by`, `created_on`) VALUES
(2, 'AGC', '+12', 'AFGHANISTAN', 'admin', '2021-06-20 10:56:32'),
(6, 'ID', '+62', 'INDONESIA', 'admin', '2021-06-20 02:43:29'),
(7, 'XX', '+62', 'AFAS', 'admin', '2021-06-20 02:52:59'),
(8, 'JPN', '+32', 'JEPANG', 'admin', '2021-06-22 02:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `t_mcurrency`
--

CREATE TABLE `t_mcurrency` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `active_flag` int(11) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mcurrency`
--

INSERT INTO `t_mcurrency` (`id`, `code`, `name`, `desc`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'IDR', 'INDONESIAN RUPIAH', 'indonesian rupiah', 1, 'admin', '2021-06-22 02:46:46', 'admin', '2021-06-22 02:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `t_mdoc_type`
--

CREATE TABLE `t_mdoc_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `doc_group` varchar(100) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_mfreight_charges`
--

CREATE TABLE `t_mfreight_charges` (
  `id` int(11) NOT NULL,
  `freight_charge` varchar(100) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `active_flag` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mfreight_charges`
--

INSERT INTO `t_mfreight_charges` (`id`, `freight_charge`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(2, 'collect', '', 1, 'admin', '2021-06-22 14:50:21'),
(3, 'freight prepaid at', '', 1, 'admin', '2021-06-22 14:50:21'),
(4, 'freight collect at', '', 1, 'admin', '2021-06-22 14:50:59'),
(5, 'prepaid', NULL, 1, 'admin', '2021-06-24 18:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `t_mincoterms`
--

CREATE TABLE `t_mincoterms` (
  `id` int(11) NOT NULL,
  `incoterns_code` varchar(25) NOT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mincoterms`
--

INSERT INTO `t_mincoterms` (`id`, `incoterns_code`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'EXW', '', 1, 'admin', '2021-06-24 17:32:47'),
(2, 'FCA', 'TEST', 1, 'admin', '2021-06-24 17:32:47'),
(3, 'FOB', NULL, 1, 'admin', '2021-06-24 19:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `t_mloaded_type`
--

CREATE TABLE `t_mloaded_type` (
  `id` int(11) NOT NULL,
  `loaded_type` varchar(100) NOT NULL,
  `desc` varchar(225) DEFAULT NULL,
  `active_flag` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mloaded_type`
--

INSERT INTO `t_mloaded_type` (`id`, `loaded_type`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'FCL', '', 1, 'admin', '2021-06-24 17:24:29'),
(2, 'LCL', '', 1, 'admin', '2021-06-24 17:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `t_mmatrix`
--

CREATE TABLE `t_mmatrix` (
  `id` int(11) NOT NULL,
  `t_muser_id` int(11) NOT NULL,
  `t_mresponsibility_id` int(11) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mmatrix`
--

INSERT INTO `t_mmatrix` (`id`, `t_muser_id`, `t_mresponsibility_id`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 1, 1, 1, '', '2021-06-20 02:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `t_mpic`
--

CREATE TABLE `t_mpic` (
  `id` int(11) NOT NULL,
  `t_mcompany_id` int(11) NOT NULL,
  `pic_desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mpic`
--

INSERT INTO `t_mpic` (`id`, `t_mcompany_id`, `pic_desc`, `name`, `phone1`, `phone2`, `fax`, `email`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 2, 'TESTTT yooo', 'TEST BANG', '0192031029', '90319230190', 'test lagii', 'lagi@gmail.com', 1, 'admin', '2021-06-24 02:26:07', 'admin', '2021-06-24 02:26:31'),
(3, 2, 'PIC JAKBAR', 'TEST XX2', '12312', '31231', 'test ajaaa', 'testdoang@gmail.com', 1, 'admin', '2021-06-24 13:41:41', 'admin', '2021-06-25 12:27:54'),
(5, 2, 'WEQE', 'CEK2', '12312', '31231', 'wewe', 'asda@gmail.com', 1, 'admin', '2021-06-25 12:27:32', 'admin', '2021-06-25 12:27:44'),
(6, 8, 'ASDASDAS', 'TEST PIC', '12312312', '123123', '123123', 'admin@forum.com', 1, 'admin', '2021-07-02 19:44:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mport`
--

CREATE TABLE `t_mport` (
  `id` int(11) NOT NULL,
  `port_code` varchar(100) NOT NULL,
  `port_name` varchar(255) NOT NULL,
  `port_type` varchar(50) NOT NULL,
  `t_mcountry_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `province` varchar(100) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mport`
--

INSERT INTO `t_mport` (`id`, `port_code`, `port_name`, `port_type`, `t_mcountry_id`, `address`, `city`, `postal_code`, `province`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 'ASDASD', 'TEST AJA', 'AIR', 6, 'asdasd', 'ASDAS', 'ASDAS', 'ASDAS', 1, 'admin', '2021-06-24 17:45:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mresponsibility`
--

CREATE TABLE `t_mresponsibility` (
  `id` int(11) NOT NULL,
  `responsibility_name` varchar(50) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mresponsibility`
--

INSERT INTO `t_mresponsibility` (`id`, `responsibility_name`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'Administrator', 1, 'admin', '0000-00-00 00:00:00'),
(2, 'Accounting', 1, 'admin', '2021-06-24 10:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `t_mschedule_type`
--

CREATE TABLE `t_mschedule_type` (
  `id` int(11) NOT NULL,
  `schedule_type` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `internal_flag` int(1) DEFAULT 0,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mschedule_type`
--

INSERT INTO `t_mschedule_type` (`id`, `schedule_type`, `desc`, `internal_flag`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'test', 'TEST', 1, 1, 'admin', '2021-06-24 18:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `t_mservice_type`
--

CREATE TABLE `t_mservice_type` (
  `id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mservice_type`
--

INSERT INTO `t_mservice_type` (`id`, `service_type`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'Door/Door', '', 1, 'admin', '2021-06-24 17:28:10'),
(2, 'Door/CY', '', 1, 'admin', '2021-06-24 17:28:10'),
(3, 'CY/CY', '', 1, 'admin', '2021-06-24 17:29:22'),
(4, 'CY/DOOR', '', 1, 'admin', '2021-06-24 17:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `t_muom`
--

CREATE TABLE `t_muom` (
  `id` int(11) NOT NULL,
  `uom_code` varchar(50) NOT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_muom`
--

INSERT INTO `t_muom` (`id`, `uom_code`, `desc`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'KG', 'kilogram', 1, 'admin', '2021-07-02 17:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `t_mvehicle`
--

CREATE TABLE `t_mvehicle` (
  `id` int(11) NOT NULL,
  `t_mvehicle_type_id` int(11) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `t_mcompany_id` int(11) NOT NULL,
  `shipment_type` varchar(50) NOT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mvehicle`
--

INSERT INTO `t_mvehicle` (`id`, `t_mvehicle_type_id`, `vehicle_no`, `t_mcompany_id`, `shipment_type`, `active_flag`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 1, 'COBA', 2, 'SEA', 1, 'admin', '2021-06-24 03:29:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_mvehicle_type`
--

CREATE TABLE `t_mvehicle_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active_flag` int(1) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_mvehicle_type`
--

INSERT INTO `t_mvehicle_type` (`id`, `type`, `description`, `active_flag`, `created_by`, `created_on`) VALUES
(1, 'Fuso', '', 1, 'admin', '2021-06-22 10:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `t_quote`
--

CREATE TABLE `t_quote` (
  `id` int(11) NOT NULL,
  `quote_no` varchar(255) NOT NULL,
  `version_no` int(11) NOT NULL,
  `quote_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `t_mloaded_type_id` int(11) NOT NULL,
  `t_mpic_id` int(11) NOT NULL,
  `shipment_by` varchar(50) NOT NULL,
  `terms` int(11) NOT NULL,
  `from_text` text NOT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_text` text NOT NULL,
  `to_id` int(11) DEFAULT NULL,
  `commodity` text NOT NULL,
  `pieces` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `weight_uom_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `volume_uom_id` int(11) NOT NULL,
  `final_flag` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `hazardous_flag` int(11) DEFAULT NULL,
  `hazardous_info` varchar(255) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `pickup_delivery_flag` int(11) DEFAULT NULL,
  `custom_flag` int(11) DEFAULT NULL,
  `fumigation_flag` int(11) DEFAULT NULL,
  `stackable_flag` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_quote`
--

INSERT INTO `t_quote` (`id`, `quote_no`, `version_no`, `quote_date`, `customer_id`, `activity`, `t_mloaded_type_id`, `t_mpic_id`, `shipment_by`, `terms`, `from_text`, `from_id`, `to_text`, `to_id`, `commodity`, `pieces`, `weight`, `weight_uom_id`, `volume`, `volume_uom_id`, `final_flag`, `status`, `hazardous_flag`, `hazardous_info`, `additional_info`, `pickup_delivery_flag`, `custom_flag`, `fumigation_flag`, `stackable_flag`, `created_by`, `created_on`) VALUES
(1, 'TEST0001', 1, '2021-07-03', 8, 'export', 1, 6, 'SEA', 1, 'TEST AJA', NULL, 'TEST AJA', 2, 'test aja', 12, 10, 1, 15, 1, 0, 1, 1, 'danger materi', NULL, NULL, NULL, NULL, NULL, 'admin', '2021-07-03 22:45:46'),
(2, 'TEST0001', 2, '2021-07-05', 8, 'domestic', 1, 6, 'LAND', 1, 'TEST AJA', NULL, 'TEST AJA', 2, 'test aja', 12, 10, 1, 15, 1, 0, NULL, 1, 'danger materi', 'ini berbahaya, jangan di banting', 1, 1, 1, 1, 'admin', '2021-07-05 09:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `t_quote_dimension`
--

CREATE TABLE `t_quote_dimension` (
  `id` int(11) NOT NULL,
  `t_quote_id` int(11) NOT NULL,
  `position_no` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `height_uom_id` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `wight` int(11) NOT NULL,
  `wight_uom_id` int(11) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_quote_dimension`
--

INSERT INTO `t_quote_dimension` (`id`, `t_quote_id`, `position_no`, `length`, `width`, `height`, `height_uom_id`, `pieces`, `wight`, `wight_uom_id`, `created_by`, `created_on`) VALUES
(1, 1, 1, 12, 16, 12, 1, 13, 11, 1, 'admin', '2021-07-04 03:25:14'),
(4, 2, 1, 12, 15, 12, 1, 12, 11, 1, 'admin', '2021-07-05 09:46:11'),
(5, 2, 1, 13, 14, 15, 1, 12, 10, 1, 'admin', '2021-07-05 09:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_quote_dtl`
--

CREATE TABLE `t_quote_dtl` (
  `id` int(11) NOT NULL,
  `t_quote_id` int(11) NOT NULL,
  `position_no` int(11) NOT NULL,
  `t_mcharge_code_id` int(11) NOT NULL,
  `desc` text NOT NULL,
  `reimburse_flag` int(1) DEFAULT NULL,
  `t_mcurrency_id` int(11) NOT NULL,
  `rate` decimal(25,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL,
  `sell` decimal(25,4) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_val` decimal(25,4) NOT NULL,
  `sell_val` decimal(25,4) NOT NULL,
  `vat` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_quote_dtl`
--

INSERT INTO `t_quote_dtl` (`id`, `t_quote_id`, `position_no`, `t_mcharge_code_id`, `desc`, `reimburse_flag`, `t_mcurrency_id`, `rate`, `cost`, `sell`, `qty`, `cost_val`, `sell_val`, `vat`, `subtotal`, `notes`, `created_by`, `created_on`) VALUES
(9, 2, 3, 4, 'test ketiga', 1, 1, '200.0000', '100.0000', '200.0000', 5, '400.0000', '450.0000', '50000.0000', '52250.0000', 'coba', 'admin', '2021-07-05 14:42:56'),
(15, 2, 4, 1, 'test', 1, 1, '100.0000', '100.0000', '100.0000', 2, '100.0000', '100.0000', '10.0000', '210.0000', NULL, 'admin', '2021-07-05 15:05:29'),
(19, 2, 5, 1, 'test', 1, 1, '100.0000', '100.0000', '100.0000', 3, '100.0000', '100.0000', '100.0000', '400.0000', NULL, 'admin', '2021-07-05 15:12:25'),
(20, 2, 6, 4, 'cek', 0, 1, '100.0000', '100.0000', '100.0000', 2, '100.0000', '200.0000', '200.0000', '600.0000', NULL, 'admin', '2021-07-06 20:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `t_quote_profit`
--

CREATE TABLE `t_quote_profit` (
  `id` int(11) NOT NULL,
  `t_quote_id` int(11) NOT NULL,
  `t_quote_ship_dtl_id` int(11) NOT NULL,
  `t_mcurrency_id` int(11) NOT NULL,
  `total_cost` decimal(25,4) NOT NULL,
  `total_sell` decimal(25,4) NOT NULL,
  `total_profit` decimal(25,4) NOT NULL,
  `profit_pct` decimal(10,2) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_quote_profit`
--

INSERT INTO `t_quote_profit` (`id`, `t_quote_id`, `t_quote_ship_dtl_id`, `t_mcurrency_id`, `total_cost`, `total_sell`, `total_profit`, `profit_pct`, `created_by`, `created_on`) VALUES
(6, 2, 4, 1, '800.0000', '950.0000', '150.0000', '15.79', 'admin', '2021-07-06 19:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `t_quote_shipg_dtl`
--

CREATE TABLE `t_quote_shipg_dtl` (
  `id` int(11) NOT NULL,
  `t_quote_id` int(11) NOT NULL,
  `position_no` int(11) NOT NULL,
  `t_mcarrier_id` int(11) NOT NULL,
  `routing` varchar(255) DEFAULT NULL,
  `transit_time` int(11) NOT NULL,
  `t_mcurrency_id` int(11) NOT NULL,
  `rate` decimal(25,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL,
  `sell` decimal(25,4) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_val` decimal(25,4) NOT NULL,
  `sell_val` decimal(25,4) NOT NULL,
  `vat` decimal(25,4) NOT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `notes` text NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_quote_shipg_dtl`
--

INSERT INTO `t_quote_shipg_dtl` (`id`, `t_quote_id`, `position_no`, `t_mcarrier_id`, `routing`, `transit_time`, `t_mcurrency_id`, `rate`, `cost`, `sell`, `qty`, `cost_val`, `sell_val`, `vat`, `subtotal`, `notes`, `created_by`, `created_on`) VALUES
(2, 1, 1, 1, 'smgk', 23, 1, '100.0000', '100.0000', '100.0000', 5, '100.0000', '300.0000', '250.0000', '1750.0000', 'good job', 'admin', '2021-07-04 12:57:27'),
(3, 1, 2, 1, 'jktx', 23, 1, '200.0000', '300.0000', '400.0000', 2, '200.0000', '300.0000', '200.0000', '800.0000', 'oke', 'admin', '2021-07-04 14:21:45'),
(4, 2, 1, 1, 'jkt', 23, 1, '100.0000', '200.0000', '200.0000', 4, '200.0000', '300.0000', '200.0000', '1400.0000', 'okew', 'admin', '2021-07-05 09:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_mcountry_id` int(11) NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_flag` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `address`, `t_mcountry_id`, `city`, `postal_code`, `state_code`, `province`, `country_code`, `country_name`, `phone1`, `phone2`, `fax`, `active_flag`, `email`, `email_verified_at`, `password`, `remember_token`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'admin', 'admin', 'asdas', 0, 'asda', 'dasd', 'dasd', 'dsada', 'dasd', 'asda', '', '', '', 1, '', NULL, '$2y$10$lzNi5slqsdplCxiPb9EYO.pj1lid9MJimqJJyeXMuq4TN2/m3I4pG', NULL, '', NULL, '', NULL),
(2, 'TEST UPDATE', 'iie test', 'asdasd', 6, 'ASDAS', 'ASDAS', NULL, 'ASDAS', NULL, NULL, '1212', '1212', 'wew', 1, 'awdad@gmail.com', NULL, '$2y$10$MLG2qa.5KHOpgL0BZdfNuOwNT.JuClV2deEUHeoOUSi2q9Xij.h8e', NULL, 'admin', '2021-06-24 10:49:05', 'admin', '2021-06-24 11:36:02');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `t_maccess_control`
--
ALTER TABLE `t_maccess_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_maccount`
--
ALTER TABLE `t_maccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_macc_segment`
--
ALTER TABLE `t_macc_segment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_maddress`
--
ALTER TABLE `t_maddress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mapps_menu`
--
ALTER TABLE `t_mapps_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mbl_issued`
--
ALTER TABLE `t_mbl_issued`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcarrier`
--
ALTER TABLE `t_mcarrier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcharge_code`
--
ALTER TABLE `t_mcharge_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcharge_group`
--
ALTER TABLE `t_mcharge_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcompany`
--
ALTER TABLE `t_mcompany`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcontainer_type`
--
ALTER TABLE `t_mcontainer_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcountry`
--
ALTER TABLE `t_mcountry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mcurrency`
--
ALTER TABLE `t_mcurrency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mdoc_type`
--
ALTER TABLE `t_mdoc_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mfreight_charges`
--
ALTER TABLE `t_mfreight_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mincoterms`
--
ALTER TABLE `t_mincoterms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mloaded_type`
--
ALTER TABLE `t_mloaded_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mmatrix`
--
ALTER TABLE `t_mmatrix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mpic`
--
ALTER TABLE `t_mpic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mport`
--
ALTER TABLE `t_mport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mresponsibility`
--
ALTER TABLE `t_mresponsibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mschedule_type`
--
ALTER TABLE `t_mschedule_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mservice_type`
--
ALTER TABLE `t_mservice_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_muom`
--
ALTER TABLE `t_muom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mvehicle`
--
ALTER TABLE `t_mvehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_mvehicle_type`
--
ALTER TABLE `t_mvehicle_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_quote`
--
ALTER TABLE `t_quote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_quote_dimension`
--
ALTER TABLE `t_quote_dimension`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_quote_dtl`
--
ALTER TABLE `t_quote_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_quote_profit`
--
ALTER TABLE `t_quote_profit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_quote_shipg_dtl`
--
ALTER TABLE `t_quote_shipg_dtl`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `t_maccess_control`
--
ALTER TABLE `t_maccess_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `t_maccount`
--
ALTER TABLE `t_maccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_macc_segment`
--
ALTER TABLE `t_macc_segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_maddress`
--
ALTER TABLE `t_maddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_mapps_menu`
--
ALTER TABLE `t_mapps_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `t_mbl_issued`
--
ALTER TABLE `t_mbl_issued`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_mcarrier`
--
ALTER TABLE `t_mcarrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_mcharge_code`
--
ALTER TABLE `t_mcharge_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_mcharge_group`
--
ALTER TABLE `t_mcharge_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mcompany`
--
ALTER TABLE `t_mcompany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_mcontainer_type`
--
ALTER TABLE `t_mcontainer_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mcountry`
--
ALTER TABLE `t_mcountry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_mcurrency`
--
ALTER TABLE `t_mcurrency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_mdoc_type`
--
ALTER TABLE `t_mdoc_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_mfreight_charges`
--
ALTER TABLE `t_mfreight_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_mincoterms`
--
ALTER TABLE `t_mincoterms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_mloaded_type`
--
ALTER TABLE `t_mloaded_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_mmatrix`
--
ALTER TABLE `t_mmatrix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mpic`
--
ALTER TABLE `t_mpic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_mport`
--
ALTER TABLE `t_mport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_mresponsibility`
--
ALTER TABLE `t_mresponsibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_mschedule_type`
--
ALTER TABLE `t_mschedule_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mservice_type`
--
ALTER TABLE `t_mservice_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_muom`
--
ALTER TABLE `t_muom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mvehicle`
--
ALTER TABLE `t_mvehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_mvehicle_type`
--
ALTER TABLE `t_mvehicle_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_quote`
--
ALTER TABLE `t_quote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_quote_dimension`
--
ALTER TABLE `t_quote_dimension`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_quote_dtl`
--
ALTER TABLE `t_quote_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `t_quote_profit`
--
ALTER TABLE `t_quote_profit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_quote_shipg_dtl`
--
ALTER TABLE `t_quote_shipg_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
