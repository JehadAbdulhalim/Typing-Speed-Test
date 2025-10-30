-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 11:22 AM
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
-- Database: `login form`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `wpm` int(11) NOT NULL,
  `playtime` int(11) NOT NULL,
  `played_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `user_name`, `wpm`, `playtime`, `played_at`) VALUES
(3, 'Alkhamis', 56, 15, '2024-12-12 20:00:29'),
(4, 'Alkhamis', 10, 30, '2024-12-12 20:01:10'),
(5, 'yes', 48, 15, '2024-12-13 11:56:53'),
(6, 'yes', 0, 15, '2024-12-13 12:00:16'),
(8, 'yes', 52, 30, '2024-12-13 14:07:54'),
(9, 'yes', 42, 60, '2024-12-13 14:09:25'),
(11, 'Alkhamis', 48, 15, '2024-12-14 11:08:35'),
(12, 'Hassan', 60, 15, '2024-12-14 12:22:25'),
(13, 'Hassan', 64, 15, '2024-12-14 12:22:56'),
(14, 'Moto', 4, 15, '2024-12-14 15:00:29'),
(15, 'Alkhamis', 64, 15, '2024-12-14 16:03:26'),
(16, 'Alkhamis', 48, 15, '2024-12-14 16:04:15'),
(17, 'me', 56, 15, '2024-12-15 11:39:10'),
(18, 'me', 48, 15, '2024-12-15 11:39:34'),
(19, 'draw 6', 36, 15, '2024-12-15 12:47:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `users` (`user_name`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
