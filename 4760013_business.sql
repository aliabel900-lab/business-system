-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 05:14 PM
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
-- Database: `business_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `owed` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`id`, `customer_name`, `owed`, `paid`, `status`) VALUES
(4, 'Murithi', NULL, 300.00, 'Unpaid'),
(5, 'Murithi', NULL, 700.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `phone`, `email`, `created_at`) VALUES
(4, 'Grace Manyala', '0789467252', 'barack@gmail.com', '2026-05-15 03:01:52'),
(5, 'victor Muthui', '0112384436', 'victor@gmail.com', '2026-05-15 03:17:37'),
(6, 'Caroline Bahati', '078327623', 'caro@gmail.com', '2026-05-15 04:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `product` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer`, `product`, `status`, `order_date`) VALUES
(10, 'Wisdom', 'flour', 'Completed', '2026-05-15 12:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `product` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `customer`, `product`, `price`, `quantity`, `total`, `sale_date`) VALUES
(5, 'victor kiyau', 'Juice', 22.00, 2, 44.00, '2026-05-15 05:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(2, 'wisdom', '$2y$10$2tcvwurRg2Vw588i2jDP/uW2lONS2YiFtFHmcxQtAhhQAXrtEYLba', 'user', 'active', '2026-05-10 21:14:34'),
(6, 'Susan Muthui', '$2y$10$4Z6CtN7H2lbqbOu9XB3GM.MtPLEhxA/lTMqi1qToJHgPYMU3RRCuK', '', 'active', '2026-05-10 21:43:31'),
(7, 'abel900', '$2y$10$.5K3178s1Hw3X82BEwwsAuBRGD6pKkEtSdUeqqkQRqISR918NZjHm', '', 'active', '2026-05-11 14:03:14'),
(8, 'Ali Juma', '$2y$10$uLxXQpBBCD9VD1IkncPyYudXtI7mXmlSxaQMi6OrPJgISB5dj01xK', '', 'active', '2026-05-11 14:41:52'),
(9, 'wisdom Ali', '$2y$10$.4s8TFAxE7E5CiAUTvexVeoXHN0gznjMs3krrUOaeG0c.hPfiiJHG', '', 'active', '2026-05-11 14:45:04'),
(10, 'Suleah', '$2y$10$Yd8WQ6wOOrWHQ/ZGDHVzRuL6K1TaTYziPWuRtN8j3pfWfQ4HfE7l2', '', 'active', '2026-05-11 15:09:55'),
(11, 'Grace Ali', '$2y$10$9r0YbpuFRCDTiusErccRveFVgLtsprnSl6NcvUSD3q576aMxw3C6C', '', 'active', '2026-05-15 01:27:39'),
(14, 'Alice Jack', '$2y$10$ifufmnIkzByuy1tphrmUlu0UmrBiYyRiwTbuh1Ye4WZKhNMbTRfuy', '', 'active', '2026-05-15 01:52:27'),
(15, 'Cythia Muthui', '$2y$10$91T/XFadpeurITwVShbqEuXCTktmckNo/XTxBgjkzv8IAt95jt4.y', '', 'active', '2026-05-15 01:53:41'),
(16, 'Victor Muthui', '$2y$10$FWagTH5reM79TGt0rQhOs./bXixtUWW.5LMkQ5IujcYdVA5kDNp7y', '', 'active', '2026-05-15 03:14:36'),
(17, 'Melina', '$2y$10$CrEyUABWPbiaZ9HEbTzB9OTI/gTurOr4s.VXcQDaRfLpBC6tzEhBS', '', 'active', '2026-05-15 07:06:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
