-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 09:01 AM
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
-- Database: `web_based_assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `productID` varchar(50) DEFAULT NULL,
  `image_path` text NOT NULL,
  `image_type` enum('product','player') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `productID`, `image_path`, `image_type`, `created_at`) VALUES
(1, 'R0001', 'product_R0001_0.jpg', 'product', '2025-03-18 07:54:25'),
(2, 'R0001', 'player_R0001_0.jpg', 'player', '2025-03-18 07:54:25'),
(3, 'R0002', 'product_R0002_0.jpg', 'product', '2025-03-18 07:55:30'),
(4, 'R0002', 'player_R0002_0.jpg', 'player', '2025-03-18 07:55:30'),
(5, 'R0003', 'product_R0003_0.jpg', 'product', '2025-03-18 07:55:50'),
(6, 'R0003', 'player_R0003_0.jpg', 'player', '2025-03-18 07:55:50'),
(7, 'R0004', 'product_R0004_0.jpg', 'product', '2025-03-18 07:57:15'),
(8, 'R0004', 'player_R0004_0.jpg', 'player', '2025-03-18 07:57:15'),
(9, 'R0005', 'product_R0005_0.jpg', 'product', '2025-03-18 07:57:26'),
(10, 'R0005', 'player_R0005_0.jpg', 'player', '2025-03-18 07:57:26'),
(11, 'R0006', 'product_R0006_0.jpg', 'product', '2025-03-18 07:57:33'),
(12, 'R0006', 'player_R0006_0.jpg', 'player', '2025-03-18 07:57:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
