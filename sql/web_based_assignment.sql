-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 03:45 PM
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
  `password` varchar(15) NOT NULL,
  `adminLevel` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `position`, `password`, `adminLevel`) VALUES
('1', 'Manager', 'pass123', '5'),
('10', 'CEO', 'admin000', '5'),
('2', 'Employee', 'pass234', '2'),
('3', 'Supervisor', 'pass345', '4'),
('4', 'Clerk', 'pass456', '1'),
('5', 'Technician', 'pass567', '3'),
('6', 'Director', 'pass678', '5'),
('7', 'Intern', 'pass789', '0'),
('8', 'HR', 'pass890', '3'),
('9', 'Accountant', 'pass901', '2');

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
(12350, 'R0001', 1, 13.99, '4UG5');

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

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `productImg`, `introduction`, `playerInfo`, `playerImage`) VALUES
('R0001', 'Yonex Arcsaber 11 Pro', 849.00, 'ARC', 'https://www.yonex.com/media/catalog/product/a/r/arc11-p.png?', 'The Arcsaber 11 Pro adopts the unique feel of impact and offers enhanced playability with an emphasis on shuttle pocketing for a controlled attack. Taking control of the court can take many forms, and for the Arcsaber it comes from the extra milliseconds of shuttle contact time.', 'Aaron Chia Teng Fong is a Malaysian badminton player.A world champion and a double bronze medalist at the Olympic Games, he and his partner Soh Wooi Yik became the first ever world badminton champions from Malaysia after winning the men\'s doubles title at the 2022 World Championships.Together, they ', 'https://www.yonex.com/media/wysiwyg/Athletes/Badminton/810x540_aaron-chia.jpg'),
('R0002', 'Yonex Nanoflare 1000z', 799.00, 'NAN', 'https://www.yonex.com/media/catalog/product/n/a/nanoflare_1000_z.png?', 'The new NANOFLARE 1000 is being used on court now in the hands of Rio Olympic gold medalist, Carolina Marin (ESP), 2022 All England silver medalist, Lakshya Sen (IND), and 2022 French Open champion, He Bing Jiao (CHN). The racquets are scheduled for a global launch on June 16th, 2023, in four different models, Z, TOUR, GAME and PLAY – each developed with the same performance concept but with variations in materials used.', 'Chen Tang Jie is a Malaysian badminton player. He was part of the Malaysian 2016 Asian Junior Championships and 2016 BWF World Junior Championships team, and helped Malaysia to clinch a silver medal in the World Junior mixed team before being defeated by China.', 'https://www.badmintonplanet.com/wp-content/uploads/2023/06/06-25-2023-badminton-news-chen-tang-jie-toh-ee-wei-taipei-open.jpg'),
('R0003', 'Yonex Astrox 88D Pro', 899.00, 'AST', 'https://www.yonex.com/media/catalog/product/3/a/3ax88d-p_076-1_02.png?', 'This brand new Astrox 88D Pro is designed for aggressive doubles players who are always ready to dominate from the back of the court. The POWER-ASSIST BUMPER has been newly added to the top of the frame, providing even more advancement for the Rotational Generator System.', 'Kunlavut Vitidsarn is a Thai badminton player. He is the current men\'s singles World Champion as he won the gold medal at the 2023 World Championships, and a silver medalist at the 2024 Olympic Games. He was also three-times World Junior champion, winning in 2017, 2018 and 2019. He is nicknamed the ', 'https://www.pattayamail.com/wp-content/uploads/2024/08/t-09-Kunlavut-Vitidsarn-makes-history-as-first-Thai-shuttler-to-reach-Olympic-badminton-final.jpg'),
('R0004', 'Yonex Astrox 100zz', 849.00, 'AST', 'https://www.yonex.com/media/catalog/product/a/s/astrox100zz_kurenai.png?', 'Yonex ASTROX 100 ZZ racket is built using with Rotational Generator System. The counter balanced head adapts to each shot, helping you to control the drive and attack the opposition with increased acceleration, steeper angle and power on the smash.', 'Viktor Axelsen (born 4 January 1994) is a Danish badminton player. He is a two-time Olympic Champion, two-time World Champion, and four-time European Champion. He has held the No. 1 BWF World Ranking in men\'s singles for a total of 183 weeks (as of August 2024), and he is the current world No. 4.Thr', 'https://c.ndtvimg.com/2021-12/1hhdm63o_viktor-axelsen_625x300_14_December_21.jpg?'),
('R0005', 'Yonex Duora Z-Strike', 739.00, 'DUO', 'https://www.yonex.com/media/catalog/product/d/u/duo-zs.png?', 'YONEX Duora Z Strike Badminton Racquet Technology: By reducing the amount of carbon in the shaft to make it 60% thinner than a conventional racquet whilst retaining stiffness, YONEX has created a revolutionary lightweight racquet with lightening head speed and control.', 'Chou Tien-chen is a Taiwanese badminton player. He became the first local shuttler in 17 years to win the men\'s singles title of the Chinese Taipei Open in 2016 since Indonesian-born Fung Permadi won it in 1999. He won his first BWF Super Series title at the 2014 French Open, beating Wang Zhengming ', 'https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w960/f_auto/primary/kp0rfgiyiusrlcskh5h9'),
('R0006', 'Yonex Astrox 99 Pro', 859.00, 'AST', 'https://www.yonex.com/media/catalog/product/a/x/ax99-pro_whitetiger.png?', 'Astrox 99 Pro uses NAMD in its entire frame from head to body of racket. A world-first, new dimension graphite material, Namd, greatly improves the adhesion of the graphite fibers and resin by attaching nanomaterial directly to the graphite fiber.', 'Kento Momota is a former Japanese badminton player. He has won several major badminton tournaments including two World Championships titles, two Asian Championships titles, and one All England title.', 'https://ss-i.thgim.com/public/incoming/7drpf6/article68078411.ece/alternates/LANDSCAPE_1200/Indonesia_Open_Badminton_04907.jpg');

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

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `productID` varchar(50) DEFAULT NULL,
  `image_path` text NOT NULL,
  `image_type` enum('product','player') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('DUO', 'Duora'),
('NAN', 'Nanoflare');

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
  `gender` enum('F','M') DEFAULT NULL COMMENT 'F: Female. \r\nM: Male.\r\nNullable. User won''t be prompted to provide their gender upon signup, but may choose to set one in the profile settings.',
  `profilePic` varchar(255) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `memberStatus` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `address`, `birthdate`, `email`, `phoneNo`, `gender`, `profilePic`, `bio`, `memberStatus`) VALUES
(1, 'cookie', '123', NULL, NULL, 'cookie@mail.com', '012-3456789', NULL, NULL, '', 'Inactive'),
(2, 'icecream', '456', NULL, NULL, 'icecream@mail.com', '012-9876543', NULL, NULL, '', 'Inactive');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
