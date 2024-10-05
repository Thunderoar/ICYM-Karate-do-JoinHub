-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 05, 2024 at 01:46 PM
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
('426746007', '1727621388', 'abc', 'abc', 'abc', ''),
('395689128', '1727621728', 'Kampung Lago Peti Surat 240', 'SABAH', 'SABAH - BEAUFORT/DL MAMPAKUR', ''),
('126880847', '1727665527', 'johanstreet', 'johanstate', 'johancity', ''),
('862324644', '1728121956', 'test', 'abc', 'abc', ''),
('657042166', '1728128062', 'Kampung Lago Peti Surat 240', 'SABAH', 'SABAH - BEAUFORT/DL MAMPAKUR', '89808'),
('353767690', '1728128066', 'abc', 'abc', 'abc', '12345'),
('236971276', '1728128257', 'Kampung Lago Peti Surat 240', 'SABAH', 'SABAH - BEAUFORT/DL MAMPAKUR', '89808');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` varchar(20) NOT NULL,
  `imageid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass_key` varchar(20) NOT NULL,
  `securekey` varchar(20) NOT NULL,
  `Full_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `imageid`, `username`, `pass_key`, `securekey`, `Full_name`) VALUES
('', '', 'admin1', 'admin1', 'admin1', 'Sports Club Manager');

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
('2024-10-05 19:37:55', 'XTWIOL', '1728128257', '2024-10-05', '1970-01-01', 'yes');

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
('689152795', '', '', '', '', '', '1727621388'),
('947924960', '', '', '', '', '', '1727621622'),
('327687540', '', '', '', '', '', '1727621728'),
('255603186', '', '', '', '', 'WOW!', '1727665527'),
('394971300', '', '', '', '', '', '1728121956'),
('423999936', '', '', '', '', '', '1728128062'),
('235753157', '', '', '', '', '', '1728128066'),
('400390580', '', '', '', '', '', '1728128257');

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
('17', '', '', 'QIVSYC', 'uploads/ijerph-17-09481-g001.jpg', '2024-10-04 13:04:07');

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
('', '', '', 'test', 'test', 'test', 'member'),
('', '', '', 'admintest', 'admintest', 'admintest', 'admin'),
('123', '123', '123', '123', '123', '123', 'admin');

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
('EOLWXI', 'graf', 'graf', 'Event', '', 1, 'yes'),
('QIVSYC', 'kucing', 'kucing', 'Event', 'Lifetime', 1, 'yes'),
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
('1727617730', '0', 'abc', '', 'Male', '0132017340', 'fa@gmail.com', '2020-02-19', '2024-05-20'),
('1727618092', '0', 'abc', '', 'Male', '0132017340', 'fa@gmail.com', '2020-02-19', '2024-05-20'),
('1727618166', '0', 'abc', '', 'Male', '0132017340', 'fa@gmail.com', '2020-02-19', '2024-05-20'),
('1727618190', '0', 'abc', '', 'Male', '0132017340', 'fa@gmail.com', '2020-02-19', '2024-05-20'),
('1727621287', '0', 'abc', '', 'Male', '0132017340', 'fa@gmail.com', '2020-10-10', '2024-02-01'),
('1727621728', '0', 'Muhammad Farhan bin Samil', 'Muhammad Farhan bin Samil', 'Male', '0196340894', 'farhansamilme@gmail.com', '2004-12-28', '2024-09-10'),
('1727665527', '0', 'johan', '', 'Male', '019', 'johan@gmail.com', '2020-09-07', '2024-09-08'),
('1728121956', '0', 'test', 'test', 'Male', '012323232', 'fa@gmail.com', '', '2024-09-20'),
('1728128062', 'UUID()', 'Muhammad Farhan bin Samil', 'Muhammad Farhan bin Samil', 'Male', '0196340894', 'farhansamilme@gmail.com', '', '2024-01-20'),
('1728128066', 'UUID()', 'abc', 'abc', 'Male', '012323232', 'farhansamilme2@gmail.com', '', '2024-01-20'),
('1728128257', 'UUID()', 'Muhammad Farhan bin Samil', 'Muhammad Farhan bin Samil', 'Male', '0196340894', 'farhansamilme@gmail.com', '', '2022-02-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageid`);

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
