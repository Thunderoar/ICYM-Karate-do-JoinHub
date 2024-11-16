-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2024 at 08:10 AM
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
`active` varchar(255)
,`amount` int
,`description` varchar(200)
,`duration` int
,`endDate` varchar(50)
,`planid` varchar(8)
,`planName` varchar(20)
,`planType` varchar(50)
,`startDate` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `addressid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staffid` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adminid` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `streetName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zipcode` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`addressid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressid`, `staffid`, `adminid`, `userid`, `streetName`, `state`, `city`, `zipcode`) VALUES
('12495812', NULL, NULL, '1731657260', '', '', '', ''),
('145149316', NULL, NULL, '1731460556', '', '', '', ''),
('159297509', NULL, NULL, '1729589256', '', '', '', ''),
('167623346', NULL, NULL, '1731658261', '', '', '', ''),
('178160492', NULL, NULL, '1729503048', '', '', '', ''),
('193052981', NULL, NULL, '1731594854', 'test', 'test', 'test', '12345'),
('233879111', NULL, NULL, '1729503254', '', '', '', ''),
('238769188', NULL, NULL, '1731460567', '', '', '', ''),
('240973158', NULL, NULL, '1731594745', '', '', '', ''),
('244071432', NULL, NULL, '1730037014', '', '', '', ''),
('259825696', NULL, NULL, '1730044070', '', '', '', ''),
('260450272', NULL, NULL, '1731458124', NULL, NULL, NULL, NULL),
('263868116', NULL, NULL, '1731462834', '', '', '', ''),
('28643920', NULL, NULL, '1731458693', NULL, NULL, NULL, NULL),
('308334204', NULL, NULL, '1731589238', '', '', '', ''),
('370773697', NULL, NULL, '1731657723', '', '', '', ''),
('398226207', NULL, NULL, '1729503605', '', '', '', ''),
('439216695', NULL, NULL, '1731425542', '', '', '', ''),
('443957638', NULL, NULL, '1729499689', '', '', '', ''),
('445117942', NULL, NULL, '1729500525', '', '', '', ''),
('474709767', NULL, NULL, '1729653160', '', '', '', ''),
('524762761', NULL, NULL, '1731594450', '', '', '', ''),
('541188054', NULL, NULL, '1729503562', '', '', '', ''),
('560851705', NULL, NULL, '1731462741', '', '', '', ''),
('570836098', NULL, NULL, '1731580029', 'yeah', 'yeah', 'yeah', 'yeah'),
('581038254', NULL, NULL, '1731601591', 'jamalstreet', 'jamal state', 'jamal city', '12345'),
('58587039', NULL, NULL, '1731680283', 'amristreet', 'amristate', 'amricity', '12345'),
('603347436', NULL, NULL, '1730942013', '', '', '', ''),
('612212550', NULL, NULL, '1731454171', '', '', '', ''),
('633100712', NULL, NULL, '1731592844', '', '', '', ''),
('651796491', NULL, NULL, '1729501754', '', '', '', ''),
('664647014', NULL, NULL, '1730036662', '', '', '', ''),
('672538767', NULL, NULL, '1729500022', '', '', '', ''),
('696159057', NULL, NULL, '1729654531', '', '', '', ''),
('703592905', NULL, NULL, '1731740302', 'kikiyamastreet', 'kikiyamastate', 'kikiyamacity', '12345'),
('721240106', NULL, NULL, '1731457462', '', '', '', ''),
('737416117', NULL, NULL, '1730035207', '', '', '', ''),
('762966398', NULL, NULL, '1729502982', '', '', '', ''),
('76893169', NULL, NULL, '1731459785', '', '', '', ''),
('769730378', NULL, NULL, '1729499715', '', '', '', ''),
('791246783', NULL, NULL, '1729816197', '', '', '', ''),
('808845610', NULL, NULL, '1731455101', '', '', '', ''),
('889334180', NULL, NULL, '1729506355', '', '', '', ''),
('903907441', NULL, NULL, '1731457659', '', '', '', ''),
('935899936', NULL, NULL, '1729499109', '', '', '', ''),
('935944418', NULL, NULL, '1731740147', '', '', '', ''),
('948864454', NULL, NULL, '1729503655', '', '', '', ''),
('957437288', NULL, NULL, '1731739934', '', '', '', ''),
('965810506', NULL, NULL, '1729503504', '', '', '', ''),
('982014755', NULL, NULL, '1730087557', '', '', '', ''),
('99440050', NULL, NULL, '1731460836', '', '', '', ''),
('995837925', NULL, NULL, '1729502959', '', '', '', ''),
('addr_6735cf83db4a3', NULL, NULL, '1730601491', 'yeah', 'yeah', 'yeah', '12345');

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
-- Table structure for table `contactinfo`
--

DROP TABLE IF EXISTS `contactinfo`;
CREATE TABLE IF NOT EXISTS `contactinfo` (
  `contactinfoid` int NOT NULL AUTO_INCREMENT,
  `contactAddress` text COLLATE utf8mb4_general_ci NOT NULL,
  `contactPhone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contactEmail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`contactinfoid`)
) ENGINE=MyISAM AUTO_INCREMENT=1730601492 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactinfo`
--

INSERT INTO `contactinfo` (`contactinfoid`, `contactAddress`, `contactPhone`, `contactEmail`) VALUES
(1, 'Kolej Antarabangsa Yayasan Melaka, No 1, Jalan Bukit Sebukor', '(+60) 18-271 62test', ''),
(1730087557, '', '', 'hello@gmail.com'),
(1730601491, '', '', 'yeah@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_status` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `archive_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `fullname`, `email`, `subject`, `message`, `created_at`, `read_status`, `archive_status`) VALUES
(1, 'a', 'a@gmail.com', 'a', 'a', '2024-11-14 00:27:58', '1', 0),
(10, 'testing1', 'testing1@gmail.com', 'testing', 'testing karate', '2024-11-14 01:42:27', NULL, 0),
(11, 'wow!', 'ww@gmail.com', 'ww@gmail.com', 'ww', '2024-11-14 01:46:32', NULL, 0),
(12, 'again', 'again@gmail.com', 'again@gmail.com', 'again', '2024-11-14 01:48:13', NULL, 0),
(3, 'Azlan', 'azlan@gmail.com', 'saya berminat untuk memasuki kelab karate ini', 'dari dahulu sy suka menendang, sy ingin mengasah bakat menendang sy dengan lebih mantap, dengan itu sy ingin di register masuk', '2024-11-14 00:33:12', '1', 1),
(4, 'wow', 'wow@gmail.com', 'wow', 'wow', '2024-11-14 00:33:26', '1', 1),
(13, 'a', 'a@gmail.com', 'a', 'a', '2024-11-14 01:51:40', NULL, 0),
(6, 'test', 'test@gmail.com', 'test', 'test', '2024-11-14 00:33:51', '1', 1),
(9, 'kereta', 'kereta@gmail.com', 'kereta', 'kereta', '2024-11-14 01:25:19', NULL, 0),
(33, 'contacttest@gmail.com', 'contacttest@gmail.com', 'contacttest', 'contacttest', '2024-11-15 16:51:30', NULL, 0),
(14, 'wo', 'wow@gmail.com', 'wow', 'wow', '2024-11-14 01:51:59', NULL, 0),
(29, 'asd', 'sdf@gmail.com', 'sdf', 'sdf', '2024-11-14 02:03:13', NULL, 0),
(30, 'asd', 'sdf@gmail.com', 'sdf', 'sdf', '2024-11-14 02:03:18', NULL, 0),
(31, 'asd', 'sdf@gmail.com', 'asd', 'asd', '2024-11-14 02:03:25', '1', 0),
(32, 'sdf', 'sdf@gmail.com', 'sdf', 'sdf', '2024-11-14 02:03:34', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`) VALUES
(1, 'Diploma in Entrepreneurship'),
(2, 'Diploma in Marketing'),
(3, 'Diploma in Accountancy'),
(4, 'Diploma in Islamic Financial Planning'),
(5, 'Diploma in Culinary Arts'),
(6, 'Diploma in Hotel Management'),
(7, 'Diploma in Tourism Management'),
(8, 'Diploma in Animation Technology'),
(9, 'Diploma in Media Technology'),
(10, 'Diploma in Theatrical Arts and Technology'),
(11, 'Diploma in Multimedia Technology'),
(12, 'Diploma in Information Technology'),
(13, 'Diploma in Computer Networking'),
(14, 'Diploma in Cyber Security'),
(15, 'Diploma in Electrical Technology'),
(16, 'Diploma in Industrial Electronic Technology'),
(17, 'Diploma in Early Childhood Education'),
(18, 'Diploma in Guidance & Counseling'),
(19, 'Diploma in Aircraft Maintenance Technology');

-- --------------------------------------------------------

--
-- Table structure for table `enrolls_to`
--

DROP TABLE IF EXISTS `enrolls_to`;
CREATE TABLE IF NOT EXISTS `enrolls_to` (
  `et_id` int NOT NULL AUTO_INCREMENT,
  `planid` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `paid_date` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expire` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hasPaid` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `hasApproved` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `receiptIMG` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`et_id`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolls_to`
--

INSERT INTO `enrolls_to` (`et_id`, `planid`, `userid`, `paid_date`, `expire`, `hasPaid`, `hasApproved`, `receiptIMG`) VALUES
(92, 'XTWIOL', '1730942013', '2024-11-12 23:30:50', '9999-12-31', 'yes', 'yes', ''),
(133, 'VXZPMY', '1730087557', NULL, NULL, 'no', 'no', ''),
(141, 'XTWIOL', '1730087557', '2024-11-12 22:28:12', '9999-12-31', 'yes', 'yes', ''),
(150, 'XTWIOL', '1730601491', '2024-11-12 22:13:22', '9999-12-31', 'yes', 'yes', ''),
(151, 'ZHXPSA', '1730601491', '2024-11-13 15:25:55', '9999-12-31', 'yes', 'yes', ''),
(152, 'XTWIOL', '1731425542', '2024-11-12', '1970-01-01', 'no', '', ''),
(153, 'VXZPMY', '1731425542', '2024-11-12 23:34:59', '9999-12-31', 'yes', 'yes', ''),
(154, 'XTWIOL', '1731454171', '2024-11-13 07:33:06', '9999-12-31', 'yes', 'yes', ''),
(155, 'VXZPMY', '1731454171', '2024-11-13 07:33:42', '9999-12-31', 'yes', 'yes', ''),
(156, 'XTWIOL', '1731455101', '2024-11-13', '1970-01-01', 'no', '', ''),
(157, 'VXZPMY', '1731455101', '2024-11-13 07:46:13', '9999-12-31', 'yes', 'yes', ''),
(160, 'XTWIOL', '1731457462', '2024-11-13', '1970-01-01', 'no', '', ''),
(161, 'XTWIOL', '1731457659', '2024-11-13', '1970-01-01', 'no', '', ''),
(162, 'VXZPMY', '1731457659', '2024-11-13 08:29:20', '9999-12-31', 'yes', 'yes', ''),
(165, 'XTWIOL', '1731458124', '2024-11-13', '1970-01-01', 'no', '', ''),
(166, 'VXZPMY', '1731458124', '2024-11-13 08:37:17', '9999-12-31', 'yes', 'yes', ''),
(167, 'XTWIOL', '1731458565', '2024-11-13', '1970-01-01', 'no', '', ''),
(168, 'XTWIOL', '1731458693', '2024-11-13', '1970-01-01', 'no', '', ''),
(169, 'VXZPMY', '1731458693', '2024-11-13 08:45:53', '9999-12-31', 'yes', 'no', ''),
(170, 'XTWIOL', '1731459785', '2024-11-13 09:04:22', '9999-12-31', 'yes', 'yes', ''),
(171, 'VXZPMY', '1731459785', '2024-11-13 09:04:51', '9999-12-31', 'yes', 'yes', ''),
(172, 'XTWIOL', '1731460346', '2024-11-13', '1970-01-01', 'no', '', ''),
(173, 'XTWIOL', '1731460556', '2024-11-13', '1970-01-01', 'no', '', ''),
(174, 'XTWIOL', '1731460567', '2024-11-13', '1970-01-01', 'no', '', ''),
(175, 'VXZPMY', '1731460567', '2024-11-13 09:17:57', '9999-12-31', 'yes', 'yes', ''),
(176, 'XTWIOL', '1731460836', '2024-11-13', '1970-01-01', 'no', '', ''),
(177, 'VXZPMY', '1731460836', '2024-11-13 09:22:21', '9999-12-31', 'yes', 'yes', ''),
(178, 'XTWIOL', '1731462741', '2024-11-13', '1970-01-01', 'no', '', ''),
(179, 'VXZPMY', '1731462741', '2024-11-13 09:53:30', '9999-12-31', 'yes', 'yes', ''),
(180, 'XTWIOL', '1731462834', '2024-11-13 09:54:39', '9999-12-31', 'yes', 'yes', ''),
(186, 'XTWIOL', '1731580029', '2024-11-14', '1970-01-01', 'no', '', ''),
(188, 'VXZPMY', '1730601491', '2024-11-16 12:29:26', '9999-12-31', 'yes', 'yes', ''),
(189, 'XTWIOL', '1731589238', '2024-11-14', '1970-01-01', 'no', '', ''),
(192, 'XTWIOL', '1731594745', '2024-11-14', '1970-01-01', 'no', '', ''),
(193, 'XTWIOL', '1731594854', '2024-11-14', '1970-01-01', 'no', '', ''),
(213, 'VXZPMY', '1731601591', '2024-11-15 15:52:41', '9999-12-31', 'no', 'no', ''),
(215, 'XTWIOL', '1731601591', '2024-11-15 15:53:13', '9999-12-31', 'yes', 'no', ''),
(216, 'XTWIOL', '1731657260', '2024-11-15', '1970-01-01', 'no', NULL, NULL),
(217, 'VXZPMY', '1731657260', NULL, '2024-12-15 15:56:38', 'no', 'no', NULL),
(218, 'XTWIOL', '1731657723', '2024-11-15', '1970-01-01', 'no', NULL, NULL),
(222, 'VXZPMY', '1731657723', '2024-11-15 19:41:16', '9999-12-31', 'no', 'no', ''),
(223, 'XTWIOL', '1731658261', '2024-11-15', '1970-01-01', 'no', NULL, NULL),
(231, 'VXZPMY', '1731658261', '2024-11-15 19:41:23', '9999-12-31', 'no', 'no', ''),
(232, 'XTWIOL', '1731660995', '2024-11-15', '1970-01-01', 'no', NULL, NULL),
(241, 'XTWIOL', '1731680283', '2024-11-15', '1970-01-01', 'no', NULL, NULL),
(245, 'VXZPMY', '1731680283', NULL, '2024-12-16 13:19:37', 'no', 'no', NULL),
(246, 'XTWIOL', '1731739934', '2024-11-16', '1970-01-01', 'no', NULL, NULL),
(247, 'XTWIOL', '1731740147', '2024-11-16', '1970-01-01', 'no', NULL, NULL),
(248, 'XTWIOL', '1731740302', '2024-11-16', '1970-01-01', 'no', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_members`
--

INSERT INTO `event_members` (`em_id`, `planid`, `userid`, `joined_at`) VALUES
(25, '0', 1730601491, '2024-11-11 09:30:44'),
(47, 'ZHXPSA', 1730087557, '2024-11-12 15:13:32'),
(86, 'XTWIOL', 1730601491, '2024-11-16 04:25:19'),
(87, 'VXZPMY', 1730601491, '2024-11-16 04:29:26'),
(85, 'XTWIOL', 1730087557, '2024-11-16 04:25:19'),
(70, 'ZHXPSA', 1730601491, '2024-11-13 07:25:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_staff`
--

INSERT INTO `event_staff` (`es_id`, `planid`, `staffid`, `joined_at`) VALUES
(22, 'VXZPMY', 'rashid', '2024-11-16 03:15:08'),
(16, 'ZHXPSA', 'rashid', '2024-11-12 15:13:32'),
(24, 'XTWIOL', 'rashid', '2024-11-16 04:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`image_id`, `section_id`, `image_path`, `uploaded_at`) VALUES
(80, 13, 'uploads/IMG_6269.JPG', '2024-11-14 15:39:56'),
(81, 13, 'uploads/IMG_6221.JPG', '2024-11-14 15:39:56'),
(82, 13, 'uploads/IMG_6186.JPG', '2024-11-14 15:39:56'),
(84, 13, 'uploads/-6273946355093322536_121.jpg', '2024-11-14 15:39:56'),
(85, 13, 'uploads/814ad696-0a1a-4832-9a13-5514bf0cf7f3.JPG', '2024-11-14 15:39:56'),
(86, 13, 'uploads/IMG_4217.JPG', '2024-11-14 15:40:22'),
(87, 13, 'uploads/IMG_4199.JPG', '2024-11-14 15:40:22'),
(88, 11, 'uploads/photo_6332501435241054672_x.jpg', '2024-11-14 15:44:08'),
(89, 14, 'uploads/IMG-20181027-WA0046.jpg', '2024-11-14 15:45:00'),
(90, 14, 'uploads/IMG-20181018-WA0038.jpg', '2024-11-14 15:45:00'),
(91, 14, 'uploads/IMG-20181027-WA0057.jpg', '2024-11-14 15:45:16'),
(92, 14, 'uploads/IMG-20180209-WA0032.jpg', '2024-11-14 15:45:16'),
(93, 14, 'uploads/IMG-20181027-WA0047.jpg', '2024-11-14 15:45:16'),
(94, 12, 'uploads/photo_6086945716703445502_w.jpg', '2024-11-14 15:45:38'),
(95, 10, 'uploads/Screenshot 2024-11-14 234921.png', '2024-11-14 15:49:54'),
(96, 10, 'uploads/photo_6078084748200229506_y.jpg', '2024-11-14 15:49:54'),
(97, 10, 'uploads/photo_6078084748200229500_y.jpg', '2024-11-14 15:49:54'),
(98, 10, 'uploads/photo_6078084748200229501_y.jpg', '2024-11-14 15:49:54'),
(99, 10, 'uploads/photo_6078084748200229514_y.jpg', '2024-11-14 15:49:54'),
(100, 10, 'uploads/photo_6078084748200229361_y.jpg', '2024-11-14 15:50:08'),
(101, 10, 'uploads/photo_6078084748200229414_y.jpg', '2024-11-14 15:50:08'),
(102, 10, 'uploads/photo_6078084748200229410_y.jpg', '2024-11-14 15:50:08'),
(103, 12, 'uploads/photo_6312283903192316420_y.jpg', '2024-11-14 15:51:54'),
(104, 10, 'uploads/photo_6078084748200229450_y.jpg', '2024-11-14 15:52:22'),
(105, 11, 'uploads/dbb209ed-817b-44e2-adbd-5df9a44afcee.jfif', '2024-11-14 15:54:04'),
(106, 11, 'uploads/683fdc14-cc31-4f19-b169-79f9930e5b8d.jfif', '2024-11-14 15:54:04'),
(107, 12, 'uploads/photo_6260367884706496346_y.jpg', '2024-11-14 15:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_sections`
--

DROP TABLE IF EXISTS `gallery_sections`;
CREATE TABLE IF NOT EXISTS `gallery_sections` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `section_description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `planid` int NOT NULL,
  PRIMARY KEY (`section_id`),
  KEY `planid` (`planid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_sections`
--

INSERT INTO `gallery_sections` (`section_id`, `section_name`, `section_description`, `created_at`, `planid`) VALUES
(10, 'Booth Exhibition & Demonstration for New Intake', 'The Booth Exhibition at ICYM Foyer showcased our club\'s achievements, displaying medals and awards that reflect our members\' dedication. Visitors were treated to live demonstrations, including Kata 1, Kata 2, and board-breaking, capturing the intensity and skill of martial arts. Refreshments and popsicles were sold to generate funds for the club, creating a lively and engaging experience for all who attended.', '2024-11-14 15:02:26', 0),
(11, 'Demonstration at Children Carnival Taman Limbongan Permai, Melaka', 'At the Children’s Carnival in Taman Limbongan Permai, Melaka, our club delivered an engaging demonstration aimed at introducing karate to young audiences and showcasing the art\'s beauty to visitors. The event featured a fast-response demonstration, along with Kata 1 and Kata 2, highlighting the precision, discipline, and agility that define karate. The performance inspired many, drawing attention to the importance of starting martial arts training at a young age.', '2024-11-14 15:07:53', 0),
(12, '1st Ever Grand Group Training Malaysia Open 2023', 'The 1st Ever Grand Group Training at Malaysia Open 2023 brought together karatekas from across the country for an inspiring session led by top professional karate instructors. This historic event, officially listed in the Malaysian Book of Records, aimed to motivate participants to expand their skills and master new techniques. The atmosphere was electric, as karatekas trained side by side, absorbing fresh movements and refining their craft under expert guidance.', '2024-11-14 15:16:03', 0),
(13, 'ICYM Students and Alumni Dinner 2024', 'The ICYM Students and Alumni Dinner 2024 was a special event dedicated to reintroducing our club after a period of inactivity due to COVID-19. Designed to attract both staff and students, the evening aimed to renew interest in joining our community. A captivating karate performance added a unique flair to the dinner, showcasing the club’s spirit and talent as we look forward to a new chapter together.', '2024-11-14 15:20:15', 0),
(14, 'Throwback of Our Alumni', 'Our alumni played an integral role in shaping the club and its legacy. As part of the team, they embraced the discipline and dedication required to train and perfect the beauty of karate. Their journey reflects the values we uphold: hard work, perseverance, and respect. We celebrate their contributions and the lasting impact they’ve had on the club, inspiring the next generation of karatekas.', '2024-11-14 15:23:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `health_status`
--

DROP TABLE IF EXISTS `health_status`;
CREATE TABLE IF NOT EXISTS `health_status` (
  `healthid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `calorie` int DEFAULT NULL,
  `height` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weight` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remarks` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fat` int DEFAULT NULL,
  PRIMARY KEY (`healthid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_status`
--

INSERT INTO `health_status` (`healthid`, `calorie`, `height`, `weight`, `remarks`, `userid`, `fat`) VALUES
('127361533', NULL, '', '', '', '1730037014', 0),
('15697384', NULL, '', '', '', '1729502982', 0),
('159244038', NULL, '', '', '', '1729326958', 0),
('161958492', NULL, '', '', '', '1729232687', 0),
('17580962', NULL, '', '', '', '1728485531', 0),
('18192879', NULL, '160', '46', 'remark test', '1731594854', 0),
('194967109', NULL, NULL, NULL, '', '1731459785', 0),
('198765922', NULL, '', '', '', '1729499988', 0),
('204334593', NULL, '', '', '', '1729589256', 0),
('205571730', NULL, '', '', '', '1729503562', 0),
('206420275', NULL, '', '', '', '1729816197', 0),
('235920854', NULL, NULL, NULL, '', '1731460567', 0),
('277790349', NULL, '', '', '', '1729499001', 0),
('297159777', NULL, '', '', '', '1729500022', 0),
('316322884', NULL, '0', '0', '', '1731457659', 0),
('319821461', NULL, '', '', '', '1729331377', 0),
('320368413', 0, 'Not meas', 'Not meas', '', '1731657723', 0),
('338833368', NULL, '', '', '', '1729653160', 0),
('353479103', NULL, '160', '48', '', '1730087557', 0),
('361339141', NULL, '', '', '', '1729503655', 0),
('377819181', NULL, '', '', '', '1729503048', 0),
('387732098', NULL, '', '', '', '1730035207', 0),
('388848522', NULL, '', '', '', '1729500806', 0),
('38888806', NULL, '', '', '', '1728384510', 0),
('394786288', NULL, '160', '53', '', '1731680283', NULL),
('398395806', NULL, '', '', '', '1729499109', 0),
('400263278', NULL, '', '', '', '1729506355', 0),
('404242844', NULL, NULL, NULL, '', '1731460346', 0),
('409696460', NULL, '', '', '', '1729654531', 0),
('42304840', NULL, NULL, NULL, '', '1731460556', 0),
('46800272', NULL, '', '', '', '1728433989', 0),
('46930702', NULL, NULL, NULL, '', '1731589238', 0),
('489011551', NULL, NULL, NULL, '', '1731657260', 0),
('502087201', NULL, NULL, NULL, '', '1731425542', 0),
('502374538', NULL, NULL, NULL, '', '1731462741', 0),
('506048860', NULL, '', '', '', '1729499673', 0),
('511416977', 1, NULL, NULL, '', '1731740147', 1),
('513408577', NULL, '', '', '', '1729499715', 0),
('545001881', NULL, '0.02', '123123', 'testing', '1731580029', 0),
('545571238', NULL, '160', '50', 'hello', '1731601591', 0),
('560855253', NULL, NULL, NULL, '', '1731592844', 0),
('561523138', NULL, '', '', '', '1729503254', 0),
('575478311', NULL, '', '', 'test', '1728486893', 0),
('601341539', NULL, NULL, NULL, '', '1731458565', 0),
('622422499', NULL, '0', '0', '', '1731458693', 0),
('633040238', NULL, '0', '0', '', '1731458124', 0),
('654097819', NULL, NULL, NULL, '', '1731455101', 0),
('669067523', NULL, NULL, NULL, '', '1731594745', 0),
('675436545', NULL, '', '', '', '1729503605', 0),
('69760681', NULL, '', '', '', '1729503504', 0),
('720563994', NULL, NULL, NULL, '', '1731460836', 0),
('733467291', 1, '180', '67', '', '1731740302', 1),
('755755046', NULL, NULL, NULL, '', '1731739934', NULL),
('770322812', NULL, '', '', '', '1729499689', 0),
('782002307', NULL, NULL, NULL, '', '1731462834', 0),
('80936596', NULL, '', '', '', '1729499036', 0),
('814154647', 0, '123', '123', '', '1731658261', 0),
('814749952', NULL, NULL, NULL, '', '1731594450', 0),
('826633186', NULL, '', '', '', '1728383471', 0),
('826677281', NULL, '', '', '', '1728384120', 0),
('8333733', NULL, NULL, NULL, '', '1730942013', 0),
('859482983', NULL, NULL, NULL, '', '1731457462', 0),
('860622780', NULL, '', '', '', '1730036662', 0),
('872369437', NULL, '', '', '', '1729502959', 0),
('874529438', NULL, '', '', '', '1729331491', 0),
('88203510', NULL, '', '', '', '1729500525', 0),
('918803354', NULL, '', '', '', '1730044070', 0),
('953569586', NULL, NULL, NULL, '', '1731454171', 0),
('955419055', NULL, '', '', '', '1729500896', 0),
('95897886', NULL, '', '', '', '1729501754', 0),
('health_6735cf83db4a6', 123, '123', '123', 'testing', '1730601491', 123);

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
('0d6d5679-a15b-11ef-be02-004e01ffe201', NULL, '1731459785', NULL, NULL, NULL, '2024-11-13 01:03:11'),
('0da40578-a273-11ef-a033-004e01ffe201', NULL, '1731580029', NULL, NULL, 'uploads/logo1.png', '2024-11-14 10:27:30'),
('16e092c9-9689-11ef-aaee-004e01ffe201', NULL, NULL, NULL, 'KYDZOV', 'uploads/6721d39503ce1_event_1.jpg', '2024-10-30 06:35:01'),
('1769271a-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, NULL, NULL, '2024-10-28 03:52:45'),
('1b713689-a2a5-11ef-b782-004e01ffe201', NULL, '1731601530', NULL, NULL, NULL, '2024-11-14 16:25:48'),
('1cd5fd45-9e86-11ef-b592-004e01ffe201', NULL, NULL, NULL, 'ZHXPSA', 'uploads/672f3a8fcc171_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-09 10:33:51'),
('1e056ed2-a156-11ef-be02-004e01ffe201', NULL, '1731457659', NULL, NULL, NULL, '2024-11-13 00:27:51'),
('1f44babb-94d2-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'UGZVJQ', 'uploads/image_2_671ef31e09eec.jpg', '2024-10-28 02:12:46'),
('20af0194-9754-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WDCFUK', 'uploads/672328394cfbc_karate_main.jpg', '2024-10-31 06:48:25'),
('2147483647', NULL, '1729500022', NULL, NULL, NULL, '2024-10-21 08:41:08'),
('262d799d-8f8a-11ef-a5b9-004e01ffe201', NULL, '1729500896', NULL, NULL, NULL, '2024-10-21 08:54:57'),
('2aa3cf84-a150-11ef-be02-004e01ffe201', NULL, '1731455101', NULL, NULL, NULL, '2024-11-12 23:45:15'),
('2abf9125-a162-11ef-be02-004e01ffe201', NULL, '1731462834', NULL, NULL, NULL, '2024-11-13 01:54:06'),
('2ea50c7f-8f8c-11ef-a5b9-004e01ffe201', NULL, '1729501754', NULL, NULL, NULL, '2024-10-21 09:09:31'),
('2f0b7fa6-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503048', NULL, NULL, NULL, '2024-10-21 09:31:00'),
('2f32718b-a329-11ef-b782-004e01ffe201', NULL, '1731658261', NULL, NULL, NULL, '2024-11-15 08:11:15'),
('3', NULL, '1729326958', NULL, NULL, NULL, '2024-10-19 08:36:30'),
('311fa78d-975e-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'KTQNRL', 'uploads/6723391bd3126_karate_main.jpg', '2024-10-31 08:00:27'),
('316b02ef-a157-11ef-be02-004e01ffe201', NULL, '1731458124', NULL, NULL, NULL, '2024-11-13 00:35:33'),
('38067411-9466-11ef-96fe-004e01ffe201', NULL, '1730035207', NULL, NULL, NULL, '2024-10-27 13:20:21'),
('3ed8cae7-a3e8-11ef-b782-004e01ffe201', NULL, '1731740302', NULL, NULL, 'uploads/529239-lily-pad-wallpaper-1920x1280-macbook.jpg', '2024-11-16 06:58:55'),
('3fc07e44-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503504', NULL, NULL, NULL, '2024-10-21 09:38:37'),
('4', NULL, '1729500525', NULL, NULL, NULL, '2024-10-21 08:48:55'),
('46b229f4-a2a5-11ef-b782-004e01ffe201', NULL, '1731601591', NULL, NULL, 'uploads/logo1.png', '2024-11-14 16:27:01'),
('4b9288ef-9268-11ef-8788-004e01ffe201', NULL, '1729816197', NULL, NULL, NULL, '2024-10-25 00:30:11'),
('4f29ea2f-a158-11ef-be02-004e01ffe201', NULL, '1731458565', NULL, NULL, NULL, '2024-11-13 00:43:32'),
('5', NULL, '1729499689', NULL, NULL, NULL, '2024-10-21 08:35:06'),
('515', NULL, '1729499673', NULL, NULL, NULL, '2024-10-21 08:34:41'),
('54a9f345-9bce-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'EHBPVK', 'uploads/672aab3bbd821_image_2.jpg', '2024-11-05 23:33:15'),
('5639b75c-a10b-11ef-be02-004e01ffe201', NULL, '1731425542', NULL, NULL, NULL, '2024-11-12 15:32:33'),
('57379856-a295-11ef-b782-004e01ffe201', NULL, '1731594745', NULL, NULL, NULL, '2024-11-14 14:32:56'),
('591e262b-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'CDZJSY', 'uploads/672ada3d264a8_event_1.jpg', '2024-11-06 02:53:49'),
('5e628491-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503562', NULL, NULL, NULL, '2024-10-21 09:39:29'),
('5fbdf482-a15c-11ef-be02-004e01ffe201', NULL, '1731460346', NULL, NULL, NULL, '2024-11-13 01:12:38'),
('611fb9ee-9bcd-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'DGEQBM', 'uploads/plans/plan_672aa9a32ccf28.10183593.jpg', '2024-11-05 15:26:27'),
('669a00ac-a290-11ef-b782-004e01ffe201', NULL, '', NULL, NULL, NULL, '2024-11-14 13:57:35'),
('6aae6da4-946a-11ef-96fe-004e01ffe201', NULL, '1730037014', NULL, NULL, NULL, '2024-10-27 13:50:24'),
('7068c242-a3e7-11ef-b782-004e01ffe201', NULL, '1731739934', NULL, NULL, NULL, '2024-11-16 06:53:09'),
('70c1601e-a294-11ef-b782-004e01ffe201', NULL, '1731594366', NULL, NULL, NULL, '2024-11-14 14:26:30'),
('79fe9b2e-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503605', NULL, NULL, NULL, '2024-10-21 09:40:15'),
('7acf25b0-9bec-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'LOXGHP', 'uploads/672addd0a4e38_event_1.jpg', '2024-11-06 03:09:04'),
('8', NULL, NULL, NULL, 'TGJIOA', 'uploads/image_2.jpg', '2024-10-18 06:23:57'),
('802064a9-a288-11ef-b782-004e01ffe201', NULL, '1731589238', NULL, NULL, NULL, '2024-11-14 13:01:02'),
('85487087-9bcf-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'XZONMS', 'uploads/672aad3acda2b_image_2.jpg', '2024-11-05 23:41:46'),
('8623dcee-a158-11ef-be02-004e01ffe201', NULL, '1731458693', NULL, NULL, NULL, '2024-11-13 00:45:05'),
('86f0c48f-a290-11ef-b782-004e01ffe201', NULL, '1731592704', NULL, NULL, NULL, '2024-11-14 13:58:29'),
('87ad5a79-9ca5-11ef-a493-004e01ffe201', NULL, '1730942013', NULL, NULL, 'uploads/hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-07 01:13:43'),
('87e56531-a15d-11ef-be02-004e01ffe201', NULL, '1731460836', NULL, NULL, NULL, '2024-11-13 01:20:55'),
('8983', NULL, '1729331377', NULL, NULL, NULL, '2024-10-19 09:50:14'),
('8984', NULL, '1729232687', NULL, NULL, NULL, '2024-10-18 06:25:15'),
('8985', NULL, '1729331491', NULL, NULL, NULL, '2024-10-19 09:51:46'),
('8989', 'admintest', NULL, NULL, NULL, 'uploads/cat-sleepy.gif', '2024-10-19 11:03:43'),
('8990', NULL, '1729499036', NULL, NULL, NULL, '2024-10-21 08:24:04'),
('8991', NULL, '1729499109', NULL, NULL, NULL, '2024-10-21 08:25:15'),
('8ddf31b6-a295-11ef-b782-004e01ffe201', NULL, '1731594854', NULL, NULL, 'uploads/cat-sleepy.gif', '2024-11-14 14:34:28'),
('9327316', NULL, '1729499715', NULL, NULL, NULL, '2024-10-21 08:36:32'),
('9327317', NULL, '1729499988', NULL, NULL, NULL, '2024-10-21 08:39:56'),
('97108066-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503655', NULL, NULL, NULL, '2024-10-21 09:41:04'),
('97673448-9469-11ef-96fe-004e01ffe201', NULL, '1730036662', NULL, NULL, NULL, '2024-10-27 13:44:30'),
('98ea3aa6-9be9-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'UGZKDM', 'uploads/672ad8faa97ef_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-06 02:48:26'),
('a0d5f526-a294-11ef-b782-004e01ffe201', NULL, '1731594450', NULL, NULL, NULL, '2024-11-14 14:27:50'),
('a0f12b11-9bcf-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'TQSFLR', 'uploads/672aad693c338_image_2.jpg', '2024-11-05 23:42:33'),
('a608b405-a32f-11ef-b782-004e01ffe201', NULL, '1731660995', NULL, NULL, NULL, '2024-11-15 08:57:31'),
('a86fba5f-a155-11ef-be02-004e01ffe201', NULL, '1731457462', NULL, NULL, NULL, '2024-11-13 00:24:34'),
('af459d21-9abc-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WBGSAZ', 'uploads/plans/plan_6728e021a7d910.92053212.jpg', '2024-11-04 14:54:25'),
('af9126c9-90ec-11ef-9771-004e01ffe201', NULL, '1729653160', NULL, NULL, NULL, '2024-10-23 03:12:50'),
('b3fd23a2-9753-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'HAJBWP', 'uploads/67232782e6b24_image_8.jpg', '2024-10-31 06:45:22'),
('bca06ed8-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, NULL, 'uploads/event_1.jpg', '2024-11-03 02:38:41'),
('bf8c290f-a2ab-11ef-b782-004e01ffe201', NULL, NULL, 'rashid', NULL, 'uploads/player_1.jpg', '2024-11-14 17:13:20'),
('c0bd6e81-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VNWQGL', 'uploads/672adaeb01828_event_1.jpg', '2024-11-06 02:56:43'),
('c1a6ad2f-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503254', NULL, NULL, NULL, '2024-10-21 09:35:06'),
('c297f3e8-94c4-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'TGNJRZ', 'uploads/event_1_671edcb3189d6.jpg', '2024-10-28 00:37:07'),
('c303703d-a290-11ef-b782-004e01ffe201', NULL, '1731592807', NULL, NULL, NULL, '2024-11-14 14:00:10'),
('c779416c-9bcc-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'KZMTED', 'uploads/plans/plan_672aa8a15f44b5.80760034.jpg', '2024-11-05 23:22:09'),
('d785ab4b-947a-11ef-96fe-004e01ffe201', NULL, '1730044070', NULL, NULL, NULL, '2024-10-27 15:47:59'),
('da6bdcf5-a290-11ef-b782-004e01ffe201', NULL, '1731592844', NULL, NULL, NULL, '2024-11-14 14:00:49'),
('dbc0ce59-a15c-11ef-be02-004e01ffe201', NULL, '1731460556', NULL, NULL, NULL, '2024-11-13 01:16:06'),
('dc81088c-8f96-11ef-a5b9-004e01ffe201', NULL, '1729506355', NULL, NULL, NULL, '2024-10-21 10:25:58'),
('df7b218f-a326-11ef-b782-004e01ffe201', NULL, '1731657260', NULL, NULL, NULL, '2024-11-15 07:54:42'),
('df9cf0f4-90ef-11ef-954f-004e01ffe201', NULL, '1729654531', NULL, NULL, NULL, '2024-10-23 03:35:39'),
('e823ad64-9057-11ef-a5b9-004e01ffe201', NULL, '1729589256', NULL, NULL, NULL, '2024-10-22 09:27:51'),
('ea1a87b8-a35c-11ef-b782-004e01ffe201', NULL, '1731680283', NULL, NULL, NULL, '2024-11-15 14:21:33'),
('ebc785dd-a3e7-11ef-b782-004e01ffe201', NULL, '1731740147', NULL, NULL, NULL, '2024-11-16 06:56:36'),
('ed943f77-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'ERQZBC', 'uploads/6724360086480_karate_main.jpg', '2024-11-01 01:59:28'),
('f1e09bcb-a327-11ef-b782-004e01ffe201', NULL, '1731657723', NULL, NULL, NULL, '2024-11-15 08:02:22'),
('f3bbb8c8-a15c-11ef-be02-004e01ffe201', NULL, '1731460567', NULL, NULL, NULL, '2024-11-13 01:16:47'),
('f7c907a6-a161-11ef-be02-004e01ffe201', NULL, '1731462741', NULL, NULL, NULL, '2024-11-13 01:52:41'),
('f9b54ceb-8f8e-11ef-a5b9-004e01ffe201', NULL, '1729502959', NULL, NULL, NULL, '2024-10-21 09:29:30'),
('fa1250de-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'FLERKI', 'uploads/672436157c3d6_image_11.jpg', '2024-11-01 01:59:49'),
('ff430ac1-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VXZPMY', 'uploads/672adb53dbe53_image_11.jpg', '2024-11-06 02:58:27'),
('ffb8592d-a14d-11ef-be02-004e01ffe201', NULL, '1731454171', NULL, NULL, NULL, '2024-11-12 23:29:44');

-- --------------------------------------------------------

--
-- Stand-in structure for view `inactive_plans`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `inactive_plans`;
CREATE TABLE IF NOT EXISTS `inactive_plans` (
`active` varchar(255)
,`amount` int
,`description` varchar(200)
,`duration` int
,`endDate` varchar(50)
,`planid` varchar(8)
,`planName` varchar(20)
,`planType` varchar(50)
,`startDate` varchar(50)
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
('0d6d3247-a15b-11ef-be02-004e01ffe201', NULL, '1731459785', NULL, 'm1', 'm1', '0d6d3265-a15b-11ef-be02-004e01ffe201', 'member'),
('0da3d601-a273-11ef-a033-004e01ffe201', NULL, '1731580029', NULL, 'one', 'oneoneone1', '0da3d63e-a273-11ef-a033-004e01ffe201', 'member'),
('10d89236-8499-11ef-83d3-3ca067e52da9', NULL, '1728297797', NULL, 'test', 'test', '10d89278-8499-11ef-83d3-3ca067e52da9', 'member'),
('123', '123', '123', NULL, '123', '123', '123', 'admin'),
('12345', '1234', 'admintest', NULL, 'admintest', 'admintest', 'admintest', 'admin'),
('12345678', NULL, NULL, 'rashid', 'rashid', 'rashid', 'rashid', 'staff'),
('17690dc6-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, 'hello', 'hello', '17690ddc-94e0-11ef-96fe-004e01ffe201', 'member'),
('1c5aa59d-85d6-11ef-bb7d-e9097018277d', NULL, '1728433989', NULL, 'q', 'q', '1c5aa65f-85d6-11ef-bb7d-e9097018277d', 'member'),
('1e0558d5-a156-11ef-be02-004e01ffe201', NULL, '1731457659', NULL, 'member6', 'member6', '1e0558ea-a156-11ef-be02-004e01ffe201', 'member'),
('23a7f823-864e-11ef-a918-3ca067e52da9', NULL, '1728485531', NULL, 'h', 'h', '23a7f891-864e-11ef-a918-3ca067e52da9', 'member'),
('262d5d4c-8f8a-11ef-a5b9-004e01ffe201', NULL, '1729500896', NULL, 'o', 'o', '262d5d5b-8f8a-11ef-a5b9-004e01ffe201', 'member'),
('2aa3ad9e-a150-11ef-be02-004e01ffe201', NULL, '1731455101', NULL, 'member3', 'member3', '2aa3adb8-a150-11ef-be02-004e01ffe201', 'member'),
('2abf78e6-a162-11ef-be02-004e01ffe201', NULL, '1731462834', NULL, 'm2', 'm2', '2abf78ff-a162-11ef-be02-004e01ffe201', 'member'),
('2ea4f5e5-8f8c-11ef-a5b9-004e01ffe201', NULL, '1729501754', NULL, 'yy', 'yy', '2ea4f5fa-8f8c-11ef-a5b9-004e01ffe201', 'member'),
('2f0b6ebb-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503048', NULL, 'noo', 'noo', '2f0b6ecb-8f8f-11ef-a5b9-004e01ffe201', 'member'),
('2f332681-a329-11ef-b782-004e01ffe201', NULL, '1731658261', NULL, 'hujan1', 'hujan12345', '2f33269c-a329-11ef-b782-004e01ffe201', 'member'),
('316ae160-a157-11ef-be02-004e01ffe201', NULL, '1731458124', NULL, 'member7', 'member7', '316ae195-a157-11ef-be02-004e01ffe201', 'member'),
('38065f55-9466-11ef-96fe-004e01ffe201', NULL, '1730035207', NULL, 'hey', 'hey', '38065f69-9466-11ef-96fe-004e01ffe201', 'member'),
('3cfe7084-8df5-11ef-9394-004e01ffe201', NULL, '1729326958', NULL, 'b', 'b', '3cfe70c0-8df5-11ef-9394-004e01ffe201', 'member'),
('3ed99b0b-a3e8-11ef-b782-004e01ffe201', NULL, '1731740302', NULL, 'kikiyama', 'kikiyama1', '3ed99b25-a3e8-11ef-b782-004e01ffe201', 'member'),
('3fc06360-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503504', NULL, 'e', 'e', '3fc06373-8f90-11ef-a5b9-004e01ffe201', 'member'),
('46b33586-a2a5-11ef-b782-004e01ffe201', NULL, '1731601591', NULL, 'jamal', 'jamal123', '46b335b9-a2a5-11ef-b782-004e01ffe201', 'member'),
('4b927727-9268-11ef-8788-004e01ffe201', NULL, '1729816197', NULL, 'u', 'u', '4b927736-9268-11ef-8788-004e01ffe201', 'member'),
('4dd8cffc-8f89-11ef-a5b9-004e01ffe201', NULL, '1729500525', NULL, 'a', 'a', '4dd8d00b-8f89-11ef-a5b9-004e01ffe201', 'member'),
('4f29c34b-a158-11ef-be02-004e01ffe201', NULL, '1731458565', NULL, 'registest', 'registest', '4f29c366-a158-11ef-be02-004e01ffe201', 'member'),
('54f7108e-8651-11ef-a918-3ca067e52da9', NULL, '1728486893', NULL, 'a', 'a', '54f7114d-8651-11ef-a918-3ca067e52da9', 'member'),
('56399260-a10b-11ef-be02-004e01ffe201', NULL, '1731425542', NULL, 'member1', 'member1', '56399287-a10b-11ef-be02-004e01ffe201', 'member'),
('5738dd77-a295-11ef-b782-004e01ffe201', NULL, '1731594745', NULL, 'alif', 'alifnajmi1', '5738dd90-a295-11ef-b782-004e01ffe201', 'member'),
('5e626f5f-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503562', NULL, 'h', 'h', '5e626f6e-8f90-11ef-a5b9-004e01ffe201', 'member'),
('5fbdd22b-a15c-11ef-be02-004e01ffe201', NULL, '1731460346', NULL, 'm2', 'm2', '5fbdd246-a15c-11ef-be02-004e01ffe201', 'member'),
('6aae584a-946a-11ef-96fe-004e01ffe201', NULL, '1730037014', NULL, 'k', 'k', '6aae585f-946a-11ef-96fe-004e01ffe201', 'member'),
('706a01db-a3e7-11ef-b782-004e01ffe201', NULL, '1731739934', NULL, 'fred', 'fred1234', '706a01fa-a3e7-11ef-b782-004e01ffe201', 'member'),
('7979b578-8560-11ef-b414-3ca067e52da9', NULL, '1728383471', NULL, 'c', 'c', '7979b628-8560-11ef-b414-3ca067e52da9', 'member'),
('79fe8f8e-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503605', NULL, 'mm', 'mm', '79fe8f9f-8f90-11ef-a5b9-004e01ffe201', 'member'),
('80203571-a288-11ef-b782-004e01ffe201', NULL, '1731589238', NULL, 'wow', 'wowwowwow1', '802035c8-a288-11ef-b782-004e01ffe201', 'member'),
('8623cdd9-a158-11ef-be02-004e01ffe201', NULL, '1731458693', NULL, 'member8', 'member8', '8623cdee-a158-11ef-be02-004e01ffe201', 'member'),
('87ad26bd-9ca5-11ef-a493-004e01ffe201', NULL, '1730942013', NULL, 'test', 'test', '87ad26e7-9ca5-11ef-a493-004e01ffe201', 'member'),
('87e545d2-a15d-11ef-be02-004e01ffe201', NULL, '1731460836', NULL, 'final1', 'final1', '87e545ed-a15d-11ef-be02-004e01ffe201', 'member'),
('8983b975-8dff-11ef-9394-004e01ffe201', NULL, '1729331377', NULL, 'c', 'c', '8983b988-8dff-11ef-9394-004e01ffe201', 'member'),
('8de03455-a295-11ef-b782-004e01ffe201', NULL, '1731594854', NULL, 'kamal', 'kamal123', '8de0346d-a295-11ef-b782-004e01ffe201', 'member'),
('9710727c-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503655', NULL, 'tt', 'tt', '9710728f-8f90-11ef-a5b9-004e01ffe201', 'member'),
('976721ba-9469-11ef-96fe-004e01ffe201', NULL, '1730036662', NULL, 'hey', 'hey', '976721ca-9469-11ef-96fe-004e01ffe201', 'member'),
('a0d77765-a294-11ef-b782-004e01ffe201', NULL, '1731594450', NULL, '', 'abubakar1', 'a0d77784-a294-11ef-b782-004e01ffe201', 'member'),
('a86fa420-a155-11ef-be02-004e01ffe201', NULL, '1731457462', NULL, 'member5', 'member5', 'a86fa440-a155-11ef-be02-004e01ffe201', 'member'),
('af9112e6-90ec-11ef-9771-004e01ffe201', NULL, '1729653160', NULL, 'a', 'a', 'af9112f6-90ec-11ef-9771-004e01ffe201', 'member'),
('bca05358-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, 'yeah', 'yeah', 'bca05374-998c-11ef-8372-004e01ffe201', 'member'),
('bd0c10a7-8d19-11ef-a94c-004e01ffe201', NULL, '1729232687', NULL, 'hello', 'hello', 'bd0c10d1-8d19-11ef-a94c-004e01ffe201', 'member'),
('c08b4665-8dff-11ef-9394-004e01ffe201', NULL, '1729331491', NULL, 'c', 'c', 'c08b467b-8dff-11ef-9394-004e01ffe201', 'member'),
('c1a68d18-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503254', NULL, 'aa', 'aa', 'c1a68d29-8f8f-11ef-a5b9-004e01ffe201', 'member'),
('d785919d-947a-11ef-96fe-004e01ffe201', NULL, '1730044070', NULL, 'y', 'y', 'd78591b1-947a-11ef-96fe-004e01ffe201', 'member'),
('da6e1e98-a290-11ef-b782-004e01ffe201', NULL, '1731592844', NULL, '', 'lapanlapan8', 'da6e1ed1-a290-11ef-b782-004e01ffe201', 'member'),
('dbc0aaed-a15c-11ef-be02-004e01ffe201', NULL, '1731460556', NULL, 'm2', 'm2', 'dbc0ab0e-a15c-11ef-be02-004e01ffe201', 'member'),
('dd2cca64-8562-11ef-b414-3ca067e52da9', NULL, '1728384510', NULL, 'a', 'a', 'dd2ccab9-8562-11ef-b414-3ca067e52da9', 'member'),
('df7bc9be-a326-11ef-b782-004e01ffe201', NULL, '1731657260', NULL, 'hujan', 'hujan123', 'df7bc9d7-a326-11ef-b782-004e01ffe201', 'member'),
('df9cd6b5-90ef-11ef-954f-004e01ffe201', NULL, '1729654531', NULL, 'a', 'a', 'df9cd6f1-90ef-11ef-954f-004e01ffe201', 'member'),
('e8238a14-9057-11ef-a5b9-004e01ffe201', NULL, '1729589256', NULL, 'hello', 'hello', 'e8238a2e-9057-11ef-a5b9-004e01ffe201', 'member'),
('ea1bb929-a35c-11ef-b782-004e01ffe201', NULL, '1731680283', NULL, 'amri_haikal45', 'amrikot12', 'ea1bb945-a35c-11ef-b782-004e01ffe201', 'member'),
('ebc8667a-a3e7-11ef-b782-004e01ffe201', NULL, '1731740147', NULL, 'kikiyama', 'kikiyama1', 'ebc86695-a3e7-11ef-b782-004e01ffe201', 'member'),
('f1e15d29-a327-11ef-b782-004e01ffe201', NULL, '1731657723', NULL, 'hujan', 'hujan123', 'f1e15d40-a327-11ef-b782-004e01ffe201', 'member'),
('f3bb99b5-a15c-11ef-be02-004e01ffe201', NULL, '1731460567', NULL, 'final', 'final', 'f3bb99ce-a15c-11ef-be02-004e01ffe201', 'member'),
('f7c8e1a8-a161-11ef-be02-004e01ffe201', NULL, '1731462741', NULL, 'm1', 'm1', 'f7c8e1c7-a161-11ef-be02-004e01ffe201', 'member'),
('ffb83aa5-a14d-11ef-be02-004e01ffe201', NULL, '1731454171', NULL, 'member2', 'member2', 'ffb83ac9-a14d-11ef-be02-004e01ffe201', 'member'),
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
  `amount` int DEFAULT '0',
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
('RCOIWL', '972417063', 'Mengaktifkan Pasukan', 'Ini adalah untuk mengaktifkan pasukan nombor 1', 'Event', '2024-12-20', '2024-12-25', 5, 'Lifetime', 100, 'yes'),
('VNWQGL', '32727319', 'Percubaan 1', 'Percubaan 1', 'Event', '2024-10-10', '2024-10-14', 4, 'Lifetime', 123, 'no'),
('VXZPMY', '451453399', 'Gambar 2', 'Gambar 22', 'Event', '2024-09-04', '2024-09-05', 8, 'Lifetime', 123, 'yes'),
('XTWIOL', '123', 'Karate Activities', 'This includes all karate activity plan', 'Core', '2024-11-09', '2024-11-28', 0, '', 20, 'yes');

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
('page_67383d2b9bea80.41427445', 'RCOIWL', 'Mengaktifkan Pasukan Nombor 1', 'Ini adalah untuk mengaktifkan pasukan nombor 1', 'Ini adalah untuk mengaktifkan pasukan nombor 1', 'engaktifkan-asukan-ombor-1', '2024-11-15 22:35:23', '2024-11-16 06:35:23', 1),
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
('972417063', 'RCOIWL', 'rashid', 'Mengaktifkan Pasukan Nombor 1', '0'),
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
('rashid', 'rashid', 'rashid', 'rashid', 'coach');

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
(2, 'Member 2', 'Black Belt', 'uploads/team_members/image_4.jpg', 2, 1, '2024-10-25 01:42:54', '2024-11-14 04:38:25', 1, NULL),
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
('day_672f3a71849ab0.66530509', '914393930', 2, NULL),
('day_67383d2b9bdcc0.11302545', '972417063', 6, NULL),
('day_67383d2b9bbd38.98129187', '972417063', 4, NULL),
('day_67383d2b9bcd37.99027383', '972417063', 5, NULL),
('day_67383d2b9bad84.17695059', '972417063', 3, NULL),
('day_67383d2b9b9c64.39819121', '972417063', 2, NULL),
('day_67383d2b9b6c97.75093135', '972417063', 1, NULL),
('abe8c2c1-a104-11ef-be02-004e01ffe201', '851246383', 2, ''),
('abe8b535-a104-11ef-be02-004e01ffe201', '851246383', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `imageid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fullName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `joining_date` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hasApproved` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `matrixNumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `courseName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_ic` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `pass_key`, `imageid`, `username`, `fullName`, `gender`, `mobile`, `email`, `dob`, `joining_date`, `hasApproved`, `matrixNumber`, `courseName`, `no_ic`) VALUES
('1729500896', 'o', 'UUID()', 'o', 'o', 'Male', '1', 'o@gmail.com', '2004-10-10', '2024-10-10', 'Yes', '', '', NULL),
('1730087557', 'hello', '1768cef2-94e0-11ef-96fe-004e01ffe201', 'hello', 'hello', 'M', '', 'hello@gmail.com', '', '', 'Yes', '', '', NULL),
('1730601491', 'yeah', 'bc9fc58b-998c-11ef-8372-004e01ffe201', 'yeah', 'yeah', 'M', '', 'yeah@gmail.com', '', '', 'Yes', '', '', NULL),
('1731580029', 'oneoneone1', 'UUID()', 'one', 'one', '', '', 'one@gmail.com', '', '', 'Yes', '', '', NULL),
('1731589238', 'wowwowwow1', 'UUID()', 'wow', 'wow', '', '', 'wow@gmail.com', '', '', 'No', '', '', NULL),
('1731594854', 'kamal123', '123', 'kamal', 'kamal juan', 'Male', '123123123123', '123123@gmail.com', '2000-06-23', '2022-02-22', 'No', '123123123123', 'Introduction to Com', '123123123123'),
('1731601591', 'jamal123', '46b229f4-a2a5-11ef-b782-004e01ffe201', 'jamal', 'jamal', 'Male', '123123123123', 'jamal@gmail.com', '2000-06-15', '2024-11-15', 'Yes', 'jamal1', 'Introduction to Computer Science', '123451231231'),
('1731657723', 'hujan123', NULL, 'hujan', 'hujan', 'Not spec', '123', 'hujan@gmail.com', 'Unknown', 'Not available', 'Yes', '123', 'Introduction to Computer Science', '123'),
('1731658261', 'hujan12345', NULL, 'hujan1', 'hujan1', 'Not spec', '12345', 'hujan@gmail.com', 'Unknown', 'Not available', 'Yes', 'hujan1', 'Introduction to Computer Science', '12345'),
('1731660995', 'holoholo1', NULL, 'holo', 'holo', NULL, 'holo', NULL, NULL, NULL, 'Yes', 'holo', 'Introduction to Computer Science', 'holo'),
('1731680283', 'amrikot12', NULL, 'amri_haikal45', 'Muhammad Amri', 'Male', '0197782351', 'Amri@gmail.com', '2001-02-01', '2024-05-10', 'Yes', 'AF221WD110KYM', 'Diploma in Entrepreneurship', '010619080082'),
('1731740302', 'kikiyama1', '3ed8cae7-a3e8-11ef-b782-004e01ffe201', 'kikiyama', 'kikiyama', 'Male', '0192531583', 'kikiyama@gmail.com', '2003-06-16', '2024-11-16', 'No', 'AF201WD012KYM', 'Diploma in Entrepreneurship', '010214020512');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_about_content`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_about_content`;
CREATE TABLE IF NOT EXISTS `v_about_content` (
`content_id` int
,`content_text` text
,`image_path` varchar(255)
,`last_updated` timestamp
,`section_name` varchar(50)
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
