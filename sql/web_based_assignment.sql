-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 10:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS web_based_assignment;
USE web_based_assignment;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_based_assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` ( 
  `id` varchar(10) NOT NULL,
  `position` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `adminLevel` ENUM('main', 'staff') NOT NULL,
  `status` ENUM('Active', 'Blocked') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `position`, `password`, `adminLevel`, `status`) VALUES
('A001', 'HR Manager', 'pass123', 'main', 'Active'),
('A002', 'IT Support', 'itpass', 'staff', 'Active'),
('A003', 'Finance Head', 'finpass', 'main', 'Blocked'),
('A004', 'Marketing Lead', 'mkpass', 'staff', 'Active'),
('A005', 'Operations', 'oppass', 'staff', 'Blocked'),
('A006', 'Sales Manager', 'salepass', 'main', 'Active'),
('A007', 'Admin Assistant', 'admpass', 'staff', 'Blocked'),
('A008', 'Project Manager', 'pm123', 'main', 'Active'),
('A009', 'Customer Support', 'cspass', 'staff', 'Blocked'),
('A010', 'Security', 'secpass', 'staff', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `userID` int(11) NOT NULL,
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(5) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `orderAddress` varchar(150) NOT NULL,
  `deliveryMethod` varchar(20) NOT NULL,
  `deliveredDate` date DEFAULT NULL,
  `tracking` int(30) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderDate`, `status`, `orderAddress`, `deliveryMethod`, `deliveredDate`, `tracking`, `discount`) VALUES
(12345, 1, '2024-10-25', 'Pending', '2 Jalan Port Dickson Langkawi, 72010, Kuala Lumpur', 'Standard', NULL, NULL, 0.00),
(12346, 2, '2024-11-02', 'In Transit', '88, Lorong Bukit Jaya, 43000, Selangor', 'Standard', NULL, NULL, 0.00),
(12347, 1, '2024-09-15', 'Delivered', '16, Jalan Taman Utama, 80000, Johor Bahru', 'Standard', '2024-09-18', NULL, 0.50),
(12348, 2, '2024-08-30', 'Pending', '7, Jalan Ampang, 50450, Kuala Lumpur', 'Standard', NULL, NULL, 0.00),
(12349, 1, '2024-12-10', 'In Transit', '22, Jalan Sutera Indah, 81100, Johor', 'Standard', NULL, NULL, 0.00),
(12350, 2, '2024-07-20', 'Delivered', '5, Lorong Melati, 10460, Penang', 'Standard', '2024-07-23', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

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
(12350, 'R0001', 1, 13.99, '4UG5');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` varchar(5) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `price` float(6,2) NOT NULL,
  `seriesID` varchar(3) DEFAULT NULL,
  `productImg` varchar(1000) NOT NULL,
  `introduction` varchar(1000) NOT NULL,
  `playerInfo` varchar(1000) NOT NULL,
  `playerImage` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `productImg`, `introduction`, `playerInfo`, `playerImage`) VALUES
('R0001', 'AeroSharp 11', 499.00, 'AS', 'product_R0001_1742917010.jpg', 'Precision meets mastery with the AeroSharp 11. Designed for players who dictate the pace of the game, this racket offers superior shuttle control, effortless net play, and unmatched accuracy. The ultra-thin shaft and aerodynamic frame reduce drag, ensuring maximum maneuverability for the smartest players on the court.', 'Ethan Cheng. A tactical genius, Ethan is known for his surgical net drops and pinpoint clears. He controls rallies with calm precision, forcing opponents into mistakes before delivering the final blow.', 'player_R0001_1742917010.jpg'),
('R0002', 'TurboSmash 1000', 599.00, 'TSM', 'product_R0002_1742917087.jpg', 'Speed redefined. The TurboSmash 1000 is built for lightning-fast reactions and rapid counterattacks. With an ultra-lightweight frame and enhanced repulsion technology, this racket enables players to unleash quick drives and rapid smashes with ease. Perfect for those who thrive on pace and aggression.', 'Kei Tanaka. With his lightning footwork and relentless attacking style, Kei overwhelms opponents before they can react. His signature double-tap drive keeps defenders scrambling to keep up.', 'player_R0002_1742917087.jpg'),
('R0003', 'ThunderStrike 88 max', 459.00, 'TST', 'product_R0003_1742917753.jpg', 'Pure dominance on the court. The ThunderStrike 88 Max is designed for explosive power, engineered with an extra-stiff shaft and head-heavy balance to deliver devastating smashes. Whether attacking from the baseline or finishing at the net, this racket turns every shot into a statement.', 'Aleksandr Ivanov. A powerhouse with a smash that echoes across arenas, Aleksandr thrives on brute force. His signature \"Iron Hammer\" smash has made him a feared opponent worldwide.', 'player_R0003_1742917753.jpg'),
('R0004', 'ThunderStrike 100', 679.00, 'TST', 'product_R0004_1742917944.jpg', 'For those who demand control over raw power, the ThunderStrike 100 balances explosive smashes with excellent shot placement. The reinforced T-joint and optimized frame weight create a racket that delivers controlled aggression, allowing powerful yet precise play.', 'Leo Park. A relentless attacker with a strategic mind, Leo mixes powerful smashes with deceptive drop shots, making him unpredictable and deadly in any rally.', 'player_R0004_1742917944.jpg'),
('R0005', 'Shadow Z', 399.00, 'SHD', 'product_R0005_1742918129.jpg', 'A perfect fusion of speed and strength, the Shadow Z is built for aggressive players who need both lightning-fast reactions and crushing power. With a revolutionary hybrid frame and reinforced carbon core, this racket ensures rapid-fire play without sacrificing stability.', 'Nathan Cole. A bold, risk-taking player, Nathan’s agility and attacking prowess keep opponents constantly guessing. His signature \"Phantom Smash\"—a deceptive half-smash disguised as a full-power shot—has won him countless matches.', 'player_R0005_1742918129.jpg'),
('R0006', 'ThunderStrike 99 max', 519.00, 'TST', 'product_R0006_1742918288.jpg', 'The evolution of power. The ThunderStrike 99 is crafted for relentless attackers who aim to dominate the game. Its high-tension frame and reinforced shaft provide the ultimate combination of stability and power, making it the ultimate weapon for smash-heavy players.', 'Rajat Sharma, known as the \"Wall Breaker,\" Rajat’s smashes have been recorded at over 400 km/h. His aggressive baseline game and ruthless net kills make him an unstoppable force.', 'player_R0006_1742918288.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productsize`
--

CREATE TABLE `productsize` (
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsize`
--

INSERT INTO `productsize` (`productID`, `sizeID`, `quantity`) VALUES
('R0001', '3UG5', 4),
('R0001', '4UG5', 5),
('R0002', '3UG5', 5),
('R0002', '4UG5', 6),
('R0003', '3UG5', 2),
('R0003', '4UG5', 3),
('R0004', '3UG5', 4),
('R0004', '4UG5', 5),
('R0005', '3UG5', 5),
('R0005', '4UG5', 6),
('R0006', '3UG5', 2),
('R0006', '4UG5', 3);

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
(1, 'R0001', 'product_R0001_1742917010.jpg', 'product', '2025-03-25 15:36:50'),
(2, 'R0001', 'player_R0001_1742917010.jpg', 'player', '2025-03-25 15:36:50'),
(3, 'R0002', 'product_R0002_1742917087.jpg', 'product', '2025-03-25 15:38:07'),
(4, 'R0002', 'player_R0002_1742917087.jpg', 'player', '2025-03-25 15:38:07'),
(5, 'R0003', 'product_R0003_1742917753.jpg', 'product', '2025-03-25 15:49:13'),
(6, 'R0003', 'player_R0003_1742917753.jpg', 'player', '2025-03-25 15:49:13'),
(7, 'R0004', 'product_R0004_1742917944.jpg', 'product', '2025-03-25 15:52:24'),
(8, 'R0004', 'player_R0004_1742917944.jpg', 'player', '2025-03-25 15:52:24'),
(9, 'R0005', 'product_R0005_1742918129.jpg', 'product', '2025-03-25 15:55:29'),
(10, 'R0005', 'player_R0005_1742918129.jpg', 'player', '2025-03-25 15:55:29'),
(11, 'R0006', 'product_R0006_1742918288.jpg', 'product', '2025-03-25 15:58:08'),
(12, 'R0006', 'player_R0006_1742918288.jpg', 'player', '2025-03-25 15:58:08');


-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `seriesID` varchar(3) NOT NULL,
  `seriesName` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`seriesID`, `seriesName`) VALUES
('AS', 'AeroSharp'),
('TST', 'ThunderStrike'),
('SHD', 'Shadow'),
('TSM', 'TurboSmash');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
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

INSERT INTO `user` (`userID`, `username`, `password`, `address`, `birthdate`, `email`, `phoneNo`, `gender`, `profilePic`, `bio`, `memberStatus`) VALUES
(1, 'cookie', '123', NULL, NULL, 'cookie@mail.com', '012-3456789', 'R', NULL, 'I love cookies, as you may have already guessed', 'Inactive'),
(2, 'icecream', '456', NULL, NULL, 'icecream@mail.com', '012-9876543', 'R', NULL, 'I love ice cream!', 'Inactive');

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
-- Indexes for table `productsize`
--
ALTER TABLE `productsize`
  ADD PRIMARY KEY (`productID`,`sizeID`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`);

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
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productsize` (`productID`, `sizeID`);

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
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productId`,`gripSize`) REFERENCES `productsize` (`productID`, `sizeID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`seriesID`) REFERENCES `series` (`seriesID`);

--
-- Constraints for table `productsize`
--
ALTER TABLE `productsize`
  ADD CONSTRAINT `productSize_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
