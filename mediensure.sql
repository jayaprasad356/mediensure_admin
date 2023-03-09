-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2023 at 06:00 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediensure`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Injections', 'upload/categories/7177-2023-02-13.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dental_networks`
--

CREATE TABLE `dental_networks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `oral_xray` text DEFAULT NULL,
  `latitude` text DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `datetime` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Pending-0 |\r\nVerified -1 |\r\nRejected -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dental_networks`
--

INSERT INTO `dental_networks` (`id`, `user_id`, `clinic_name`, `email`, `mobile`, `address`, `oral_xray`, `latitude`, `longitude`, `datetime`, `remarks`, `status`) VALUES
(1, 1, 'Sella Dental Clinic', 'sellandentals56@gmail.com', '6532883013', 'Coimbatore', 'Yes', '70.64674', '14.00393', '2023-03-02 11:14:19', 'hnghfhthth', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_networks`
--

CREATE TABLE `lab_networks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `center_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `center_address` text DEFAULT NULL,
  `operational_hours` text DEFAULT NULL,
  `radiology_test` text DEFAULT NULL,
  `home_visit` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `datetime` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Pending-0 |\r\nVerified -1 |\r\nRejected -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_networks`
--

INSERT INTO `lab_networks` (`id`, `user_id`, `center_name`, `email`, `mobile`, `manager_name`, `center_address`, `operational_hours`, `radiology_test`, `home_visit`, `latitude`, `longitude`, `image`, `datetime`, `remarks`, `status`) VALUES
(1, 1, 'Renuga Lab\'s', 'labrenuga43@gmail.com', '765410921', 'Sri Yogesh', 'Seppakam', '9:00 - 5:00', 'Available', 'Yes', 65.9902, '14.2344', '1677827366.3177.jpg', '2023-02-21 11:16:58', 'Hello', 2);

-- --------------------------------------------------------

--
-- Table structure for table `opd_networks`
--

CREATE TABLE `opd_networks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` text DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `latitude` text DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `datetime` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Pending-0 |\r\nVerified -1 |\r\nRejected -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opd_networks`
--

INSERT INTO `opd_networks` (`id`, `user_id`, `category`, `name`, `address`, `email`, `mobile`, `latitude`, `longitude`, `datetime`, `remarks`, `status`) VALUES
(1, 1, '', 'Vengat Clinic', 'Tambaram,Chennai', 'vengatclinic45@gmail.com', '9076123043', '74.90123', '10.23347', '2023-02-21 11:14:30', 'This is verified', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_networks`
--

CREATE TABLE `pharmacy_networks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `operational_hours` text DEFAULT '',
  `latitude` text DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `datetime` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Pending-0 |\r\nVerified -1 |\r\nRejected -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_networks`
--

INSERT INTO `pharmacy_networks` (`id`, `user_id`, `shop_name`, `address`, `email`, `mobile`, `operational_hours`, `latitude`, `longitude`, `datetime`, `remarks`, `status`) VALUES
(1, 1, 'Lalli Pharmacy', 'Trichy', 'lallispharm@gmail.com', '9787012346', '', '74.09123', '14.00393', '2023-02-20 11:18:05', 'Hi You have addded more than Fifteen Inventories', 2);

-- --------------------------------------------------------

--
-- Table structure for table `radiology_networks`
--

CREATE TABLE `radiology_networks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `center_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `center_address` text DEFAULT NULL,
  `operational_hours` text DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `datetime` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Pending-0 |\r\nVerified -1 |\r\nRejected -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radiology_networks`
--

INSERT INTO `radiology_networks` (`id`, `user_id`, `center_name`, `email`, `mobile`, `manager_name`, `center_address`, `operational_hours`, `latitude`, `longitude`, `image`, `datetime`, `remarks`, `status`) VALUES
(1, 1, 'Vengatash Radilogy Services', 'vengatash7884@gmail.com', '7489099321', 'Jeya', 'Cudalore', '9:00 - 4:00', 74.8744, '14.23123', '1677825966.3226.jpg', '2023-02-28 11:24:37', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'Verified-1 |\r\nNot-verified -0 |\r\nBlocked -2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `status`) VALUES
(1, 'sanjay', '8742443011', 'sanjay3s@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dental_networks`
--
ALTER TABLE `dental_networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_networks`
--
ALTER TABLE `lab_networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_networks`
--
ALTER TABLE `opd_networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_networks`
--
ALTER TABLE `pharmacy_networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radiology_networks`
--
ALTER TABLE `radiology_networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dental_networks`
--
ALTER TABLE `dental_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lab_networks`
--
ALTER TABLE `lab_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opd_networks`
--
ALTER TABLE `opd_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacy_networks`
--
ALTER TABLE `pharmacy_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `radiology_networks`
--
ALTER TABLE `radiology_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
