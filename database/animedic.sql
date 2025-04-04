-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 04:30 PM
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
-- Database: `animedic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(8) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(2, 'abcmalaria@admin.com', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `appointment_num` int(9) NOT NULL,
  `appointment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `user_id` int(8) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `age` int(8) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `cnumber` int(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verification_token` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=not\r\n1=yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`user_id`, `fname`, `lname`, `age`, `gender`, `cnumber`, `password`, `email`, `verification_token`, `email_verified_at`, `verify_status`) VALUES
(55, 'Gyan ', 'Gee', 21, 'Male', 2147483647, '$2y$10$YMNfqXEpLX9u1XJljFf1oua2Un5J4Q1c4TdzJrYf1JJumw6fKT2CS', 'almanonsinb@gmail.com', '2da8148f517456b28e9f1c4aa6ec9576', '2025-04-04 14:20:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_data`
--

CREATE TABLE `vaccination_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bitten_by` varchar(255) DEFAULT NULL,
  `date_exposure` date DEFAULT NULL,
  `date_treatment` date DEFAULT NULL,
  `vaccine` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `D0_date` date DEFAULT NULL,
  `D0_site` varchar(255) DEFAULT NULL,
  `D0_given` varchar(255) DEFAULT NULL,
  `D3_date` date DEFAULT NULL,
  `D3_site` varchar(255) DEFAULT NULL,
  `D3_given` varchar(255) DEFAULT NULL,
  `D7_date` date DEFAULT NULL,
  `D7_site` varchar(255) DEFAULT NULL,
  `D7_given` varchar(255) DEFAULT NULL,
  `D14_date` date DEFAULT NULL,
  `D14_site` varchar(255) DEFAULT NULL,
  `D14_given` varchar(255) DEFAULT NULL,
  `D28_date` date DEFAULT NULL,
  `D28_site` varchar(255) DEFAULT NULL,
  `D28_given` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccination_data`
--

INSERT INTO `vaccination_data` (`id`, `user_id`, `bitten_by`, `date_exposure`, `date_treatment`, `vaccine`, `brand_name`, `route`, `D0_date`, `D0_site`, `D0_given`, `D3_date`, `D3_site`, `D3_given`, `D7_date`, `D7_site`, `D7_given`, `D14_date`, `D14_site`, `D14_given`, `D28_date`, `D28_site`, `D28_given`) VALUES
(9, 55, 'Cat', '2025-04-04', '2025-05-10', 'PCEC', 'Alvin', 'Intradermal', '2025-04-04', 'ygigbiyh', 'hyihbikhbik', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vaccination_data`
--
ALTER TABLE `vaccination_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vaccination_data`
--
ALTER TABLE `vaccination_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `patient` (`user_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `patient` (`user_id`);

--
-- Constraints for table `vaccination_data`
--
ALTER TABLE `vaccination_data`
  ADD CONSTRAINT `vaccination_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `patient` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
