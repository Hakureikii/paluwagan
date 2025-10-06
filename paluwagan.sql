-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2025 at 12:54 PM
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
-- Database: `paluwagan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(25) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password_hash`, `admin_id`) VALUES
('admin', '$2y$10$Jl97c62SfukTq2L8edjKfuNCd1roVm9wpjIgGz2v9Jcd3VD4LVhyC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_capacity` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_capacity`, `creator_id`) VALUES
(13, 'Baithon', 6, 17);

-- --------------------------------------------------------

--
-- Table structure for table `group_invitations`
--

CREATE TABLE `group_invitations` (
  `invitation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_invitations`
--

INSERT INTO `group_invitations` (`invitation_id`, `sender_id`, `reciever_id`, `group_id`) VALUES
(3, 17, 19, 13);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `credentials` varchar(100) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `last_name`, `first_name`, `middle_name`, `barangay`, `municipality`, `province`, `email`, `password`, `credentials`, `contact_number`, `group_id`) VALUES
(1, 'asdfsdaf', 'fsdsfsdaf', 'sdasfdsaf', 'dsfsdaf', 'sdafsddfsdf', 'sadfsdafsdf', 'asdfsdfsdaf', '$2y$10$3trdIkptQX/wedI/SvQ2VOKgtly3yMW4imP8yzcYxp3PbDtXRq2se', 'C:\\fakepath\\Paper_Big_Data_and_Analytics_Adoption_Intention_in_SMEs_2025.pdf', '234234', NULL),
(11, 'bai', 'bai', 'bai', 'bai', 'bai', 'bai', 'bai@gmail.com', '$2y$10$7toWc6nh1aK7Rbv9XD./yuR9u1zxOxg7MWBTgRcwoQwsCP5w7gI4q', 'C:\\fakepath\\Screenshot 2025-10-02 160847.png', '09987654321', NULL),
(12, 'sakjdfh', 'sahfkash', 'sajshfksjh', 'asfhkasfh', 'safhsakdfh', 'askfhskadh', 'bai@gmail.com', '$2y$10$sLSgqYTsdXu4VNtTQr/GEOoqo6dxzUgdJMM4Tf9EjDBstvzuyUZ4a', 'C:\\fakepath\\Screenshot 2025-10-02 181416.png', '0998764321', NULL),
(17, 'Casaquite', 'Kenneth', 'Alfonso', 'Brgy. Sibacungan', 'Lambunao', 'Iloilo', 'casaquitekenneth@gmail.com', '$2y$10$Hv1l9eF5OYYzRV/K1OXx6ONtgIz9GHky/YMOR6RFTz99RhzBXHsA6', 'C:\\fakepath\\responsive.png', '09123456789', 13),
(18, 'Gimeno', 'Sean Ivan', 'Andales', 'Brgy. Basta', 'Badiangan', 'Iloilo', 'seanivandoks@gmail.com', '$2y$10$/InXCxkaBWPaD8Tja1qZn.wq6D8xISmNVLte5UbVfUJ.52ic6Ydym', 'C:\\fakepath\\Screenshot 2025-10-05 183005.png', '09987654321', 13),
(19, 'Solanib', 'Jan Kennard', 'Gadong', 'Pob Ilawod', 'Bingawan', 'Iloilo', 'imKENN@gmail.com', '$2y$10$/UfnJ5O4Nirhu9dH65Rvn.PO0Gq//czftyx31LXd2NSTWMRPXLFvG', 'C:\\fakepath\\Screenshot 2025-10-02 181416.png', '09111111111', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `groups_ibfk_1` (`creator_id`);

--
-- Indexes for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD PRIMARY KEY (`invitation_id`),
  ADD KEY `reciever_id` (`reciever_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `group_invitations_ibfk_1` (`group_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `member_ibfk_1` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `group_invitations`
--
ALTER TABLE `group_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD CONSTRAINT `group_invitations_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `group_invitations_ibfk_2` FOREIGN KEY (`reciever_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `group_invitations_ibfk_3` FOREIGN KEY (`sender_id`) REFERENCES `member` (`member_id`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
