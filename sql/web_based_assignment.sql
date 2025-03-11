-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 01:17 PM
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
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `orderId` int(5) NOT NULL,
  `productId` varchar(5) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `gripSize` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderId`, `productId`, `quantity`, `subtotal`, `gripSize`) VALUES
(12345, 'R0001', 1, 15.99, 'G5'),
(12345, 'R0002', 1, 9.99, 'G4'),
(12346, 'R0001', 1, 25.00, 'G5'),
(12346, 'R0002', 1, 15.99, 'G4'),
(12346, 'R0003', 2, 31.98, 'G6'),
(12347, 'R0003', 1, 16.50, 'G6'),
(12348, 'R0001', 2, 32.00, 'G5'),
(12348, 'R0002', 1, 10.00, 'G4'),
(12348, 'R0003', 1, 15.99, 'G6'),
(12349, 'R0002', 1, 12.99, 'G4'),
(12349, 'R0003', 2, 19.98, 'G6'),
(12350, 'R0001', 1, 13.99, 'G5');

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
  `orderAddress` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderDate`, `status`, `orderAddress`) VALUES
(12345, 1, '2024-10-25', 'Pending', '2 Jalan Port Dickson Langkawi, 72010, Kuala Lumpur'),
(12346, 2, '2024-11-02', 'In Transit', '88, Lorong Bukit Jaya, 43000, Selangor'),
(12347, 1, '2024-09-15', 'Delivered', '16, Jalan Taman Utama, 80000, Johor Bahru'),
(12348, 2, '2024-08-30', 'Pending', '7, Jalan Ampang, 50450, Kuala Lumpur'),
(12349, 1, '2024-12-10', 'In Transit', '22, Jalan Sutera Indah, 81100, Johor'),
(12350, 2, '2024-07-20', 'Delivered', '5, Lorong Melati, 10460, Penang');

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
  `productImg` varchar(1000) NOT NULL,
  `introduction` varchar(1000) NOT NULL,
  `playerInfo` varchar(300) NOT NULL,
  `playerImage` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `productImg`,`introduction`,`playerInfo`,`playerImage`) VALUES
('R0001', 'Yonex Arcsaber 11 Pro', 849.00, 'ARC', 'https://www.yonex.com/media/catalog/product/a/r/arc11-p.png?', "The Arcsaber 11 Pro adopts the unique feel of impact and offers enhanced playability with an emphasis on shuttle pocketing for a controlled attack. Taking control of the court can take many forms, and for the Arcsaber it comes from the extra milliseconds of shuttle contact time.", "Aaron Chia Teng Fong is a Malaysian badminton player.A world champion and a double bronze medalist at the Olympic Games, he and his partner Soh Wooi Yik became the first ever world badminton champions from Malaysia after winning the men's doubles title at the 2022 World Championships.Together, they also won a gold medal at the 2019 SEA Games, a silver medal at the 2022 Asian Championships,as well as bronze medals at the 2020 Summer Olympics,2022 Commonwealth Games,2023 World Championships,2022 Asian Games,2024 Asian Championships,and 2024 Summer Olympics.They are also the first Malaysian men’s doubles pair to win consecutive medals at the Olympic Games.",'https://www.yonex.com/media/wysiwyg/Athletes/Badminton/810x540_aaron-chia.jpg'),
('R0002', 'Yonex Nanoflare 1000z', 799.00, 'NAN', 'https://www.yonex.com/media/catalog/product/n/a/nanoflare_1000_z.png?', "The new NANOFLARE 1000 is being used on court now in the hands of Rio Olympic gold medalist, Carolina Marin (ESP), 2022 All England silver medalist, Lakshya Sen (IND), and 2022 French Open champion, He Bing Jiao (CHN). The racquets are scheduled for a global launch on June 16th, 2023, in four different models, Z, TOUR, GAME and PLAY – each developed with the same performance concept but with variations in materials used.", "Chen Tang Jie is a Malaysian badminton player. He was part of the Malaysian 2016 Asian Junior Championships and 2016 BWF World Junior Championships team, and helped Malaysia to clinch a silver medal in the World Junior mixed team before being defeated by China.", 'https://www.badmintonplanet.com/wp-content/uploads/2023/06/06-25-2023-badminton-news-chen-tang-jie-toh-ee-wei-taipei-open.jpg'),
('R0003', 'Yonex Astrox 88D Pro', 899.00, 'AST', 'https://www.yonex.com/media/catalog/product/3/a/3ax88d-p_076-1_02.png?', "This brand new Astrox 88D Pro is designed for aggressive doubles players who are always ready to dominate from the back of the court. The POWER-ASSIST BUMPER has been newly added to the top of the frame, providing even more advancement for the Rotational Generator System.", "Kunlavut Vitidsarn is a Thai badminton player. He is the current men's singles World Champion as he won the gold medal at the 2023 World Championships, and a silver medalist at the 2024 Olympic Games. He was also three-times World Junior champion, winning in 2017, 2018 and 2019. He is nicknamed the 'Three-Game God' because his playing style requires him to play three games long and always win in the end.",'https://www.pattayamail.com/wp-content/uploads/2024/08/t-09-Kunlavut-Vitidsarn-makes-history-as-first-Thai-shuttler-to-reach-Olympic-badminton-final.jpg');


-- --------------------------------------------------------

--
-- Table structure for table `productsize`
--

DROP TABLE IF EXISTS `productsize`;
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
('R0003', '4UG5', 3);

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
('ARC', 'Arcsaber'),
('AST', 'Astrox'),
('NAN', 'Nanoflare');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `dob` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `memberStatus` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `address`, `dob`, `email`, `profilePic`, `memberStatus`) VALUES
(1, 'cookie', '123', NULL, NULL, 'cookie@mail.com', NULL, 'Inactive'),
(2, 'icecream', '456', NULL, NULL, 'icecream@mail.com', NULL, 'Inactive');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`orderId`,`productId`),
  ADD KEY `productId` (`productId`);

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productID`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- admin table
DROP TABLE IF EXISTS `admin`;
CREATE TABLE admin (
    id VARCHAR(10) PRIMARY KEY,
    position VARCHAR(20) NOT NULL,
    password VARCHAR(15) NOT NULL,
    adminLevel VARCHAR(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- insert data of admin
INSERT INTO admin (id, position, password, adminLevel)  
VALUES  
('1', 'Manager', 'pass123', '5'),  
('2', 'Employee', 'pass234', '2'),  
('3', 'Supervisor', 'pass345', '4'),  
('4', 'Clerk', 'pass456', '1'),  
('5', 'Technician', 'pass567', '3'),  
('6', 'Director', 'pass678', '5'),  
('7', 'Intern', 'pass789', '0'),  
('8', 'HR', 'pass890', '3'),  
('9', 'Accountant', 'pass901', '2'),  
('10', 'CEO', 'admin000', '5');
