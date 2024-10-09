-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 09, 2024 at 05:18 PM
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
('admintest', 'admintest', 'admintest1', 'admintest', 'admintest');

-- --------------------------------------------------------

--
-- Table structure for table `enrolls_to`
--

CREATE TABLE `enrolls_to` (
  `et_id` int(100) NOT NULL,
  `planid` varchar(8) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `paid_date` varchar(40) NOT NULL,
  `expire` varchar(40) NOT NULL,
  `hasPaid` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolls_to`
--

INSERT INTO `enrolls_to` (`et_id`, `planid`, `userid`, `paid_date`, `expire`, `hasPaid`) VALUES
(29, 'XTWIOL', '1728384120', '2024-10-08 19:00:28', '2024-11-08 19:00:28', 'yes'),
(30, 'XTWIOL', '1728384510', '2024-10-09 22:49:29', '9999-12-31', 'yes'),
(31, 'XTWIOL', '1728433989', '2024-10-09 22:49:23', '9999-12-31', 'yes'),
(32, 'XTWIOL', '1728485531', '2024-10-09 22:53:27', '9999-12-31', 'yes'),
(33, 'XTWIOL', '1728486893', '2024-10-09 23:16:58', '9999-12-31', 'yes');

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
('17580962', '', '', '', '', '', '1728485531'),
('38888806', '', '', '', '', '', '1728384510'),
('46800272', '', '', '', '', '', '1728433989'),
('575478311', '', '', '', '', '', '1728486893'),
('826633186', '', '', '', '', '', '1728383471'),
('826677281', '', '', '', '', '', '1728384120');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageid` varchar(200) NOT NULL,
  `adminid` varchar(20) NOT NULL DEFAULT '0',
  `userid` varchar(20) NOT NULL DEFAULT '0',
  `planid` varchar(8) NOT NULL DEFAULT '0',
  `image_path` varchar(255) DEFAULT 'placeholder.jpg',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageid`, `adminid`, `userid`, `planid`, `image_path`, `uploaded_at`) VALUES
('01131e80-8562-11ef-b414-3ca067e52da9', '0', '1728384120', '0', NULL, '2024-10-08 10:42:24'),
('0cccfde9-848c-11ef-94ce-3ca067e52da9', '0', '1728292246', '0', 'uploads/user_profile/a9d7ddf79f8967ef8ed2cccd10112606.jpg', '2024-10-07 09:10:53'),
('10da5ba0-8499-11ef-83d3-3ca067e52da9', '0', '1728297797', '0', NULL, '2024-10-07 10:44:01'),
('1c5ba1ce-85d6-11ef-bb7d-e9097018277d', '0', '1728433989', '0', NULL, '2024-10-09 00:33:31'),
('23aa5175-864e-11ef-a918-3ca067e52da9', '0', '1728485531', '0', NULL, '2024-10-09 14:52:43'),
('3100ac59-839d-11ef-8354-3ca067e52da9', '0', '1728189648', '0', 'uploads/user_profile/ijerph-17-09481-g001.jpg', '2024-10-06 04:41:02'),
('54f860aa-8651-11ef-a918-3ca067e52da9', '0', '1728486893', '0', NULL, '2024-10-09 15:15:34'),
('797b4815-8560-11ef-b414-3ca067e52da9', '0', '1728383471', '0', NULL, '2024-10-08 10:31:27'),
('833c3b18-8489-11ef-94ce-3ca067e52da9', '0', '1728291151', '0', 'uploads/user_profile/cb29fd18a62485da33431fb6500f0439.jpg', '2024-10-07 08:52:43'),
('931bb42d-8490-11ef-94ce-3ca067e52da9', '0', '1728294194', '0', NULL, '2024-10-07 09:43:16'),
('9566be7b-83a5-11ef-8354-3ca067e52da9', 'admintest', '0', '0', 'uploads/a9d7ddf79f8967ef8ed2cccd10112606.jpg', '2024-10-06 05:41:07'),
('9746d457-83a6-11ef-8354-3ca067e52da9', '1234', '0', '0', 'uploads/a9d7ddf79f8967ef8ed2cccd10112606.jpg', '2024-10-06 05:48:19'),
('dd2da44c-8562-11ef-b414-3ca067e52da9', '0', '1728384510', '0', NULL, '2024-10-08 10:48:33'),
('f245b3cb-848a-11ef-94ce-3ca067e52da9', '0', '1728291773', '0', 'uploads/user_profile/output-onlinepngtools.png', '2024-10-07 09:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `loginid` varchar(200) NOT NULL,
  `adminid` varchar(20) DEFAULT NULL,
  `userid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass_key` varchar(20) NOT NULL,
  `securekey` varchar(200) NOT NULL,
  `authority` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginid`, `adminid`, `userid`, `username`, `pass_key`, `securekey`, `authority`) VALUES
('0110b27d-8562-11ef-b414-3ca067e52da9', NULL, '1728384120', 'b', 'test1', '0110b2d2-8562-11ef-b414-3ca067e52da9', 'member'),
('10d89236-8499-11ef-83d3-3ca067e52da9', NULL, '1728297797', 'test', 'test', '10d89278-8499-11ef-83d3-3ca067e52da9', 'member'),
('123', '123', '123', '123', '123', '123', 'admin'),
('12345', '1234', 'admintest', 'admintest', 'admintest', 'admintest', 'admin'),
('1c5aa59d-85d6-11ef-bb7d-e9097018277d', NULL, '1728433989', 'q', 'q', '1c5aa65f-85d6-11ef-bb7d-e9097018277d', 'member'),
('23a7f823-864e-11ef-a918-3ca067e52da9', NULL, '1728485531', 'h', 'h', '23a7f891-864e-11ef-a918-3ca067e52da9', 'member'),
('54f7108e-8651-11ef-a918-3ca067e52da9', NULL, '1728486893', 'a', 'a', '54f7114d-8651-11ef-a918-3ca067e52da9', 'member'),
('7979b578-8560-11ef-b414-3ca067e52da9', NULL, '1728383471', 'c', 'c', '7979b628-8560-11ef-b414-3ca067e52da9', 'member'),
('dd2cca64-8562-11ef-b414-3ca067e52da9', NULL, '1728384510', 'a', 'a', 'dd2ccab9-8562-11ef-b414-3ca067e52da9', 'member'),
('test', 'test', '1728121956', '1728121956', 'test', 'test', 'member');

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
('ENVCLG', 'practice', 'practice', 'Event', 'Lifetime', 20, 'yes'),
('XTWIOL', 'Karate Activities', 'This includes all karate activity plan', 'Core', '1', 20, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sports_timetable`
--

CREATE TABLE `sports_timetable` (
  `tid` varchar(45) NOT NULL,
  `tname` varchar(45) NOT NULL,
  `day1` varchar(200) NOT NULL,
  `day2` varchar(200) NOT NULL,
  `day3` varchar(200) NOT NULL,
  `day4` varchar(200) NOT NULL,
  `day5` varchar(200) NOT NULL,
  `day6` varchar(200) NOT NULL,
  `pid` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_timetable`
--

INSERT INTO `sports_timetable` (`tid`, `tname`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `pid`) VALUES
('b764ef36-862b-11ef-a53d-3ca067e52da9', 'practice', 'practice', 'practice', 'practice', 'practice', 'practice', 'practice', 'BJEFSY');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass_key` varchar(50) NOT NULL,
  `role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `name`, `username`, `pass_key`, `role`) VALUES
('1', 'Rashid Rahman', 'Rashid', '123456', 'coach');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(20) NOT NULL,
  `pass_key` varchar(100) NOT NULL,
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

INSERT INTO `users` (`userid`, `pass_key`, `imageid`, `username`, `fullName`, `gender`, `mobile`, `email`, `dob`, `joining_date`) VALUES
('1728486893', 'a', 'UUID()', 'a', 'a', 'Male', '1', 'a@gmail.com', '', '2024-02-29');

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
-- Indexes for table `enrolls_to`
--
ALTER TABLE `enrolls_to`
  ADD PRIMARY KEY (`et_id`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrolls_to`
--
ALTER TABLE `enrolls_to`
  MODIFY `et_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
