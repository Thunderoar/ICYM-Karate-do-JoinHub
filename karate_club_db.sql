-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2024 at 03:28 AM
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
,`planName` text
,`description` text
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
  `addressid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
('162277213', NULL, NULL, '1732111763', 'Street12', 'Melaka', 'Alor Gajah', '12345'),
('167623346', NULL, NULL, '1731658261', '', '', '', ''),
('178160492', NULL, NULL, '1729503048', '', '', '', ''),
('190560546', NULL, NULL, '1732368681', '', '', '', ''),
('193052981', NULL, NULL, '1731594854', 'test', 'test', 'test', '12345'),
('193643527', NULL, NULL, '1731806292', '', '', '', ''),
('233879111', NULL, NULL, '1729503254', '', '', '', ''),
('238769188', NULL, NULL, '1731460567', '', '', '', ''),
('240973158', NULL, NULL, '1731594745', '', '', '', ''),
('244071432', NULL, NULL, '1730037014', '', '', '', ''),
('259825696', NULL, NULL, '1730044070', '', '', '', ''),
('260450272', NULL, NULL, '1731458124', NULL, NULL, NULL, NULL),
('263868116', NULL, NULL, '1731462834', '', '', '', ''),
('279263050', NULL, NULL, '1732368303', '', '', '', ''),
('28643920', NULL, NULL, '1731458693', NULL, NULL, NULL, NULL),
('308334204', NULL, NULL, '1731589238', '', '', '', ''),
('312961590', NULL, NULL, '1732109890', 'melaka', 'melaka', 'melaka', '12345'),
('370773697', NULL, NULL, '1731657723', '', '', '', ''),
('398226207', NULL, NULL, '1729503605', '', '', '', ''),
('407163359', NULL, NULL, '1732368801', '', '', '', ''),
('409725909', NULL, NULL, '1732368878', '', '', '', ''),
('424131070', NULL, NULL, '1732281817', '', '', '', ''),
('439216695', NULL, NULL, '1731425542', '', '', '', ''),
('443957638', NULL, NULL, '1729499689', '', '', '', ''),
('445117942', NULL, NULL, '1729500525', '', '', '', ''),
('474709767', NULL, NULL, '1729653160', '', '', '', ''),
('47774667', NULL, NULL, '1732368048', '', '', '', ''),
('479403470', NULL, NULL, '1732368557', '', '', '', ''),
('501251484', NULL, NULL, '1732367951', '', '', '', ''),
('524762761', NULL, NULL, '1731594450', '', '', '', ''),
('529074327', NULL, NULL, '1732368433', '', '', '', ''),
('541188054', NULL, NULL, '1729503562', '', '', '', ''),
('560851705', NULL, NULL, '1731462741', '', '', '', ''),
('564043783', NULL, NULL, '1732368212', '', '', '', ''),
('570836098', NULL, NULL, '1731580029', 'yeah', 'yeah', 'yeah', 'yeah'),
('581038254', NULL, NULL, '1731601591', 'jamalstreet', 'jamal state', 'jamal city', '12345'),
('58587039', NULL, NULL, '1731680283', 'amristreet', 'amristate', 'amricity', '12345'),
('603347436', NULL, NULL, '1730942013', '', '', '', ''),
('612212550', NULL, NULL, '1731454171', '', '', '', ''),
('620564592', NULL, NULL, '1732282137', '', '', '', ''),
('633100712', NULL, NULL, '1731592844', '', '', '', ''),
('651796491', NULL, NULL, '1729501754', '', '', '', ''),
('664647014', NULL, NULL, '1730036662', '', '', '', ''),
('672538767', NULL, NULL, '1729500022', '', '', '', ''),
('673939126', NULL, NULL, '1732066288', 'Rohani Street', 'Rohani State', 'Rohani City', '12345'),
('693786055', NULL, NULL, '1732367770', '', '', '', ''),
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
('982014755', NULL, NULL, '1730087557', '12312', '12312', '12312', '12312'),
('99440050', NULL, NULL, '1731460836', '', '', '', ''),
('995837925', NULL, NULL, '1729502959', '', '', '', ''),
('A143809511', NULL, NULL, '1732066169', 'Rohani Street', 'SABAH', 'Rohani City', '12345'),
('A294408664', NULL, NULL, '1732367313', '456 Oak Avenue', 'Kuala Lumpur', 'Cheras', '56000'),
('A341286692', NULL, NULL, '1732368926', 'kampung baru', 'wilayah persekutuan kuala lumpur', 'kuala lumpur', '53300'),
('A396303433', NULL, NULL, '1732366824', '654 Cedar Court', 'Selangor', 'Shah Alam', '40150'),
('A439464398', NULL, NULL, '1732368176', 'desa rejang', 'wilayah persekutuan kuala lumpur', 'kuala lumpur', '53300'),
('A443308974', NULL, NULL, '1732368421', 'cheras', 'selangor', 'selangor', '48300'),
('A477379557', NULL, NULL, '1732065939', 'Rohani Street', 'SABAH', 'Rohani City', '12345'),
('A494406122', NULL, NULL, '1732367022', '321 Pine Lane', 'Johor', 'Johor Bahru', '80100'),
('A506426250', NULL, NULL, '1732368793', 'bukit beruang', 'melaka', 'melaka', '75000'),
('A533505335', NULL, NULL, '1732368660', 'pekan seberang', 'pahang', 'jerantut', '25000'),
('A614174712', NULL, NULL, '1732366527', '123 Palm Street', 'Selangor', 'Petaling Jaya', '47301'),
('A678417673', NULL, NULL, '1732369063', 'taman melawati', 'wilayah persekutuan kuala lumpur', 'kuala lumpur', '53300'),
('A704574240', NULL, NULL, '1732369150', 'bukit ara', 'kuala terengganu', 'terengganu', '20000'),
('A745670986', NULL, NULL, '1732367978', 'haji taib', 'pulau pinang', 'pulau pinang ', '10000'),
('A761042317', NULL, NULL, '1732367210', '789 Maple Road', 'Penang', 'Georgetown', '11600'),
('A764502459', NULL, NULL, '1732368304', 'wangsa maju', 'wilayah persekutuan kuala lumpur', 'kuala lumpur', '53300'),
('addr_6735cf83db4a3', NULL, NULL, '1730601491', 'yeah', 'yeah', 'yeah', '12345'),
('addr_673a2ad699997', NULL, NULL, '1731838081', 'kurastreet', 'kurastate', 'kuracity', '12345');

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
(1, 'Kolej Antarabangsa Yayasan Melaka, No 1, Jalan Bukit Sebukor', '(+60) 18-271 621', ''),
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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `fullname`, `email`, `subject`, `message`, `created_at`, `read_status`, `archive_status`) VALUES
(38, 'Greta', 'greta@gmail.com', 'The gallery looks great', 'It looks like this karate club will be fun to join in!', '2024-11-23 13:51:56', NULL, 0),
(3, 'Azlan', 'azlan@gmail.com', 'saya berminat untuk memasuki kelab karate ini', 'dari dahulu sy suka menendang, sy ingin mengasah bakat menendang sy dengan lebih mantap, dengan itu sy ingin di register masuk', '2024-11-14 00:33:12', '1', 1),
(37, 'Ju An', 'ju-an@gmail.com', 'I&#039;d like to ask for a permission to be included into an event', 'Hello! i would like to know is the event Bushido still available? Thanks!', '2024-11-23 13:51:01', NULL, 0),
(33, 'contacttest@gmail.com', 'contacttest@gmail.com', 'contacttest', 'contacttest', '2024-11-15 16:51:30', NULL, 0),
(36, 'Trix', 'trix@gmail.com', 'kemasukan ke kelab karate', 'saya hendak masuk ke kelab karate ini, ianya nampak menarik', '2024-11-23 13:49:54', NULL, 0),
(35, 'han hakim', 'hakim@gmail.com', 'contact', 'hi', '2024-11-20 13:51:03', '1', 0),
(34, 'hello!', 'hello!@gmail.com', 'hello!', 'hello!', '2024-11-19 11:22:57', NULL, 0);

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
-- Table structure for table `disapproval_reasons`
--

DROP TABLE IF EXISTS `disapproval_reasons`;
CREATE TABLE IF NOT EXISTS `disapproval_reasons` (
  `reason_id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `adminid` int NOT NULL,
  `reason` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reason_id`),
  KEY `userid` (`userid`),
  KEY `adminid` (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disapproval_reasons`
--

INSERT INTO `disapproval_reasons` (`reason_id`, `userid`, `adminid`, `reason`, `created_at`) VALUES
(1, 1732066288, 0, 'displinary action', '2024-11-20 10:33:42'),
(2, 1732066288, 0, 'disciplinary action', '2024-11-20 10:34:25'),
(3, 1732066288, 0, 'late', '2024-11-20 10:50:24'),
(4, 1732066288, 0, 'late', '2024-11-20 10:58:22'),
(5, 1732066288, 0, 'late', '2024-11-20 10:59:04');

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
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolls_to`
--

INSERT INTO `enrolls_to` (`et_id`, `planid`, `userid`, `paid_date`, `expire`, `hasPaid`, `hasApproved`, `receiptIMG`) VALUES
(141, 'XTWIOL', '1730087557', '2024-11-11 18:54:07', '9999-12-31', 'yes', 'yes', NULL),
(255, 'FCEDGV', '1731838081', '2024-11-18 08:03:57', '9999-12-31', 'yes', 'yes', ''),
(271, 'LSATQE', '1731601591', '2024-11-18 09:19:28', '9999-12-31', 'yes', 'yes', ''),
(276, 'XTWIOL', '1732063404', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(277, 'XTWIOL', '1732064459', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(278, 'XTWIOL', '1732064672', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(279, 'XTWIOL', '1732065126', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(280, 'XTWIOL', '1732065284', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(281, 'XTWIOL', '1732065364', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(282, 'XTWIOL', '1732065557', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(283, 'XTWIOL', '1732065688', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(284, 'XTWIOL', '1732065939', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(285, 'XTWIOL', '1732066169', '2024-11-20', '1970-01-01', 'no', NULL, NULL),
(286, 'XTWIOL', '1732066288', NULL, NULL, 'yes', 'no', '../../dashboard/admin/uploads/payment/image_11.jpg'),
(287, 'KRT002', '1731601591', NULL, '2024-12-20 21:15:31', 'no', 'no', NULL),
(288, 'XTWIOL', '1732109890', NULL, NULL, 'no', 'no', '../../dashboard/admin/uploads/payment/event_1.jpg'),
(289, 'KRT002', '1732109890', '2024-11-20 22:26:30', '9999-12-31', 'yes', 'no', '../../dashboard/admin/uploads/payment/karate_main.jpg'),
(293, 'XTWIOL', '1732111763', '2024-11-20 22:16:14', '9999-12-31', 'yes', 'yes', ''),
(294, 'KRT002', '1732111763', '2024-11-20 22:19:50', '9999-12-31', 'no', 'no', ''),
(295, 'KRT004', '1732111763', '2024-11-20 22:25:55', '9999-12-31', 'yes', 'no', ''),
(296, 'XTWIOL', '1732281817', '2024-11-22', '1970-01-01', 'no', NULL, NULL),
(297, 'XTWIOL', '1732282137', '2024-11-22', '1970-01-01', 'no', NULL, NULL),
(298, 'XTWIOL', '1732366527', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(299, 'XTWIOL', '1732366824', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(300, 'XTWIOL', '1732367022', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(301, 'XTWIOL', '1732367210', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(302, 'XTWIOL', '1732367313', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(303, 'XTWIOL', '1732367770', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(304, 'XTWIOL', '1732367951', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(305, 'YVFGZL', '1732367978', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(306, 'XTWIOL', '1732368048', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(307, 'XTWIOL', '1732368212', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(308, 'YVFGZL', '1732368176', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(309, 'XTWIOL', '1732368304', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(310, 'XTWIOL', '1732368303', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(311, 'XTWIOL', '1732368433', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(312, 'XTWIOL', '1732368421', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(313, 'XTWIOL', '1732368557', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(314, 'JWAZQG', '1732368660', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(315, 'XTWIOL', '1732368681', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(316, 'XTWIOL', '1732368801', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(317, 'IPZCOV', '1732368793', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(318, 'XTWIOL', '1732368878', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(319, 'CXFDIA', '1732368926', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(320, 'IPZCOV', '1732369063', '2024-11-23', '1970-01-01', 'no', NULL, NULL),
(321, 'UYCZEB', '1732369150', '2024-11-23', '1970-01-01', 'no', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_members`
--

INSERT INTO `event_members` (`em_id`, `planid`, `userid`, `joined_at`) VALUES
(128, 'XTWIOL', 1732111763, '2024-11-20 14:16:14'),
(125, 'LSATQE', 1731601591, '2024-11-18 01:34:33'),
(124, 'LSATQE', 1731838081, '2024-11-18 01:34:28');

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
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_staff`
--

INSERT INTO `event_staff` (`es_id`, `planid`, `staffid`, `joined_at`) VALUES
(41, 'VXZPMY', 'rashid', '2024-11-18 00:04:48'),
(16, 'ZHXPSA', 'rashid', '2024-11-12 15:13:32'),
(76, 'DORFVC', 'cik_umaiyyah', '2024-11-20 14:28:55'),
(26, '60647328', 'rashid', '2024-11-17 17:08:40'),
(27, '15505317', 'rashid', '2024-11-17 17:10:28'),
(28, 'JFBROC', 'rashid', '2024-11-17 17:12:39'),
(39, 'XTWIOL', 'rashid', '2024-11-18 00:03:36'),
(35, 'FCEDGV', 'cik_umaiyyah', '2024-11-17 17:56:09'),
(68, 'XTWIOL', 'sensei_tamil', '2024-11-18 01:02:13'),
(58, 'OEHFJY', 'rashid', '2024-11-18 00:33:32'),
(66, 'GRWTPO', 'sensei_tamil', '2024-11-18 00:40:06'),
(59, 'OEHFJY', 'rashid', '2024-11-18 00:33:40'),
(63, 'GRWTPO', 'cik_umaiyyah', '2024-11-18 00:36:15'),
(64, 'GRWTPO', 'rashid', '2024-11-18 00:37:44'),
(69, 'LSATQE', 'cik_umaiyyah', '2024-11-18 01:14:49'),
(70, 'AFKJVD', 'rashid', '2024-11-18 01:42:13'),
(71, 'XFSVQU', 'rashid', '2024-11-19 12:12:14'),
(72, 'VCEDXZ', 'rashid', '2024-11-19 12:13:42'),
(73, 'YVFGZL', 'rashid', '2024-11-19 12:15:20'),
(75, 'KRT002', 'cik_umaiyyah', '2024-11-20 14:00:41'),
(77, 'LUDYAW', 'cik_umaiyyah', '2024-11-20 14:29:51'),
(78, 'JWAZQG', 'rashid', '2024-11-23 13:27:59'),
(79, 'TKMSVH', 'cik_umaiyyah', '2024-11-23 13:31:08'),
(80, 'IPZCOV', 'cik_umaiyyah', '2024-11-23 13:33:03'),
(81, 'UYCZEB', 'cik_umaiyyah', '2024-11-23 13:34:02'),
(82, 'CXFDIA', 'cik_umaiyyah', '2024-11-23 13:34:52'),
(83, 'VGIBNU', 'cik_umaiyyah', '2024-11-23 13:46:44'),
(84, 'PMXDVJ', 'rashid', '2024-11-23 13:48:46');

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
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(107, 12, 'uploads/photo_6260367884706496346_y.jpg', '2024-11-14 15:54:51'),
(108, 15, 'uploads/image_8.jpg', '2024-11-20 14:37:37');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_sections`
--

INSERT INTO `gallery_sections` (`section_id`, `section_name`, `section_description`, `created_at`, `planid`) VALUES
(10, 'Booth Exhibition & Demonstration for New Intake', 'The Booth Exhibition at ICYM Foyer showcased our club\'s achievements, displaying medals and awards that reflect our members\' dedication. Visitors were treated to live demonstrations, including Kata 1, Kata 2, and board-breaking, capturing the intensity and skill of martial arts. Refreshments and popsicles were sold to generate funds for the club, creating a lively and engaging experience for all who attended.', '2024-11-14 15:02:26', 0),
(11, 'Demonstration at Children Carnival Taman Limbongan Permai, Melaka', 'At the Children’s Carnival in Taman Limbongan Permai, Melaka, our club delivered an engaging demonstration aimed at introducing karate to young audiences and showcasing the art\'s beauty to visitors. The event featured a fast-response demonstration, along with Kata 1 and Kata 2, highlighting the precision, discipline, and agility that define karate. The performance inspired many, drawing attention to the importance of starting martial arts training at a young age.', '2024-11-14 15:07:53', 0),
(12, '1st Ever Grand Group Training Malaysia Open 2023', 'The 1st Ever Grand Group Training at Malaysia Open 2023 brought together karatekas from across the country for an inspiring session led by top professional karate instructors. This historic event, officially listed in the Malaysian Book of Records, aimed to motivate participants to expand their skills and master new techniques. The atmosphere was electric, as karatekas trained side by side, absorbing fresh movements and refining their craft under expert guidance.', '2024-11-14 15:16:03', 0),
(13, 'ICYM Students and Alumni Dinner 2024', 'The ICYM Students and Alumni Dinner 2024 was a special event dedicated to reintroducing our club after a period of inactivity due to COVID-19. Designed to attract both staff and students, the evening aimed to renew interest in joining our community. A captivating karate performance added a unique flair to the dinner, showcasing the club’s spirit and talent as we look forward to a new chapter together.', '2024-11-14 15:20:15', 0),
(14, 'Throwback of Our Alumni', 'Our alumni played an integral role in shaping the club and its legacy. As part of the team, they embraced the discipline and dedication required to train and perfect the beauty of karate. Their journey reflects the values we uphold: hard work, perseverance, and respect. We celebrate their contributions and the lasting impact they’ve had on the club, inspiring the next generation of karatekas.', '2024-11-14 15:23:14', 0),
(15, 'gallery 2', 'gellery 2', '2024-11-20 14:37:25', 0);

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
('102844612', 1, NULL, NULL, '', '1732368303', 1),
('110137701', 1, NULL, NULL, '', '1731806292', 1),
('127361533', NULL, '', '', '', '1730037014', 0),
('148880091', 1, NULL, NULL, '', '1732282137', 1),
('15697384', NULL, '', '', '', '1729502982', 0),
('159244038', NULL, '', '', '', '1729326958', 0),
('161958492', NULL, '', '', '', '1729232687', 0),
('163317348', 1, '160', '50', '', '1732109890', 1),
('17580962', NULL, '', '', '', '1728485531', 0),
('176600284', 1, NULL, NULL, '', '1732368048', 1),
('18192879', NULL, '160', '46', 'remark test', '1731594854', 0),
('194967109', NULL, NULL, NULL, '', '1731459785', 0),
('198765922', NULL, '', '', '', '1729499988', 0),
('204334593', NULL, '', '', '', '1729589256', 0),
('205571730', NULL, '', '', '', '1729503562', 0),
('206420275', NULL, '', '', '', '1729816197', 0),
('235920854', NULL, NULL, NULL, '', '1731460567', 0),
('277790349', NULL, '', '', '', '1729499001', 0),
('297159777', NULL, '', '', '', '1729500022', 0),
('305966793', 1, NULL, NULL, '', '1732368433', 1),
('306970881', 1, NULL, NULL, '', '1732367951', 1),
('316322884', NULL, '0', '0', '', '1731457659', 0),
('319821461', NULL, '', '', '', '1729331377', 0),
('320368413', 0, 'Not meas', 'Not meas', '', '1731657723', 0),
('338833368', NULL, '', '', '', '1729653160', 0),
('340255930', 1, NULL, NULL, '', '1732368878', 1),
('353479103', 1, '', '', '', '1730087557', 1),
('361339141', NULL, '', '', '', '1729503655', 0),
('376218640', 1, NULL, NULL, '', '1732368681', 1),
('377819181', NULL, '', '', '', '1729503048', 0),
('38316833', 1, NULL, NULL, '', '1732368212', 1),
('387732098', NULL, '', '', '', '1730035207', 0),
('388848522', NULL, '', '', '', '1729500806', 0),
('38888806', NULL, '', '', '', '1728384510', 0),
('394786288', NULL, '160', '53', '', '1731680283', NULL),
('398395806', NULL, '', '', '', '1729499109', 0),
('400263278', NULL, '', '', '', '1729506355', 0),
('404242844', NULL, NULL, NULL, '', '1731460346', 0),
('409696460', NULL, '', '', '', '1729654531', 0),
('42304840', NULL, NULL, NULL, '', '1731460556', 0),
('45421949', NULL, NULL, NULL, '', '1732064672', NULL),
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
('702491918', 1, '160', '50', '', '1732066288', 1),
('720563994', NULL, NULL, NULL, '', '1731460836', 0),
('733467291', 1, '180', '67', '', '1731740302', 1),
('755755046', NULL, NULL, NULL, '', '1731739934', NULL),
('764863192', 1, '189', '63', '', '1732111763', 1),
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
('872391091', 1, NULL, NULL, '', '1732368801', 1),
('874529438', NULL, '', '', '', '1729331491', 0),
('88203510', NULL, '', '', '', '1729500525', 0),
('888221077', NULL, NULL, NULL, '', '1732064459', NULL),
('89777473', 1, NULL, NULL, '', '1732368557', 1),
('918803354', NULL, '', '', '', '1730044070', 0),
('934571436', 1, NULL, NULL, '', '1732367770', 1),
('953569586', NULL, NULL, NULL, '', '1731454171', 0),
('955419055', 1, '', '', '', '1729500896', 1),
('955864959', 1, NULL, NULL, '', '1732281817', 1),
('95897886', NULL, '', '', '', '1729501754', 0),
('dd8ecb5d-a6dc-11ef-8920-004e01ffe201', NULL, NULL, NULL, '', '1732065284', NULL),
('H16113500', NULL, NULL, NULL, '', '1732368660', NULL),
('H17092509', NULL, NULL, NULL, '', '1732065364', NULL),
('H20738467', NULL, NULL, NULL, '', '1732368304', NULL),
('H251748846', NULL, NULL, NULL, '', '1732367313', NULL),
('H253919192', NULL, NULL, NULL, '', '1732369063', NULL),
('H27007932', NULL, NULL, NULL, '', '1732368926', NULL),
('H272573910', NULL, NULL, NULL, '', '1732368176', NULL),
('H315713217', NULL, NULL, NULL, '', '1732369150', NULL),
('H345260396', NULL, NULL, NULL, '', '1732367978', NULL),
('H350814094', NULL, NULL, NULL, '', '1732065688', NULL),
('H352470112', NULL, NULL, NULL, '', '1732368793', NULL),
('H443563110', NULL, NULL, NULL, '', '1732367022', NULL),
('H546280139', NULL, NULL, NULL, '', '1732366824', NULL),
('H72043897', NULL, NULL, NULL, '', '1732065557', NULL),
('H77112870', NULL, NULL, NULL, '', '1732065126', NULL),
('H777572520', 1, '', '', '', '1732366527', 1),
('H784253980', NULL, NULL, NULL, '', '1732066169', NULL),
('H794055556', NULL, NULL, NULL, '', '1732367210', NULL),
('H818337174', NULL, NULL, NULL, '', '1732368421', NULL),
('H821153610', NULL, NULL, NULL, '', '1732065939', NULL),
('health_6735cf83db4a6', 1, '', '', 'testing', '1730601491', 1),
('health_673a2ad699c75', 0, '160', '55', '', '1731838081', 0);

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
('03063dd3-a6db-11ef-8920-004e01ffe201', NULL, '1732064459', NULL, NULL, 'uploads/user_profile/person_1.jpg', '2024-11-20 01:01:45'),
('04d46f48-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729502982', NULL, NULL, NULL, '2024-10-21 09:29:49'),
('078b48be-a4d0-11ef-ae1d-004e01ffe201', NULL, '1731838081', NULL, NULL, 'uploads/image_3.jpg', '2024-11-17 10:38:05'),
('07a2b88e-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732368926', NULL, NULL, NULL, '2024-11-23 13:37:05'),
('0b4ccac1-a99e-11ef-b8f5-004e01ffe201', NULL, '1732367978', NULL, NULL, NULL, '2024-11-23 13:22:53'),
('0c6de9dd-a6dd-11ef-8920-004e01ffe201', NULL, '1732065364', NULL, NULL, NULL, '2024-11-20 01:16:19'),
('0d6d5679-a15b-11ef-be02-004e01ffe201', NULL, '1731459785', NULL, NULL, NULL, '2024-11-13 01:03:11'),
('0da40578-a273-11ef-a033-004e01ffe201', NULL, '1731580029', NULL, NULL, 'uploads/logo1.png', '2024-11-14 10:27:30'),
('0e4099df-a505-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'QEGIRY', 'uploads/673a208468dab_event_1.jpg', '2024-11-17 16:57:40'),
('1215d1ae-a6d9-11ef-8920-004e01ffe201', NULL, '1732063404', NULL, NULL, 'uploads/user_profile/event_1.jpg', '2024-11-20 00:47:51'),
('16e092c9-9689-11ef-aaee-004e01ffe201', NULL, NULL, NULL, 'KYDZOV', 'uploads/6721d39503ce1_event_1.jpg', '2024-10-30 06:35:01'),
('1769271a-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, NULL, NULL, '2024-10-28 03:52:45'),
('1b3f7594-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368421', NULL, NULL, NULL, '2024-11-23 13:30:29'),
('1b713689-a2a5-11ef-b782-004e01ffe201', NULL, '1731601530', NULL, NULL, NULL, '2024-11-14 16:25:48'),
('1cd5fd45-9e86-11ef-b592-004e01ffe201', NULL, NULL, NULL, 'ZHXPSA', 'uploads/672f3a8fcc171_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-09 10:33:51'),
('1e056ed2-a156-11ef-be02-004e01ffe201', NULL, '1731457659', NULL, NULL, NULL, '2024-11-13 00:27:51'),
('1f44babb-94d2-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'UGZVJQ', 'uploads/image_2_671ef31e09eec.jpg', '2024-10-28 02:12:46'),
('20af0194-9754-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WDCFUK', 'uploads/672328394cfbc_karate_main.jpg', '2024-10-31 06:48:25'),
('2147483647', NULL, '1729500022', NULL, NULL, NULL, '2024-10-21 08:41:08'),
('21b8ec50-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368048', NULL, NULL, NULL, '2024-11-23 13:23:30'),
('260eb423-a507-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'JFBROC', 'uploads/673a240758719_image_8.jpg', '2024-11-17 17:12:39'),
('262d799d-8f8a-11ef-a5b9-004e01ffe201', NULL, '1729500896', NULL, NULL, NULL, '2024-10-21 08:54:57'),
('2aa3cf84-a150-11ef-be02-004e01ffe201', NULL, '1731455101', NULL, NULL, NULL, '2024-11-12 23:45:15'),
('2abf9125-a162-11ef-be02-004e01ffe201', NULL, '1731462834', NULL, NULL, NULL, '2024-11-13 01:54:06'),
('2e125604-a6df-11ef-8920-004e01ffe201', NULL, '1732066288', NULL, NULL, 'uploads/person_2.jpg', '2024-11-20 01:31:35'),
('2ea50c7f-8f8c-11ef-a5b9-004e01ffe201', NULL, '1729501754', NULL, NULL, NULL, '2024-10-21 09:09:31'),
('2f0b7fa6-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503048', NULL, NULL, NULL, '2024-10-21 09:31:00'),
('2f32718b-a329-11ef-b782-004e01ffe201', NULL, '1731658261', NULL, NULL, NULL, '2024-11-15 08:11:15'),
('3', NULL, '1729326958', NULL, NULL, NULL, '2024-10-19 08:36:30'),
('311fa78d-975e-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'KTQNRL', 'uploads/6723391bd3126_karate_main.jpg', '2024-10-31 08:00:27'),
('316b02ef-a157-11ef-be02-004e01ffe201', NULL, '1731458124', NULL, NULL, NULL, '2024-11-13 00:35:33'),
('38067411-9466-11ef-96fe-004e01ffe201', NULL, '1730035207', NULL, NULL, NULL, '2024-10-27 13:20:21'),
('38ea11d1-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368557', NULL, NULL, NULL, '2024-11-23 13:31:19'),
('3973d24c-a8d6-11ef-b8f5-004e01ffe201', NULL, '1732282137', NULL, NULL, NULL, '2024-11-22 13:32:31'),
('3e55272e-a749-11ef-8920-004e01ffe201', NULL, '1732111763', NULL, NULL, NULL, '2024-11-20 14:10:49'),
('3ed8cae7-a3e8-11ef-b782-004e01ffe201', NULL, '1731740302', NULL, NULL, 'uploads/529239-lily-pad-wallpaper-1920x1280-macbook.jpg', '2024-11-16 06:58:55'),
('3fc07e44-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503504', NULL, NULL, NULL, '2024-10-21 09:38:37'),
('4', NULL, '1729500525', NULL, NULL, NULL, '2024-10-21 08:48:55'),
('450e8fa5-a99c-11ef-b8f5-004e01ffe201', NULL, '1732367313', NULL, NULL, NULL, '2024-11-23 13:10:11'),
('46b229f4-a2a5-11ef-b782-004e01ffe201', NULL, '1731601591', NULL, NULL, 'uploads/logo1.png', '2024-11-14 16:27:01'),
('4a6be0aa-a99b-11ef-b8f5-004e01ffe201', NULL, '1732366824', NULL, NULL, NULL, '2024-11-23 13:03:10'),
('4b9288ef-9268-11ef-8788-004e01ffe201', NULL, '1729816197', NULL, NULL, NULL, '2024-10-25 00:30:11'),
('4f1dc305-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732369063', NULL, NULL, NULL, '2024-11-23 13:39:05'),
('4f29ea2f-a158-11ef-be02-004e01ffe201', NULL, '1731458565', NULL, NULL, NULL, '2024-11-13 00:43:32'),
('5', NULL, '1729499689', NULL, NULL, NULL, '2024-10-21 08:35:06'),
('515', NULL, '1729499673', NULL, NULL, NULL, '2024-10-21 08:34:41'),
('54a9f345-9bce-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'EHBPVK', 'uploads/672aab3bbd821_image_2.jpg', '2024-11-05 23:33:15'),
('5579d953-a54e-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'AFKJVD', 'uploads/673a9b752d341_karate_main.jpg', '2024-11-18 01:42:13'),
('5639b75c-a10b-11ef-be02-004e01ffe201', NULL, '1731425542', NULL, NULL, NULL, '2024-11-12 15:32:33'),
('57379856-a295-11ef-b782-004e01ffe201', NULL, '1731594745', NULL, NULL, NULL, '2024-11-14 14:32:56'),
('5779cec0-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368212', NULL, NULL, NULL, '2024-11-23 13:25:00'),
('584580fb-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368176', NULL, NULL, NULL, '2024-11-23 13:25:02'),
('591e262b-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'CDZJSY', 'uploads/672ada3d264a8_event_1.jpg', '2024-11-06 02:53:49'),
('5e628491-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503562', NULL, NULL, NULL, '2024-10-21 09:39:29'),
('5fbdf482-a15c-11ef-be02-004e01ffe201', NULL, '1731460346', NULL, NULL, NULL, '2024-11-13 01:12:38'),
('611fb9ee-9bcd-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'DGEQBM', 'uploads/plans/plan_672aa9a32ccf28.10183593.jpg', '2024-11-05 15:26:27'),
('638b9f64-a6de-11ef-8920-004e01ffe201', NULL, '1732065939', NULL, NULL, NULL, '2024-11-20 01:25:55'),
('669a00ac-a290-11ef-b782-004e01ffe201', NULL, '', NULL, NULL, NULL, '2024-11-14 13:57:35'),
('6aae6da4-946a-11ef-96fe-004e01ffe201', NULL, '1730037014', NULL, NULL, NULL, '2024-10-27 13:50:24'),
('7068c242-a3e7-11ef-b782-004e01ffe201', NULL, '1731739934', NULL, NULL, NULL, '2024-11-16 06:53:09'),
('70c1601e-a294-11ef-b782-004e01ffe201', NULL, '1731594366', NULL, NULL, NULL, '2024-11-14 14:26:30'),
('78ed02cc-a6db-11ef-8920-004e01ffe201', NULL, '1732064672', NULL, NULL, 'uploads/user_profile/hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-20 01:05:02'),
('79fe9b2e-8f90-11ef-a5b9-004e01ffe201', NULL, '1729503605', NULL, NULL, NULL, '2024-10-21 09:40:15'),
('7acf25b0-9bec-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'LOXGHP', 'uploads/672addd0a4e38_event_1.jpg', '2024-11-06 03:09:04'),
('7bb50221-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368660', NULL, NULL, NULL, '2024-11-23 13:33:11'),
('8', NULL, NULL, NULL, 'TGJIOA', 'uploads/image_2.jpg', '2024-10-18 06:23:57'),
('802064a9-a288-11ef-b782-004e01ffe201', NULL, '1731589238', NULL, NULL, NULL, '2024-11-14 13:01:02'),
('8040b77b-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368681', NULL, NULL, NULL, '2024-11-23 13:33:18'),
('80efee94-a6dd-11ef-8920-004e01ffe201', NULL, '1732065557', NULL, NULL, NULL, '2024-11-20 01:19:35'),
('824bc5d3-a6dc-11ef-8920-004e01ffe201', NULL, '1732065126', NULL, NULL, NULL, '2024-11-20 01:12:28'),
('833d5e9c-a66f-11ef-8920-004e01ffe201', NULL, NULL, NULL, 'XFSVQU', 'uploads/673c809e7c6da_karate_main.jpg', '2024-11-19 12:12:14'),
('847c7d48-a99d-11ef-b8f5-004e01ffe201', NULL, '1732367770', NULL, NULL, NULL, '2024-11-23 13:19:06'),
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
('97d2a5d9-a506-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'NABOIX', 'uploads/673a2318b2c36_karate_main.jpg', '2024-11-17 17:08:40'),
('98ea3aa6-9be9-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'UGZKDM', 'uploads/672ad8faa97ef_hero_1729843905_aaf684e335f14f2b.jpg', '2024-11-06 02:48:26'),
('9b9d033a-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732369150', NULL, NULL, NULL, '2024-11-23 13:41:14'),
('9e577952-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368304', NULL, NULL, NULL, '2024-11-23 13:26:59'),
('a0d5f526-a294-11ef-b782-004e01ffe201', NULL, '1731594450', NULL, NULL, NULL, '2024-11-14 14:27:50'),
('a0f12b11-9bcf-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'TQSFLR', 'uploads/672aad693c338_image_2.jpg', '2024-11-05 23:42:33'),
('a4bb458a-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368303', NULL, NULL, NULL, '2024-11-23 13:27:10'),
('a608b405-a32f-11ef-b782-004e01ffe201', NULL, '1731660995', NULL, NULL, NULL, '2024-11-15 08:57:31'),
('a86fba5f-a155-11ef-be02-004e01ffe201', NULL, '1731457462', NULL, NULL, NULL, '2024-11-13 00:24:34'),
('abeca888-a745-11ef-8920-004e01ffe201', NULL, '1732109890', NULL, NULL, 'uploads/default_plan_image.jpg', '2024-11-20 13:45:15'),
('ae55bd7d-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368801', NULL, NULL, NULL, '2024-11-23 13:34:36'),
('af459d21-9abc-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'WBGSAZ', 'uploads/plans/plan_6728e021a7d910.92053212.jpg', '2024-11-04 14:54:25'),
('af9126c9-90ec-11ef-9771-004e01ffe201', NULL, '1729653160', NULL, NULL, NULL, '2024-10-23 03:12:50'),
('b3fd23a2-9753-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'HAJBWP', 'uploads/67232782e6b24_image_8.jpg', '2024-10-31 06:45:22'),
('b8a5ee01-a8d5-11ef-b8f5-004e01ffe201', NULL, '1732281817', NULL, NULL, NULL, '2024-11-22 13:28:55'),
('bca06ed8-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, NULL, 'uploads/event_1.jpg', '2024-11-03 02:38:41'),
('bf0bb872-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368793', NULL, NULL, NULL, '2024-11-23 13:35:04'),
('bf469605-a99d-11ef-b8f5-004e01ffe201', NULL, '1732367951', NULL, NULL, NULL, '2024-11-23 13:20:45'),
('bf8c290f-a2ab-11ef-b782-004e01ffe201', NULL, NULL, 'rashid', NULL, 'uploads/player_1.jpg', '2024-11-14 17:13:20'),
('c0bd6e81-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VNWQGL', 'uploads/672adaeb01828_event_1.jpg', '2024-11-06 02:56:43'),
('c1a6ad2f-8f8f-11ef-a5b9-004e01ffe201', NULL, '1729503254', NULL, NULL, NULL, '2024-10-21 09:35:06'),
('c297f3e8-94c4-11ef-96fe-004e01ffe201', NULL, NULL, NULL, 'TGNJRZ', 'uploads/event_1_671edcb3189d6.jpg', '2024-10-28 00:37:07'),
('c303703d-a290-11ef-b782-004e01ffe201', NULL, '1731592807', NULL, NULL, NULL, '2024-11-14 14:00:10'),
('c4330753-a99b-11ef-b8f5-004e01ffe201', NULL, '1732367022', NULL, NULL, NULL, '2024-11-23 13:06:34'),
('c779416c-9bcc-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'KZMTED', 'uploads/plans/plan_672aa8a15f44b5.80760034.jpg', '2024-11-05 23:22:09'),
('cecea036-a6dd-11ef-8920-004e01ffe201', NULL, '1732065688', NULL, NULL, NULL, '2024-11-20 01:21:45'),
('d785ab4b-947a-11ef-96fe-004e01ffe201', NULL, '1730044070', NULL, NULL, NULL, '2024-10-27 15:47:59'),
('d8244473-a506-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'FCEDGV', 'uploads/673a23849c912_karate_main.jpg', '2024-11-17 17:10:28'),
('da6bdcf5-a290-11ef-b782-004e01ffe201', NULL, '1731592844', NULL, NULL, NULL, '2024-11-14 14:00:49'),
('dbc0ce59-a15c-11ef-be02-004e01ffe201', NULL, '1731460556', NULL, NULL, NULL, '2024-11-13 01:16:06'),
('dc81088c-8f96-11ef-a5b9-004e01ffe201', NULL, '1729506355', NULL, NULL, NULL, '2024-10-21 10:25:58'),
('dd8efa39-a6dc-11ef-8920-004e01ffe201', NULL, '1732065284', NULL, NULL, NULL, '2024-11-20 01:15:01'),
('df7b218f-a326-11ef-b782-004e01ffe201', NULL, '1731657260', NULL, NULL, NULL, '2024-11-15 07:54:42'),
('df9cf0f4-90ef-11ef-954f-004e01ffe201', NULL, '1729654531', NULL, NULL, NULL, '2024-10-23 03:35:39'),
('e6c629fe-a99a-11ef-b8f5-004e01ffe201', NULL, '1732366527', NULL, NULL, NULL, '2024-11-23 13:00:23'),
('e823ad64-9057-11ef-a5b9-004e01ffe201', NULL, '1729589256', NULL, NULL, NULL, '2024-10-22 09:27:51'),
('ea030671-a6de-11ef-8920-004e01ffe201', NULL, '1732066169', NULL, NULL, NULL, '2024-11-20 01:29:41'),
('ea1a87b8-a35c-11ef-b782-004e01ffe201', NULL, '1731680283', NULL, NULL, NULL, '2024-11-15 14:21:33'),
('ebc785dd-a3e7-11ef-b782-004e01ffe201', NULL, '1731740147', NULL, NULL, NULL, '2024-11-16 06:56:36'),
('ed943f77-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'ERQZBC', 'uploads/6724360086480_karate_main.jpg', '2024-11-01 01:59:28'),
('ef17343a-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368433', NULL, NULL, NULL, '2024-11-23 13:29:15'),
('f1e09bcb-a327-11ef-b782-004e01ffe201', NULL, '1731657723', NULL, NULL, NULL, '2024-11-15 08:02:22'),
('f22779d9-a481-11ef-ae1d-004e01ffe201', NULL, '1731806292', NULL, NULL, NULL, '2024-11-17 01:19:09'),
('f3bbb8c8-a15c-11ef-be02-004e01ffe201', NULL, '1731460567', NULL, NULL, NULL, '2024-11-13 01:16:47'),
('f42bad97-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368878', NULL, NULL, NULL, '2024-11-23 13:36:33'),
('f7c907a6-a161-11ef-be02-004e01ffe201', NULL, '1731462741', NULL, NULL, NULL, '2024-11-13 01:52:41'),
('f9b54ceb-8f8e-11ef-a5b9-004e01ffe201', NULL, '1729502959', NULL, NULL, NULL, '2024-10-21 09:29:30'),
('fa1250de-97f4-11ef-8372-004e01ffe201', NULL, NULL, NULL, 'FLERKI', 'uploads/672436157c3d6_image_11.jpg', '2024-11-01 01:59:49'),
('faf0fe2d-a542-11ef-ae1d-004e01ffe201', NULL, NULL, NULL, 'OEHFJY', 'uploads/673a8868ca40d_image_5.jpg', '2024-11-18 00:20:56'),
('ff430ac1-9bea-11ef-a493-004e01ffe201', NULL, NULL, NULL, 'VXZPMY', 'uploads/672adb53dbe53_image_11.jpg', '2024-11-06 02:58:27'),
('ffb8592d-a14d-11ef-be02-004e01ffe201', NULL, '1731454171', NULL, NULL, NULL, '2024-11-12 23:29:44'),
('ffc7f96e-a99b-11ef-b8f5-004e01ffe201', NULL, '1732367210', NULL, NULL, NULL, '2024-11-23 13:08:14');

-- --------------------------------------------------------

--
-- Stand-in structure for view `inactive_plans`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `inactive_plans`;
CREATE TABLE IF NOT EXISTS `inactive_plans` (
`planid` varchar(8)
,`planName` text
,`description` text
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
('078b248c-a4d0-11ef-ae1d-004e01ffe201', NULL, '1731838081', NULL, 'heizmis', 'heizmis1', '078b24a7-a4d0-11ef-ae1d-004e01ffe201', 'member'),
('07a2a1ca-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732368926', NULL, 'malique', 'ZASX145S', '07a2a1dc-a9a0-11ef-b8f5-004e01ffe201', 'member'),
('0b4cb344-a99e-11ef-b8f5-004e01ffe201', NULL, '1732367978', NULL, 'sabr1na', '1478KMJN', '0b4cb355-a99e-11ef-b8f5-004e01ffe201', 'member'),
('12345', '1234', 'admintest', NULL, 'admintest', 'admintest', 'admintest', 'admin'),
('12345678', NULL, NULL, 'rashid', 'rashid', 'rashid', 'rashid', 'staff'),
('17690dc6-94e0-11ef-96fe-004e01ffe201', NULL, '1730087557', NULL, 'hello', 'hello', '17690ddc-94e0-11ef-96fe-004e01ffe201', 'member'),
('1b3f51f0-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368421', NULL, 'liwei', '014mnbvc', '1b3f5208-a99f-11ef-b8f5-004e01ffe201', 'member'),
('21b9d7d9-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368048', NULL, 'sabellaziz', '54bella21z', '21b9d7f3-a99e-11ef-b8f5-004e01ffe201', 'member'),
('2e13295e-a6df-11ef-8920-004e01ffe201', NULL, '1732066288', NULL, 'rohani', 'rohani12', '2e132974-a6df-11ef-8920-004e01ffe201', 'member'),
('324334532', NULL, NULL, 'cik_umaiyyah', 'cik_umaiyyah', 'umaiyyah', 'umaiyyah', 'staff'),
('38eb3e10-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368557', NULL, 'Kamar', 'ctKamariah04', '38eb3e30-a99f-11ef-b8f5-004e01ffe201', 'member'),
('397482db-a8d6-11ef-b8f5-004e01ffe201', NULL, '1732282137', NULL, 'mimi', 'Mimi$000', '397482f2-a8d6-11ef-b8f5-004e01ffe201', 'member'),
('3e55f7df-a749-11ef-8920-004e01ffe201', NULL, '1732111763', NULL, 'emma04', 'emma1234', '3e55f810-a749-11ef-8920-004e01ffe201', 'member'),
('450e5fb8-a99c-11ef-b8f5-004e01ffe201', NULL, '1732367313', NULL, 'sarah_lee', 'marikh000', '450e5fd1-a99c-11ef-b8f5-004e01ffe201', 'member'),
('46b33586-a2a5-11ef-b782-004e01ffe201', NULL, '1731601591', NULL, 'jamal', 'jamal123', '46b335b9-a2a5-11ef-b782-004e01ffe201', 'member'),
('4a6bbe49-a99b-11ef-b8f5-004e01ffe201', NULL, '1732366824', NULL, 'raj_kumar', 'hashraj202', '4a6bbe61-a99b-11ef-b8f5-004e01ffe201', 'member'),
('4f1db2d4-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732369063', NULL, 'lee_gwe', 'as14wdxx', '4f1db2e1-a9a0-11ef-b8f5-004e01ffe201', 'member'),
('577a9210-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368212', NULL, 'yoofelix', 'FelixY00', '577a9229-a99e-11ef-b8f5-004e01ffe201', 'member'),
('58456d58-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368176', NULL, 'miqa', '14789AQW', '58456d66-a99e-11ef-b8f5-004e01ffe201', 'member'),
('7bb4e867-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368660', NULL, 'rakesh', 'asddxc01', '7bb4e87d-a99f-11ef-b8f5-004e01ffe201', 'member'),
('80416927-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368681', NULL, 'ridzuan', 'zuanridz00', '80416941-a99f-11ef-b8f5-004e01ffe201', 'member'),
('847d52a8-a99d-11ef-b8f5-004e01ffe201', NULL, '1732367770', NULL, 'Angela', '4ngelaMajan', '847d52bf-a99d-11ef-b8f5-004e01ffe201', 'member'),
('9b9ceb1b-a9a0-11ef-b8f5-004e01ffe201', NULL, '1732369150', NULL, 'aman04', '753wefsa', '9b9ceb2f-a9a0-11ef-b8f5-004e01ffe201', 'member'),
('9e575743-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368304', NULL, 'kasih', '0125zxcv', '9e575757-a99e-11ef-b8f5-004e01ffe201', 'member'),
('a4bbe3cb-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368303', NULL, 'hadry', 'HadyrL33', 'a4bbe3e0-a99e-11ef-b8f5-004e01ffe201', 'member'),
('abee2b1b-a745-11ef-8920-004e01ffe201', NULL, '1732109890', NULL, 'pelajar1', 'pelajar1', 'abee2b4e-a745-11ef-8920-004e01ffe201', 'member'),
('ae5668a5-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368801', NULL, 'syu', '5yuhadaa', 'ae5668b4-a99f-11ef-b8f5-004e01ffe201', 'member'),
('b8a77d66-a8d5-11ef-b8f5-004e01ffe201', NULL, '1732281817', NULL, 'matin', 'Lege5angat', 'b8a77d79-a8d5-11ef-b8f5-004e01ffe201', 'member'),
('bca05358-998c-11ef-8372-004e01ffe201', NULL, '1730601491', NULL, 'yeah', 'yeah12', 'bca05374-998c-11ef-8372-004e01ffe201', 'member'),
('bf0b979e-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368793', NULL, 'aizat', '012zxdcn', 'bf0b97c4-a99f-11ef-b8f5-004e01ffe201', 'member'),
('bf474c55-a99d-11ef-b8f5-004e01ffe201', NULL, '1732367951', NULL, 'Sofiah', '5ofiah00', 'bf474c6f-a99d-11ef-b8f5-004e01ffe201', 'member'),
('c432d86a-a99b-11ef-b8f5-004e01ffe201', NULL, '1732367022', NULL, 'lisa_tan', 'tanlisa1235', 'c432d889-a99b-11ef-b8f5-004e01ffe201', 'member'),
('e6c5ee42-a99a-11ef-b8f5-004e01ffe201', NULL, '1732366527', NULL, 'vitar', 'vitasaran123', 'e6c5ee5a-a99a-11ef-b8f5-004e01ffe201', 'member'),
('ef17f0cd-a99e-11ef-b8f5-004e01ffe201', NULL, '1732368433', NULL, 'Iesyaa', '135yaaSherry', 'ef17f0e6-a99e-11ef-b8f5-004e01ffe201', 'member'),
('f42c67f1-a99f-11ef-b8f5-004e01ffe201', NULL, '1732368878', NULL, 'siva', '5ivaayamini', 'f42c6805-a99f-11ef-b8f5-004e01ffe201', 'member'),
('ffc7d46d-a99b-11ef-b8f5-004e01ffe201', NULL, '1732367210', NULL, 'mike_wong', 'kime@123', 'ffc7d485-a99b-11ef-b8f5-004e01ffe201', 'member'),
('sensei_tamil', NULL, NULL, 'sensei_tamil', 'sensei_tamil', 'tamil', 'tamil', 'staff');

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
  `planName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `planType` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `startDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `endDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `validity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Lifetime',
  `amount` int DEFAULT '0',
  `active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`planid`),
  KEY `idx_plan_type` (`planType`),
  KEY `idx_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`planid`, `tid`, `planName`, `description`, `planType`, `startDate`, `endDate`, `duration`, `validity`, `amount`, `active`) VALUES
('CXFDIA', '332201543', 'Dubai International Open', 'The Dubai International Open is poised to be one of the most prestigious karate events of 2025. Set against the backdrop of Dubai\'s stunning architectural landscape on July 19th, this high-caliber tournament promises to bring together elite karatekas from around the globe.\r\nAs an International Open restricted to Brown and Black Belt competitors, the event represents the pinnacle of karate competition. The tournament offers a comprehensive martial arts experience by featuring both Kata and Kumite divisions. The weight class structure, focusing on Heavyweight and Lightweight categories, creates interesting dynamic contrasts in the fighting styles showcased.\r\nWhat makes this tournament particularly unique is its inclusive age range, spanning from teenagers to senior practitioners. The three age divisions - Teen (13-17), Adult (18+), and Senior (35+) - promise to deliver an inspiring display of how karate excellence transcends age barriers. With 478 expected participants, the competition will be fierce and the level of technique exceptional.\r\nThe substantial prize pool of $9,876 reflects the tournament\'s international status and has attracted top-tier talent. The registration fee of $195 positions this as a premium event, while the venue\'s capacity of 1,655 spectators ensures an electrifying atmosphere. Dubai\'s reputation for luxury and excellence, combined with its central global location, makes it an ideal host city for this international gathering of martial arts masters.\r\nThe combination of the city\'s world-class facilities, the high level of competition, and the diverse participant pool makes the Dubai International Open a must-attend event in the international karate circuit. Spectators can expect to witness both the explosive power of Kumite matches and the graceful precision of Kata performances, all executed at the highest level of martial arts mastery.', 'Event', '2024-07-19', '2024-07-20', 1, 'Lifetime', 195, 'yes'),
('IPZCOV', '64983063', 'Paris Regional Championship', 'The Paris Regional Championship promises to be a thrilling display of martial arts excellence in the heart of France. Set for September 14th, 2025, this prestigious Black Belt-only tournament will unfold in Paris, bringing together the region\'s most skilled karatekas.\r\nThis comprehensive championship features both Kumite (sparring) and Kata (forms) divisions, offering a complete showcase of traditional karate skills. Competitors will compete across all weight classes - Lightweight, Middleweight, and Heavyweight - ensuring balanced and fair competition. The tournament focuses on adult competitors, welcoming both regular adult (18+) and senior (35+) divisions, highlighting the enduring spirit of karate across age groups.\r\nWith an expected turnout of 342 elite participants, the venue can accommodate up to 1,456 spectators, promising an electric atmosphere for both competitors and fans. The substantial prize pool of $5,843 adds to the competitive spirit, while the registration fee of $127 reflects the tournament\'s professional caliber.\r\nThe event will be particularly notable for its exclusive Black Belt requirement, ensuring the highest level of technical proficiency and competitive intensity. Spectators can expect to witness masterful demonstrations of both combat skills in Kumite and the precise, powerful movements of Kata performances.\r\nThe central Paris location makes this tournament easily accessible to both local and international participants, promising to draw top talent from across the region. This championship stands as an important milestone in the European karate circuit, offering black belt practitioners a premier platform to showcase their abilities and compete at the highest level.', 'Event', '2025-09-14', '2025-09-15', 1, 'Lifetime', 127, 'yes'),
('JWAZQG', '318051860', 'Kebarangkalian Karate Terbesar', 'ini adalah event karate tergembar', 'Event', '2024-10-15', '2024-10-20', 5, 'Lifetime', 123, 'yes'),
('LOXGHP', '874489422', 'gambar 3', 'gambar 3', 'Event', '2024-10-14', '2024-10-16', 2, 'Lifetime', 123, 'no'),
('PMXDVJ', '517033276', 'Shogun Showdown 2024', 'Join us for the \"Shogun Showdown 2024,\" an international karate competition showcasing skill, discipline, and the spirit of martial arts. Whether you’re a seasoned competitor or a karate enthusiast, this two-day event promises excitement for all.', 'Event', '2024-03-16', '2024-03-17', 1, 'Lifetime', 70, 'yes'),
('RCOIWL', '972417063', 'Mengaktifkan Pasukan', 'Ini adalah untuk mengaktifkan pasukan nombor 1', 'Event', '2024-12-20', '2024-12-25', 5, 'Lifetime', 100, 'no'),
('UYCZEB', '521686748', 'Seoul Youth Championship', 'The Seoul Youth Championship is set to showcase the next generation of karate talent in South Korea\'s vibrant capital. Scheduled for March 8th, 2025, this dynamic youth-focused tournament is specifically designed to nurture and celebrate young martial artists in their competitive journey.\r\nFocusing exclusively on Kumite (sparring), the championship provides an excellent opportunity for colored belt practitioners to test their skills in real combat scenarios. The tournament is thoughtfully structured with Lightweight and Middleweight divisions to ensure fair and safe competition among young athletes. The age categories span from Youth (8-12) to Teen (13-17), creating an ideal developmental platform for aspiring karatekas.\r\nWith a modest registration fee of $82, the tournament aims to be accessible to young practitioners while maintaining high organizational standards. The event expects to draw 289 young competitors, and the spacious venue can accommodate 1,823 spectators, ensuring that family, friends, and karate enthusiasts can all be part of this exciting championship. The prize pool of $2,156 adds a competitive edge while keeping the focus on personal growth and sporting excellence.\r\nThe choice of Seoul as the host city provides a perfect backdrop for this youth championship, with its blend of traditional martial arts heritage and modern sporting facilities. This event represents an important stepping stone for young karatekas, offering them valuable competition experience in a well-structured and supportive environment. The colored belt requirement ensures that participants compete against peers at similar skill levels, promoting fair and encouraging matches for these developing athletes.', 'Event', '2025-03-08', '2025-03-09', 1, 'Lifetime', 82, 'yes'),
('VGIBNU', '393089340', 'Sydney Grand Prix', 'The Sydney Grand Prix marks a unique addition to the 2025 karate calendar, offering an innovative format focused purely on the artistry of Kata. Set for May 2nd in the vibrant Australian metropolis, this Grand Prix breaks traditional molds by welcoming practitioners of all belt levels, from beginners to masters.\r\nWhat makes this event particularly special is its exclusive focus on Kata (forms), allowing participants to demonstrate the beauty and precision of karate\'s choreographed patterns without the element of combat. Despite being primarily a Kata competition, the event maintains a Lightweight division classification to ensure participants compete against others of similar physical attributes.\r\nThe tournament creates an interesting generational bridge by featuring both Youth (8-12) and Adult (18+) divisions, offering a rare opportunity to witness the evolution of Kata execution from promising young practitioners to seasoned adults. With 415 expected participants, the competition will showcase a wide spectrum of interpretations and styles within the Kata discipline.\r\nThe generous prize pool of $7,234 demonstrates the event\'s commitment to elevating Kata as a standalone art form. The moderate registration fee of $143 makes the event accessible while maintaining professional standards. The venue\'s capacity of 1,789 spectators ensures a substantial audience for these artistic displays of martial arts excellence.\r\nSydney\'s world-class facilities and natural beauty provide a perfect backdrop for this unique celebration of karate\'s formal patterns. The \"All Belts\" format creates an inclusive environment where practitioners at every level can learn from each other, making this Grand Prix not just a competition, but also a valuable learning experience for the entire karate community.', 'Event', '2022-02-05', '2022-02-06', 1, 'Lifetime', 143, 'yes'),
('XTWIOL', '123', 'Karate Activities', 'This includes all karate activity plan', 'Core', '2024-11-15', '2024-11-28', 16, '', 20, 'yes'),
('YVFGZL', '16745872', 'Bushido Spirit Karat', 'Unleash your inner warrior at the Bushido Spirit Karate Open 2024! This prestigious tournament celebrates the art of karate, emphasizing discipline, respect, and excellence. Whether you\'re a seasoned competitor or a passionate spectator, this event promises an unforgettable experience filled with fierce competition and cultural appreciation.\r\n\r\nDate: February 10, 2024\r\nTime: 10:00 AM – 6:00 PM\r\nLocation: Kyoto International Conference Center, Kyoto, Japan\r\n\r\nEvent Highlights:\r\n\r\nOpen-category sparring and kata competitions\r\nJunior, senior, and masters divisions\r\nExclusive seminar on \"The Philosophy of Bushido in Karate\"\r\nDemonstrations of rare traditional katas\r\nNetworking opportunities for karate clubs and practitioners\r\nParticipants:\r\n\r\nYouth Division: Ages 8–14\r\nOpen Division: Ages 15 and above\r\nAwards:\r\n\r\nTrophies and medals for winners in each category\r\nSpecial \"Bushido Spirit\" award for the most disciplined competitor\r\nRegistration:\r\n\r\nFee: $60 per participant\r\nRegistration Deadline: January 25, 2024\r\nContact Information:\r\nFor registration and event details, visit www.bushidospiritopen.com or email info@bushidospiritopen.com.', 'Event', '2024-02-10', '2024-02-15', 5, 'Lifetime', 60, 'yes');

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
('page_6741d85f0c6856.22995658', 'JWAZQG', 'Kebarangkalian Karate Terbesar', 'ini adalah event karate tergembar', 'ini adalah event karate tergembar', 'ebarangkalian-arate-erbesar', '2024-11-23 05:27:59', '2024-11-23 13:27:59', 1),
('page_672addd0a50314.91648404', 'LOXGHP', 'gambar 3', 'gambar 3', 'gambar 3', 'gambar-3', '2024-11-05 19:09:04', '2024-11-06 03:09:04', 1),
('page_672f3a8fcc53f8.62831523', 'ZHXPSA', 'pintu', 'pintu', 'pintu', 'pintu', '2024-11-09 02:33:51', '2024-11-09 10:33:51', 1),
('page_6726cf1974f279.76136256', 'JIFKPO', 'WOW', 'WOW', 'WOW', '', '2024-11-02 17:17:13', '2024-11-03 01:17:13', 1),
('page_673c815828f613.26810826', 'YVFGZL', 'Bushido Spirit Karate Open 2024', 'Unleash your inner warrior at the Bushido Spirit Karate Open 2024! This prestigious tournament celebrates the art of karate, emphasizing discipline, respect, and excellence. Whether you\'re a seasoned competitor or a passionate spectator, this event promises an unforgettable experience filled with fierce competition and cultural appreciation.\r\n\r\nDate: February 10, 2024\r\nTime: 10:00 AM – 6:00 PM\r\nLocation: Kyoto International Conference Center, Kyoto, Japan\r\n\r\nEvent Highlights:\r\n\r\nOpen-category sparring and kata competitions\r\nJunior, senior, and masters divisions\r\nExclusive seminar on \"The Philosophy of Bushido in Karate\"\r\nDemonstrations of rare traditional katas\r\nNetworking opportunities for karate clubs and practitioners\r\nParticipants:\r\n\r\nYouth Division: Ages 8–14\r\nOpen Division: Ages 15 and above\r\nAwards:\r\n\r\nTrophies and medals for winners in each category\r\nSpecial \"Bushido Spirit\" award for the most disciplined competitor\r\nRegistration:\r\n\r\nFee: $60 per participant\r\nRegistration Deadline: January 25, 2024\r\nContact Information:\r\nFor registration and event details, visit www.bushidospiritopen.com or email info@bushidospiritopen.com.', 'Unleash your inner warrior at the Bushido Spirit Karate Open 2024! This prestigious tournament celebrates the art of karate, emphasizing discipline, r', 'ushido-pirit-arate-pen-2024', '2024-11-19 04:15:20', '2024-11-19 12:15:20', 1),
('page_6741d98f2689d4.90983011', 'IPZCOV', 'Paris Regional Championship', 'The Paris Regional Championship promises to be a thrilling display of martial arts excellence in the heart of France. Set for September 14th, 2025, this prestigious Black Belt-only tournament will unfold in Paris, bringing together the region\'s most skilled karatekas.\r\nThis comprehensive championship features both Kumite (sparring) and Kata (forms) divisions, offering a complete showcase of traditional karate skills. Competitors will compete across all weight classes - Lightweight, Middleweight, and Heavyweight - ensuring balanced and fair competition. The tournament focuses on adult competitors, welcoming both regular adult (18+) and senior (35+) divisions, highlighting the enduring spirit of karate across age groups.\r\nWith an expected turnout of 342 elite participants, the venue can accommodate up to 1,456 spectators, promising an electric atmosphere for both competitors and fans. The substantial prize pool of $5,843 adds to the competitive spirit, while the registration fee of $127 reflects the tournament\'s professional caliber.\r\nThe event will be particularly notable for its exclusive Black Belt requirement, ensuring the highest level of technical proficiency and competitive intensity. Spectators can expect to witness masterful demonstrations of both combat skills in Kumite and the precise, powerful movements of Kata performances.\r\nThe central Paris location makes this tournament easily accessible to both local and international participants, promising to draw top talent from across the region. This championship stands as an important milestone in the European karate circuit, offering black belt practitioners a premier platform to showcase their abilities and compete at the highest level.', 'The Paris Regional Championship promises to be a thrilling display of martial arts excellence in the heart of France. Set for September 14th, 2025, th', 'aris-egional-hampionship', '2024-11-23 05:33:03', '2024-11-23 13:33:03', 1),
('page_6741d9ca081148.80464250', 'UYCZEB', 'Seoul Youth Championship', 'The Seoul Youth Championship is set to showcase the next generation of karate talent in South Korea\'s vibrant capital. Scheduled for March 8th, 2025, this dynamic youth-focused tournament is specifically designed to nurture and celebrate young martial artists in their competitive journey.\r\nFocusing exclusively on Kumite (sparring), the championship provides an excellent opportunity for colored belt practitioners to test their skills in real combat scenarios. The tournament is thoughtfully structured with Lightweight and Middleweight divisions to ensure fair and safe competition among young athletes. The age categories span from Youth (8-12) to Teen (13-17), creating an ideal developmental platform for aspiring karatekas.\r\nWith a modest registration fee of $82, the tournament aims to be accessible to young practitioners while maintaining high organizational standards. The event expects to draw 289 young competitors, and the spacious venue can accommodate 1,823 spectators, ensuring that family, friends, and karate enthusiasts can all be part of this exciting championship. The prize pool of $2,156 adds a competitive edge while keeping the focus on personal growth and sporting excellence.\r\nThe choice of Seoul as the host city provides a perfect backdrop for this youth championship, with its blend of traditional martial arts heritage and modern sporting facilities. This event represents an important stepping stone for young karatekas, offering them valuable competition experience in a well-structured and supportive environment. The colored belt requirement ensures that participants compete against peers at similar skill levels, promoting fair and encouraging matches for these developing athletes. CopyRetryClaude does not have the ability to run the code it generates yet.', 'The Seoul Youth Championship is set to showcase the next generation of karate talent in South Korea\'s vibrant capital. Scheduled for March 8th, 2025, ', 'eoul-outh-hampionship', '2024-11-23 05:34:02', '2024-11-23 13:34:02', 1),
('page_6741d9fc48bf19.37827538', 'CXFDIA', 'Dubai International Open', 'The Dubai International Open is poised to be one of the most prestigious karate events of 2025. Set against the backdrop of Dubai\'s stunning architectural landscape on July 19th, this high-caliber tournament promises to bring together elite karatekas from around the globe.\r\nAs an International Open restricted to Brown and Black Belt competitors, the event represents the pinnacle of karate competition. The tournament offers a comprehensive martial arts experience by featuring both Kata and Kumite divisions. The weight class structure, focusing on Heavyweight and Lightweight categories, creates interesting dynamic contrasts in the fighting styles showcased.\r\nWhat makes this tournament particularly unique is its inclusive age range, spanning from teenagers to senior practitioners. The three age divisions - Teen (13-17), Adult (18+), and Senior (35+) - promise to deliver an inspiring display of how karate excellence transcends age barriers. With 478 expected participants, the competition will be fierce and the level of technique exceptional.\r\nThe substantial prize pool of $9,876 reflects the tournament\'s international status and has attracted top-tier talent. The registration fee of $195 positions this as a premium event, while the venue\'s capacity of 1,655 spectators ensures an electrifying atmosphere. Dubai\'s reputation for luxury and excellence, combined with its central global location, makes it an ideal host city for this international gathering of martial arts masters.\r\nThe combination of the city\'s world-class facilities, the high level of competition, and the diverse participant pool makes the Dubai International Open a must-attend event in the international karate circuit. Spectators can expect to witness both the explosive power of Kumite matches and the graceful precision of Kata performances, all executed at the highest level of martial arts mastery.', 'The Dubai International Open is poised to be one of the most prestigious karate events of 2025. Set against the backdrop of Dubai\'s stunning architect', 'ubai-nternational-pen', '2024-11-23 05:34:52', '2024-11-23 13:34:52', 1),
('page_6741dcc4b649c6.79367197', 'VGIBNU', 'Sydney Grand Prix', 'The Sydney Grand Prix marks a unique addition to the 2025 karate calendar, offering an innovative format focused purely on the artistry of Kata. Set for May 2nd in the vibrant Australian metropolis, this Grand Prix breaks traditional molds by welcoming practitioners of all belt levels, from beginners to masters.\r\nWhat makes this event particularly special is its exclusive focus on Kata (forms), allowing participants to demonstrate the beauty and precision of karate\'s choreographed patterns without the element of combat. Despite being primarily a Kata competition, the event maintains a Lightweight division classification to ensure participants compete against others of similar physical attributes.\r\nThe tournament creates an interesting generational bridge by featuring both Youth (8-12) and Adult (18+) divisions, offering a rare opportunity to witness the evolution of Kata execution from promising young practitioners to seasoned adults. With 415 expected participants, the competition will showcase a wide spectrum of interpretations and styles within the Kata discipline.\r\nThe generous prize pool of $7,234 demonstrates the event\'s commitment to elevating Kata as a standalone art form. The moderate registration fee of $143 makes the event accessible while maintaining professional standards. The venue\'s capacity of 1,789 spectators ensures a substantial audience for these artistic displays of martial arts excellence.\r\nSydney\'s world-class facilities and natural beauty provide a perfect backdrop for this unique celebration of karate\'s formal patterns. The \"All Belts\" format creates an inclusive environment where practitioners at every level can learn from each other, making this Grand Prix not just a competition, but also a valuable learning experience for the entire karate community.', 'The Sydney Grand Prix marks a unique addition to the 2025 karate calendar, offering an innovative format focused purely on the artistry of Kata. Set f', 'ydney-rand-rix', '2024-11-23 05:46:44', '2024-11-23 13:46:44', 1),
('page_6741dd3e655df0.81705877', 'PMXDVJ', 'Shogun Showdown 2024', 'Join us for the \"Shogun Showdown 2024,\" an international karate competition showcasing skill, discipline, and the spirit of martial arts. Whether you’re a seasoned competitor or a karate enthusiast, this two-day event promises excitement for all.', 'Join us for the \"Shogun Showdown 2024,\" an international karate competition showcasing skill, discipline, and the spirit of martial arts. Whether you’', 'hogun-howdown-2024', '2024-11-23 05:48:46', '2024-11-23 13:48:46', 1);

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
('16745872', 'YVFGZL', 'rashid', 'Bushido Spirit Karate Open 2024', '0'),
('181961', 'XTWIOL', 'rashid', 'New Schedule', '0'),
('223845966', 'KRT004', '1', 'Default Timetable Name', 'no'),
('232273', 'XTWIOL', 'sensei_tamil', 'New Schedule', '0'),
('318051860', 'JWAZQG', 'rashid', 'Kebarangkalian Karate Terbesar', '0'),
('332201543', 'CXFDIA', 'cik_umaiyyah', 'Dubai International Open', '0'),
('351979', 'KRT002', 'cik_umaiyyah', 'New Schedule', '0'),
('393089340', 'VGIBNU', 'cik_umaiyyah', 'Sydney Grand Prix', '0'),
('443967826', 'ZHXPSA', 'rashid', 'pintu', '0'),
('48a96c46-8d18-11ef-a94c-004e01ffe201', 'BJEFSY', 'Rashid', 'aaaa', 'yes'),
('517033276', 'PMXDVJ', 'rashid', 'Shogun Showdown 2024', '0'),
('521686748', 'UYCZEB', 'cik_umaiyyah', 'Seoul Youth Championship', '0'),
('64983063', 'IPZCOV', 'cik_umaiyyah', 'Paris Regional Championship', '0'),
('720413099', 'KRT002', '1', 'Default Timetable Name', '0'),
('7b00f52c-8d18-11ef-a94c-004e01ffe201', 'BJEFSY', 'rashid', 'test', 'yes'),
('807351', 'XTWIOL', 'cik_umaiyyah', 'New Schedule', '0'),
('847758526', 'XTWIOL', '1', 'Default Timetable Name', '0'),
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
('cik_umaiyyah', 'cik umaiyyah', 'cik_umaiyyah', 'umaiyyah', 'coach'),
('rashid', 'rashid', 'rashid', 'rashid', 'coach'),
('sensei_tamil', 'sensei tamil', 'sensei_tamil', 'tamil', 'coach');

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
('day_673c80f6b6b404.66043864', '681576180', 4, NULL),
('day_673c815828e5b9.96580842', '16745872', 6, NULL),
('day_672aaa8847ec29.07070788', '934889673', 4, NULL),
('day_672aaa8847d8d7.19964684', '934889673', 3, NULL),
('day_672aaa8847c189.45420558', '934889673', 2, NULL),
('day_673c815828d6b0.55106592', '16745872', 5, NULL),
('day_6741d85f0c5a68.81131828', '318051860', 6, NULL),
('day_6741d85f0c4c07.68007230', '318051860', 5, NULL),
('day_6741d85f0c3c95.10450427', '318051860', 4, NULL),
('day_6741d85f0c2da1.03555171', '318051860', 3, NULL),
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
('724dd0a6-a489-11ef-ae1d-004e01ffe201', '847758526', 14, ''),
('day_672aab3bbcdd02.12141019', '844415098', 1, NULL),
('day_672aab3bbcee20.05245171', '844415098', 7, NULL),
('day_6726cb41902ce9.24094170', '574511568', 1, 'testtt'),
('day_6726cbc57af975.25485836', '149645521', 1, 'testtt'),
('day_6726cbd39c3bc0.74671018', '2265016', 1, 'fg'),
('day_672aab3bbd5a35.67476964', '844415098', 14, NULL),
('day_6726cf1974d8d4.38236568', '92618308', 1, 'WOW'),
('day_6726cf28a099c1.41472425', '473138343', 1, 'WOW'),
('day_673c815828c504.93993319', '16745872', 4, NULL),
('724dc784-a489-11ef-ae1d-004e01ffe201', '847758526', 13, ''),
('724dbe6f-a489-11ef-ae1d-004e01ffe201', '847758526', 12, ''),
('day_672addd0a4c6d2.50293593', '874489422', 3, NULL),
('724da714-a489-11ef-ae1d-004e01ffe201', '847758526', 10, ''),
('day_672aab3bbd4a45.05343951', '844415098', 13, NULL),
('day_672aab3bbd3ae6.47945327', '844415098', 12, NULL),
('day_6728cb39944e59.34765918', '174532960', 1, NULL),
('day_6728cb39946162.56949739', '174532960', 2, NULL),
('day_6728cb39947090.24752937', '174532960', 3, NULL),
('724db3ae-a489-11ef-ae1d-004e01ffe201', '847758526', 11, ''),
('724d99c6-a489-11ef-ae1d-004e01ffe201', '847758526', 9, ''),
('724d8b77-a489-11ef-ae1d-004e01ffe201', '847758526', 8, ''),
('724d5d2f-a489-11ef-ae1d-004e01ffe201', '847758526', 5, ''),
('724d7ce4-a489-11ef-ae1d-004e01ffe201', '847758526', 7, ''),
('724d6d52-a489-11ef-ae1d-004e01ffe201', '847758526', 6, ''),
('day_6728cd60754817.72663183', '433860664', 1, NULL),
('day_6728cd60755874.33438462', '433860664', 2, NULL),
('day_6728cd60756517.81659827', '433860664', 3, NULL),
('day_6728cd607574b7.87020113', '433860664', 4, NULL),
('724d4d81-a489-11ef-ae1d-004e01ffe201', '847758526', 4, ''),
('724d3de1-a489-11ef-ae1d-004e01ffe201', '847758526', 3, ''),
('724d2d14-a489-11ef-ae1d-004e01ffe201', '847758526', 2, ''),
('724d1f51-a489-11ef-ae1d-004e01ffe201', '847758526', 1, ''),
('day_672addd0a4a046.71617153', '874489422', 1, NULL),
('day_672addd0a4b574.68473845', '874489422', 2, NULL),
('day_6741d85f0bee10.83957706', '318051860', 1, 'jiu jitsu'),
('day_6741d85f0c1e95.04436748', '318051860', 2, NULL),
('day_673a8868c9fec2.06240680', '187072972', 6, NULL),
('day_673a8868c9d861.10931654', '187072972', 5, NULL),
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
('day_6741d9fc48b299.59641232', '332201543', 2, NULL),
('day_6741d9fc48a807.25053125', '332201543', 1, NULL),
('day_6741d9ca080371.61357802', '521686748', 2, NULL),
('day_673a8868c9b916.72734572', '187072972', 4, NULL),
('day_6741d9ca07f493.18445353', '521686748', 1, NULL),
('day_6741d98f2676f4.02418656', '64983063', 2, NULL),
('day_6741d98f264e06.75843277', '64983063', 1, NULL),
('day_673a8868c99333.90709381', '187072972', 3, NULL),
('day_673a8868c97298.02730084', '187072972', 2, NULL),
('day_673a8868c94b63.66747076', '187072972', 1, NULL),
('day_673c80f6b6c416.05216427', '681576180', 5, NULL),
('day_673c80f6b6a885.86072201', '681576180', 3, NULL),
('day_673c80f6b697a9.94563079', '681576180', 2, NULL),
('day_673c80f6b68a96.05758693', '681576180', 1, NULL),
('day_673c815828b640.42565308', '16745872', 3, 'hari 3'),
('day_673c815828a665.86900022', '16745872', 2, 'hari 2'),
('day_673c8158289861.69138440', '16745872', 1, 'hari 1'),
('day_6741dcc4b60b31.93096169', '393089340', 1, '123'),
('day_6741dcc4b637e3.36616063', '393089340', 2, NULL),
('day_6741dd3e6536e2.14154000', '517033276', 1, NULL),
('day_6741dd3e654c42.76338200', '517033276', 2, NULL);

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
('1730087557', 'hello', '1768cef2-94e0-11ef-96fe-004e01ffe201', 'hello', 'hello', 'male', '123-23232323', 'hello@gmail.com', '123', '2024-11-13', 'Yes', 'AF212WD102KYM', '', '010201929123'),
('1730601491', 'yeah12', 'bc9fc58b-998c-11ef-8372-004e01ffe201', 'yeah', 'yeah', 'M', '0192837412', 'yeah@gmail.com', '', '', 'Yes', '', '', NULL),
('1731601591', 'jamal123', '46b229f4-a2a5-11ef-b782-004e01ffe201', 'jamal', 'jamal', 'Male', '123123123123', 'jamal@gmail.com', '2000-06-15', '2024-11-15', 'Yes', 'jamal1', 'Introduction to Computer Science', '123451231231'),
('1731838081', 'heizmis1', '078b48be-a4d0-11ef-ae1d-004e01ffe201', 'heizmis', 'heizmis', 'Male', '0192383238', 'heizmis@gmail.com', '2001-10-10', '2024-11-18', 'Yes', 'AF212WD102KYM', '', '123123123123'),
('1732066288', 'rohani12', '2e125604-a6df-11ef-8920-004e01ffe201', 'rohani', 'Encik Rohani', 'Male', '234-32432432', 'rohani@gmail.com', '2003-06-20', '2024-11-20', 'Yes', 'AF221WD010KYM', 'Diploma in Entrepreneurship', '001238-10-2812'),
('1732109890', 'pelajar1', 'abeca888-a745-11ef-8920-004e01ffe201', 'pelajar1', 'Pelajar', 'Male', '011-2382371', 'pelajar1@gmail.com', '2000-10-10', '2024-11-20', 'Yes', 'AF123WD213KYM', 'Diploma in Entrepreneurship', '012381-92-3123'),
('1732111763', 'emma1234', NULL, 'emma04', 'Emma', 'Female', '019-0989023', 'emma123@gmail.com', '1998-02-03', '2024-11-20', 'Yes', 'AF221WD001KYM', 'Diploma in Multimedia Technology', '980203-01-0456'),
('1732281817', 'Lege5angat', NULL, 'matin', 'matin', NULL, '012-3456789', NULL, NULL, NULL, 'No', 'AF220WD001KYM', 'Diploma in Electrical Technology', '090524-10-1190'),
('1732282137', 'Mimi$000', NULL, 'mimi', 'Nur Syamimi', NULL, '011-2997689', NULL, NULL, NULL, 'No', 'AF200WD009KYM', 'Diploma in Entrepreneurship', '001010-10-5574'),
('1732366527', 'vitasaran123', 'e6c52e36-a99a-11ef-b8f5-004e01ffe201', 'vitar', 'vitar', 'male', '012-34949127', 'vitasaran@gmail.com', '2000-11-12', '', 'No', 'AF123WD031KYM', NULL, '001211-01-0011'),
('1732366824', 'hashraj202', '4a6b1d68-a99b-11ef-b8f5-004e01ffe201', 'raj_kumar', 'raj_kumar', 'Male', '012-34567894', 'raj@email.com', '1999-09-25', '2024-11-23', 'No', 'AF412WD091KYM', NULL, '990925-10-7765'),
('1732367022', 'tanlisa1235', 'c43211ec-a99b-11ef-b8f5-004e01ffe201', 'lisa_tan', 'lisa_tan', 'Female', '012-34567893', 'lisa@email.com', '1996-05-18', '2024-11-23', 'No', 'AF341WD015KYM', NULL, '960518-10-6654'),
('1732367210', 'kime@123', 'ffc739af-a99b-11ef-b8f5-004e01ffe201', 'mike_wong', 'mike_wong', 'Male', '012-34567892', 'mike@email.com', '1997-11-30', '2024-11-23', 'No', 'AF124WD124KYM', NULL, '971130-10-5543'),
('1732367313', 'marikh000', '450debed-a99c-11ef-b8f5-004e01ffe201', 'sarah_lee', 'sarah_lee', 'Male', '012-34567891', 'sarah@email.com', '1998-07-22', '2024-11-23', 'No', 'AF231WD583KYM', NULL, '980722-10-4432'),
('1732367770', '4ngelaMajan', NULL, 'Angela', 'Angela Majan', NULL, '011-87604679', NULL, NULL, NULL, 'No', 'AF221WD001KYM', 'Diploma in Information Technology', '040105-13-0722'),
('1732367951', '5ofiah00', NULL, 'Sofiah', 'Sofiah Azzahrah', NULL, '011-59909496', NULL, NULL, NULL, 'No', 'AF221wd018KYM', 'Diploma in Information Technology', '040528-10-2192'),
('1732367978', '1478KMJN', '0b4c5b08-a99e-11ef-b8f5-004e01ffe201', 'sabr1na', 'sabr1na', 'Female', '014-7859632', 'sabr1ina@gmail.com', '2005-02-23', '2024-11-23', 'No', 'AF214WD78KYM', NULL, '147859-12-4578'),
('1732368048', '54bella21z', NULL, 'sabellaziz', 'Isabela Aziz', NULL, '019-56789590', NULL, NULL, NULL, 'No', 'AF678WG009KYM', 'Diploma in Entrepreneurship', '567893-45-6790'),
('1732368176', '14789AQW', '58452135-a99e-11ef-b8f5-004e01ffe201', 'miqa', 'miqa', 'Male', '012-4578963', 'haikal@gmail.com', '2001-03-10', '2024-11-23', 'No', 'AF213WD021KYM', NULL, '147896-22-4578'),
('1732368212', 'FelixY00', NULL, 'yoofelix', 'Felix Yoo', NULL, '018-76542345', NULL, NULL, NULL, 'No', 'WC0987653KYM', 'Diploma in Entrepreneurship', '098764-32-1234'),
('1732368303', 'HadyrL33', NULL, 'hadry', 'Hadrian lee', NULL, '013-4567890', NULL, NULL, NULL, 'No', 'AF3456WWKYM', 'Diploma in Tourism Management', '050722-04-5677'),
('1732368304', '0125zxcv', '9e56f7dc-a99e-11ef-b8f5-004e01ffe201', 'kasih', 'kasih', 'Female', '014-5236987', 'maisarah99@gmail.com', '1999-05-11', '2024-11-23', 'No', 'AF201WD145KYM', NULL, '125639-11-4785'),
('1732368421', '014mnbvc', '1b3ec6fd-a99f-11ef-b8f5-004e01ffe201', 'liwei', 'liwei', 'Male', '013-4569874', 'liwei04@gmail.com', '2004-08-07', '2024-11-23', 'No', 'AF213WD051KYM', NULL, '014785-11-0678'),
('1732368433', '135yaaSherry', NULL, 'Iesyaa', 'Nur Shareviana Erisya', NULL, '013-09345679', NULL, NULL, NULL, 'No', 'BI0001315', 'Diploma in Early Childhood Education', '041109-14-5678'),
('1732368557', 'ctKamariah04', NULL, 'Kamar', 'Siti Kamariah binti Roslin', NULL, '015-678903', NULL, NULL, NULL, 'No', 'BI0001322', 'Diploma in Early Childhood Education', '041224-56-7890'),
('1732368660', 'asddxc01', '7bb48f3f-a99f-11ef-b8f5-004e01ffe201', 'rakesh', 'rakesh', 'Male', '012-5478964', 'rakesh06@gmail.com', '2006-06-06', '2024-11-23', 'No', 'AF221WD054KYM', NULL, '021547-88-9635'),
('1732368681', 'zuanridz00', NULL, 'ridzuan', 'Muhamnad Ridzuan', NULL, '015-67890345', NULL, NULL, NULL, 'No', 'T0000622', 'Diploma in Electrical Technology', '040812-09-2345'),
('1732368793', '012zxdcn', 'bf0b037e-a99f-11ef-b8f5-004e01ffe201', 'aizat', 'aizat', 'Male', '015-7849631', 'aizat@gmail.com', '2014-05-21', '2024-11-23', 'No', 'AF254WD147KYM', NULL, '147852-11-4569'),
('1732368801', '5yuhadaa', NULL, 'syu', 'Nursyuhada', NULL, '012-09845678', NULL, NULL, NULL, 'No', 'BI0001369', 'Diploma in Early Childhood Education', '960204-05-6784'),
('1732368878', '5ivaayamini', NULL, 'siva', 'Sivayamini', NULL, '017-09345298', NULL, NULL, NULL, 'No', 'SFT221R010KYM', 'Diploma in Marketing', '020330-12-4568'),
('1732368926', 'ZASX145S', '07a24ed6-a9a0-11ef-b8f5-004e01ffe201', 'malique', 'malique', 'Male', '013-6985214', 'malique30@gmail.com', '2003-03-30', '2024-11-23', 'No', 'AF236WD256KYM', NULL, '147852-14-7541'),
('1732369063', 'as14wdxx', '4f1d74d3-a9a0-11ef-b8f5-004e01ffe201', 'lee_gwe', 'lee_gwe', 'Male', '014-5278412', 'leegwei@gmail.com', '2008-08-08', '2024-11-23', 'No', 'AF214WD369KYM', NULL, '142563-98-7415'),
('1732369150', '753wefsa', '9b9c944e-a9a0-11ef-b8f5-004e01ffe201', 'aman04', 'aman04', 'Male', '012-5987461', 'aman04@gmail.com', '2003-09-07', '2024-11-23', 'No', 'AF257WD354KYM', NULL, '258963-11-4578');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
