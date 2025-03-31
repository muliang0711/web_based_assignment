-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 01:38 PM
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
-- Database: `web_based_assignment`
--
CREATE DATABASE IF NOT EXISTS `web_based_assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_based_assignment`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` varchar(10) NOT NULL,
  `position` varchar(20) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `adminLevel` enum('main','staff') NOT NULL,
  `status` enum('Active','Blocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `position`, `passwordHash`, `adminLevel`, `status`) VALUES
('A001', 'HR Manager', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('A002', 'IT Support', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('A003', 'Finance Head', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('A004', 'Marketing Lead', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Blocked'),
('A005', 'Operations', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

DROP TABLE IF EXISTS `cartitem`;
CREATE TABLE `cartitem` (
  `userID` int(11) NOT NULL,
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitem`
--

INSERT INTO `cartitem` (`userID`, `productID`, `sizeID`, `quantity`) VALUES
(2, 'R0001', '4UG5', 2),
(2, 'R0002', '4UG5', 3),
(2, 'R0003', '4UG5', 3),
(2, 'R0004', '4UG5', 5),
(2, 'R0005', '4UG5', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `orderId` int(5) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `orderAddress` varchar(150) NOT NULL,
  `orderName` varchar(40) NOT NULL,
  `orderPhone` varchar(15) NOT NULL,
  `deliveryMethod` varchar(20) NOT NULL,
  `deliveredDate` date DEFAULT NULL,
  `tracking` int(30) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderDate`, `status`, `orderAddress`, `orderName`, `orderPhone`, `deliveryMethod`, `deliveredDate`, `tracking`, `discount`) VALUES
(12345, 1, '2024-10-25', 'Pending', '2 Jalan Port Dickson Langkawi, 72010, Kuala Lumpur', '', '', 'Standard', NULL, NULL, 0.00),
(12346, 2, '2024-11-02', 'In Transit', '88, Lorong Bukit Jaya, 43000, Selangor', '', '', 'Standard', NULL, NULL, 0.00),
(12347, 1, '2024-09-15', 'Delivered', '16, Jalan Taman Utama, 80000, Johor Bahru', '', '', 'Standard', '2024-09-18', NULL, 0.50),
(12348, 2, '2024-08-30', 'Pending', '7, Jalan Ampang, 50450, Kuala Lumpur', '', '', 'Standard', NULL, NULL, 0.00),
(12349, 1, '2024-12-10', 'In Transit', '22, Jalan Sutera Indah, 81100, Johor', '', '', 'Standard', NULL, NULL, 0.00),
(12350, 2, '2024-07-20', 'Delivered', '5, Lorong Melati, 10460, Penang', '', '', 'Standard', '2024-07-23', NULL, 0.00),
(12351, 1, '2025-03-31', 'Pending', '9, Jalan Merdeka, 75000 Melaka, Malaysia', 'Alexandra', '012-6129291', 'Standard', NULL, NULL, 2018.10),
(12352, 1, '2025-03-31', 'Pending', 'No. 15, Jalan Ampang, 50450 Kuala Lumpur, Malaysia', 'Alexandra', '012-6129291', 'Standard', NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `orderId` int(5) NOT NULL,
  `productId` varchar(5) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `gripSize` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderId`, `productId`, `quantity`, `subtotal`, `gripSize`) VALUES
(12345, 'R0001', 1, 15.99, '3UG5'),
(12345, 'R0001', 1, 15.99, '4UG5'),
(12345, 'R0002', 1, 9.99, '3UG5'),
(12346, 'R0001', 1, 25.00, '4UG5'),
(12346, 'R0002', 1, 15.99, '3UG5'),
(12346, 'R0003', 2, 31.98, '3UG5'),
(12347, 'R0003', 1, 16.50, '3UG5'),
(12348, 'R0001', 2, 32.00, '4UG5'),
(12348, 'R0002', 1, 10.00, '3UG5'),
(12348, 'R0003', 1, 15.99, '3UG5'),
(12349, 'R0002', 1, 12.99, '3UG5'),
(12349, 'R0003', 2, 19.98, '3UG5'),
(12350, 'R0001', 1, 13.99, '4UG5'),
(12351, 'R0001', 2, 998.00, '3UG5'),
(12351, 'R0002', 5, 2995.00, '3UG5'),
(12351, 'R0003', 1, 459.00, '3UG5'),
(12351, 'R0004', 1, 679.00, '3UG5'),
(12351, 'R0005', 4, 1596.00, '3UG5'),
(12352, 'R0001', 1, 499.00, '3UG5'),
(12352, 'R0002', 1, 599.00, '4UG5');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `productID` varchar(5) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `price` float(6,2) NOT NULL,
  `seriesID` varchar(3) DEFAULT NULL,
  `introduction` varchar(1000) NOT NULL,
  `playerInfo` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `introduction`, `playerInfo`) VALUES
('R0001', 'AeroSharp 11', 499.00, 'AS', 'Precision meets mastery with the AeroSharp 11. Designed for players who dictate the pace of the game, this racket offers superior shuttle control, effortless net play, and unmatched accuracy. The ultra-thin shaft and aerodynamic frame reduce drag, ensuring maximum maneuverability for the smartest players on the court.', 'Ethan Cheng. A tactical genius, Ethan is known for his surgical net drops and pinpoint clears. He controls rallies with calm precision, forcing opponents into mistakes before delivering the final blow.'),
('R0002', 'TurboSmash 1000', 599.00, 'TSM', 'Speed redefined. The TurboSmash 1000 is built for lightning-fast reactions and rapid counterattacks. With an ultra-lightweight frame and enhanced repulsion technology, this racket enables players to unleash quick drives and rapid smashes with ease. Perfect for those who thrive on pace and aggression.', 'Kei Tanaka. With his lightning footwork and relentless attacking style, Kei overwhelms opponents before they can react. His signature double-tap drive keeps defenders scrambling to keep up.'),
('R0003', 'ThunderStrike 88 max', 459.00, 'TST', 'Pure dominance on the court. The ThunderStrike 88 Max is designed for explosive power, engineered with an extra-stiff shaft and head-heavy balance to deliver devastating smashes. Whether attacking from the baseline or finishing at the net, this racket turns every shot into a statement.', 'Aleksandr Ivanov. A powerhouse with a smash that echoes across arenas, Aleksandr thrives on brute force. His signature \"Iron Hammer\" smash has made him a feared opponent worldwide.'),
('R0004', 'ThunderStrike 100', 679.00, 'TST', 'For those who demand control over raw power, the ThunderStrike 100 balances explosive smashes with excellent shot placement. The reinforced T-joint and optimized frame weight create a racket that delivers controlled aggression, allowing powerful yet precise play.', 'Leo Park. A relentless attacker with a strategic mind, Leo mixes powerful smashes with deceptive drop shots, making him unpredictable and deadly in any rally.'),
('R0005', 'Shadow Z', 399.00, 'SHD', 'A perfect fusion of speed and strength, the Shadow Z is built for aggressive players who need both lightning-fast reactions and crushing power. With a revolutionary hybrid frame and reinforced carbon core, this racket ensures rapid-fire play without sacrificing stability.', 'Nathan Cole. A bold, risk-taking player, Nathan’s agility and attacking prowess keep opponents constantly guessing. His signature \"Phantom Smash\"—a deceptive half-smash disguised as a full-power shot—has won him countless matches.'),
('R0006', 'ThunderStrike 99 max', 519.00, 'TST', 'The evolution of power. The ThunderStrike 99 is crafted for relentless attackers who aim to dominate the game. Its high-tension frame and reinforced shaft provide the ultimate combination of stability and power, making it the ultimate weapon for smash-heavy players.', 'Rajat Sharma, known as the \"Wall Breaker,\" Rajat’s smashes have been recorded at over 400 km/h. His aggressive baseline game and ruthless net kills make him an unstoppable force.');

-- --------------------------------------------------------

--
-- Table structure for table `productstock`
--

DROP TABLE IF EXISTS `productstock`;
CREATE TABLE `productstock` (
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('onsales','notonsales') NOT NULL DEFAULT 'notonsales',
  `low_stock_threshold` int(11) DEFAULT 5,
  `alert_sent` tinyint(1) DEFAULT 0,
  `qr_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productstock`
--

INSERT INTO `productstock` (`productID`, `sizeID`, `stock`, `status`, `low_stock_threshold`, `alert_sent`, `qr_token`) VALUES
('R0001', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0001', '4UG5', 1, 'onsales', 5, 1, '9e22411d04b7c9b04584a1339265e142'),
('R0002', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0002', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0003', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0003', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0004', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0004', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0005', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0005', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0006', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0006', '4UG5', 3, 'onsales', 5, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
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
(1, 'R0001', 'product_R0001_1743343865.png', 'product', '2025-03-30 14:11:05'),
(2, 'R0001', 'player_R0001_1743343865.png', 'player', '2025-03-30 14:11:05'),
(3, 'R0002', 'product_R0002_1743343876.png', 'product', '2025-03-30 14:11:16'),
(4, 'R0002', 'player_R0002_1743343876.png', 'player', '2025-03-30 14:11:16'),
(5, 'R0003', 'product_R0003_1743343896.png', 'product', '2025-03-30 14:11:36'),
(6, 'R0003', 'player_R0003_1743343896.png', 'player', '2025-03-30 14:11:36'),
(7, 'R0004', 'product_R0004_1743343915.png', 'product', '2025-03-30 14:11:55'),
(8, 'R0004', 'player_R0004_1743343915.png', 'player', '2025-03-30 14:11:55'),
(9, 'R0005', 'product_R0005_1743343932.png', 'product', '2025-03-30 14:12:12'),
(10, 'R0005', 'player_R0005_1743343932.png', 'player', '2025-03-30 14:12:12'),
(11, 'R0006', 'product_R0006_1743343950.png', 'product', '2025-03-30 14:12:30'),
(12, 'R0006', 'player_R0006_1743343950.png', 'player', '2025-03-30 14:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `savedaddress`
--

DROP TABLE IF EXISTS `savedaddress`;
CREATE TABLE `savedaddress` (
  `userID` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phoneNo` varchar(15) NOT NULL,
  `name` varchar(40) NOT NULL,
  `defaultAdd` tinyint(1) NOT NULL DEFAULT 0,
  `addressIndex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savedaddress`
--

INSERT INTO `savedaddress` (`userID`, `address`, `phoneNo`, `name`, `defaultAdd`, `addressIndex`) VALUES
(1, 'PV18 RESIDENCE, JALAN LANGKAWI, 53000, Kuala Lumpur', '60126289399', 'Mr Wayne', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `seriesID` varchar(3) NOT NULL,
  `seriesName` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`seriesID`, `seriesName`) VALUES
('AS', 'AeroSharp'),
('SHD', 'Shadow'),
('TSM', 'TurboSmash'),
('TST', 'ThunderStrike');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNo` varchar(15) DEFAULT NULL,
  `gender` enum('F','M','R') NOT NULL DEFAULT 'R' COMMENT 'F: Female. \r\nM: Male.\r\nR: Rather not say',
  `profilePic` varchar(255) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `memberStatus` enum('Active','Inactive','Blocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `passwordHash`, `address`, `birthdate`, `email`, `phoneNo`, `gender`, `profilePic`, `bio`, `memberStatus`) VALUES
(1, 'cookie', '$2y$10$82Iz4eXE.Ar4s99CF11A2u8tIiOQd3Qr65apYOZ1lVsNimp8oumwG', NULL, NULL, 'cookie@mail.com', '012-3456789', 'R', NULL, 'I love cookies, as you may have already guessed', 'Inactive'),
(2, 'icecream', '$2y$10$HN1VCP3xMBQkkD4fsxUMUe4Ri/ujjDaoJ9u1vZTdibF8yyXjfQ3LG', NULL, NULL, 'icecream@mail.com', '012-9876543', 'R', NULL, 'I love ice cream!', 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`userID`,`productID`,`sizeID`),
  ADD KEY `productID` (`productID`,`sizeID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderId`,`productId`,`gripSize`),
  ADD KEY `productId` (`productId`),
  ADD KEY `order_items_ibfk_2` (`productId`,`gripSize`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `seriesID` (`seriesID`);

--
-- Indexes for table `productstock`
--
ALTER TABLE `productstock`
  ADD PRIMARY KEY (`productID`,`sizeID`),
  ADD UNIQUE KEY `qr_token` (`qr_token`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD PRIMARY KEY (`addressIndex`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`seriesID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12355;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `savedaddress`
--
ALTER TABLE `savedaddress`
  MODIFY `addressIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productId`,`gripSize`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`seriesID`) REFERENCES `series` (`seriesID`);

--
-- Constraints for table `productstock`
--
ALTER TABLE `productstock`
  ADD CONSTRAINT `productStock_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;

--
-- Constraints for table `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD CONSTRAINT `savedaddress_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
