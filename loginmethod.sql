-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 09:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginmethod`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `Pass_word` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(255) NOT NULL,
  `user_profile_picture` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `user_email`, `Pass_word`, `firstname`, `lastname`, `birthday`, `sex`, `user_profile_picture`, `account_type`) VALUES
(95237, 'Kaelpogi', 'Z@gmail.com', '$2y$10$T.hkaOzdb2vqJzcqEHwo/OIwUdujnvPTvuoOegJWjIxJytWqmd5kO', 'Kayel', 'Latayan', '2003-07-22', 'Female', 'uploads/kayelpic_1716345627.jpg', 1),
(95238, 'Kayel', 'KateLatayan22@gmail.com', '$2y$10$WMUaKCwzZi8pAWtozwQ33O8iAUIwlADmehVsnq9mhbxSXHtvr6Y6y', 'Kayel', 'pogi', '2004-07-22', 'Male', 'uploads/850ba0ab-bb30-48b9-b26a-5c5adb12c847.jpg', 0),
(95239, 'eka', 'KateLatayan22@gmail.com', '$2y$10$95RIzL5pB44p8UGlN53gWuttdDZSQsGKsXOD.4h5m8uKAPm72JRUq', 'eka', 'yanto', '2004-06-18', 'Female', 'uploads/download.jpg', 1),
(95240, 'kael', '', 'Password@01', 'kael', 'libao', '2009-03-22', 'female', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `user_add_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `user_add_street` varchar(255) DEFAULT NULL,
  `user_add_barangay` varchar(255) DEFAULT NULL,
  `user_add_city` varchar(255) DEFAULT NULL,
  `user_add_province` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`user_add_id`, `UserID`, `user_add_street`, `user_add_barangay`, `user_add_city`, `user_add_province`) VALUES
(19, 95237, 'Sitio Bauan', 'quilo-quilo south', 'batangas ', 'Padre Garcia '),
(20, 95238, 'dyanlangtasatabi', 'East Poblacion', 'Rizal', 'Region IV-A (CALABARZON)'),
(21, 95239, 'sitiokanluran', 'Maugat west', 'Batangas ', 'Batangas ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`user_add_id`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95241;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `user_add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
