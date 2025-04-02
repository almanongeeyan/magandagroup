-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 10:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(31, 'gee', 'gee', 21, 'Male', 2147483647, '$2y$10$y1gqNuQQjNZlRrhAwVOt7eY/fjwtZJQ4Esb7EZ4rCpmDaSOetdDMG', 'almanonsinb@gmail.com', '3c74933856ee7d63e69fdb1322c1c4ca', '2025-04-01 00:40:57', 1),
(32, 'Jane', 'Aberin', 21, 'Female', 2147483647, '$2y$10$ukLgMv8YfhAUhD.G0JDUPucEkpioMY6s.p5jX7iAcwC6CZ2aZQvkK', 'cholenejaneaberin@gmail.com', '66a612e8f3bb9dee2b44a4f8bd0096d9', '2025-04-01 14:36:52', 1),
(33, 'Geeyan', 'Agustin', 21, 'Male', 2147483647, '$2y$10$iL6fKtQytuQDwna5/YMW/.n0YT4.vcRYrkAP0Q3kETqI9WtfHusp6', 'me.cholenejane@gmail.com', '6f51f9b79639349a5ac7fdb708c29da4', '2025-04-01 15:13:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_exposure_sched`
--

CREATE TABLE `post_exposure_sched` (
  `post_exposure_id` int(11) NOT NULL,
  `vax_sched` datetime(6) NOT NULL,
  `vax_taken` datetime(6) NOT NULL,
  `clinician` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_exposure_sched`
--

CREATE TABLE `pre_exposure_sched` (
  `pre_exposure_id` int(11) NOT NULL,
  `vax_sched` datetime(6) NOT NULL,
  `vax_taken` datetime(6) NOT NULL,
  `vax_place` varchar(255) NOT NULL,
  `clinician` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `vax_id` int(11) NOT NULL,
  `pre_exposure_id` int(11) NOT NULL,
  `post_exposure_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccination`
--

CREATE TABLE `vaccination` (
  `vax_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exposure_category` int(11) NOT NULL,
  `exposure_date` datetime(6) NOT NULL,
  `start_treatment` datetime(6) NOT NULL,
  `vax_used` varchar(255) NOT NULL,
  `vax_brand` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `erig_used` varchar(255) NOT NULL,
  `hrig_used` varchar(255) NOT NULL,
  `tetanus_toxiod` varchar(255) NOT NULL,
  `ats_units` float NOT NULL,
  `ats_vax_place` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `post_exposure_sched`
--
ALTER TABLE `post_exposure_sched`
  ADD PRIMARY KEY (`post_exposure_id`);

--
-- Indexes for table `pre_exposure_sched`
--
ALTER TABLE `pre_exposure_sched`
  ADD PRIMARY KEY (`pre_exposure_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD UNIQUE KEY `pre_exposure_id` (`pre_exposure_id`),
  ADD UNIQUE KEY `post_exposure_id` (`post_exposure_id`),
  ADD UNIQUE KEY `vax_id` (`vax_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD PRIMARY KEY (`vax_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`vax_id`) REFERENCES `vaccination` (`vax_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`post_exposure_id`) REFERENCES `post_exposure_sched` (`post_exposure_id`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`pre_exposure_id`) REFERENCES `pre_exposure_sched` (`pre_exposure_id`);

--
-- Constraints for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD CONSTRAINT `vaccination_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
