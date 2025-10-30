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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `SecurityQ1` varchar(255) NOT NULL,
  `SecurityQ2` varchar(255) NOT NULL,
  `SecurityQ3` varchar(255) NOT NULL,
  `review_stars` int(1) NOT NULL,
  `review_text` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `Password`, `Email`, `SecurityQ1`, `SecurityQ2`, `SecurityQ3`, `review_stars`, `review_text`) VALUES
(5, 'Hassan', '$2y$10$XrVPrCvB/rxJQMgT6RuLEOTcp.ji6uY385E538VTq1nUYNL7IVBsa', 'Hassan@gmail.com', 'Sakamoto', 'Sakamoto', 'Sakamoto', 1, 'The best website ever made. '),
(6, 'Alkhamis', '$2y$10$qiMMFycEXBXA.AAhLT7QH.JfT2AFmlq4t6gMy3wuiIVWB7KO9zicW', 'hmmlm78@gmail.com', 'Alkhamis', 'Alkhamis', 'Alkhamis', 5, 'test'),
(7, 'yes', '$2y$10$Xg0DOGSiRikBAlSpFnqeVODO0U3baN1YQGo27A6VOoRxAH/ZKjpfm', 'yes@gmail.com', 'Alkhamis', 'Alkhamis', 'Alkhamis', 3, 'test'),
(8, 'test', '$2y$10$cNC9xYNY5vMCW5mAgkP8POend9mJ6h7ivpb4rv2b9WxoY2bMDQj72', 'test@gmail.com', 'Alkhamis', 'Alkhamis', 'Alkhamis', 0, NULL),
(9, 'Moto', '$2y$10$sn/MNlJME7tsQ.KnWtLQAOa6YEg6lJzvsnxsPjeRGYx4YkFRLYGNi', 'Moto@gmail.com', 'd', 'd', 'd', 2, 'test'),
(10, 'me', '$2y$10$Ymv1ZdIKFoYtTYzZiC9SX.8QK7Qo/ZkUEZm2oEFns2jCWy8X6SVru', 'me@gmail.com', 'k', 'k', 'k', 1, 'Testing'),
(11, 'temp', '', 'tempmail101999@gmail.com', '', '', '', 0, NULL),
(12, 'draw 6', '', 'drawhse6@gmail.com', '', '', '', 5, 'The name is hassan '),
(13, 'fdssdf', '$2y$10$DGMVJdDCOwbBhbvZJ74jtu/DOZx1U5M04eeJN3JikK/7AXqmzThxq', 'dfssdf@gmail.com', 'dfs', 'fds', 'dfs', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
