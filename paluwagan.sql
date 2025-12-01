-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 05:31 PM
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
(6, 'Transaction: Deposit', 'You Deposited: ₱10000', '2025-12-01 23:46:42', 37),
(7, 'Transaction: Deposit', 'You Deposited: ₱5000', '2025-12-01 23:47:22', 33),
(8, 'Transaction: Deposit', 'You Deposited: ₱100', '2025-12-01 23:50:28', 35);

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
(25, 'Baiiii', 6, '2025-12-01', 35),
(26, 'Lilam Group', 6, '2025-12-01', 37),
(27, 'Pouf', 6, '2025-12-01', 33);

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
-- Table structure for table `join_requests`
--

CREATE TABLE `join_requests` (
  `request_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `date_time_requested` datetime NOT NULL,
  `message` text NOT NULL
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
(33, 'Abelarde', 'Ocede Marl', 'Cabanero', 'Maribong', 'Lambunao', 'Iloilo', 'abelarde@gmail.com', '$2y$10$vwiEe0HSotpgZzNENL/3b./dpRFVNiF3qum0PxajhutCNlGxPA0RK', 'C:\\fakepath\\After Auto deleteion.png', '09293853759', 27),
(34, 'Recabar', 'Angel Rose', 'Cedazo', 'Brgy. Guadalupe', 'Janiuay', 'Iloilo', 'recabar@gmail.com', '$2y$10$NAfYqoYwGY/o/.7OQ.ndyey01XFKIaFJBuGaNrvKhwXUui9pYRQs6', 'C:\\fakepath\\Screenshot 2025-08-30 090132.png', '09193056854', 25),
(35, 'Casaquite', 'Kenneth', 'Alfonso', 'Sibacungan', 'Lambunao', 'Iloilo', 'casaquite@gmail.com', '$2y$10$VYyrwqCICZlvf.gCA5Y4ieL8j.K3npS829KQZ5KHnsJx/kNBAN9IC', 'C:\\fakepath\\After Auto deleteion.png', '09380952768', 25),
(36, 'Gimeno', 'Sean Ivan', 'Andales', 'Manaolan', 'Badiangan', 'Iloilo', 'gimeno@gmail.com', '$2y$10$qTVYxAokvWPelCEpNynEveACDF1Z/AnoQdSPdk3tEskZYuq6HCT7i', 'C:\\fakepath\\Screenshot 2025-07-11 094633.png', '09483951095', 25),
(37, 'Arana', 'Cathlene Ann', 'Lilam', 'Capangyan', 'Lambunao', 'Iloilo', 'arana@gmail.com', '$2y$10$.TO1nia6pGT0R1ntVSJEqunDnmoxG3pQCd.PEp12ijCD8gYpyTfCm', 'C:\\fakepath\\Screenshot 2025-08-30 090132.png', '09681920953', 26),
(38, 'test', 'test', 'test', 'test', 'test', 'test', 'test@test.com', '$2y$10$jKE79V38HOUSGq5PEjUlHeBAv9MTVIlIVfelsY9DH9mUSbeBUzaoK', 'C:\\fakepath\\Screenshot 2025-07-11 094633.png', '09032849941', 25),
(39, 'test2', 'test2', 'test2', 'test', 'test', 'test', 'test2@test.com', '$2y$10$rDjyqvI8c5EbTeA2ZU3GAeo8igxzM/F5Uns16DH4rkg2fbihhVib.', 'C:\\fakepath\\Screenshot 2025-08-30 090132.png', '09032849941', NULL),
(40, 'test3', 'test3', 'test3', 'test', 'test', 'test', 'test3@test.com', '$2y$10$K1Fgcf44E1zobDG7gOr8BOrZdrbc7VYHdYseDtjhOo7wCSXcWNVla', 'C:\\fakepath\\Screenshot 2025-07-11 094633.png', '09032849941', NULL),
(41, 'Solanib', 'Jan Kennard', 'Gadong', 'Pob. Ilawod', 'Bingawan', 'Iloilo', 'solanib@gmail.com', '$2y$10$Y1vTstVVJgrlqWpy8pQe/euVtH36qI3eSi7lk0u9gE1H7EFmGgBZC', 'C:\\fakepath\\Screenshot 2025-08-29 195411.png', '09093480923', NULL);

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
(1, 36, 'You are invited to join a group!', 1, '2025-12-01 16:27:16'),
(2, 34, 'You are invited to join a group!', 1, '2025-12-01 16:27:16'),
(3, 38, 'You are invited to join a group!', 1, '2025-12-01 16:27:16'),
(4, 39, 'You are invited to join a group!', 1, '2025-12-01 16:27:16'),
(5, 40, 'You are invited to join a group!', 1, '2025-12-01 16:28:02'),
(6, 41, 'You are invited to join a group!', 0, '2025-12-01 16:32:20'),
(7, 35, 'Someone wants to join your group', 1, '2025-12-01 23:34:36'),
(8, 34, 'The leader accepted your join request', 1, '2025-12-01 23:34:47'),
(9, 34, 'Withdrawal ready', 1, '2025-12-01 23:42:21'),
(10, 35, 'Withdrawal ready', 1, '2025-12-01 23:44:29');

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
(6, 'Deposit', '2025-12-01 23:46:42', 10000, 37, 26),
(7, 'Deposit', '2025-12-01 23:47:22', 5000, 33, 27),
(8, 'Deposit', '2025-12-01 23:50:28', 100, 35, 25);

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
-- Indexes for table `join_requests`
--
ALTER TABLE `join_requests`
  ADD PRIMARY KEY (`request_id`);

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
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `group_invitations`
--
ALTER TABLE `group_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `group_rotation`
--
ALTER TABLE `group_rotation`
  MODIFY `rotation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `join_requests`
--
ALTER TABLE `join_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rotation_schedule`
--
ALTER TABLE `rotation_schedule`
  MODIFY `rotation_schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL;

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
