-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 06:54 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `logs_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date_time_created` datetime NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`logs_id`, `title`, `description`, `date_time_created`, `member_id`) VALUES
(1, 'Transaction: Deposit', 'You Deposited: ₱2000', '2025-11-30 09:56:06', 22);

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
  `date_created` date NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_capacity`, `date_created`, `creator_id`) VALUES
(19, 'Banog', 6, '2025-10-24', 22),
(21, 'Lilam\'s Group', 6, '2025-11-14', 24);

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

-- --------------------------------------------------------

--
-- Table structure for table `group_rotation`
--

CREATE TABLE `group_rotation` (
  `rotation_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `current_member_id` int(11) NOT NULL,
  `rotation_status` text NOT NULL,
  `total_pot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(22, 'Casaquite', 'Kenneth', 'Alfonso', 'Sibacungan', 'Lambunao', 'Iloilo', 'casaquitekenneth@gmail.com', '$2y$10$wPrt32jCs1vLMZZIFkBPY.6Aoq5x9Ev3Cw15.FNJmmZn7xdAwaW22', 'C:\\fakepath\\download (4).jpg', '09621848506', 19),
(23, 'Gimeno', 'Sean Ivan', 'Andales', 'Manaolan', 'Badiangan', 'Iloilo', 'gimeno@gmail.com', '$2y$10$VPQG5O9kRfU9nx6xkcCj8.ymCHb.dLhePKK3YU4G2I6IAJzJBdFTO', 'C:\\fakepath\\download (3).jpg', '09123456789', 19),
(24, 'Arana', 'Cathlene Ann', 'Lilam', 'Corot-on', 'Lambunao', 'Iloilo', 'arana@gmail.com', '$2y$10$OtJ5o5KJYz1GocsQO1WNVOjzDVfCHCFwuVG0JF7uyrCK/0CKJ36sm', 'C:\\fakepath\\Screenshot 2025-09-27 235451.png', '09112223333', 21),
(25, 'Bay', 'na', 'bay', 'BAY', 'bay', 'bay', 'baybay@gmail.com', '$2y$10$SNbpWJxHhS5/pOqywzWiVOYxWEqSHBzkbMVodKhZ9TJUs0ldkQVVu', 'C:\\fakepath\\images (2).jpg', '03949139123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `date_time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `member_id`, `description`, `is_read`, `date_time_created`) VALUES
(1, 23, 'You are invited to join a group!', 1, '2025-11-13 13:18:25'),
(2, 23, 'You are invited to join a group!', 1, '2025-11-13 14:19:54'),
(3, 23, 'You are invited to join a group!', 1, '2025-11-13 14:27:45'),
(4, 23, 'You are invited to join a group!', 1, '2025-11-14 06:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `rotation_schedule`
--

CREATE TABLE `rotation_schedule` (
  `rotation_schedule_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `assigned_month` date NOT NULL,
  `status` varchar(25) NOT NULL,
  `to_withdraw` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `transaction_type` varchar(155) NOT NULL,
  `transaction_date_time` datetime NOT NULL,
  `amount` float NOT NULL,
  `member_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_type`, `transaction_date_time`, `amount`, `member_id`, `group_id`) VALUES
(1, 'Deposit', '2025-11-30 09:56:06', 2000, 22, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`logs_id`),
  ADD KEY `member_id` (`member_id`);

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
-- Indexes for table `group_rotation`
--
ALTER TABLE `group_rotation`
  ADD PRIMARY KEY (`rotation_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `member_ibfk_1` (`group_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `rotation_schedule`
--
ALTER TABLE `rotation_schedule`
  ADD PRIMARY KEY (`rotation_schedule_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `group_invitations`
--
ALTER TABLE `group_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `group_rotation`
--
ALTER TABLE `group_rotation`
  MODIFY `rotation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rotation_schedule`
--
ALTER TABLE `rotation_schedule`
  MODIFY `rotation_schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);

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

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
