-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 11:25 PM
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
-- Database: `support_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','Resolved','Escalated','Closed') NOT NULL DEFAULT 'Open',
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `subject`, `description`, `status`, `username`, `created_at`, `resolved_at`) VALUES
(1, 'Issue with Login', 'Cannot log in to the system', 'Open', 'user1', '2024-10-08 20:14:40', NULL),
(2, 'System Crash', 'System crashes when trying to submit a form', 'Open', 'user2', '2024-10-08 20:14:40', '2024-10-09 13:26:50'),
(3, 'Slow Performance', 'The system is slow during peak hours', 'Open', 'user1', '2024-10-08 20:14:40', '2024-10-12 14:35:25'),
(4, 'Email Not Sent', 'Support emails are not being sent', 'Open', 'user1', '2024-10-08 20:14:40', NULL),
(5, 'Dashboard Bug', 'Dashboard is not displaying the ticket count properly', 'Resolved', 'user1', '2024-10-08 20:14:40', '2024-10-09 13:27:21'),
(6, 'Login Issue', 'Cannot log in to the system', 'Open', 'user1', '2024-10-09 10:14:46', NULL),
(7, 'Slow Performance', 'The system is running slow during peak hours', 'Open', 'user1', '2024-10-09 10:14:46', NULL),
(8, 'Email Issue', 'Emails are not being sent out to customers', 'Resolved', 'user2', '2024-10-09 10:14:46', NULL),
(9, 'Bug in Dashboard', 'Dashboard does not display data correctly', 'Closed', 'user2', '2024-10-09 10:14:46', NULL),
(10, 'Payment Failure', 'Payment gateway is not processing transactions', 'Resolved', 'user2', '2024-10-09 10:14:46', '2024-10-09 11:11:01'),
(11, 'Page Not Loading', 'The support page fails to load', 'Escalated', 'user1', '2024-10-09 10:14:46', NULL),
(12, 'Feature Request', 'Request to add a new feature for user settings', 'Escalated', 'user1', '2024-10-09 10:14:46', NULL),
(13, 'Data Sync Issue', 'Data is not syncing between server and client', 'Escalated', 'user2', '2024-10-09 10:14:46', NULL),
(15, 'something\'s broken lol', 'fix it', 'Escalated', 'user1', '2024-10-09 11:01:51', NULL),
(16, 'Issue with login', 'Unable to log in to my account', 'Open', 'mannuel', '2024-10-14 18:09:23', NULL),
(17, 'Feature request', 'Would like a dark mode feature', 'Escalated', 'mannuel', '2024-10-14 18:09:23', NULL),
(18, 'Bug in dashboard', 'The dashboard shows an incorrect number of tickets', 'Resolved', 'mannuel', '2024-10-14 18:09:23', NULL),
(19, 'Account locked', 'My account got locked after failed attempts', 'Closed', 'mannuel', '2024-10-14 18:09:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','tier 1 agent','tier 2 agent') NOT NULL DEFAULT 'user',
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `full_name`, `created_at`) VALUES
(1, 'user1', 'userpassword', 'user', 'User One', '2024-10-08 20:14:40'),
(2, 'agent1', 'agentpassword', 'tier 1 agent', 'Agent One', '2024-10-08 20:14:40'),
(3, 'agent2', 'agentpassword2', 'tier 2 agent', 'Agent Two', '2024-10-08 20:14:40'),
(6, 'user2', 'pass1', 'user', 'emma', '2024-10-08 20:40:48'),
(7, 'mannuel', 'mannuel', 'user', 'Emmanuel Adegbola', '2024-10-14 18:09:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_ticket_user` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
