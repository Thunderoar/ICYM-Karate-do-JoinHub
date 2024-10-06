-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 06, 2024 at 11:32 AM
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
-- Database: `karate_club_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addressid` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `streetName` varchar(40) NOT NULL,
  `state` varchar(40) NOT NULL,
  `city` varchar(40) NOT NULL,
  `zipcode` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressid`, `userid`, `streetName`, `state`, `city`, `zipcode`) VALUES
('126880847', '1727665527', 'johanstreet', 'johanstate', 'johancity', ''),
('211954374', '1728189607', 'johanstreet', 'johanstate', 'johancity', '1'),
('353767690', '1728128066', 'abc', 'abc', 'abc', '12345'),
('414372421', '1728189648', 'johanstreet', 'johanstate', 'johancity', '1'),
('426746007', '1727621388', 'abc', 'abc', 'abc', ''),
('862324644', '1728121956', 'test', 'abc', 'abc', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass_key` varchar(20) NOT NULL,
  `securekey` varchar(20) NOT NULL,
  `Full_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `pass_key`, `securekey`, `Full_name`) VALUES
('1234', 'admintest', 'admintest', 'admintest', 'admintest');

-- --------------------------------------------------------

--
-- Table structure for table `enrolls_to`
--

CREATE TABLE `enrolls_to` (
  `et_id` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `planid` varchar(8) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `paid_date` varchar(15) NOT NULL,
  `expire` varchar(15) NOT NULL,
  `renewal` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolls_to`
--

INSERT INTO `enrolls_to` (`et_id`, `planid`, `userid`, `paid_date`, `expire`, `renewal`) VALUES
('2024-09-29 21:57:02', 'BJEFSY', '1727618220', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 21:59:51', 'BJEFSY', '1727618390', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 22:00:31', 'BJEFSY', '1727618429', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 22:48:36', 'BJEFSY', '1727621310', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 22:49:50', 'BJEFSY', '1727621388', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 22:53:44', 'BJEFSY', '1727621622', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-29 22:55:31', 'BJEFSY', '1727621728', '2024-09-29', '1970-01-01', 'yes'),
('2024-09-30 11:06:25', 'BJEFSY', '1727665527', '2024-09-30', '1970-01-01', 'yes'),
('2024-10-05 17:53:07', 'XTWIOL', '1728121956', '2024-10-05', '1970-01-01', 'yes'),
('2024-10-05 19:34:24', 'EOLWXI', '1728128062', '2024-10-05', '1970-01-01', 'yes'),
('2024-10-05 19:36:12', 'QIVSYC', '1728128066', '2024-10-05', '1970-01-01', 'yes'),
('2024-10-05 19:37:55', 'XTWIOL', '1728128257', '2024-10-05', '1970-01-01', 'yes'),
('2024-10-06 12:40:30', 'NJHMPR', '1728189607', '2024-10-06', '1970-01-01', 'yes'),
('2024-10-06 12:41:02', 'NJHMPR', '1728189648', '2024-10-06', '1970-01-01', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `health_status`
--

CREATE TABLE `health_status` (
  `healthid` varchar(100) NOT NULL,
  `calorie` varchar(8) NOT NULL DEFAULT '',
  `height` varchar(8) NOT NULL DEFAULT '',
  `weight` varchar(8) NOT NULL DEFAULT '',
  `fat` varchar(8) NOT NULL DEFAULT '',
  `remarks` varchar(200) NOT NULL DEFAULT '',
  `userid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_status`
--

INSERT INTO `health_status` (`healthid`, `calorie`, `height`, `weight`, `fat`, `remarks`, `userid`) VALUES
('12981953', '', '', '', '', '', '1728189607'),
('235753157', '', '', '', '', '', '1728128066'),
('255603186', '', '', '', '', 'WOW!', '1727665527'),
('327687540', '', '', '', '', '', '1727621728'),
('394971300', '', '', '', '', '', '1728121956'),
('400390580', '', '', '', '', '', '1728128257'),
('423999936', '', '', '', '', '', '1728128062'),
('516492845', '', '', '', '', '', '1728189648'),
('689152795', '', '', '', '', '', '1727621388'),
('947924960', '', '', '', '', '', '1727621622');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageid` varchar(200) NOT NULL,
  `adminid` varchar(20) NOT NULL DEFAULT '0',
  `userid` varchar(20) NOT NULL DEFAULT '0',
  `planid` varchar(8) NOT NULL DEFAULT '0',
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageid`, `adminid`, `userid`, `planid`, `image_path`, `uploaded_at`) VALUES
('3100ac59-839d-11ef-8354-3ca067e52da9', '0', '1728189648', '0', 'uploads/user_profile/ijerph-17-09481-g001.jpg', '2024-10-06 04:41:02'),
('9566be7b-83a5-11ef-8354-3ca067e52da9', 'admintest', '0', '0', 'uploads/a9d7ddf79f8967ef8ed2cccd10112606.jpg', '2024-10-06 05:41:07'),
('9746d457-83a6-11ef-8354-3ca067e52da9', '1234', '0', '0', 'uploads/d27ebb6de481e23dafccc64d636e01bf.jpg', '2024-10-06 05:48:19'),
('cab09151-839c-11ef-8354-3ca067e52da9', '0', '0', 'NJHMPR', 'uploads/cb29fd18a62485da33431fb6500f0439.jpg', '2024-10-06 04:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `loginid` varchar(20) NOT NULL,
  `adminid` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass_key` varchar(20) NOT NULL,
  `securekey` varchar(20) NOT NULL,
  `authority` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginid`, `adminid`, `userid`, `username`, `pass_key`, `securekey`, `authority`) VALUES
('123', '123', '123', '123', '123', '123', 'admin'),
('12345', '1234', '', 'admintest', 'admintest', 'admintest', 'admin'),
('wah', '', '', 'test', 'test', 'test', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `log_users`
--

CREATE TABLE `log_users` (
  `logid` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `planid` varchar(8) NOT NULL,
  `planName` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `planType` varchar(50) NOT NULL,
  `validity` varchar(20) NOT NULL DEFAULT 'Lifetime',
  `amount` int(10) NOT NULL DEFAULT 0,
  `active` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`planid`, `planName`, `description`, `planType`, `validity`, `amount`, `active`) VALUES
('NJHMPR', 'kucing', 'kucing', 'Event', 'Lifetime', 0, 'yes'),
('QKHDIS', 'kucing', 'kucing', 'Event', 'Lifetime', 0, 'yes'),
('XTWIOL', 'Karate Activities', 'This includes all karate activity plan', 'Core', '', 20, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sports_timetable`
--

CREATE TABLE `sports_timetable` (
  `tid` int(12) NOT NULL,
  `tname` varchar(45) NOT NULL,
  `day1` varchar(200) NOT NULL,
  `day2` varchar(200) NOT NULL,
  `day3` varchar(200) NOT NULL,
  `day4` varchar(200) NOT NULL,
  `day5` varchar(200) NOT NULL,
  `day6` varchar(200) NOT NULL,
  `pid` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(20) NOT NULL,
  `imageid` varchar(200) NOT NULL,
  `username` varchar(40) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `joining_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `imageid`, `username`, `fullName`, `gender`, `mobile`, `email`, `dob`, `joining_date`) VALUES
('1727665527', '0', 'johan', '', 'Male', '019', 'johan@gmail.com', '2020-09-07', '2024-09-08'),
('1728121956', '0', 'test', 'test', 'Male', '012323232', 'fa@gmail.com', '', '2024-09-20'),
('1728189607', 'UUID()', 'johan', 'johan', 'Male', '1', 'johan@gmail.com', '', '2024-10-20'),
('1728189648', 'UUID()', 'johan', 'johan', 'Male', '1', 'johan@gmail.com', '', '2024-10-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressid`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `health_status`
--
ALTER TABLE `health_status`
  ADD PRIMARY KEY (`healthid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`loginid`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`planid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
