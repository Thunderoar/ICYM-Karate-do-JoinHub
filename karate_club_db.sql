-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2024 at 01:37 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karate_club_db`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_plans`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `active_plans`;
CREATE TABLE IF NOT EXISTS `active_plans` (
`planid` varchar(8)
,`planName` varchar(20)
,`description` varchar(200)
,`planType` varchar(50)
,`startDate` varchar(50)
,`endDate` varchar(50)
,`duration` int
,`amount` int
,`active` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `addressid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `streetName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `zipcode` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`addressid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressid`, `userid`, `streetName`, `state`, `city`, `zipcode`) VALUES
('159297509', '1729589256', '', '', '', ''),
('178160492', '1729503048', '', '', '', ''),
('233879111', '1729503254', '', '', '', ''),
('244071432', '1730037014', '', '', '', ''),
('259825696', '1730044070', '', '', '', ''),
('398226207', '1729503605', '', '', '', ''),
('443957638', '1729499689', '', '', '', ''),
('445117942', '1729500525', '', '', '', ''),
('474709767', '1729653160', '', '', '', ''),
('541188054', '1729503562', '', '', '', ''),
('603347436', '1730942013', '', '', '', ''),
('651796491', '1729501754', '', '', '', ''),
('664647014', '1730036662', '', '', '', ''),
('672538767', '1729500022', '', '', '', ''),
('696159057', '1729654531', '', '', '', ''),
('737416117', '1730035207', '', '', '', ''),
('749610901', '1730601491', '', '', '', ''),
('762966398', '1729502982', '', '', '', ''),
('769730378', '1729499715', '', '', '', ''),
('791246783', '1729816197', '', '', '', ''),
('889334180', '1729506355', '', '', '', ''),
('935899936', '1729499109', '', '', '', ''),
('948864454', '1729503655', '', '', '', ''),
('965810506', '1729503504', '', '', '', ''),
('982014755', '1730087557', '', '', '', ''),
('995837925', '1729502959', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass_key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `securekey` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `pass_key`, `securekey`, `Full_name`) VALUES
('admintest', 'admintest', 'admintest', 'admintest', 'admintest');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('new','read','replied') COLLATE utf8mb4_general_ci DEFAULT 'new',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrolls_to`
--

DROP TABLE IF EXISTS `enrolls_to`;
CREATE TABLE IF NOT EXISTS `enrolls_to` (
  `et_id` int NOT NULL AUTO_INCREMENT,
  `planid` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `paid_date` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expire` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hasPaid` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `hasApproved` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiptIMG` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`et_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolls_to`
--

INSERT INTO `enrolls_to` (`et_id`, `planid`, `userid`, `paid_date`, `expire`, `hasPaid`, `hasApproved`, `receiptIMG`) VALUES
(89, 'UGZVJQ', '1730087557', '', '2024-11-28 11:54:08', 'no', '', ''),
(90, 'TGNJRZ', '1730087557', '', '2024-11-28 11:54:13', 'no', '', ''),
(91, 'XTWIOL', '1730601491', '2024-11-11 19:18:05', '9999-12-31', 'no', 'no', ''),
(92, 'XTWIOL', '1730942013', '2024-11-09 14:39:20', '9999-12-31', 'yes', 'yes', ''),
(133, 'VXZPMY', '1730087557', '2024-11-11 19:14:36', '9999-12-31', 'yes', 'no', ''),
(141, 'XTWIOL', '1730087557', '2024-11-11 18:54:07', '9999-12-31', 'yes', 'yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `event_members`
--

DROP TABLE IF EXISTS `event_members`;
CREATE TABLE IF NOT EXISTS `event_members` (
  `em_id` int NOT NULL AUTO_INCREMENT,
  `planid` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userid` int DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`em_id`),
  KEY `planid` (`planid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_members`
--

INSERT INTO `event_members` (`em_id`, `planid`, `userid`, `joined_at`) VALUES
(25, '0', 1730601491, '2024-11-11 09:30:44'),
(29, 'VXZPMY', 1730087557, '2024-11-11 11:26:31'),
(30, 'VXZPMY', 1729500896, '2024-11-11 11:26:31'),
(31, 'VXZPMY', 1730601491, '2024-11-11 11:26:31'),
(32, 'VXZPMY', 1730942013, '2024-11-11 11:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `event_staff`
--

DROP TABLE IF EXISTS `event_staff`;
CREATE TABLE IF NOT EXISTS `event_staff` (
  `es_id` int NOT NULL AUTO_INCREMENT,
  `planid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `staffid` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`es_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_staff`
--

INSERT INTO `event_staff` (`es_id`, `planid`, `staffid`, `joined_at`) VALUES
(12, 'VXZPMY', 'rashid', '2024-11-11 11:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int DEFAULT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_id`),
  KEY `gallery_images_ibfk_1` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`image_id`, `section_id`, `image_path`, `uploaded_at`) VALUES
(63, 7, 'uploads/image_4.jpg', '2024-10-20 06:27:24'),
(64, 8, 'uploads/image_1.jpg', '2024-10-23 09:41:43'),
(65, 8, 'uploads/image_2.jpg', '2024-10-23 09:41:43'),
(66, 8, 'uploads/image_3.jpg', '2024-10-23 09:41:43'),
(67, 8, 'uploads/image_4.jpg', '2024-10-23 09:41:43'),
(68, 8, 'uploads/image_5.jpg', '2024-10-23 09:41:43'),
(69, 8, 'uploads/image_6.jpg', '2024-10-23 09:41:43'),
(70, 8, 'uploads/image_2.jpg', '2024-10-28 02:16:46'),
(71, 8, 'uploads/image_3.jpg', '2024-10-28 02:16:46'),
(72, 8, 'uploads/image_4.jpg', '2024-10-28 02:16:46'),
(73, 8, 'uploads/image_5.jpg', '2024-10-28 02:16:46'),
(74, 8, 'uploads/image_6.jpg', '2024-10-28 02:16:46'),
(75, 8, 'uploads/image_7.jpg', '2024-10-28 02:16:46'),
(76, 8, 'uploads/image_8.jpg', '2024-10-28 02:16:46'),
(77, 8, 'uploads/image_10.jpg', '2024-10-28 02:16:46'),
(78, 8, 'uploads/image_11.jpg', '2024-10-28 02:16:46'),
(79, 8, 'uploads/image_12.jpg', '2024-10-28 02:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_sections`
--

DROP TABLE IF EXISTS `gallery_sections`;
CREATE TABLE IF NOT EXISTS `gallery_sections` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `section_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `planid` int DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_sections`
--

INSERT INTO `gallery_sections` (`section_id`, `section_name`, `section_description`, `created_at`, `planid`) VALUES
(7, 'test2', 'test2', '2024-10-20 06:07:04', NULL),
(8, 'WAH', 'WAH', '2024-10-23 09:41:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `health_status`
--

DROP TABLE IF EXISTS `health_status`;
CREATE TABLE IF NOT EXISTS `health_status` (
  `healthid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `calorie` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `height` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weight` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fat` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `remarks` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`healthid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_status`
--

INSERT INTO `health_status` (`healthid`, `calorie`, `height`, `weight`, `fat`, `remarks`, `userid`) VALUES
('127361533', '', '', '', '', '', '1730037014'),
('15697384', '', '', '', '', '', '1729502982'),
('159244038', '', '', '', '', '', '1729326958'),
('161958492', '', '', '', '', '', '1729232687'),
('17580962', '', '', '', '', '', '1728485531'),
('198765922', '', '', '', '', '', '1729499988'),
('204334593', '', '', '', '', '', '1729589256'),
('205571730', '', '', '', '', '', '1729503562'),
('206420275', '', '', '', '', '', '1729816197'),
('277790349', '', '', '', '', '', '1729499001'),
('297159777', '', '', '', '', '', '1729500022'),
('319821461', '', '', '', '', '', '1729331377'),
('338833368', '', '', '', '', '', '1729653160'),
('353479103', '', '160', '48', '', '', '1730087557'),
('361339141', '', '', '', '', '', '1729503655'),
('377819181', '', '', '', '', '', '1729503048'),
('387732098', '', '', '', '', '', '1730035207'),
('388848522', '', '', '', '', '', '1729500806'),
('38888806', '', '', '', '', '', '1728384510'),
('398395806', '', '', '', '', '', '1729499109'),
('400263278', '', '', '', '', '', '1729506355'),
('409696460', '', '', '', '', '', '1729654531'),
('46800272', '', '', '', '', '', '1728433989'),
('506048860', '', '', '', '', '', '1729499673'),
('513408577', '', '', '', '', '', '1729499715'),
('529626955', '', '', '', '', '', '1730601491'),
('561523138', '', '', '', '', '', '1729503254'),
('575478311', '', '', '', '', 'test', '1728486893'),
('675436545', '', '', '', '', '', '1729503605'),
('69760681', '', '', '', '', '', '1729503504'),
('770322812', '', '', '', '', '', '1729499689'),
('80936596', '', '', '', '', '', '1729499036'),
('826633186', '', '', '', '', '', '1728383471'),
('826677281', '', '', '', '', '', '1728384120'),
('8333733', '', NULL, NULL, '', '', '1730942013'),
('860622780', '', '', '', '', '', '1730036662'),
('872369437', '', '', '', '', '', '1729502959'),
('874529438', '', '', '', '', '', '1729331491'),
('88203510', '', '', '', '', '', '1729500525'),
('918803354', '', '', '', '', '', '1730044070'),
('955419055', '', '', '', '', '', '1729500896'),
('95897886', '', '', '', '', '', '1729501754');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `imageid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adminid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staffid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `planid` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'placeholder.jpg',
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`imageid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageid`, `adminid`, `userid`, `staffid`, `planid`, `image_path`, `uploaded_at`) VALUES
('04d46f48-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729502982', NULL, NULL, NULL, '2024-10-21 09:29:49'),
('16e092c9-9689-11ef-aaee-004e01ffe201', NULL, NULL, NULL, 'KYDZOV', 'uploads/6721d39503ce1_event_1.jpg', '2024-10-30 06:35:01'),
('1769271a-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, NULL, NULL, '2024-10-28 03:52:45'),
('1cd5fd45-9e86-11ef-b592-004e01ffe201', NULL, NULL, NULL, 'ZHXPSA', 'uploads/672f3a8fcc171_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-09 10:33:51'),
('1f44babb-94d2-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'UGZVJQ', 'uploads/image_2_671ef31e09eec.jpg', '2024-10-28 02:12:46'),
('20af0194-9754-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WDCFUK', 'uploads/672328394cfbc_karate_main.jpg', '2024-10-31 06:48:25'),
('2147483647', NULL, '1729500022', NULL, NULL, NULL, '2024-10-21 08:41:08'),
('262d799d-8f8a-11ef-a5b9-004e01ffe201', NULL, '1729500896', NULL, NULL, NULL, '2024-10-21 08:54:57'),
('2ea50c7f-8f8c-11ef-a5b9-004e01ffe201', NULL, '1729501754', NULL, NULL, NULL, '2024-10-21 09:09:31'),
('2f0b7fa6-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503048', NULL, NULL, NULL, '2024-10-21 09:31:00'),
('3', NULL, '1729326958', NULL, NULL, NULL, '2024-10-19 08:36:30'),
('311fa78d-975e-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'KTQNRL', 'uploads/6723391bd3126_karate_main.jpg', '2024-10-31 08:00:27'),
('38067411-9466-11ef-96fe-004e01ffe201', NULL, '1730035207', NULL, NULL, NULL, '2024-10-27 13:20:21'),
('3fc07e44-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503504', NULL, NULL, NULL, '2024-10-21 09:38:37'),
('4', NULL, '1729500525', NULL, NULL, NULL, '2024-10-21 08:48:55'),
('4b9288ef-9268-11ef-8788-004e01ffe201', NULL, '1729816197', NULL, NULL, NULL, '2024-10-25 00:30:11'),
('5', NULL, '1729499689', NULL, NULL, NULL, '2024-10-21 08:35:06'),
('515', NULL, '1729499673', NULL, NULL, NULL, '2024-10-21 08:34:41'),
('54a9f345-9bce-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'EHBPVK', 'uploads/672aab3bbd821_image_2.jpg', '2024-11-05 23:33:15'),
('591e262b-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'CDZJSY', 'uploads/672ada3d264a8_event_1.jpg', '2024-11-06 02:53:49'),
('5e628491-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503562', NULL, NULL, NULL, '2024-10-21 09:39:29'),
('611fb9ee-9bcd-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'DGEQBM', 'uploads/plans/plan_672aa9a32ccf28.10183593.jpg', '2024-11-05 15:26:27'),
('6aae6da4-946a-11ef-96fe-004e01ffe201', NULL, '1730037014', NULL, NULL, NULL, '2024-10-27 13:50:24'),
('79fe9b2e-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503605', NULL, NULL, NULL, '2024-10-21 09:40:15'),
('7acf25b0-9bec-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'LOXGHP', 'uploads/672addd0a4e38_event_1.jpg', '2024-11-06 03:09:04'),
('8', NULL, NULL, NULL, 'TGJIOA', 'uploads/image_2.jpg', '2024-10-18 06:23:57'),
('85487087-9bcf-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'XZONMS', 'uploads/672aad3acda2b_image_2.jpg', '2024-11-05 23:41:46'),
('87ad5a79-9ca5-11ef-a493-004e01ffe201', NULL, '1730942013', NULL, NULL, NULL, '2024-11-07 01:13:43'),
('8983', NULL, '1729331377', NULL, NULL, NULL, '2024-10-19 09:50:14'),
('8984', NULL, '1729232687', NULL, NULL, NULL, '2024-10-18 06:25:15'),
('8985', NULL, '1729331491', NULL, NULL, NULL, '2024-10-19 09:51:46'),
('8989', 'admintest', NULL, NULL, NULL, 'uploads/cat-sleepy.gif', '2024-10-19 11:03:43'),
('8990', NULL, '1729499036', NULL, NULL, NULL, '2024-10-21 08:24:04'),
('8991', NULL, '1729499109', NULL, NULL, NULL, '2024-10-21 08:25:15'),
('9327316', NULL, '1729499715', NULL, NULL, NULL, '2024-10-21 08:36:32'),
('9327317', NULL, '1729499988', NULL, NULL, NULL, '2024-10-21 08:39:56'),
('97108066-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503655', NULL, NULL, NULL, '2024-10-21 09:41:04'),
('97673448-9469-11ef-96fe-004e01ffe201', NULL, '1730036662', NULL, NULL, NULL, '2024-10-27 13:44:30'),
('98ea3aa6-9be9-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'UGZKDM', 'uploads/672ad8faa97ef_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-06 02:48:26'),
('a0f12b11-9bcf-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'TQSFLR', 'uploads/672aad693c338_image_2.jpg', '2024-11-05 23:42:33'),
('af459d21-9abc-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WBGSAZ', 'uploads/plans/plan_6728e021a7d910.92053212.jpg', '2024-11-04 14:54:25'),
('af9126c9-90ec-11ef-9771-004e01ffe201', NULL, '1729653160', NULL, NULL, NULL, '2024-10-23 03:12:50'),
('b3fd23a2-9753-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'HAJBWP', 'uploads/67232782e6b24_image_8.jpg', '2024-10-31 06:45:22'),
('bca06ed8-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, NULL, NULL, '2024-11-03 02:38:41'),
('c0bd6e81-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VNWQGL', 'uploads/672adaeb01828_event_1.jpg', '2024-11-06 02:56:43'),
('c1a6ad2f-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503254', NULL, NULL, NULL, '2024-10-21 09:35:06'),
('c297f3e8-94c4-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'TGNJRZ', 'uploads/event_1_671edcb3189d6.jpg', '2024-10-28 00:37:07'),
('c779416c-9bcc-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'KZMTED', 'uploads/plans/plan_672aa8a15f44b5.80760034.jpg', '2024-11-05 23:22:09'),
('d785ab4b-947a-11ef-96fe-004e01ffe201', NULL, '1730044070', NULL, NULL, NULL, '2024-10-27 15:47:59'),
('dc81088c-8f96-11ef-a5b9-004e01ffe201', NULL, '1729506355', NULL, NULL, NULL, '2024-10-21 10:25:58'),
('df9cf0f4-90ef-11ef-954f-004e01ffe201', NULL, '1729654531', NULL, NULL, NULL, '2024-10-23 03:35:39'),
('e823ad64-9057-11ef-a5b9-004e01ffe201', NULL, '1729589256', NULL, NULL, NULL, '2024-10-22 09:27:51'),
('ed943f77-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'ERQZBC', 'uploads/6724360086480_karate_main.jpg', '2024-11-01 01:59:28'),
('f9b54ceb-8f8e-11ef-a5b9-004e01ffe201', NULL, '1729502959', NULL, NULL, NULL, '2024-10-21 09:29:30'),
('fa1250de-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'FLERKI', 'uploads/672436157c3d6_image_11.jpg', '2024-11-01 01:59:49'),
('ff430ac1-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VXZPMY', 'uploads/672adb53dbe53_image_11.jpg', '2024-11-06 02:58:27');

-- --------------------------------------------------------

--
-- Stand-in structure for view `inactive_plans`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `inactive_plans`;
CREATE TABLE IF NOT EXISTS `inactive_plans` (
`planid` varchar(8)
,`planName` varchar(20)
,`description` varchar(200)
,`planType` varchar(50)
,`startDate` varchar(50)
,`endDate` varchar(50)
,`duration` int
,`amount` int
,`active` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `loginid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adminid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staffid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass_key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `securekey` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `authority` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`loginid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginid`, `adminid`, `userid`, `staffid`, `username`, `pass_key`, `securekey`, `authority`) VALUES
('0110b27d-8562-11ef-b414-3ca067e52da9', NULL, '1728384120', NULL, 'b', 'test1', '0110b2d2-8562-11ef-b414-3ca067e52da9', 'member'),
('04d45ea8-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729502982', NULL, '123', '', '04d45eb9-8f8f-11ef-a5b9-004e01ffe201', 'member'),
('10d89236-8499-11ef-83d3-3ca067e52da9', NULL, '1728297797', NULL, 'test', 'test', '10d89278-8499-11ef-83d3-3ca067e52da9', 'member'),
('123', '123', '123', NULL, '123', '123', '123', 'admin'),
('12345', '1234', 'admintest', NULL, 'admintest', 'admintest', 'admintest', 'admin'),
('12345678', NULL, NULL, 'rashid', 'rashid', 'rashid', 'rashid', 'staff'),
('17690dc6-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, 'hello', 'hello', '17690ddc-94e0-11ef-96fe-004e01ffe201', 'member'),
('1c5aa59d-85d6-11ef-bb7d-e9097018277d', NULL, '1728433989', NULL, 'q', 'q', '1c5aa65f-85d6-11ef-bb7d-e9097018277d', 'member'),
('23a7f823-864e-11ef-a918-3ca067e52da9', NULL, '1728485531', NULL, 'h', 'h', '23a7f891-864e-11ef-a918-3ca067e52da9', 'member'),
('262d5d4c-8f8a-11ef-a5b9-004e01ffe201', NULL, '1729500896', NULL, 'o', 'o', '262d5d5b-8f8a-11ef-a5b9-004e01ffe201', 'member'),
('2ea4f5e5-8f8c-11ef-a5b9-004e01ffe201', NULL, '1729501754', NULL, 'yy', 'yy', '2ea4f5fa-8f8c-11ef-a5b9-004e01ffe201', 'member'),
('2f0b6ebb-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503048', NULL, 'noo', 'noo', '2f0b6ecb-8f8f-11ef-a5b9-004e01ffe201', 'member'),
('38065f55-9466-11ef-96fe-004e01ffe201', NULL, '1730035207', NULL, 'hey', 'hey', '38065f69-9466-11ef-96fe-004e01ffe201', 'member'),
('3cfe7084-8df5-11ef-9394-004e01ffe201', NULL, '1729326958', NULL, 'b', 'b', '3cfe70c0-8df5-11ef-9394-004e01ffe201', 'member'),
('3fc06360-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503504', NULL, 'e', 'e', '3fc06373-8f90-11ef-a5b9-004e01ffe201', 'member'),
('4b927727-9268-11ef-8788-004e01ffe201', NULL, '1729816197', NULL, 'u', 'u', '4b927736-9268-11ef-8788-004e01ffe201', 'member'),
('4dd8cffc-8f89-11ef-a5b9-004e01ffe201', NULL, '1729500525', NULL, 'a', 'a', '4dd8d00b-8f89-11ef-a5b9-004e01ffe201', 'member'),
('54f7108e-8651-11ef-a918-3ca067e52da9', NULL, '1728486893', NULL, 'a', 'a', '54f7114d-8651-11ef-a918-3ca067e52da9', 'member'),
('5e626f5f-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503562', NULL, 'h', 'h', '5e626f6e-8f90-11ef-a5b9-004e01ffe201', 'member'),
('6aae584a-946a-11ef-96fe-004e01ffe201', NULL, '1730037014', NULL, 'k', 'k', '6aae585f-946a-11ef-96fe-004e01ffe201', 'member'),
('7979b578-8560-11ef-b414-3ca067e52da9', NULL, '1728383471', NULL, 'c', 'c', '7979b628-8560-11ef-b414-3ca067e52da9', 'member'),
('79fe8f8e-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503605', NULL, 'mm', 'mm', '79fe8f9f-8f90-11ef-a5b9-004e01ffe201', 'member'),
('87ad26bd-9ca5-11ef-a493-004e01ffe201', NULL, '1730942013', NULL, 'test', 'test', '87ad26e7-9ca5-11ef-a493-004e01ffe201', 'member'),
('8983b975-8dff-11ef-9394-004e01ffe201', NULL, '1729331377', NULL, 'c', 'c', '8983b988-8dff-11ef-9394-004e01ffe201', 'member'),
('9710727c-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503655', NULL, 'tt', 'tt', '9710728f-8f90-11ef-a5b9-004e01ffe201', 'member'),
('976721ba-9469-11ef-96fe-004e01ffe201', NULL, '1730036662', NULL, 'hey', 'hey', '976721ca-9469-11ef-96fe-004e01ffe201', 'member'),
('af9112e6-90ec-11ef-9771-004e01ffe201', NULL, '1729653160', NULL, 'a', 'a', 'af9112f6-90ec-11ef-9771-004e01ffe201', 'member'),
('bca05358-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, 'yeah', 'yeah', 'bca05374-998c-11ef-8372-004e01ffe201', 'member'),
('bd0c10a7-8d19-11ef-a94c-004e01ffe201', NULL, '1729232687', NULL, 'hello', 'hello', 'bd0c10d1-8d19-11ef-a94c-004e01ffe201', 'member'),
('c08b4665-8dff-11ef-9394-004e01ffe201', NULL, '1729331491', NULL, 'c', 'c', 'c08b467b-8dff-11ef-9394-004e01ffe201', 'member'),
('c1a68d18-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503254', NULL, 'aa', 'aa', 'c1a68d29-8f8f-11ef-a5b9-004e01ffe201', 'member'),
('d785919d-947a-11ef-96fe-004e01ffe201', NULL, '1730044070', NULL, 'y', 'y', 'd78591b1-947a-11ef-96fe-004e01ffe201', 'member'),
('dd2cca64-8562-11ef-b414-3ca067e52da9', NULL, '1728384510', NULL, 'a', 'a', 'dd2ccab9-8562-11ef-b414-3ca067e52da9', 'member'),
('df9cd6b5-90ef-11ef-954f-004e01ffe201', NULL, '1729654531', NULL, 'a', 'a', 'df9cd6f1-90ef-11ef-954f-004e01ffe201', 'member'),
('e8238a14-9057-11ef-a5b9-004e01ffe201', NULL, '1729589256', NULL, 'hello', 'hello', 'e8238a2e-9057-11ef-a5b9-004e01ffe201', 'member'),
('test', 'test', '1728121956', NULL, '1728121956', 'test', 'test', 'member'),
('ww', NULL, NULL, '1', 'Rashid', 'rashid', 'rashid', 'coach');

-- --------------------------------------------------------

--
-- Table structure for table `log_users`
--

DROP TABLE IF EXISTS `log_users`;
CREATE TABLE IF NOT EXISTS `log_users` (
  `logid` int NOT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `action` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
CREATE TABLE IF NOT EXISTS `plan` (
  `planid` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tid` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `planName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `planType` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `startDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `endDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `validity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Lifetime',
  `amount` int NOT NULL DEFAULT '0',
  `active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`planid`),
  KEY `idx_plan_name` (`planName`),
  KEY `idx_plan_type` (`planType`),
  KEY `idx_description` (`description`),
  KEY `idx_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`planid`, `tid`, `planName`, `description`, `planType`, `startDate`, `endDate`, `duration`, `validity`, `amount`, `active`) VALUES
('LOXGHP', '874489422', 'gambar 3', 'gambar 3', 'Event', '2024-10-14', '2024-10-16', 2, 'Lifetime', 123, 'no'),
('VNWQGL', '32727319', 'Percubaan 1', 'Percubaan 1', 'Event', '2024-10-10', '2024-10-14', 4, 'Lifetime', 123, 'no'),
('VXZPMY', '451453399', 'Gambar 2', 'Gambar 22', 'Event', '2024-09-07', '2024-09-08', 2, 'Lifetime', 123, 'yes'),
('XTWIOL', '', 'Karate Activities', 'This includes all karate activity plan', 'Core', '2024-11-09', '2024-11-28', 0, '', 20, 'yes'),
('ZHXPSA', '443967826', 'pintu', 'pintu', 'Event', '2024-10-10', '2024-10-14', 4, 'Lifetime', 123, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `plan_pages`
--

DROP TABLE IF EXISTS `plan_pages`;
CREATE TABLE IF NOT EXISTS `plan_pages` (
  `page_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `planid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `page_title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `page_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `meta_description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `planid` (`planid`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan_pages`
--

INSERT INTO `plan_pages` (`page_id`, `planid`, `page_title`, `page_content`, `meta_description`, `slug`, `created_at`, `updated_at`, `published`) VALUES
('page_672440785b00f5.08825658', 'MTDQCH', 'hellos', 'hellos', 'hellos', 'hellos', '2024-11-01 02:44:08', '2024-11-01 02:44:08', 1),
('page_6725ad49a3a4f6.40544225', 'THSMAF', 'et', 'et', 'et', 'et', '2024-11-02 04:40:41', '2024-11-02 04:40:41', 1),
('page_672adaeb01b011.33593391', 'VNWQGL', 'Percubaan 1', 'Percubaan 1', 'Percubaan 1', 'ercubaan-1', '2024-11-05 18:56:43', '2024-11-06 02:56:43', 1),
('page_672adb53dc0743.17552309', 'VXZPMY', 'Gambar 2', 'Gambar 2', 'Gambar 2', 'ambar-2', '2024-11-05 18:58:27', '2024-11-06 02:58:27', 1),
('page_672addd0a50314.91648404', 'LOXGHP', 'gambar 3', 'gambar 3', 'gambar 3', 'gambar-3', '2024-11-05 19:09:04', '2024-11-06 03:09:04', 1),
('page_672f3a8fcc53f8.62831523', 'ZHXPSA', 'pintu', 'pintu', 'pintu', 'pintu', '2024-11-09 02:33:51', '2024-11-09 10:33:51', 1),
('page_6726cf1974f279.76136256', 'JIFKPO', 'WOW', 'WOW', 'WOW', '', '2024-11-02 17:17:13', '2024-11-03 01:17:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plan_page_sections`
--

DROP TABLE IF EXISTS `plan_page_sections`;
CREATE TABLE IF NOT EXISTS `plan_page_sections` (
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `page_id` char(36) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `section_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `section_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `section_order` int DEFAULT NULL,
  `section_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`section_id`),
  KEY `page_id` (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

DROP TABLE IF EXISTS `site_content`;
CREATE TABLE IF NOT EXISTS `site_content` (
  `content_id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `idx_section_name` (`section_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`content_id`, `section_name`, `content_text`, `image_path`, `last_updated`, `created_at`) VALUES
(1, 'about_hero_image', NULL, 'images/hero_1729843905_aaf684e335f14f2b.jpg', '2024-10-25 08:11:45', '2024-10-25 07:42:51'),
(2, 'about_main_text', 'WOW!', NULL, '2024-10-27 14:44:48', '2024-10-25 07:42:51'),
(3, 'about_secondary_text', 'Our mission is to develop athletes who excel both in sports and in life.', NULL, '2024-10-25 07:42:51', '2024-10-25 07:42:51'),
(4, 'about_column_1', 'We offer world-class training facilities and experienced coaching staasdasdff to help our athletes reach their full potential.', NULL, '2024-10-25 07:59:31', '2024-10-25 07:42:51'),
(5, 'about_column_2', 'Our programs focus on both physical training and mental preparation, creating well-rounded athletes ready for competition.', NULL, '2024-10-25 07:42:51', '2024-10-25 07:42:51'),
(6, 'contact_form', '<div class=\"site-section\">...your HTML content here...</div>', NULL, '2024-10-27 15:38:34', '2024-10-27 15:38:34'),
(7, 'contact_address', 'Your Address Here', NULL, '2024-10-27 23:55:18', '2024-10-27 23:55:18'),
(8, 'contact_phone', 'Your Phone Number', NULL, '2024-10-27 23:55:18', '2024-10-27 23:55:18'),
(9, 'contact_email', 'your@email.com', NULL, '2024-10-27 23:55:18', '2024-10-27 23:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `sports_timetable`
--

DROP TABLE IF EXISTS `sports_timetable`;
CREATE TABLE IF NOT EXISTS `sports_timetable` (
  `tid` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `planid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staffid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hasApproved` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_timetable`
--

INSERT INTO `sports_timetable` (`tid`, `planid`, `staffid`, `tname`, `hasApproved`) VALUES
('32727319', 'VNWQGL', 'rashid', 'Percubaan 1', '0'),
('443967826', 'ZHXPSA', 'rashid', 'pintu', '0'),
('48a96c46-8d18-11ef-a94c-004e01ffe201', 'BJEFSY', 'Rashid', 'aaaa', 'yes'),
('7b00f52c-8d18-11ef-a94c-004e01ffe201', 'BJEFSY', 'rashid', 'test', 'yes'),
('847758526', 'XTWIOL', '1', 'Default Timetable Name', 'no'),
('851246383', 'VXZPMY', '1', 'Default Timetable Name', 'no'),
('874489422', 'LOXGHP', 'rashid', 'gambar 3', '0'),
('9cfff539-90fd-11ef-954f-004e01ffe201', 'CAFXVW', 'rashid', 'test', 'yes'),
('f3ce119d-8d17-11ef-a94c-004e01ffe201', 'BJEFSY', '1', 'aa', 'yes'),
('fb3cb188-8d16-11ef-a94c-004e01ffe201', 'BJEFSY', 'rashid', 'yes', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staffid` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`staffid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `name`, `username`, `pass_key`, `role`) VALUES
('rashid', 'Rashid Rahman', 'Rashid', 'rashid', 'coach');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display_order` int DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `featured` tinyint(1) DEFAULT '0',
  `jersey_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`member_id`, `full_name`, `position`, `image_path`, `display_order`, `active`, `created_at`, `updated_at`, `featured`, `jersey_number`) VALUES
(1, 'Member 1', 'Black Belt', 'uploads/team_members/event_3.jpg', 1, 1, '2024-10-25 01:42:54', '2024-11-03 13:24:11', 1, NULL),
(2, 'Member 2', 'Black Belt', 'uploads/team_members/image_4.jpg', 2, 1, '2024-10-25 01:42:54', '2024-11-03 13:28:52', 1, NULL),
(3, 'Member 3', 'Black Belt', 'images/team_1_1729827128.jpg', 3, 1, '2024-10-25 01:42:54', '2024-10-27 15:36:36', 1, NULL),
(4, 'Member 4', 'Black Belt', 'images/team_1_1729827128.jpg', 4, 1, '2024-10-25 01:42:54', '2024-10-27 15:36:36', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timetable_days`
--

DROP TABLE IF EXISTS `timetable_days`;
CREATE TABLE IF NOT EXISTS `timetable_days` (
  `day_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `day_number` int DEFAULT NULL,
  `activities` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  PRIMARY KEY (`day_id`),
  KEY `timetable_id` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable_days`
--

INSERT INTO `timetable_days` (`day_id`, `tid`, `day_number`, `activities`) VALUES
('6725a97bcf0d9', 'ZJOAXS', 1, 'test'),
('6725aa5c75593', 'PVNOCY', 1, 'test'),
('day_6726207ed138e4.09339605', '655468533', 1, 'test'),
('day_672aab3bbd0ae1.33750337', '844415098', 9, NULL),
('day_672aab3bbd1d29.53662441', '844415098', 10, NULL),
('f96132dd-9e8c-11ef-b592-004e01ffe201', '847758526', 14, ''),
('f9612b4f-9e8c-11ef-b592-004e01ffe201', '847758526', 13, ''),
('day_672aaa8847ec29.07070788', '934889673', 4, NULL),
('day_672aaa8847d8d7.19964684', '934889673', 3, NULL),
('day_672aaa8847c189.45420558', '934889673', 2, NULL),
('f9615885-9e8c-11ef-b592-004e01ffe201', '847758526', 18, ''),
('day_672adaeb014db8.82811995', '32727319', 4, NULL),
('day_672adaeb013dd9.32448563', '32727319', 3, NULL),
('day_672adaeb012ce6.48905042', '32727319', 2, NULL),
('day_672adaeb011910.37625541', '32727319', 1, NULL),
('day_672aaa8847a183.54031519', '934889673', 1, NULL),
('day_672aa96a184676.17455081', '800464268', 1, NULL),
('day_672aa96a185710.20497464', '800464268', 2, NULL),
('day_672aa96a186635.47452718', '800464268', 3, NULL),
('day_672aa96a1873d4.64084379', '800464268', 4, NULL),
('day_672aaa8847fd29.61720252', '934889673', 5, NULL),
('day_672aab3bbc9857.29306277', '844415098', 1, NULL),
('day_672aab3bbca902.82937042', '844415098', 2, NULL),
('day_672aab3bbcb6b4.62486935', '844415098', 3, NULL),
('day_672aab3bbcc2b5.26178271', '844415098', 4, NULL),
('f9616161-9e8c-11ef-b592-004e01ffe201', '847758526', 19, ''),
('day_672aab3bbcdd02.12141019', '844415098', 1, NULL),
('day_672aab3bbcee20.05245171', '844415098', 7, NULL),
('day_6726cb41902ce9.24094170', '574511568', 1, 'testtt'),
('day_6726cbc57af975.25485836', '149645521', 1, 'testtt'),
('day_6726cbd39c3bc0.74671018', '2265016', 1, 'fg'),
('day_672aab3bbd5a35.67476964', '844415098', 14, NULL),
('day_6726cf1974d8d4.38236568', '92618308', 1, 'WOW'),
('day_6726cf28a099c1.41472425', '473138343', 1, 'WOW'),
('f9616cf3-9e8c-11ef-b592-004e01ffe201', '847758526', 20, ''),
('f961228a-9e8c-11ef-b592-004e01ffe201', '847758526', 12, ''),
('f9611a17-9e8c-11ef-b592-004e01ffe201', '847758526', 11, ''),
('day_672addd0a4c6d2.50293593', '874489422', 3, NULL),
('f9614582-9e8c-11ef-b592-004e01ffe201', '847758526', 16, ''),
('day_672aab3bbd4a45.05343951', '844415098', 13, NULL),
('day_672aab3bbd3ae6.47945327', '844415098', 12, NULL),
('day_6728cb39944e59.34765918', '174532960', 1, NULL),
('day_6728cb39946162.56949739', '174532960', 2, NULL),
('day_6728cb39947090.24752937', '174532960', 3, NULL),
('f9614f85-9e8c-11ef-b592-004e01ffe201', '847758526', 17, ''),
('f961103a-9e8c-11ef-b592-004e01ffe201', '847758526', 10, ''),
('f9610791-9e8c-11ef-b592-004e01ffe201', '847758526', 9, ''),
('f960fda1-9e8c-11ef-b592-004e01ffe201', '847758526', 8, ''),
('f960f3c1-9e8c-11ef-b592-004e01ffe201', '847758526', 7, ''),
('f960e80e-9e8c-11ef-b592-004e01ffe201', '847758526', 6, ''),
('day_6728cd60754817.72663183', '433860664', 1, NULL),
('day_6728cd60755874.33438462', '433860664', 2, NULL),
('day_6728cd60756517.81659827', '433860664', 3, NULL),
('day_6728cd607574b7.87020113', '433860664', 4, NULL),
('f9613b72-9e8c-11ef-b592-004e01ffe201', '847758526', 15, ''),
('f960da97-9e8c-11ef-b592-004e01ffe201', '847758526', 5, ''),
('f960cd06-9e8c-11ef-b592-004e01ffe201', '847758526', 4, ''),
('f960bfc2-9e8c-11ef-b592-004e01ffe201', '847758526', 3, ''),
('day_672addd0a4a046.71617153', '874489422', 1, NULL),
('day_672addd0a4b574.68473845', '874489422', 2, NULL),
('day_672adaeb015fb5.39506782', '32727319', 5, NULL),
('f960a8a1-9e8c-11ef-b592-004e01ffe201', '847758526', 1, ''),
('f960b44f-9e8c-11ef-b592-004e01ffe201', '847758526', 2, ''),
('day_672f3a8fcc0156.01923688', '443967826', 5, NULL),
('day_672f3a8fcbf508.17281470', '443967826', 4, NULL),
('day_672f3a8fcbe8e0.51007404', '443967826', 3, NULL),
('day_672f3a8fcbdc24.03831000', '443967826', 2, NULL),
('day_672f3a8fcbcd40.42767975', '443967826', 1, NULL),
('day_672f3a7184aa95.31837238', '914393930', 3, NULL),
('day_672f3a71848469.85494086', '914393930', 1, NULL),
('1a310e47-9c9c-11ef-a493-004e01ffe201', '451453399', 2, ''),
('1a310309-9c9c-11ef-a493-004e01ffe201', '451453399', 1, 'ew'),
('day_672f3a71849ab0.66530509', '914393930', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `imageid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `joining_date` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hasApproved` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `pass_key`, `imageid`, `username`, `fullName`, `gender`, `mobile`, `email`, `dob`, `joining_date`, `hasApproved`) VALUES
('1729500896', 'o', 'UUID()', 'o', 'o', 'Male', '1', 'o@gmail.com', '2004-10-10', '2024-10-10', 'Yes'),
('1730087557', 'hello', '1768cef2-94e0-11ef-96fe-004e01ffe201', 'hello', 'hello', '', '', 'hello@gmail.com', '', '', 'Yes'),
('1730601491', 'yeah', 'bc9fc58b-998c-11ef-8372-004e01ffe201', 'yeah', 'yeah', 'Male', '', 'yeah@gmail.com', '', '', 'Yes'),
('1730942013', 'test', '87ab09aa-9ca5-11ef-a493-004e01ffe201', 'test', 'test', '', '', 'test@gmail.com', '', '', 'Yes');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_about_content`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_about_content`;
CREATE TABLE IF NOT EXISTS `v_about_content` (
`content_id` int
,`section_name` varchar(50)
,`content_text` text
,`image_path` varchar(255)
,`last_updated` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `active_plans`
--
DROP TABLE IF EXISTS `active_plans`;

DROP VIEW IF EXISTS `active_plans`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `active_plans`  AS SELECT `plan`.`planid` AS `planid`, `plan`.`planName` AS `planName`, `plan`.`description` AS `description`, `plan`.`planType` AS `planType`, `plan`.`startDate` AS `startDate`, `plan`.`endDate` AS `endDate`, `plan`.`duration` AS `duration`, `plan`.`amount` AS `amount`, `plan`.`active` AS `active` FROM `plan` WHERE (`plan`.`active` = 'yes') ;

-- --------------------------------------------------------

--
-- Structure for view `inactive_plans`
--
DROP TABLE IF EXISTS `inactive_plans`;

DROP VIEW IF EXISTS `inactive_plans`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inactive_plans`  AS SELECT `plan`.`planid` AS `planid`, `plan`.`planName` AS `planName`, `plan`.`description` AS `description`, `plan`.`planType` AS `planType`, `plan`.`startDate` AS `startDate`, `plan`.`endDate` AS `endDate`, `plan`.`duration` AS `duration`, `plan`.`amount` AS `amount`, `plan`.`active` AS `active` FROM `plan` WHERE (`plan`.`active` = 'no') ;

-- --------------------------------------------------------

--
-- Structure for view `v_about_content`
--
DROP TABLE IF EXISTS `v_about_content`;

DROP VIEW IF EXISTS `v_about_content`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_about_content`  AS SELECT `site_content`.`content_id` AS `content_id`, `site_content`.`section_name` AS `section_name`, `site_content`.`content_text` AS `content_text`, `site_content`.`image_path` AS `image_path`, `site_content`.`last_updated` AS `last_updated` FROM `site_content` WHERE (`site_content`.`section_name` like 'about%') ORDER BY `site_content`.`content_id` ASC ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `gallery_sections` (`section_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
