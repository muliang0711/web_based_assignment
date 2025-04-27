-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-04-27 11:41:11
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `web_based_assignment`
--
CREATE DATABASE IF NOT EXISTS `web_based_assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_based_assignment`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `department` enum('SA','IT','IN','CS','PD','TS','FI') NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `adminLevel` enum('main','staff') NOT NULL,
  `status` enum('Active','Blocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `department`, `passwordHash`, `adminLevel`, `status`) VALUES
('0Adjmlte9d', 'Lucas Johnson', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Blocked'),
('0nOWwqj4lJ', 'Emma Johnson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('13GRGMg0Ry', 'Emma Brown', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('1GPzY82PUv', 'Liam Garcia', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('1N6SuAbpK6', 'Isabella Miller', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('2vDMmuBSYn', 'Sophia Wilson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('3nca0DuNF0', 'Ava Anderson', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Blocked'),
('3pantLcZnt', 'Emma Davis', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('45qAjXrlBO', 'James Davis', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('65BCWA8jOM', 'Ava Jones', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('6Yl78qPFIU', 'Olivia Garcia', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('7rwKpgKwFO', 'Emma Williams', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'main', 'Blocked'),
('8DVtcDZmYU', 'Liam Wilson', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('8TtvXVfo9C', 'Ava Jones', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('8yab2LZSUS', 'Olivia Johnson', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Blocked'),
('9VUf61kT0c', 'Liam Brown', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('A001', 'Alice Wong', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('A002', 'Bob Tan', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('A003', 'Charlie Lim', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('A004', 'Daphne Teo', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Blocked'),
('A005', 'Hannah Yeo', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('A4FDSheqRt', 'Olivia Williams', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Blocked'),
('ACe0PGraZt', 'Ava Jones', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('Ayuw0knWRf', 'Noah Anderson', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('b6pJ7EHDfF', 'Liam Anderson', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('BjWmYLDvZV', 'Lucas Jones', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('bNiwkROGri', 'Emma Smith', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('bQeJ0Icbm8', 'Ethan Brown', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('cOa7IAJfzA', 'Sophia Brown', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('CSULKh2K2S', 'Ethan Anderson', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('DhzbQs12Fk', 'Sophia Garcia', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('EbpShAA6QW', 'Emma Anderson', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('ecr2A1CGTk', 'Sophia Smith', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Blocked'),
('ENO9zMw1JO', 'Emma Brown', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('EQG9j5jgLl', 'Isabella Williams', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Blocked'),
('ERQbmWz3Op', 'Ava Jones', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('etxHBVBMd8', 'Emma Brown', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('fHaopFxbo3', 'Isabella Garcia', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('fmxNXyIHEF', 'Olivia Miller', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('GG5Z90YTn3', 'Ava Johnson', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('gILvMJJHyp', 'Olivia Williams', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Blocked'),
('GMHADGK6YT', 'Isabella Miller', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('GzRrnkogqz', 'Isabella Smith', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('hBxLANqjk7', 'James Johnson', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Blocked'),
('hdjM37RICT', 'Sophia Anderson', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('HGRmOmo2SK', 'Sophia Jones', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('HlmIHicjfg', 'Liam Wilson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('I3nwtleBeQ', 'Sophia Williams', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('i7ExTJIRWv', 'Emma Williams', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Blocked'),
('iPG5ReIk7p', 'Liam Brown', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('j1ZhBvPP0i', 'Olivia Anderson', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('J9HKUi5pUn', 'Noah Brown', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Blocked'),
('jAIYyEonhT', 'Emma Anderson', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('JjltuvXK1i', 'Olivia Brown', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('kkGM0Z79dp', 'Noah Davis', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('KKkrlkiBpm', 'Lucas Williams', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('kUp05RrUWS', 'Lucas Smith', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('l4jKan5Fc0', 'Noah Anderson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Active'),
('maEHeIF2JS', 'Liam Wilson', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'main', 'Active'),
('MI4XVlD2Sd', 'Liam Jones', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('MmQgjtdbFt', 'Sophia Jones', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('MztlTfDaUb', 'James Smith', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('N5t5NOb4nn', 'Lucas Davis', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Blocked'),
('NAUay5cSJK', 'Emma Garcia', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('nJwXoZlLAb', 'Ethan Garcia', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('nvHphg5t2K', 'Sophia Jones', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('nzKrVHBroR', 'Emma Jones', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'main', 'Blocked'),
('Oe09sOZxhE', 'Olivia Jones', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Active'),
('oJwMOdJVUB', 'Liam Davis', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('OO8dVOEe9J', 'Lucas Miller', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('p18MXFHwgb', 'Lucas Brown', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Blocked'),
('pewJowGjzm', 'Ava Anderson', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('PIiHXGICVU', 'Sophia Smith', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('Pwtar3fdb9', 'Liam Anderson', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('qartpFnFIt', 'Liam Jones', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('QefDzEF6GA', 'Lucas Williams', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('QUohyKyv1r', 'Liam Davis', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('rBH7ScbILA', 'Ethan Garcia', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Blocked'),
('S8SStA0xe9', 'Lucas Anderson', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Blocked'),
('S9xGaudFEa', 'Emma Jones', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('sJZk1XwyN7', 'Isabella Brown', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('SnIFuQy45E', 'Isabella Garcia', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('SohrjZNStE', 'Ava Anderson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('soNpMnsqUF', 'Sophia Anderson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active'),
('sQ7s3j9lkM', 'Ava Smith', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Blocked'),
('tcnHUvE3Uy', 'Sophia Johnson', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('TcZpRgZuw7', 'Sophia Brown', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('tECzRtSJXy', 'Lucas Smith', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('tr48dbk3Pt', 'Ethan Johnson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'main', 'Blocked'),
('TxpebDjSGG', 'Olivia Davis', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('U8NTAX0ead', 'Emma Miller', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Active'),
('uHcoU3GyrJ', 'Ethan Anderson', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('Ukmac7Wz6C', 'Ava Anderson', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('UqGxY1zQGx', 'Lucas Jones', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('VN9FVlKXjE', 'Liam Wilson', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'staff', 'Active'),
('vW6sEp4vFh', 'Ava Brown', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'main', 'Active'),
('WRgkDAKktf', 'Olivia Garcia', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('WUvKMgl2qh', 'Olivia Miller', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('WXNVkHS8ce', 'Lucas Garcia', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('WZ8WMp0hC1', 'Noah Jones', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('Y6FM0DyWlK', 'Liam Davis', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Active'),
('YXBfQ8AzCF', 'Olivia Garcia', 'FI', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked'),
('Z2XQzNUNkV', 'Emma Smith', 'IN', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'staff', 'Blocked'),
('zGC0udksdn', 'Emma Davis', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'main', 'Blocked'),
('zxsWNP3Jhf', 'Ava Anderson', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Active');

-- --------------------------------------------------------

--
-- 表的结构 `blockeduser`
--

DROP TABLE IF EXISTS `blockeduser`;
CREATE TABLE `blockeduser` (
  `blockedUserID` varchar(15) NOT NULL,
  `role` enum('user','staff') NOT NULL,
  `status` enum('-','reject','request') NOT NULL,
  `appealReason` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `blockeduser`
--

INSERT INTO `blockeduser` (`blockedUserID`, `role`, `status`, `appealReason`) VALUES
('10', 'user', 'request', 'Not Me'),
('12', 'user', 'request', 'Not Me'),
('13', 'user', 'request', 'Not Me'),
('14', 'user', 'request', 'Not Me'),
('16', 'user', 'request', 'Not Me'),
('17', 'user', 'request', 'Not Me'),
('19', 'user', 'request', 'Not Me'),
('1N6SuAbpK6', 'staff', '-', NULL),
('20', 'user', 'request', 'Not Me'),
('23', 'user', 'request', 'Not Me'),
('27', 'user', 'request', 'Not Me'),
('28', 'user', 'request', 'Not Me'),
('30', 'user', 'request', 'Not Me'),
('32', 'user', 'request', 'Not Me'),
('34', 'user', 'request', 'Not Me'),
('35', 'user', 'request', 'Not Me'),
('3nca0DuNF0', 'staff', 'request', 'Wrongfully accused'),
('40', 'user', 'request', 'Not Me'),
('41', 'user', 'request', 'Not Me'),
('44', 'user', 'request', 'Not Me'),
('45', 'user', 'request', 'Not Me'),
('47', 'user', 'request', 'Not Me'),
('49', 'user', 'request', 'Not Me'),
('51', 'user', 'request', 'Not Me'),
('53', 'user', 'request', 'Not Me'),
('7rwKpgKwFO', 'staff', '-', NULL),
('8', 'user', 'request', 'Not Me'),
('8yab2LZSUS', 'staff', '-', NULL),
('9', 'user', 'request', 'Not Me'),
('A002', 'staff', '-', ''),
('A4FDSheqRt', 'staff', 'reject', 'Please reconsider'),
('bNiwkROGri', 'staff', 'reject', 'Wrongfully accused'),
('bQeJ0Icbm8', 'staff', 'request', 'Wrongfully accused'),
('DhzbQs12Fk', 'staff', '-', NULL),
('EbpShAA6QW', 'staff', 'reject', 'I didn’t do it'),
('ecr2A1CGTk', 'staff', 'request', 'I didn’t do it'),
('EQG9j5jgLl', 'staff', 'reject', 'Please reconsider'),
('ERQbmWz3Op', 'staff', 'reject', NULL),
('GG5Z90YTn3', 'staff', 'request', 'I didn’t do it'),
('gILvMJJHyp', 'staff', '-', NULL),
('hBxLANqjk7', 'staff', 'request', 'I didn’t do it'),
('HlmIHicjfg', 'staff', 'reject', 'I didn’t do it'),
('I3nwtleBeQ', 'staff', '-', NULL),
('i7ExTJIRWv', 'staff', 'reject', 'Wrongfully accused'),
('j1ZhBvPP0i', 'staff', '-', NULL),
('J9HKUi5pUn', 'staff', '-', NULL),
('kUp05RrUWS', 'staff', '-', NULL),
('MI4XVlD2Sd', 'staff', 'request', 'Please reconsider'),
('N5t5NOb4nn', 'staff', 'request', 'Please reconsider'),
('nzKrVHBroR', 'staff', '-', NULL),
('oJwMOdJVUB', 'staff', 'reject', 'I didn’t do it'),
('OO8dVOEe9J', 'staff', '-', NULL),
('p18MXFHwgb', 'staff', '-', NULL),
('Pwtar3fdb9', 'staff', 'request', 'Wrongfully accused'),
('QefDzEF6GA', 'staff', '-', NULL),
('QUohyKyv1r', 'staff', 'request', 'Please reconsider'),
('rBH7ScbILA', 'staff', 'reject', 'Wrongfully accused'),
('S8SStA0xe9', 'staff', '-', NULL),
('S9xGaudFEa', 'staff', '-', NULL),
('SnIFuQy45E', 'staff', 'reject', 'I didn’t do it'),
('SohrjZNStE', 'staff', 'reject', 'I didn’t do it'),
('sQ7s3j9lkM', 'staff', 'reject', 'I didn’t do it'),
('tr48dbk3Pt', 'staff', 'request', 'Wrongfully accused'),
('WRgkDAKktf', 'staff', 'request', 'Please reconsider'),
('WUvKMgl2qh', 'staff', 'request', 'I didn’t do it'),
('WXNVkHS8ce', 'staff', '-', NULL),
('YXBfQ8AzCF', 'staff', 'request', 'I didn’t do it'),
('Z2XQzNUNkV', 'staff', 'reject', 'Wrongfully accused'),
('zGC0udksdn', 'staff', '-', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `cartitem`
--

DROP TABLE IF EXISTS `cartitem`;
CREATE TABLE `cartitem` (
  `userID` int(11) NOT NULL,
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `cartitem`
--

INSERT INTO `cartitem` (`userID`, `productID`, `sizeID`, `quantity`) VALUES
(2, 'R0001', '4UG5', 2),
(2, 'R0002', '4UG5', 3),
(2, 'R0003', '4UG5', 3),
(2, 'R0004', '4UG5', 5),
(2, 'R0005', '4UG5', 4);

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `messageID` bigint(20) NOT NULL,
  `senderID` int(11) NOT NULL,
  `adminID` varchar(10) NOT NULL,
  `content` varchar(200) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `userSent` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`messageID`, `senderID`, `adminID`, `content`, `sent_at`, `userSent`) VALUES
(55, 6, 'A001', 'i wanna know how', '2025-04-27 00:58:28', 1),
(56, 6, 'A001', 'wdym', '2025-04-27 00:58:40', 0),
(57, 55, 'A001', 'just wanted to ask something', '2025-04-27 01:00:06', 1),
(58, 55, 'A001', 'alright no problem! 🥰', '2025-04-27 01:00:40', 0),
(59, 55, 'A001', 'gotcha! 😁', '2025-04-27 01:00:56', 1),
(60, 6, 'A001', 'nothing much', '2025-04-27 01:01:38', 1),
(61, 6, 'A001', 'ok i see whatchu mean', '2025-04-27 01:01:51', 0),
(62, 6, 'A001', 'your price is too high 😢', '2025-04-27 01:02:04', 1);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
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
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notify` tinyint(1) NOT NULL DEFAULT 0,
  `cancel_reason` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderDate`, `status`, `orderAddress`, `orderName`, `orderPhone`, `deliveryMethod`, `deliveredDate`, `tracking`, `discount`, `notify`, `cancel_reason`) VALUES
(1, 1, '2025-03-31', 'Canceled', 'PV18 RESIDENCE, JALAN LANGKAWI, 53000, Kuala Lumpur', 'Wayne Gan', '60126289399', 'Standard', NULL, 0, 119.70, 1, NULL),
(2, 1, '2025-04-23', 'Pending', 'Straits Court, JALAN Ujong pasir, 75050, Melaka', 'MR lolipop', '60126289399', 'Standard', NULL, 1, 0.00, 0, NULL),
(3, 6, '2025-04-26', 'Pending', 'PV18 RESIDENCE, JALAN LANGKAWI, 53000, Kuala Lumpur', 'Cookie Le', '60126289399', 'Standard', NULL, NULL, 0.00, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
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
-- 转存表中的数据 `order_items`
--

INSERT INTO `order_items` (`orderId`, `productId`, `quantity`, `subtotal`, `gripSize`) VALUES
(1, 'R0005', 1, 399.00, '3UG5'),
(2, 'R0060', 1, 199.00, '3UG5'),
(3, 'R0070', 1, 199.00, '3UG5');

-- --------------------------------------------------------

--
-- 表的结构 `product`
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
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `introduction`, `playerInfo`) VALUES
('R0001', 'AeroSharp 11', 499.00, 'AS', 'Precision meets mastery with the AeroSharp 11. Designed for players who dictate the pace of the game, this racket offers superior shuttle control, effortless net play, and unmatched accuracy. The ultra-thin shaft and aerodynamic frame reduce drag, ensuring maximum maneuverability for the smartest players on the court.', 'Ethan Cheng. A tactical genius, Ethan is known for his surgical net drops and pinpoint clears. He controls rallies with calm precision, forcing opponents into mistakes before delivering the final blow.'),
('R0002', 'TurboSmash 1000', 599.00, 'TSM', 'Speed redefined. The TurboSmash 1000 is built for lightning-fast reactions and rapid counterattacks. With an ultra-lightweight frame and enhanced repulsion technology, this racket enables players to unleash quick drives and rapid smashes with ease. Perfect for those who thrive on pace and aggression.', 'Kei Tanaka. With his lightning footwork and relentless attacking style, Kei overwhelms opponents before they can react. His signature double-tap drive keeps defenders scrambling to keep up.'),
('R0003', 'ThunderStrike 88 max', 459.00, 'TST', 'Pure dominance on the court. The ThunderStrike 88 Max is designed for explosive power, engineered with an extra-stiff shaft and head-heavy balance to deliver devastating smashes. Whether attacking from the baseline or finishing at the net, this racket turns every shot into a statement.', 'Aleksandr Ivanov. A powerhouse with a smash that echoes across arenas, Aleksandr thrives on brute force. His signature \"Iron Hammer\" smash has made him a feared opponent worldwide.'),
('R0004', 'ThunderStrike 100', 679.00, 'TST', 'For those who demand control over raw power, the ThunderStrike 100 balances explosive smashes with excellent shot placement. The reinforced T-joint and optimized frame weight create a racket that delivers controlled aggression, allowing powerful yet precise play.', 'Leo Park. A relentless attacker with a strategic mind, Leo mixes powerful smashes with deceptive drop shots, making him unpredictable and deadly in any rally.'),
('R0005', 'Shadow Z', 399.00, 'SHD', 'A perfect fusion of speed and strength, the Shadow Z is built for aggressive players who need both lightning-fast reactions and crushing power. With a revolutionary hybrid frame and reinforced carbon core, this racket ensures rapid-fire play without sacrificing stability.', 'Nathan Cole. A bold, risk-taking player, Nathan’s agility and attacking prowess keep opponents constantly guessing. His signature \"Phantom Smash\"—a deceptive half-smash disguised as a full-power shot—has won him countless matches.'),
('R0006', 'ThunderStrike 99 max', 519.00, 'TST', 'The evolution of power. The ThunderStrike 99 is crafted for relentless attackers who aim to dominate the game. Its high-tension frame and reinforced shaft provide the ultimate combination of stability and power, making it the ultimate weapon for smash-heavy players.', 'Rajat Sharma, known as the \"Wall Breaker,\" Rajat’s smashes have been recorded at over 400 km/h. His aggressive baseline game and ruthless net kills make him an unstoppable force.'),
('R0007', 'AeroSharp 12', 509.00, 'AS', 'An evolution in precision play, the AeroSharp 12 enhances shot accuracy and net finesse. With its balanced frame and ultra-responsive shaft, it caters to tactical players who control tempo and flow.', 'Maya Liu. A quiet strategist, Maya dismantles opponents with graceful footwork and sharp placements, outthinking rather than overpowering.'),
('R0008', 'TurboSmash 1100', 609.00, 'TSM', 'Built for the relentless, the TurboSmash 1100 adds torque-enhanced flexibility for maximum shuttle repulsion. Rapid-fire rallies and back-to-back attacks are its specialty.', 'Kenji Watanabe. Known for his whirlwind style, Kenji’s explosive counters and unstoppable smashes leave no room for hesitation.'),
('R0009', 'ThunderStrike 90', 489.00, 'TST', 'Blending muscle with mobility, the ThunderStrike 90 provides a versatile mix of punch and responsiveness. A racket for players who dominate with strength and speed.', 'Carlos Méndez. An all-court powerhouse, Carlos rains down smashes from all angles, keeping defenders on the run.'),
('R0010', 'Shadow Z2', 429.00, 'SHD', 'The Shadow Z2 adds flex-engineered layers for improved shot recovery and mid-rally power. Designed for explosive play without losing court control.', 'Leila Arif. Unpredictable and fast, Leila confuses with feints and strikes with force. Her style: chaos refined.'),
('R0011', 'AeroSharp X', 549.00, 'AS', 'A pinnacle of finesse, the AeroSharp X integrates carbon-weave technology for elite shuttle control and net precision. Ideal for master tacticians.', 'Damien Zhou. Nicknamed “The Chessmaster,” Damien’s every shot is calculated and cold-blooded.'),
('R0012', 'TurboSmash 1200', 619.00, 'TSM', 'TurboSmash 1200 elevates aggression with a hyper-tensile shaft and lightning frame. Created for rapid play transitions and relentless front-court offense.', 'Sofia Blanco. Blazing speed and relentless energy make Sofia a one-woman highlight reel.'),
('R0013', 'ThunderStrike Titan', 699.00, 'TST', 'Unmatched in brute force, the Titan version features a reinforced graphite core and edge-tuned headweight for thunderous delivery.', 'Omar Singh. Pure carnage on court, Omar brings sheer power with calculated destruction.'),
('R0014', 'Shadow ZX', 459.00, 'SHD', 'Blending power and swiftness, the Shadow ZX includes dual-flex zones and an anti-vibration grip, perfect for quick hitters who can strike from nowhere.', 'Tanya Lin. Fast as a shadow, Tanya weaves through rallies like smoke—then strikes like lightning.'),
('R0015', 'AeroSharp Elite', 579.00, 'AS', 'Crafted for shot artists, the Elite version upgrades responsiveness and tactical control with a precision-balanced shaft.', 'Julian Hart. A magician on court, Julian sees gaps others miss and exploits them with surgical touch.'),
('R0016', 'TurboSmash Blaze', 639.00, 'TSM', 'The Blaze model boosts kinetic repulsion and edge-light structure, allowing unrelenting firepower without exhausting control.', 'Freya Novak. Her fiery style leaves no rally untouched by chaos, and her smash-speed record is unmatched.'),
('R0017', 'ThunderStrike Nova', 509.00, 'TST', 'Nova delivers cosmic power with enhanced torsion control and anti-twist core. A go-to for players seeking heavy offense with fine-tuned control.', 'Arjun Patel. A rising star with galactic smashes and a calm head—Arjun strikes with force and focus.'),
('R0018', 'Shadow Z3', 449.00, 'SHD', 'Z3 upgrades the Shadow legacy with kinetic mesh grip and rapid-flex strings. Built for players who strike hard without warning.', 'Camila Torres. Her sudden drops and smash counters make every rally feel like walking a tightrope.'),
('R0019', 'AeroSharp Nova', 529.00, 'AS', 'With reactive frame balancing and swift recovery mechanics, the AeroSharp Nova brings aerial command and shot anticipation to new heights.', 'Min-Ho Kim. Master of flow, Min-Ho glides from shot to shot with effortless rhythm and quiet control.'),
('R0020', 'TurboSmash Neo', 649.00, 'TSM', 'The Neo edition adds vibration-dampening tech and jet-thrust architecture for smooth yet ferocious play.', 'Rina Yamada. Sleek and fast, Rina’s cross-court power and snappy net play dazzle crowds.'),
('R0021', 'ThunderStrike Edge', 469.00, 'TST', 'Designed for relentless court pressure, the Edge adds cut-resist grommets and torque-lock control zones for ultra-stable shot production.', 'Victor Lau. His relentless pressure and pinpoint timing break through the tightest defenses.'),
('R0022', 'Shadow Z Pro', 499.00, 'SHD', 'Advanced rebound layering and split-torque control make the Z Pro a top-tier choice for high-speed aggression with touch finesse.', 'Sara Jang. Elegant but dangerous, Sara makes the impossible shot look routine.'),
('R0023', 'AeroSharp Vision', 489.00, 'AS', 'Built for predictive play, Vision uses intuitive weight mapping and neutral balance for high precision in tight spaces.', 'Elijah Brooks. A calm storm on the court, Elijah anticipates the play three moves ahead.'),
('R0024', 'TurboSmash Infinity', 659.00, 'TSM', 'Unlimited potential with the Infinity dual-energy core and aero-rebound tech. A beast for extreme offense and fast-paced transitions.', 'Yuki Matsuda. She never stops attacking—every shot is a new explosion.'),
('R0025', 'ThunderStrike Eclipse', 699.00, 'TST', 'Eclipse delivers blackout force with its ultra-dense graphite weave and reinforced shaft. For elite attackers only.', 'Andre Rousseau. The shadow striker, Andre lands every smash like a sledgehammer through space.'),
('R0026', 'Shadow Z Stealth', 479.00, 'SHD', 'The Stealth variant enhances frame acoustics and minimizes swing signature—perfect for players who thrive on surprise and precision.', 'Kira Nakamura. Invisible until it’s too late, Kira’s flicks and smashes seem to come from nowhere.'),
('R0027', 'AeroSharp Spirit', 509.00, 'AS', 'Spirit combines an energy-snap core with adaptive torsion for pinpoint rally control and explosive push shots.', 'Liam Ortega. With flair and finesse, Liam balances mind and muscle in perfect harmony.'),
('R0028', 'TurboSmash Spark', 619.00, 'TSM', 'Spark is raw fire. With acceleration-boost strings and carbon-fusion taper, it triggers fast attacks with electrifying feedback.', 'Emily Zhang. Her game is speed, spark, and no second chances.'),
('R0029', 'ThunderStrike Prime', 549.00, 'TST', 'Prime packs layered strength with ultra-stiff frame integrity for players who control pace through pressure and power.', 'Tobias Meier. Known as “The Engine,” Tobias just keeps going, applying constant, ruthless force.'),
('R0030', 'Shadow Z Alpha', 439.00, 'SHD', 'Alpha enhances the Shadow Z DNA with power-flex zones and layered tension control. Designed for quick-strike players who can turn defense into offense.', 'Amira Solis. Her game is all about timing—deflect, strike, and disappear.'),
('R0031', 'AeroSharp Delta', 529.00, 'AS', 'Delta introduces tri-phase frame engineering for sharp rotation speed and net-lock control, ideal for mid-court domination.', 'Lucas Brandt. A quiet competitor, Lucas works the court like a sculptor—every stroke deliberate, every shot beautiful.'),
('R0032', 'TurboSmash Hyper', 679.00, 'TSM', 'Hyper’s triple-core propulsion and drag-minimized shaft produce relentless pace with silky follow-through.', 'Natalie Reyes. Once she starts attacking, she doesn’t stop. Hyper-aggressive and fearless.'),
('R0033', 'ThunderStrike Alpha Max', 599.00, 'TST', 'Alpha Max adds a reinforced flex-bridge for counterpressure strength and maximum strike torque.', 'Felix Huang. Big energy, bigger hits. Felix owns the baseline like it’s his home turf.'),
('R0034', 'Shadow Z Omega', 489.00, 'SHD', 'Omega’s final form channels precision and pace, using gravity-tuned balance for excellent all-court utility.', 'Zoë Palmer. Tactical yet tenacious, Zoë adapts fast and finishes faster.'),
('R0035', 'AeroSharp Vision X', 559.00, 'AS', 'Vision X upgrades tactical dominance with dynamic weight mapping and reflex-core energy systems.', 'Ethan Rowe. Pure focus. Pure reflex. Ethan’s sharp reads and unflinching defense win rallies before they begin.'),
('R0036', 'TurboSmash Velocity', 649.00, 'TSM', 'Velocity rockets the shuttle with pulse-shot technology and kinetic tension rebound. A machine built for constant attack.', 'Chiara Rossi. Light-speed fast and ten steps ahead, Chiara disorients with pace and precision.'),
('R0037', 'ThunderStrike Raptor', 589.00, 'TST', 'Raptor adds aggressive head-weighting with fast recoil, enabling dominant aerial strikes and punishing kills.', 'Jalen Reed. He stalks the net, strikes from above, and never lets prey escape.'),
('R0038', 'Shadow Z Nova', 509.00, 'SHD', 'Nova harnesses a dual-balance core and amplified whip-flex for sudden, explosive rallies.', 'Nia Morgan. Calm and composed—until she isn’t. Her explosive transitions turn the tide in seconds.'),
('R0039', 'AeroSharp Ghost', 539.00, 'AS', 'Ghost cloaks motion and manipulates tempo with precision-flex memory and passive string tuning.', 'Kai Yamamoto. Subtle, stylish, and dangerous—his ghost shots blur the line between fake and real.'),
('R0040', 'TurboSmash Nitro', 669.00, 'TSM', 'Nitro’s explosive architecture and dynamic string bed create instant attack power for the most aggressive players.', 'Layla Khan. Her style is volatile, but when she’s on fire, there’s no stopping the barrage.'),
('R0041', 'ThunderStrike Omega', 639.00, 'TST', 'Omega upgrades torque control and elastic resonance tech for pinpoint power. Perfect for those who want to finish rallies with finality.', 'Maksim Volkov. Ruthless and robotic, Maksim dominates with mechanical precision.'),
('R0042', 'Shadow Z Strike', 499.00, 'SHD', 'Strike layers enhanced recoil channels and a speed-thin shaft for agile, powerful blows from every angle.', 'Serena Tan. The queen of transitions—she attacks from the back, the net, or mid-air with flawless instinct.'),
('R0043', 'AeroSharp Apex', 579.00, 'AS', 'Apex blends aerodynamic lift and micro-grip detail for tight control over flicks, taps, and net drives.', 'Tyrese Gordon. Smooth operator with no wasted movement—Tyrese flows like water, then cuts like a blade.'),
('R0044', 'TurboSmash Volt', 689.00, 'TSM', 'Volt charges every swing with reactive energy and ultra-dense coil rebound. Built for full-court explosiveness.', 'Ines Müller. Her electrifying playstyle sends sparks through every rally. One mistake, and it’s game over.'),
('R0045', 'Phantom Edge', 529.00, 'PHM', 'A racket shrouded in mystery and performance. The Phantom Edge introduces GhostFrame tech for reduced air resistance and spectral shot recovery. Designed for players who vanish and strike.', 'Noah Ryker. Elusive and calculating, Noah blends stealth with brilliance. His court presence is a riddle opponents cant solve.'),
('R0046', 'Phantom Core', 499.00, 'PHM', 'The Phantom Core is light, lethal, and responsive. With its soul-threaded shaft and energy recoil system, it enables deceptive play and lightning counters.', 'Isla Feng. Her signature style is misdirection—every stroke disguises her next devastating move.'),
('R0047', 'Phantom Vortex', 559.00, 'PHM', 'The Vortex spins opponents into confusion with twisted frame aerodynamics and chaotic shuttle spin control.', 'Zane Mitchell. Known as “The Illusionist,” Zane turns matches into psychological warfare.'),
('R0048', 'Phantom Ghost', 579.00, 'PHM', 'Designed for unseen domination, the Ghost is ultra-light yet deadly. Its FadeGrip handle and soft-release strings help mask swing intent.', 'Mei Sato. Silent on court, Mei strikes with eerie timing and untraceable finesse.'),
('R0049', 'Phantom Reaper', 599.00, 'PHM', 'The Reaper brings judgment in every shot. With spectral tension tech and control-boosting balance, it excels in rally execution and kill shots.', 'Darius Quinn. A legend of clutch moments, Darius’s opponents fear his cold-blooded final strikes.'),
('R0050', 'Phantom Mirage', 549.00, 'PHM', 'The Mirage creates visual deception with its mirrored frame coating and erratic shot feedback. A true weapon for tricksters and mind gamers.', 'Ayla Cruz. A flair-filled performer, Ayla dazzles crowds and opponents with feints, flicks, and unexplainable winners.'),
('R0051', 'Phantom Vibe', 379.00, 'PHM', 'Designed for silent speed, the Phantom Vibe is ultra-maneuverable with a low vibration core. Great for players who outpace rather than overpower.', 'Noah Lin. A smooth and steady rhythm defines his play—never rushed, always in control.'),
('R0052', 'Phantom X', 429.00, 'PHM', 'The Phantom X combines deceptive flex and quick-snap power. Ideal for ambush-style rallies and surprise drives.', 'Aria Chen. Known for vanishing mid-rally and reappearing with a winner, Aria plays like a shadow.'),
('R0053', 'AeroSharp 5', 259.00, 'AS', 'An affordable option for rising tacticians, with a light shaft and reliable control.', 'Zane Wright. Young, quick-thinking, and calm—Zane’s strength lies in his precision.'),
('R0054', 'TurboSmash 600', 299.00, 'TSM', 'Budget-friendly speed with a responsive core, made for entry-level aggression.', 'Sanjay Kapoor. Bursting with energy, Sanjay brings a fast game and fearless attacks.'),
('R0055', 'ThunderStrike Core', 339.00, 'TST', 'Raw power at a low cost, with stiff flex and a focus on smash-heavy play.', 'Luca Petrović. A student of force, Luca is learning to wield power with discipline.'),
('R0056', 'Shadow Lite', 229.00, 'SHD', 'Speed-first racket for beginners and intermediate players who rely on quick footwork.', 'Emma Rae. Nimble and quick, she dashes across the court with a dancer’s grace.'),
('R0057', 'Phantom Flow', 289.00, 'PHM', 'Designed for elegant, deceptive movement. Flexible shaft helps launch surprise flicks and rolls.', 'Reina Matsuno. She glides like wind—barely seen, rarely touched.'),
('R0058', 'Phantom Ace', 349.00, 'PHM', 'A precision player’s racket, tuned for net play and drop shots, with stable handling.', 'Yusuf Idris. A specialist at the net, his touches leave opponents stunned.'),
('R0059', 'TurboSmash 700', 319.00, 'TSM', 'Solid speed and aggressive potential with beginner-friendly handling.', 'Chen Wei. Rising through the ranks, Chen combines smart angles with sneaky pace.'),
('R0060', 'AeroSharp Base', 199.00, 'AS', 'Entry-level AeroSharp model for players learning to control rallies and play smart.', 'Grace Romero. New to the game, but already showing flashes of sharp strategy.'),
('R0061', 'ThunderStrike Micro', 249.00, 'TST', 'A compact, high-rebound racket for learning players who love to hit hard.', 'Jason Moore. Small in size, big on power—Jason swings for the fences.'),
('R0062', 'Phantom Ghost', 409.00, 'PHM', 'A higher-end Phantom with tension-tuned strings and “silent whip” shaft. Deadly for precision strikers.', 'Isla Novak. Cool and unshakable, Isla’s winners come from nowhere.'),
('R0063', 'Shadow Edge', 269.00, 'SHD', 'Sharp and fast, Shadow Edge helps intermediate players push rallies with stealthy speed.', 'Devon Hill. Known for sneaky drop smashes and unmatched footwork.'),
('R0064', 'Phantom Shift', 319.00, 'PHM', 'Built for rhythm changes and play disruption. Balanced frame supports quick transitions.', 'Leo Zhang. Master of rhythm—he speeds up, slows down, and resets the rally at will.'),
('R0065', 'TurboSmash 300', 219.00, 'TSM', 'Simple, clean design for players who want a reliable attack-based racket at a low cost.', 'Natalie King. Learning fast, her smashes are getting harder and smarter every match.'),
('R0066', 'AeroSharp Light', 239.00, 'AS', 'Lightweight with modest flex—perfect for defensive-minded players on a budget.', 'Ravi Mehta. Focused on consistency, Ravi builds points shot by shot.'),
('R0067', 'Phantom Mirage', 389.00, 'PHM', 'Engineered for deception, with semi-stiff flex and high torsional response.', 'Hana Kim. Her shot fakes are legendary—nobody knows where it’s really going.'),
('R0068', 'ThunderStrike 70', 299.00, 'TST', 'Mid-tier power frame, good for developing smash technique and baseline drives.', 'Owen Carter. A raw attacker learning to harness timing and torque.'),
('R0069', 'Shadow Stryke', 369.00, 'SHD', 'Combines sudden burst power and sleek maneuverability. Perfect for quick strike players.', 'Jia Li. She sees patterns no one else sees—and punishes every opening.'),
('R0070', 'Phantom Zero', 199.00, 'PHM', 'Entry-level Phantom with whisper-frame tech and elastic shaft. Light, fast, and silent.', 'Ben Torres. A new Phantom disciple—he practices deception every day.'),
('R0071', 'AeroSharp Core', 219.00, 'AS', 'Sturdy core construction, tuned for control learning and baseline stability.', 'Niko Yamazaki. A thinker on court, always positioning for the next shot.'),
('R0072', 'TurboSmash Spin', 279.00, 'TSM', 'For players experimenting with aggressive lifts and rotating power.', 'Ayaka Shimizu. Loves a fast rally and a spinning drive.'),
('R0073', 'Phantom Hex', 359.00, 'PHM', 'Hexagonal frame edges reduce wind drag, maximizing disguise and swing speed.', 'Ibrahim Salem. Precision and stealth define his game—every movement intentional.'),
('R0074', 'Shadow Whisper', 249.00, 'SHD', 'Low-audio frame design and balanced tension ideal for subtle, controlled play.', 'Lila Morgan. A defensive wall with a killer instinct.'),
('R0075', 'ThunderStrike Basic', 229.00, 'TST', 'Intro-level strike power with balanced handling for learners.', 'Daniël Koenig. Quiet, focused, and determined to master the smash.'),
('R0076', 'Phantom Echo', 409.00, 'PHM', 'Designed for players who control tempo and rhythm, with delayed recoil frame response.', 'Chloe Ng. Her shots echo long after they land.'),
('R0077', 'AeroSharp Rise', 199.00, 'AS', 'Starter model for players learning touch control and court awareness.', 'Marko Silva. Learning fast, rising faster—his control game is coming together.'),
('R0078', 'TurboSmash Quick', 249.00, 'TSM', 'Compact grip and quick response, best for players working on fast rallies.', 'Nina Ivanova. Lightning hands and a love for tight net battles.'),
('R0079', 'Phantom Blade', 389.00, 'PHM', 'Sharp edges and stiffer flex give this racket a slice-through feel, great for fast winners.', 'Zaid Khan. A cutting-edge attacker who finishes points before they start.'),
('R0080', 'Shadow Delta', 299.00, 'SHD', 'Improved frame resilience and solid handling. Ideal for all-round intermediate players.', 'Fatima Rahman. Her balance and timing are deadly.'),
('R0081', 'ThunderStrike Flex', 279.00, 'TST', 'More forgiving flex shaft with head-heavy control for developing players.', 'Ezra Bell. He learns with every strike, slowly building his arsenal.'),
('R0082', 'Phantom Pulse', 379.00, 'PHM', 'Pulse tech amplifies contact feedback, aiding control in deceptive shots.', 'Aliyah Tan. Her pulse-sync rallies make her hard to predict.'),
('R0083', 'AeroSharp Tour', 319.00, 'AS', 'Tour-level handling with tight shaft response and net shot accuracy.', 'Ren Ito. On the edge of pro play, Ren perfects every detail.'),
('R0084', 'TurboSmash Jet', 339.00, 'TSM', 'Jet propulsion build with improved corner-to-corner speed.', 'Maddox Hayes. A blur on court—never still, always attacking.'),
('R0085', 'Shadow Vortex', 369.00, 'SHD', 'Vortex shaping adds twist energy and shot curve potential.', 'Tina Vos. Her control of spin and shape is a thing of beauty.'),
('R0086', 'Phantom Arc', 359.00, 'PHM', 'Arched frame with top-weighted flow—ideal for overhead deception and drop control.', 'Kaito Sugimoto. Every motion a disguise, every arc a trick.'),
('R0087', 'ThunderStrike StrikeLite', 249.00, 'TST', 'A light version of the classic strike series with manageable power.', 'Georgia Neal. Fast and feisty, learning to channel power in new ways.'),
('R0088', 'AeroSharp Reflex', 289.00, 'AS', 'Designed for fast-response counterplay and last-second saves.', 'Kiran Das. Reflexes sharp as a blade—he’s never caught sleeping.'),
('R0089', 'Phantom Nova', 399.00, 'PHM', 'Balanced and elegant, Nova blends clean flex with consistent shot return.', 'Sasha Petrov. Always graceful—until the moment she attacks.'),
('R0090', 'TurboSmash Lite', 219.00, 'TSM', 'Basic, speedy build with balanced grip and low swing weight.', 'Miguel Santos. A developing player, full of energy and drive.'),
('R0091', 'Phantom Line', 289.00, 'PHM', 'For players who draw the line between chaos and control.', 'Hailey Seo. She strikes only when the odds favor her—precise and poised.'),
('R0092', 'Shadow Phantom', 369.00, 'SHD', 'The most Phantom-inspired Shadow yet—flexible, fast, and fluid.', 'Jared Olsen. Smooth and steady, but lethal when provoked.'),
('R0093', 'AeroSharp Scout', 239.00, 'AS', 'Light, mobile and perfect for court coverage drills.', 'Yana Milosz. She never stops moving, always scouting for the next opening.'),
('R0094', 'ThunderStrike VoltLite', 289.00, 'TST', 'Volt series-inspired energy with lighter construction.', 'Luis Moreno. Young, strong, and learning to channel it all.'),
('R0095', 'Phantom Circuit', 349.00, 'PHM', 'Tuned for endurance and rally rhythm—consistency over chaos.', 'Zoe Armstrong. She’ll wear you down, then pick you apart.'),
('R0096', 'TurboSmash Pulse', 329.00, 'TSM', 'High-response strings for constant drive play.', 'Felipe Navarro. Always pressing the pace with nonstop rallies.'),
('R0097', 'Shadow Base', 199.00, 'SHD', 'Starter Shadow model built for entry-level agility and touch.', 'Camryn Lee. Fast feet, big dreams.'),
('R0098', 'Phantom Loop', 269.00, 'PHM', 'With spin-boost strings and counter-drag design, the Loop brings deceptive rally control.', 'Tariq Amin. Loves to grind out points with spin and placement.'),
('R0099', 'AeroSharp Neo', 289.00, 'AS', 'Sharp feel and nimble handling for advancing players.', 'Mina Kwon. Clean strokes and growing confidence.'),
('R0100', 'Phantom Rise', 319.00, 'PHM', 'Lightweight Phantom tuned for beginners ready to level up.', 'Jake Fields. Learning to rise, one swing at a time.'),
('xx25', 'xx1', 0.00, 'xx1', 'dqwdq', 'dqwdq'),
('xx27', 'xx1', 123.00, 'xx1', 'dqdw', 'dqdq');

-- --------------------------------------------------------

--
-- 表的结构 `productstock`
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
-- 转存表中的数据 `productstock`
--

INSERT INTO `productstock` (`productID`, `sizeID`, `stock`, `status`, `low_stock_threshold`, `alert_sent`, `qr_token`) VALUES
('R0001', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0001', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0002', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0002', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0003', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0003', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0004', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0004', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0005', '3UG5', 7, 'onsales', 5, 0, NULL),
('R0005', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0006', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0006', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0007', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0007', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0008', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0008', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0009', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0009', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0010', '3UG5', 8, 'onsales', 0, 0, NULL),
('R0010', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0011', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0011', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0012', '3UG5', 7, 'onsales', 5, 0, NULL),
('R0012', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0013', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0013', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0014', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0014', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0015', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0015', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0016', '3UG5', 7, 'onsales', 5, 0, NULL),
('R0016', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0017', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0017', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0018', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0018', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0019', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0019', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0020', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0020', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0021', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0021', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0022', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0022', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0023', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0023', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0024', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0024', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0025', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0025', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0026', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0026', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0027', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0027', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0028', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0028', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0029', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0029', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0030', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0030', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0031', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0031', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0032', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0032', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0033', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0033', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0034', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0034', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0035', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0035', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0036', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0036', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0037', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0037', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0038', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0038', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0039', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0039', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0040', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0040', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0041', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0041', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0042', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0042', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0043', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0043', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0044', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0044', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0045', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0045', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0046', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0046', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0047', '3UG5', 7, 'onsales', 5, 0, NULL),
('R0047', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0048', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0048', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0049', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0049', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0050', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0050', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0051', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0051', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0052', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0052', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0053', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0053', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0054', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0054', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0055', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0055', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0056', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0056', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0057', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0057', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0058', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0058', '4UG5', 15, 'onsales', 5, 0, NULL),
('R0059', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0059', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0060', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0060', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0061', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0061', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0062', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0062', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0063', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0063', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0064', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0064', '4UG5', 10, 'onsales', 5, 0, NULL),
('R0065', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0065', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0066', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0066', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0067', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0067', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0068', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0068', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0069', '3UG5', 7, 'onsales', 5, 0, NULL),
('R0069', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0070', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0070', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0071', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0071', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0072', '3UG5', 8, 'onsales', 5, 0, NULL),
('R0072', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0073', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0073', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0074', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0074', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0075', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0075', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0076', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0076', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0077', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0077', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0078', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0078', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0079', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0079', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0080', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0080', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0081', '3UG5', 12, 'onsales', 5, 0, NULL),
('R0081', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0082', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0082', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0083', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0083', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0084', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0084', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0085', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0085', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0086', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0086', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0087', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0087', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0088', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0088', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0089', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0089', '4UG5', 13, 'onsales', 5, 0, NULL),
('R0090', '3UG5', 13, 'onsales', 5, 0, NULL),
('R0090', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0091', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0091', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0092', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0092', '4UG5', 9, 'onsales', 5, 0, NULL),
('R0093', '3UG5', 10, 'onsales', 5, 0, NULL),
('R0093', '4UG5', 8, 'onsales', 5, 0, NULL),
('R0094', '3UG5', 11, 'onsales', 5, 0, NULL),
('R0094', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0095', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0095', '4UG5', 14, 'onsales', 5, 0, NULL),
('R0096', '3UG5', 14, 'onsales', 5, 0, NULL),
('R0096', '4UG5', 12, 'onsales', 5, 0, NULL),
('R0097', '3UG5', 6, 'onsales', 5, 0, NULL),
('R0097', '4UG5', 11, 'onsales', 5, 0, NULL),
('R0098', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0098', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0099', '3UG5', 9, 'onsales', 5, 0, NULL),
('R0099', '4UG5', 7, 'onsales', 5, 0, NULL),
('R0100', '3UG5', 15, 'onsales', 5, 0, NULL),
('R0100', '4UG5', 10, 'onsales', 5, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_images`
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
-- 转存表中的数据 `product_images`
--

INSERT INTO `product_images` (`id`, `productID`, `image_path`, `image_type`, `created_at`) VALUES
(3, 'R0002', 'product_R0002_1743343876.png', 'product', '2025-03-30 14:11:16'),
(4, 'R0002', 'player_R0002_1743343876.png', 'player', '2025-03-30 14:11:16'),
(5, 'R0003', 'product_R0003_1743343896.png', 'product', '2025-03-30 14:11:36'),
(6, 'R0003', 'player_R0003_1743343896.png', 'player', '2025-03-30 14:11:36'),
(7, 'R0004', 'product_R0004_1743343915.png', 'product', '2025-03-30 14:11:55'),
(8, 'R0004', 'player_R0004_1743343915.png', 'player', '2025-03-30 14:11:55'),
(9, 'R0005', 'product_R0005_1743343932.png', 'product', '2025-03-30 14:12:12'),
(10, 'R0005', 'player_R0005_1743343932.png', 'player', '2025-03-30 14:12:12'),
(11, 'R0006', 'product_R0006_1743343950.png', 'product', '2025-03-30 14:12:30'),
(12, 'R0006', 'player_R0006_1743343950.png', 'player', '2025-03-30 14:12:30'),
(15, 'R0007', 'product_R0007_1744986951.png', 'product', '2025-04-18 14:35:51'),
(16, 'R0007', 'player_R0007_1744986951.jpg', 'player', '2025-04-18 14:35:51'),
(17, 'R0008', 'product_R0008_1744986995.png', 'product', '2025-04-18 14:36:35'),
(18, 'R0008', 'player_R0008_1744986995.png', 'player', '2025-04-18 14:36:35'),
(19, 'R0009', 'product_R0009_1744987030.png', 'product', '2025-04-18 14:37:10'),
(20, 'R0009', 'player_R0009_1744987030.png', 'player', '2025-04-18 14:37:10'),
(28, 'R0012', 'product_R0012_1744987230.png', 'product', '2025-04-18 14:40:30'),
(29, 'R0013', 'product_R0013_1744987251.png', 'product', '2025-04-18 14:40:51'),
(30, 'R0013', 'player_R0013_1744987251.png', 'player', '2025-04-18 14:40:51'),
(31, 'R0014', 'product_R0014_1744987299.png', 'product', '2025-04-18 14:41:39'),
(32, 'R0014', 'player_R0014_1744987299.png', 'player', '2025-04-18 14:41:39'),
(35, 'R0016', 'product_R0016_1744987346.png', 'product', '2025-04-18 14:42:26'),
(36, 'R0016', 'player_R0016_1744987346.png', 'player', '2025-04-18 14:42:26'),
(37, 'R0015', 'product_R0015_1744987493.png', 'product', '2025-04-18 14:44:53'),
(38, 'R0015', 'player_R0015_1744987493.png', 'player', '2025-04-18 14:44:53'),
(39, 'R0017', 'product_R0017_1744987571.png', 'product', '2025-04-18 14:46:11'),
(40, 'R0017', 'player_R0017_1744987571.png', 'player', '2025-04-18 14:46:11'),
(41, 'R0018', 'product_R0018_1744987612.png', 'product', '2025-04-18 14:46:52'),
(42, 'R0018', 'player_R0018_1744987612.png', 'player', '2025-04-18 14:46:52'),
(43, 'R0019', 'product_R0019_1744987625.png', 'product', '2025-04-18 14:47:05'),
(44, 'R0019', 'player_R0019_1744987625.png', 'player', '2025-04-18 14:47:05'),
(45, 'R0020', 'product_R0020_1744987639.png', 'product', '2025-04-18 14:47:19'),
(46, 'R0020', 'player_R0020_1744987639.png', 'player', '2025-04-18 14:47:19'),
(48, 'R0011', 'product_R0011_1744987703.png', 'product', '2025-04-18 14:48:23'),
(49, 'R0011', 'player_R0011_1744987703.png', 'player', '2025-04-18 14:48:23'),
(50, 'R0021', 'product_R0021_1744987787.png', 'product', '2025-04-18 14:49:47'),
(51, 'R0021', 'player_R0021_1744987787.png', 'player', '2025-04-18 14:49:47'),
(52, 'R0022', 'product_R0022_1744987820.png', 'product', '2025-04-18 14:50:20'),
(53, 'R0022', 'player_R0022_1744987820.jpg', 'player', '2025-04-18 14:50:20'),
(54, 'R0023', 'product_R0023_1744988036.png', 'product', '2025-04-18 14:53:56'),
(55, 'R0023', 'player_R0023_1744988036.png', 'player', '2025-04-18 14:53:56'),
(56, 'R0024', 'product_R0024_1744988049.png', 'product', '2025-04-18 14:54:09'),
(57, 'R0024', 'player_R0024_1744988049.png', 'player', '2025-04-18 14:54:09'),
(58, 'R0025', 'product_R0025_1744988061.png', 'product', '2025-04-18 14:54:21'),
(59, 'R0025', 'player_R0025_1744988061.png', 'player', '2025-04-18 14:54:21'),
(60, 'R0026', 'product_R0026_1744988119.png', 'product', '2025-04-18 14:55:19'),
(61, 'R0026', 'player_R0026_1744988119.png', 'player', '2025-04-18 14:55:19'),
(62, 'R0027', 'product_R0027_1744988140.png', 'product', '2025-04-18 14:55:40'),
(63, 'R0027', 'player_R0027_1744988140.png', 'player', '2025-04-18 14:55:40'),
(64, 'R0028', 'product_R0028_1744988173.png', 'product', '2025-04-18 14:56:13'),
(65, 'R0028', 'player_R0028_1744988173.png', 'player', '2025-04-18 14:56:13'),
(66, 'R0029', 'product_R0029_1744988189.png', 'product', '2025-04-18 14:56:29'),
(67, 'R0029', 'player_R0029_1744988189.png', 'player', '2025-04-18 14:56:29'),
(68, 'R0030', 'product_R0030_1744988204.png', 'product', '2025-04-18 14:56:44'),
(69, 'R0030', 'player_R0030_1744988204.png', 'player', '2025-04-18 14:56:44'),
(70, 'R0031', 'product_R0031_1744988305.png', 'product', '2025-04-18 14:58:25'),
(71, 'R0031', 'player_R0031_1744988305.png', 'player', '2025-04-18 14:58:25'),
(72, 'R0032', 'product_R0032_1744988322.png', 'product', '2025-04-18 14:58:42'),
(73, 'R0032', 'player_R0032_1744988322.png', 'player', '2025-04-18 14:58:42'),
(74, 'R0033', 'product_R0033_1744988333.png', 'product', '2025-04-18 14:58:53'),
(75, 'R0033', 'player_R0033_1744988333.png', 'player', '2025-04-18 14:58:53'),
(76, 'R0034', 'product_R0034_1744988350.png', 'product', '2025-04-18 14:59:10'),
(77, 'R0034', 'player_R0034_1744988350.png', 'player', '2025-04-18 14:59:10'),
(78, 'R0035', 'product_R0035_1744988361.png', 'product', '2025-04-18 14:59:21'),
(79, 'R0035', 'player_R0035_1744988361.png', 'player', '2025-04-18 14:59:21'),
(80, 'R0036', 'product_R0036_1744988371.png', 'product', '2025-04-18 14:59:31'),
(81, 'R0036', 'player_R0036_1744988371.png', 'player', '2025-04-18 14:59:31'),
(82, 'R0037', 'product_R0037_1744988380.png', 'product', '2025-04-18 14:59:40'),
(83, 'R0037', 'player_R0037_1744988380.png', 'player', '2025-04-18 14:59:40'),
(84, 'R0038', 'product_R0038_1744988397.png', 'product', '2025-04-18 14:59:57'),
(85, 'R0038', 'player_R0038_1744988397.png', 'player', '2025-04-18 14:59:57'),
(86, 'R0039', 'product_R0039_1744988409.png', 'product', '2025-04-18 15:00:09'),
(87, 'R0039', 'player_R0039_1744988409.png', 'player', '2025-04-18 15:00:09'),
(88, 'R0040', 'product_R0040_1744988419.png', 'product', '2025-04-18 15:00:19'),
(89, 'R0040', 'player_R0040_1744988419.png', 'player', '2025-04-18 15:00:19'),
(90, 'R0041', 'product_R0041_1744988436.png', 'product', '2025-04-18 15:00:36'),
(91, 'R0041', 'player_R0041_1744988436.png', 'player', '2025-04-18 15:00:36'),
(92, 'R0042', 'product_R0042_1744988454.png', 'product', '2025-04-18 15:00:54'),
(93, 'R0042', 'player_R0042_1744988454.png', 'player', '2025-04-18 15:00:54'),
(94, 'R0043', 'product_R0043_1744988464.png', 'product', '2025-04-18 15:01:04'),
(95, 'R0043', 'player_R0043_1744988464.png', 'player', '2025-04-18 15:01:04'),
(96, 'R0044', 'product_R0044_1744988482.png', 'product', '2025-04-18 15:01:22'),
(97, 'R0044', 'player_R0044_1744988482.png', 'player', '2025-04-18 15:01:22'),
(98, 'R0045', 'product_R0045_1744988493.png', 'product', '2025-04-18 15:01:33'),
(99, 'R0045', 'player_R0045_1744988493.png', 'player', '2025-04-18 15:01:33'),
(100, 'R0046', 'product_R0046_1744988552.png', 'product', '2025-04-18 15:02:32'),
(101, 'R0046', 'player_R0046_1744988552.png', 'player', '2025-04-18 15:02:32'),
(102, 'R0047', 'product_R0047_1744988561.png', 'product', '2025-04-18 15:02:41'),
(103, 'R0047', 'player_R0047_1744988561.png', 'player', '2025-04-18 15:02:41'),
(104, 'R0048', 'product_R0048_1744988570.png', 'product', '2025-04-18 15:02:50'),
(105, 'R0048', 'player_R0048_1744988570.png', 'player', '2025-04-18 15:02:50'),
(106, 'R0049', 'product_R0049_1744988581.png', 'product', '2025-04-18 15:03:01'),
(107, 'R0049', 'player_R0049_1744988581.png', 'player', '2025-04-18 15:03:01'),
(108, 'R0050', 'product_R0050_1744988590.png', 'product', '2025-04-18 15:03:10'),
(109, 'R0050', 'player_R0050_1744988590.png', 'player', '2025-04-18 15:03:10'),
(110, 'R0051', 'product_R0051_1744988622.png', 'product', '2025-04-18 15:03:42'),
(111, 'R0051', 'player_R0051_1744988622.png', 'player', '2025-04-18 15:03:42'),
(112, 'R0052', 'product_R0052_1744988630.png', 'product', '2025-04-18 15:03:50'),
(113, 'R0052', 'player_R0052_1744988630.png', 'player', '2025-04-18 15:03:50'),
(114, 'R0053', 'product_R0053_1744988640.png', 'product', '2025-04-18 15:04:00'),
(115, 'R0053', 'player_R0053_1744988640.png', 'player', '2025-04-18 15:04:00'),
(116, 'R0054', 'product_R0054_1744988661.png', 'product', '2025-04-18 15:04:21'),
(117, 'R0054', 'player_R0054_1744988661.png', 'player', '2025-04-18 15:04:21'),
(118, 'R0055', 'product_R0055_1744988670.png', 'product', '2025-04-18 15:04:30'),
(119, 'R0055', 'player_R0055_1744988670.png', 'player', '2025-04-18 15:04:30'),
(120, 'R0056', 'product_R0056_1744988679.png', 'product', '2025-04-18 15:04:39'),
(121, 'R0056', 'player_R0056_1744988679.png', 'player', '2025-04-18 15:04:39'),
(122, 'R0057', 'product_R0057_1744988695.png', 'product', '2025-04-18 15:04:55'),
(123, 'R0057', 'player_R0057_1744988695.png', 'player', '2025-04-18 15:04:55'),
(126, 'R0058', 'product_R0058_1744988708.png', 'product', '2025-04-18 15:05:08'),
(127, 'R0058', 'player_R0058_1744988708.png', 'player', '2025-04-18 15:05:08'),
(128, 'R0059', 'product_R0059_1744988718.png', 'product', '2025-04-18 15:05:18'),
(129, 'R0059', 'player_R0059_1744988718.png', 'player', '2025-04-18 15:05:18'),
(130, 'R0060', 'product_R0060_1744988731.png', 'product', '2025-04-18 15:05:31'),
(131, 'R0060', 'player_R0060_1744988731.png', 'player', '2025-04-18 15:05:31'),
(132, 'R0061', 'product_R0061_1744988759.png', 'product', '2025-04-18 15:05:59'),
(133, 'R0061', 'player_R0061_1744988759.png', 'player', '2025-04-18 15:05:59'),
(134, 'R0062', 'product_R0062_1744988771.png', 'product', '2025-04-18 15:06:11'),
(135, 'R0062', 'player_R0062_1744988771.png', 'player', '2025-04-18 15:06:11'),
(136, 'R0063', 'product_R0063_1744988788.png', 'product', '2025-04-18 15:06:28'),
(137, 'R0063', 'player_R0063_1744988788.png', 'player', '2025-04-18 15:06:28'),
(138, 'R0064', 'product_R0064_1744988807.png', 'product', '2025-04-18 15:06:47'),
(139, 'R0064', 'player_R0064_1744988807.png', 'player', '2025-04-18 15:06:47'),
(140, 'R0065', 'product_R0065_1744988826.png', 'product', '2025-04-18 15:07:06'),
(141, 'R0065', 'player_R0065_1744988826.png', 'player', '2025-04-18 15:07:06'),
(142, 'R0066', 'product_R0066_1744988837.png', 'product', '2025-04-18 15:07:17'),
(143, 'R0066', 'player_R0066_1744988837.png', 'player', '2025-04-18 15:07:17'),
(144, 'R0067', 'product_R0067_1744988849.png', 'product', '2025-04-18 15:07:29'),
(145, 'R0067', 'player_R0067_1744988849.png', 'player', '2025-04-18 15:07:29'),
(146, 'R0068', 'product_R0068_1744988860.png', 'product', '2025-04-18 15:07:40'),
(147, 'R0068', 'player_R0068_1744988860.png', 'player', '2025-04-18 15:07:40'),
(148, 'R0069', 'product_R0069_1744988888.png', 'product', '2025-04-18 15:08:08'),
(149, 'R0069', 'player_R0069_1744988888.png', 'player', '2025-04-18 15:08:08'),
(150, 'R0070', 'product_R0070_1744988900.png', 'product', '2025-04-18 15:08:20'),
(151, 'R0070', 'player_R0070_1744988900.png', 'player', '2025-04-18 15:08:20'),
(152, 'R0071', 'product_R0071_1744989027.png', 'product', '2025-04-18 15:10:27'),
(153, 'R0071', 'player_R0071_1744989027.png', 'player', '2025-04-18 15:10:27'),
(154, 'R0072', 'product_R0072_1744989038.png', 'product', '2025-04-18 15:10:38'),
(155, 'R0072', 'player_R0072_1744989038.png', 'player', '2025-04-18 15:10:38'),
(156, 'R0073', 'product_R0073_1744989052.png', 'product', '2025-04-18 15:10:52'),
(157, 'R0073', 'player_R0073_1744989052.png', 'player', '2025-04-18 15:10:52'),
(158, 'R0074', 'product_R0074_1744989069.png', 'product', '2025-04-18 15:11:09'),
(159, 'R0074', 'player_R0074_1744989069.png', 'player', '2025-04-18 15:11:09'),
(160, 'R0075', 'product_R0075_1744989081.png', 'product', '2025-04-18 15:11:21'),
(161, 'R0075', 'player_R0075_1744989081.png', 'player', '2025-04-18 15:11:21'),
(162, 'R0010', 'product_R0010_1744989229.png', 'product', '2025-04-18 15:13:49'),
(163, 'R0010', 'player_R0010_1744989229.png', 'player', '2025-04-18 15:13:49'),
(164, 'R0076', 'product_R0076_1744989343.png', 'product', '2025-04-18 15:15:43'),
(165, 'R0076', 'player_R0076_1744989343.png', 'player', '2025-04-18 15:15:43'),
(166, 'R0077', 'product_R0077_1744989357.png', 'product', '2025-04-18 15:15:57'),
(167, 'R0077', 'player_R0077_1744989357.png', 'player', '2025-04-18 15:15:57'),
(168, 'R0078', 'product_R0078_1744989376.png', 'product', '2025-04-18 15:16:16'),
(169, 'R0078', 'player_R0078_1744989376.png', 'player', '2025-04-18 15:16:16'),
(170, 'R0079', 'product_R0079_1744989396.png', 'product', '2025-04-18 15:16:36'),
(171, 'R0079', 'player_R0079_1744989396.png', 'player', '2025-04-18 15:16:36'),
(172, 'R0080', 'product_R0080_1744989414.png', 'product', '2025-04-18 15:16:54'),
(173, 'R0080', 'player_R0080_1744989414.png', 'player', '2025-04-18 15:16:54'),
(174, 'R0081', 'product_R0081_1744989446.png', 'product', '2025-04-18 15:17:26'),
(175, 'R0081', 'player_R0081_1744989446.png', 'player', '2025-04-18 15:17:26'),
(176, 'R0082', 'product_R0082_1744989458.png', 'product', '2025-04-18 15:17:38'),
(177, 'R0082', 'player_R0082_1744989458.png', 'player', '2025-04-18 15:17:38'),
(178, 'R0083', 'product_R0083_1744989475.png', 'product', '2025-04-18 15:17:55'),
(179, 'R0083', 'player_R0083_1744989475.png', 'player', '2025-04-18 15:17:55'),
(180, 'R0084', 'product_R0084_1744989489.png', 'product', '2025-04-18 15:18:09'),
(181, 'R0084', 'player_R0084_1744989489.png', 'player', '2025-04-18 15:18:09'),
(182, 'R0085', 'product_R0085_1744989506.png', 'product', '2025-04-18 15:18:26'),
(183, 'R0085', 'player_R0085_1744989506.png', 'player', '2025-04-18 15:18:26'),
(184, 'R0086', 'product_R0086_1744989521.png', 'product', '2025-04-18 15:18:41'),
(185, 'R0086', 'player_R0086_1744989521.png', 'player', '2025-04-18 15:18:41'),
(186, 'R0087', 'product_R0087_1744989531.png', 'product', '2025-04-18 15:18:51'),
(187, 'R0087', 'player_R0087_1744989531.png', 'player', '2025-04-18 15:18:51'),
(188, 'R0088', 'product_R0088_1744989542.png', 'product', '2025-04-18 15:19:02'),
(189, 'R0088', 'player_R0088_1744989542.png', 'player', '2025-04-18 15:19:02'),
(190, 'R0089', 'product_R0089_1744989558.png', 'product', '2025-04-18 15:19:18'),
(191, 'R0089', 'player_R0089_1744989558.png', 'player', '2025-04-18 15:19:18'),
(192, 'R0090', 'product_R0090_1744989572.png', 'product', '2025-04-18 15:19:32'),
(193, 'R0090', 'player_R0090_1744989572.png', 'player', '2025-04-18 15:19:32'),
(194, 'R0091', 'product_R0091_1744989582.png', 'product', '2025-04-18 15:19:42'),
(195, 'R0091', 'player_R0091_1744989582.png', 'player', '2025-04-18 15:19:42'),
(196, 'R0092', 'product_R0092_1744989595.png', 'product', '2025-04-18 15:19:55'),
(197, 'R0092', 'player_R0092_1744989595.png', 'player', '2025-04-18 15:19:55'),
(198, 'R0093', 'product_R0093_1744989611.png', 'product', '2025-04-18 15:20:11'),
(199, 'R0093', 'player_R0093_1744989611.png', 'player', '2025-04-18 15:20:11'),
(200, 'R0095', 'product_R0095_1744989648.png', 'product', '2025-04-18 15:20:48'),
(201, 'R0095', 'player_R0095_1744989648.png', 'player', '2025-04-18 15:20:48'),
(202, 'R0096', 'product_R0096_1744989669.png', 'product', '2025-04-18 15:21:09'),
(203, 'R0096', 'player_R0096_1744989669.png', 'player', '2025-04-18 15:21:09'),
(204, 'R0097', 'product_R0097_1744989678.png', 'product', '2025-04-18 15:21:18'),
(205, 'R0097', 'player_R0097_1744989678.png', 'player', '2025-04-18 15:21:18'),
(206, 'R0098', 'product_R0098_1744989688.png', 'product', '2025-04-18 15:21:28'),
(207, 'R0098', 'player_R0098_1744989688.png', 'player', '2025-04-18 15:21:28'),
(208, 'R0099', 'product_R0099_1744989696.png', 'product', '2025-04-18 15:21:36'),
(209, 'R0099', 'player_R0099_1744989696.png', 'player', '2025-04-18 15:21:36'),
(210, 'R0100', 'product_R0100_1744989707.png', 'product', '2025-04-18 15:21:47'),
(211, 'R0100', 'player_R0100_1744989707.png', 'player', '2025-04-18 15:21:47'),
(212, 'R0001', 'product_R0001_17457382930.png', 'product', '2025-04-27 07:18:13'),
(213, 'R0001', 'product_R0001_17457382931.png', 'product', '2025-04-27 07:18:13'),
(214, 'R0001', 'product_R0001_17457382932.png', 'product', '2025-04-27 07:18:13'),
(253, 'R0001', 'product_R0001_17456811840.png', 'product', '2025-04-26 15:26:24'),
(254, 'R0001', 'product_R0001_17456811841.jpg', 'product', '2025-04-26 15:26:24'),
(255, 'R0001', 'product_R0001_17456811842.jpg', 'product', '2025-04-26 15:26:24'),
(256, 'R0001', 'player_R0001_17456811840.jpg', 'player', '2025-04-26 15:26:24');

-- --------------------------------------------------------

--
-- 表的结构 `restock_history`
--

DROP TABLE IF EXISTS `restock_history`;
CREATE TABLE `restock_history` (
  `restockID` int(11) NOT NULL,
  `productID` varchar(20) NOT NULL,
  `sizeID` varchar(20) NOT NULL,
  `restock_quantity` int(11) NOT NULL,
  `restock_price` decimal(10,2) NOT NULL,
  `restocked_by` varchar(250) DEFAULT NULL,
  `restock_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `restock_history`
--

INSERT INTO `restock_history` (`restockID`, `productID`, `sizeID`, `restock_quantity`, `restock_price`, `restocked_by`, `restock_time`) VALUES
(103, 'R0001', '3UG5', 12, 298.94, 'admin003', '2024-12-06 01:34:59'),
(104, 'R0001', '4UG5', 10, 271.10, 'admin002', '2024-11-16 01:34:59'),
(105, 'R0002', '3UG5', 12, 179.04, 'admin001', '2023-12-27 01:34:59'),
(106, 'R0002', '4UG5', 8, 161.91, 'admin002', '2024-06-21 01:34:59'),
(107, 'R0003', '3UG5', 7, 250.44, 'admin003', '2024-11-25 01:34:59'),
(108, 'R0003', '4UG5', 7, 184.71, 'admin002', '2023-06-20 01:34:59'),
(109, 'R0004', '3UG5', 6, 247.45, 'admin002', '2023-10-30 01:34:59'),
(110, 'R0004', '4UG5', 12, 221.77, 'admin003', '2024-01-30 01:34:59'),
(111, 'R0005', '3UG5', 7, 171.23, 'admin003', '2024-06-25 01:34:59'),
(112, 'R0005', '4UG5', 13, 231.32, 'admin003', '2024-03-29 01:34:59'),
(113, 'R0006', '3UG5', 13, 193.00, 'admin001', '2025-03-16 01:34:59'),
(114, 'R0006', '4UG5', 12, 119.68, 'admin003', '2023-05-29 01:34:59'),
(115, 'R0007', '3UG5', 6, 191.66, 'admin003', '2025-01-07 01:34:59'),
(116, 'R0007', '4UG5', 15, 170.66, 'admin003', '2023-11-20 01:34:59'),
(117, 'R0008', '3UG5', 11, 198.83, 'admin003', '2023-06-22 01:34:59'),
(118, 'R0008', '4UG5', 15, 205.67, 'admin001', '2024-07-12 01:34:59'),
(119, 'R0009', '3UG5', 10, 103.99, 'admin001', '2024-03-12 01:34:59'),
(120, 'R0009', '4UG5', 7, 185.58, 'admin001', '2024-11-14 01:34:59'),
(121, 'R0010', '3UG5', 15, 193.22, 'admin001', '2023-09-16 01:34:59'),
(122, 'R0010', '4UG5', 6, 212.19, 'admin003', '2023-07-02 01:34:59'),
(123, 'R0011', '3UG5', 7, 272.79, 'admin002', '2024-04-11 01:34:59'),
(124, 'R0011', '4UG5', 11, 158.76, 'admin003', '2025-04-01 01:34:59'),
(125, 'R0012', '3UG5', 15, 113.43, 'admin003', '2025-04-09 01:34:59'),
(126, 'R0012', '4UG5', 6, 296.50, 'admin002', '2025-01-26 01:34:59'),
(127, 'R0013', '3UG5', 14, 266.59, 'admin002', '2024-01-20 01:34:59'),
(128, 'R0013', '4UG5', 5, 191.03, 'admin002', '2025-02-25 01:34:59'),
(129, 'R0014', '3UG5', 9, 201.03, 'admin001', '2025-02-06 01:34:59'),
(130, 'R0014', '4UG5', 8, 264.98, 'admin002', '2024-07-17 01:34:59'),
(131, 'R0015', '3UG5', 14, 209.14, 'admin001', '2025-03-07 01:34:59'),
(132, 'R0015', '4UG5', 6, 127.83, 'admin003', '2023-11-19 01:34:59'),
(133, 'R0016', '3UG5', 6, 165.26, 'admin002', '2023-05-28 01:34:59'),
(134, 'R0016', '4UG5', 8, 200.77, 'admin001', '2024-06-24 01:34:59'),
(135, 'R0017', '3UG5', 11, 265.30, 'admin002', '2024-02-29 01:34:59'),
(136, 'R0017', '4UG5', 9, 119.34, 'admin003', '2025-01-11 01:34:59'),
(137, 'R0018', '3UG5', 15, 148.84, 'admin002', '2023-11-25 01:34:59'),
(138, 'R0018', '4UG5', 15, 168.39, 'admin003', '2023-12-17 01:34:59'),
(139, 'R0019', '3UG5', 5, 274.43, 'admin003', '2024-06-26 01:34:59'),
(140, 'R0019', '4UG5', 13, 105.56, 'admin003', '2024-10-21 01:34:59'),
(141, 'R0020', '3UG5', 8, 276.66, 'admin003', '2024-07-24 01:34:59'),
(142, 'R0020', '4UG5', 5, 225.29, 'admin003', '2024-02-29 01:34:59'),
(143, 'R0021', '3UG5', 5, 168.21, 'admin002', '2024-03-20 01:34:59'),
(144, 'R0021', '4UG5', 10, 258.57, 'admin003', '2025-01-03 01:34:59'),
(145, 'R0022', '3UG5', 13, 156.93, 'admin002', '2023-12-15 01:34:59'),
(146, 'R0022', '4UG5', 13, 169.60, 'admin001', '2023-09-25 01:34:59'),
(147, 'R0023', '3UG5', 12, 199.99, 'admin002', '2023-10-11 01:34:59'),
(148, 'R0023', '4UG5', 12, 270.64, 'admin002', '2024-11-20 01:34:59'),
(149, 'R0024', '3UG5', 6, 162.36, 'admin002', '2025-02-05 01:34:59'),
(150, 'R0024', '4UG5', 13, 244.69, 'admin003', '2024-03-29 01:34:59'),
(151, 'R0025', '3UG5', 12, 146.47, 'admin003', '2025-01-01 01:34:59'),
(152, 'R0025', '4UG5', 7, 176.77, 'admin002', '2024-04-07 01:34:59'),
(153, 'R0026', '3UG5', 13, 112.67, 'admin002', '2025-01-06 01:34:59'),
(154, 'R0026', '4UG5', 6, 237.60, 'admin003', '2024-02-10 01:34:59'),
(155, 'R0027', '3UG5', 11, 262.95, 'admin001', '2024-05-27 01:34:59'),
(156, 'R0027', '4UG5', 10, 157.27, 'admin003', '2023-07-16 01:34:59'),
(157, 'R0028', '3UG5', 12, 115.98, 'admin001', '2024-09-17 01:34:59'),
(158, 'R0028', '4UG5', 6, 203.17, 'admin003', '2023-08-30 01:34:59'),
(159, 'R0029', '3UG5', 10, 128.32, 'admin002', '2024-12-23 01:34:59'),
(160, 'R0029', '4UG5', 11, 255.20, 'admin001', '2025-04-20 01:34:59'),
(161, 'R0030', '3UG5', 15, 158.55, 'admin003', '2024-04-14 01:34:59'),
(162, 'R0030', '4UG5', 6, 100.38, 'admin003', '2024-11-13 01:34:59'),
(163, 'R0031', '3UG5', 11, 175.71, 'admin002', '2024-09-16 01:34:59'),
(164, 'R0031', '4UG5', 15, 180.96, 'admin001', '2024-02-09 01:34:59'),
(165, 'R0032', '3UG5', 11, 242.65, 'admin001', '2024-04-27 01:34:59'),
(166, 'R0032', '4UG5', 6, 148.72, 'admin001', '2024-08-08 01:34:59'),
(167, 'R0033', '3UG5', 14, 253.68, 'admin002', '2024-06-17 01:34:59'),
(168, 'R0033', '4UG5', 12, 106.68, 'admin001', '2025-03-11 01:34:59'),
(169, 'R0034', '3UG5', 14, 250.44, 'admin003', '2025-03-14 01:34:59'),
(170, 'R0034', '4UG5', 6, 193.28, 'admin002', '2024-09-23 01:34:59'),
(171, 'R0035', '3UG5', 12, 282.67, 'admin001', '2024-05-11 01:34:59'),
(172, 'R0035', '4UG5', 15, 285.65, 'admin003', '2023-09-12 01:34:59'),
(173, 'R0036', '3UG5', 7, 197.10, 'admin002', '2024-01-13 01:34:59'),
(174, 'R0036', '4UG5', 15, 297.85, 'admin001', '2024-07-01 01:34:59'),
(175, 'R0037', '3UG5', 12, 143.49, 'admin001', '2024-11-13 01:34:59'),
(176, 'R0037', '4UG5', 9, 232.32, 'admin002', '2023-11-02 01:34:59'),
(177, 'R0038', '3UG5', 5, 250.07, 'admin003', '2023-10-14 01:34:59'),
(178, 'R0038', '4UG5', 14, 245.81, 'admin001', '2024-05-28 01:34:59'),
(179, 'R0039', '3UG5', 10, 267.85, 'admin002', '2024-10-05 01:34:59'),
(180, 'R0039', '4UG5', 12, 197.03, 'admin002', '2024-07-14 01:34:59'),
(181, 'R0040', '3UG5', 13, 225.79, 'admin002', '2023-05-31 01:34:59'),
(182, 'R0040', '4UG5', 5, 291.69, 'admin003', '2023-05-18 01:34:59'),
(183, 'R0041', '3UG5', 10, 248.81, 'admin002', '2025-03-08 01:34:59'),
(184, 'R0041', '4UG5', 10, 139.28, 'admin003', '2024-05-09 01:34:59'),
(185, 'R0042', '3UG5', 5, 237.12, 'admin003', '2023-10-19 01:34:59'),
(186, 'R0042', '4UG5', 13, 164.41, 'admin002', '2023-11-02 01:34:59'),
(187, 'R0043', '3UG5', 10, 216.14, 'admin001', '2025-03-26 01:34:59'),
(188, 'R0043', '4UG5', 13, 148.55, 'admin001', '2025-01-20 01:34:59'),
(189, 'R0044', '3UG5', 10, 117.20, 'admin002', '2024-07-28 01:34:59'),
(190, 'R0044', '4UG5', 10, 131.44, 'admin003', '2023-07-30 01:34:59'),
(191, 'R0045', '3UG5', 6, 258.22, 'admin001', '2023-08-10 01:34:59'),
(192, 'R0045', '4UG5', 13, 196.44, 'admin001', '2023-12-15 01:34:59'),
(193, 'R0046', '3UG5', 13, 161.80, 'admin003', '2024-08-06 01:34:59'),
(194, 'R0046', '4UG5', 7, 216.06, 'admin001', '2024-07-11 01:34:59'),
(195, 'R0047', '3UG5', 5, 254.87, 'admin001', '2023-11-17 01:34:59'),
(196, 'R0047', '4UG5', 5, 280.00, 'admin001', '2023-10-28 01:34:59'),
(197, 'R0048', '3UG5', 7, 220.64, 'admin003', '2024-05-16 01:34:59'),
(198, 'R0048', '4UG5', 9, 203.79, 'admin003', '2024-01-31 01:34:59'),
(199, 'R0049', '3UG5', 9, 219.12, 'admin003', '2023-05-24 01:34:59'),
(200, 'R0049', '4UG5', 5, 263.83, 'admin002', '2024-02-24 01:34:59'),
(201, 'R0050', '3UG5', 7, 120.55, 'admin002', '2024-10-10 01:34:59'),
(202, 'R0050', '4UG5', 15, 165.37, 'admin002', '2023-08-18 01:34:59'),
(203, 'R0051', '3UG5', 13, 233.86, 'admin002', '2023-10-15 01:34:59'),
(204, 'R0051', '4UG5', 15, 273.54, 'admin002', '2023-12-19 01:34:59'),
(205, 'R0052', '3UG5', 14, 222.37, 'admin002', '2025-02-08 01:34:59'),
(206, 'R0052', '4UG5', 9, 213.60, 'admin003', '2023-09-04 01:34:59'),
(207, 'R0053', '3UG5', 10, 175.01, 'admin001', '2023-06-08 01:34:59'),
(208, 'R0053', '4UG5', 5, 274.10, 'admin001', '2023-11-17 01:34:59'),
(209, 'R0054', '3UG5', 10, 209.18, 'admin001', '2023-10-03 01:34:59'),
(210, 'R0054', '4UG5', 11, 139.63, 'admin003', '2024-12-28 01:34:59'),
(211, 'R0055', '3UG5', 10, 202.04, 'admin003', '2024-09-27 01:34:59'),
(212, 'R0055', '4UG5', 5, 130.95, 'admin002', '2023-04-30 01:34:59'),
(213, 'R0056', '3UG5', 14, 161.03, 'admin003', '2024-02-10 01:34:59'),
(214, 'R0056', '4UG5', 8, 257.78, 'admin002', '2023-08-25 01:34:59'),
(215, 'R0057', '3UG5', 12, 272.35, 'admin001', '2024-06-06 01:34:59'),
(216, 'R0057', '4UG5', 7, 105.35, 'admin002', '2024-03-31 01:34:59'),
(217, 'R0058', '3UG5', 8, 228.42, 'admin001', '2024-02-04 01:34:59'),
(218, 'R0058', '4UG5', 14, 190.47, 'admin003', '2023-11-05 01:34:59'),
(219, 'R0059', '3UG5', 15, 158.26, 'admin003', '2024-04-05 01:34:59'),
(220, 'R0059', '4UG5', 14, 130.25, 'admin001', '2024-06-28 01:34:59'),
(221, 'R0060', '3UG5', 11, 238.31, 'admin003', '2025-03-04 01:34:59'),
(222, 'R0060', '4UG5', 14, 218.06, 'admin002', '2023-07-12 01:34:59'),
(223, 'R0061', '3UG5', 8, 162.03, 'admin003', '2023-06-19 01:34:59'),
(224, 'R0061', '4UG5', 9, 289.38, 'admin002', '2024-11-22 01:34:59'),
(225, 'R0062', '3UG5', 14, 224.14, 'admin002', '2024-10-01 01:34:59'),
(226, 'R0062', '4UG5', 15, 154.19, 'admin002', '2025-02-23 01:34:59'),
(227, 'R0063', '3UG5', 10, 208.62, 'admin002', '2024-04-16 01:34:59'),
(228, 'R0063', '4UG5', 6, 233.18, 'admin002', '2024-02-13 01:34:59'),
(229, 'R0064', '3UG5', 8, 112.61, 'admin002', '2025-04-20 01:34:59'),
(230, 'R0064', '4UG5', 13, 112.70, 'admin002', '2024-02-18 01:34:59'),
(231, 'R0065', '3UG5', 15, 261.62, 'admin002', '2024-08-06 01:34:59'),
(232, 'R0065', '4UG5', 8, 228.77, 'admin002', '2025-04-12 01:34:59'),
(233, 'R0066', '3UG5', 5, 191.55, 'admin001', '2024-09-26 01:34:59'),
(234, 'R0066', '4UG5', 8, 210.75, 'admin003', '2024-10-20 01:34:59'),
(235, 'R0067', '3UG5', 11, 107.67, 'admin003', '2024-10-29 01:34:59'),
(236, 'R0067', '4UG5', 11, 106.19, 'admin001', '2024-01-24 01:34:59'),
(237, 'R0068', '3UG5', 11, 160.18, 'admin001', '2025-01-31 01:34:59'),
(238, 'R0068', '4UG5', 6, 195.74, 'admin001', '2023-05-12 01:34:59'),
(239, 'R0069', '3UG5', 7, 145.20, 'admin001', '2023-09-07 01:34:59'),
(240, 'R0069', '4UG5', 12, 299.11, 'admin003', '2023-10-15 01:34:59'),
(241, 'R0070', '3UG5', 14, 102.16, 'admin002', '2024-12-06 01:34:59'),
(242, 'R0070', '4UG5', 12, 298.99, 'admin001', '2025-04-03 01:34:59'),
(243, 'R0071', '3UG5', 13, 225.06, 'admin001', '2023-05-14 01:34:59'),
(244, 'R0071', '4UG5', 9, 177.46, 'admin001', '2024-09-22 01:34:59'),
(245, 'R0072', '3UG5', 13, 230.47, 'admin001', '2024-05-25 01:34:59'),
(246, 'R0072', '4UG5', 13, 121.47, 'admin003', '2023-08-08 01:34:59'),
(247, 'R0073', '3UG5', 10, 163.20, 'admin002', '2023-10-29 01:34:59'),
(248, 'R0073', '4UG5', 10, 104.12, 'admin003', '2023-11-19 01:34:59'),
(249, 'R0074', '3UG5', 9, 209.37, 'admin002', '2025-04-24 01:34:59'),
(250, 'R0074', '4UG5', 8, 260.18, 'admin001', '2023-10-16 01:34:59'),
(251, 'R0075', '3UG5', 14, 192.97, 'admin003', '2025-01-04 01:34:59'),
(252, 'R0075', '4UG5', 13, 106.71, 'admin003', '2024-07-27 01:34:59'),
(253, 'R0076', '3UG5', 15, 268.72, 'admin003', '2023-08-06 01:34:59'),
(254, 'R0076', '4UG5', 7, 116.13, 'admin001', '2024-02-29 01:34:59'),
(255, 'R0077', '3UG5', 12, 296.65, 'admin003', '2024-12-15 01:34:59'),
(256, 'R0077', '4UG5', 15, 175.26, 'admin003', '2025-02-15 01:34:59'),
(257, 'R0078', '3UG5', 5, 274.47, 'admin001', '2024-05-20 01:34:59'),
(258, 'R0078', '4UG5', 7, 274.30, 'admin001', '2023-08-26 01:34:59'),
(259, 'R0079', '3UG5', 9, 266.39, 'admin002', '2023-10-30 01:34:59'),
(260, 'R0079', '4UG5', 14, 196.08, 'admin003', '2025-01-17 01:34:59'),
(261, 'R0080', '3UG5', 6, 250.68, 'admin001', '2024-01-06 01:34:59'),
(262, 'R0080', '4UG5', 8, 203.04, 'admin001', '2025-01-19 01:34:59'),
(263, 'R0081', '3UG5', 11, 255.31, 'admin003', '2023-05-05 01:34:59'),
(264, 'R0081', '4UG5', 14, 292.55, 'admin001', '2024-05-22 01:34:59'),
(265, 'R0082', '3UG5', 9, 191.79, 'admin001', '2023-05-26 01:34:59'),
(266, 'R0082', '4UG5', 14, 115.95, 'admin002', '2024-04-17 01:34:59'),
(267, 'R0083', '3UG5', 15, 183.51, 'admin001', '2023-05-21 01:34:59'),
(268, 'R0083', '4UG5', 5, 223.01, 'admin001', '2025-02-03 01:34:59'),
(269, 'R0084', '3UG5', 13, 163.18, 'admin003', '2024-02-19 01:34:59'),
(270, 'R0084', '4UG5', 10, 216.09, 'admin003', '2024-09-29 01:34:59'),
(271, 'R0085', '3UG5', 10, 198.11, 'admin002', '2024-11-12 01:34:59'),
(272, 'R0085', '4UG5', 13, 167.35, 'admin003', '2023-11-07 01:34:59'),
(273, 'R0086', '3UG5', 7, 136.95, 'admin001', '2024-05-27 01:34:59'),
(274, 'R0086', '4UG5', 9, 209.60, 'admin001', '2023-12-21 01:34:59'),
(275, 'R0087', '3UG5', 15, 130.44, 'admin001', '2024-02-14 01:34:59'),
(276, 'R0087', '4UG5', 6, 130.48, 'admin002', '2024-12-30 01:34:59'),
(277, 'R0088', '3UG5', 7, 271.42, 'admin002', '2023-10-25 01:34:59'),
(278, 'R0088', '4UG5', 12, 191.21, 'admin003', '2023-10-26 01:34:59'),
(279, 'R0089', '3UG5', 15, 272.71, 'admin001', '2023-07-14 01:34:59'),
(280, 'R0089', '4UG5', 12, 150.06, 'admin002', '2024-09-06 01:34:59'),
(281, 'R0090', '3UG5', 11, 167.54, 'admin002', '2024-05-23 01:34:59'),
(282, 'R0090', '4UG5', 15, 256.35, 'admin001', '2025-03-10 01:34:59'),
(283, 'R0091', '3UG5', 9, 221.43, 'admin001', '2024-03-21 01:34:59'),
(284, 'R0091', '4UG5', 5, 112.20, 'admin003', '2024-07-10 01:34:59'),
(285, 'R0092', '3UG5', 15, 125.62, 'admin003', '2024-03-07 01:34:59'),
(286, 'R0092', '4UG5', 11, 294.94, 'admin001', '2024-08-15 01:34:59'),
(287, 'R0093', '3UG5', 10, 156.57, 'admin003', '2023-07-19 01:34:59'),
(288, 'R0093', '4UG5', 7, 252.88, 'admin003', '2024-02-27 01:34:59'),
(289, 'R0094', '3UG5', 9, 127.45, 'admin003', '2023-06-27 01:34:59'),
(290, 'R0094', '4UG5', 7, 176.99, 'admin001', '2025-01-31 01:34:59'),
(291, 'R0095', '3UG5', 12, 288.13, 'admin001', '2024-09-30 01:34:59'),
(292, 'R0095', '4UG5', 7, 193.89, 'admin003', '2024-12-27 01:34:59'),
(293, 'R0096', '3UG5', 9, 290.10, 'admin002', '2023-10-04 01:34:59'),
(294, 'R0096', '4UG5', 10, 202.01, 'admin002', '2024-12-04 01:34:59'),
(295, 'R0097', '3UG5', 9, 242.53, 'admin002', '2024-09-26 01:34:59'),
(296, 'R0097', '4UG5', 10, 203.76, 'admin003', '2024-12-29 01:34:59'),
(297, 'R0098', '3UG5', 5, 135.25, 'admin002', '2023-12-12 01:34:59'),
(298, 'R0098', '4UG5', 10, 184.59, 'admin003', '2023-12-31 01:34:59'),
(299, 'R0099', '3UG5', 10, 168.32, 'admin002', '2024-09-03 01:34:59'),
(300, 'R0099', '4UG5', 11, 259.41, 'admin002', '2025-03-26 01:34:59'),
(301, 'R0100', '3UG5', 14, 137.35, 'admin001', '2025-02-11 01:34:59'),
(302, 'R0100', '4UG5', 11, 255.27, 'admin003', '2023-08-01 01:34:59');

-- --------------------------------------------------------

--
-- 表的结构 `savedaddress`
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
-- 转存表中的数据 `savedaddress`
--

INSERT INTO `savedaddress` (`userID`, `address`, `phoneNo`, `name`, `defaultAdd`, `addressIndex`) VALUES
(1, 'Straits Court, JALAN Ujong pasir, 75050, Melaka', '60126289399', 'MR lolipop', 1, 7),
(6, 'PV18 RESIDENCE, JALAN LANGKAWI, 53000, Kuala Lumpur', '60126289399', 'Cookie Le', 1, 9);

-- --------------------------------------------------------

--
-- 表的结构 `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `seriesID` varchar(3) NOT NULL,
  `seriesName` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `series`
--

INSERT INTO `series` (`seriesID`, `seriesName`) VALUES
('AS', 'AeroSharp'),
('PHM', 'Phantom'),
('SHD', 'Shadow'),
('TSM', 'TurboSmash'),
('TST', 'ThunderStrike');

-- --------------------------------------------------------

--
-- 表的结构 `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `type` enum('verify-email','change-password','remember-user') NOT NULL,
  `selector` char(12) DEFAULT NULL COMMENT 'for remember-user tokens',
  `hashedValidator` char(64) DEFAULT NULL COMMENT 'for remember-user tokens. Hashed with SHA256\r\n',
  `expire` datetime NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'tinyint(1) is the same as boolean. 0 is false, 1 is true.',
  `phoneNo` varchar(15) DEFAULT NULL,
  `gender` enum('F','M','R') NOT NULL DEFAULT 'R' COMMENT 'F: Female. \r\nM: Male.\r\nR: Rather not say',
  `profilePic` varchar(255) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `memberStatus` enum('Active','Blocked') NOT NULL DEFAULT 'Active' COMMENT 'Active: regular registered user. Blocked: barred from admin from logging in.',
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'tinyint(1) is the same as boolean. 0 is false, 1 is true.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`userID`, `username`, `passwordHash`, `address`, `birthdate`, `email`, `emailVerified`, `phoneNo`, `gender`, `profilePic`, `bio`, `memberStatus`, `isDeleted`) VALUES
(1, 'cookie', '$2y$10$y9w5iLGDpKgYyStjoM1.G.sWRoSTKVHIZ/Tk125N7CIVdBZ/iITuC', NULL, NULL, 'cookie@mail.com', 0, '012-3456789', 'R', NULL, 'I love cookies, as you may have already guessed', 'Active', 1),
(2, 'icecream', '$2y$10$HN1VCP3xMBQkkD4fsxUMUe4Ri/ujjDaoJ9u1vZTdibF8yyXjfQ3LG', NULL, NULL, 'icecream@mail.com', 0, '012-9876543', 'R', NULL, 'I love ice cream!', 'Active', 0),
(4, 'cookie2', '$2y$10$j3VTdYyGhsqKo8f0Fn1NMe1lt2Kr9fLKJLEW.AXALN6J6EVqCTpFy', NULL, NULL, 'jasonlhtown@gmail.com', 0, NULL, 'R', NULL, NULL, 'Active', 0),
(5, 'cookie', '$2y$10$8CTUED9iJRZu/B4rNLnVge75vzIivuBxiiOM2nNuV8LDQyO.SLrum', NULL, NULL, 'cookie@mail.com', 0, NULL, 'R', NULL, NULL, 'Active', 1),
(6, 'cookie', '$2y$10$9NRvfqQwZ9276XmS1BYob.ZsLtRPZ8.2RAo4K.O8r2sWRGqJC0Nx6', NULL, NULL, 'cookie@mail.com', 0, NULL, 'R', NULL, NULL, 'Active', 0),
(7, 'cookie3', '$2y$10$.zhdWmdm3mkXIwefOI.9IeHO1vrboeWbKDcYhob0lpwqAH6iluPaq', NULL, NULL, 'haha@mail.com', 0, NULL, 'R', NULL, NULL, 'Active', 0),
(8, 'dlewis', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '2404 Vincent Lake Apt. 343, Lake Suzanne, MI 50120', '1992-09-10', 'anelson@hotmail.com', 1, '(262)205-8820', 'F', 'profPic3.jpg', 'Professional overthinker. I put the \"mental\" in \"fundamental\". Currently training my cat to bring me snacks - so far he just brings me dead bugs.', 'Blocked', 0),
(9, 'eric36', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '66386 Murphy Garden Apt. 911, West Edgar, WA 26275', '1985-06-14', 'thomaspearson@gmail.com', 1, '(329)906-3769', 'F', 'profPic5.jpg', 'I\'m not weird, I\'m a limited edition. My hobbies include arguing with inanimate objects and pretending to remember people\'s names.', 'Blocked', 1),
(10, 'lisa26', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '9676 Edwards Fork, Gregorytown, MD 02923', '1988-08-09', 'ruizmelissa@yahoo.com', 1, '001-504-468-814', 'R', 'profPic9.jpg', 'I\'m not short, I\'m concentrated awesome. My spirit animal is a disgruntled panda who just wants to eat bamboo in peace.', 'Blocked', 0),
(11, 'omurray', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '969 Monica Wells Apt. 367, Port Rebecca, DE 41245', '1990-03-09', 'ksolis@yahoo.com', 0, '001-023-170-243', 'M', 'profPic6.jpg', 'I\'m not arguing, I\'m just passionately expressing my point of view while completely dismissing yours. Also, I can recite the entire script of The Princess Bride backwards.', 'Active', 0),
(12, 'perezgloria', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '005 David Cliff, South Shelby, VT 49228', '2002-07-20', 'charlesbrown@rodriguez.com', 0, '(283)461-0606', 'F', 'profPic5.jpg', 'I\'m not a morning person, not an afternoon person, and definitely not an evening person. Basically, I\'m not a person until I\'ve had coffee.', 'Blocked', 0),
(13, 'martinezdarryl', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '499 Rodriguez Brook, Tyroneburgh, RI 91186', '1992-10-19', 'sarahnelson@mccall-lopez.com', 0, '+1-000-962-1322', 'R', 'profPic5.jpg', 'I\'m not lazy, I\'m just on energy-saving mode. My spirit animal is a sloth riding a turtle while reading a \"Go Faster\" manual.', 'Blocked', 0),
(14, 'brianmoore', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '128 Beasley Tunnel, Lake Rebeccaland, AK 42809', '1991-04-03', 'rgreen@gmail.com', 1, '479.858.7590', 'M', 'profPic3.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right. Also, I can identify over 50 different species of dinosaurs but can\'t remember what I had for breakfast.', 'Blocked', 0),
(15, 'travissmith', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '3346 King Ridges, Keithbury, IN 16341', '1992-10-21', 'jkelley@christensen.com', 1, '(741)317-4475x3', 'M', 'profPic7.jpg', 'I put the \"pro\" in procrastination. Currently writing a novel in my head - the hard part is transferring it to paper. Maybe tomorrow.', 'Active', 0),
(16, 'maddenjordan', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '49087 Michael Mall, Bryanview, AZ 08019', '2005-12-22', 'zknapp@gmail.com', 0, '398-229-0996x32', 'R', 'profPic8.jpg', 'I\'m not short, I\'m fun-sized. My spirit animal is a raccoon who\'s just discovered espresso. I can quote entire episodes of The Office but can\'t remember my own phone number.', 'Blocked', 0),
(17, 'wbaker', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '4376 Bailey Trail, Martinside, AZ 90015', '2005-03-26', 'twashington@sanchez.com', 0, '297.509.6645x65', 'M', 'profPic4.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a loud voice. My hobbies include misplacing important items and finding them immediately after replacing them.', 'Blocked', 0),
(18, 'adavis', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '15863 Wright Mission Apt. 422, Christopherport, HI 03357', '2003-08-22', 'houstongary@lloyd-jones.com', 0, '139.125.8003', 'R', 'profPic3.jpg', 'I\'m not weird, I\'m a limited edition. My brain has too many tabs open and they\'re all playing different songs at the same time.', 'Active', 1),
(19, 'sjohnson', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '79042 David Green Apt. 431, Carloston, MI 74458', '1985-06-08', 'smithpatricia@hebert.com', 1, '201-566-6201', 'R', 'profPic5.jpg', 'I\'m not lazy, I\'m just in energy-saving mode. My spirit animal is a cat who knocks things off tables while maintaining intense eye contact.', 'Blocked', 0),
(20, 'yvettechapman', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '2802 Walters Fort, Berryland, MT 04537', '1997-11-09', 'oholt@yahoo.com', 1, '868.997.0626x55', 'F', 'profPic3.jpg', 'I\'m 98% caffeine and 2% questionable decisions. My hobbies include starting books I\'ll never finish and finishing snacks I probably shouldn\'t have started.', 'Blocked', 0),
(21, 'pollardjames', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '003 Tammy Glens Apt. 598, Feliciabury, NJ 03941', '1996-05-04', 'sarah43@hall.biz', 1, '(347)814-3533', 'M', 'profPic1.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice. My spirit animal is a honey badger who\'s had too much coffee.', 'Active', 1),
(22, 'helliott', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '63621 Figueroa Roads, Kevinview, SC 96900', '2005-09-06', 'brooke59@schwartz.com', 1, '+1-851-356-7855', 'F', 'profPic3.jpg', 'I\'m not short, I\'m concentrated awesome. My hobbies include correcting people\'s grammar and then immediately making typos in my own messages.', 'Active', 0),
(23, 'kylegarrison', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '7880 Green Divide, Joshuaport, TN 37606', '1989-02-09', 'ayersbrandon@gmail.com', 0, '+1-661-839-2761', 'F', 'profPic4.jpg', 'I\'m not weird, I\'m a limited edition. My brain is like an internet browser: 20 tabs open, 3 are frozen, and I have no idea where the music is coming from.', 'Blocked', 0),
(24, 'rebecca12', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '486 Flores Spurs, North Stephaniefort, NY 27735', '1993-08-31', 'lorimartin@fisher.com', 1, '+1-026-125-4810', 'F', 'profPic7.jpg', 'I\'m not lazy, I\'m just on energy-saving mode. My spirit animal is a sloth riding a turtle with a \"Go Faster\" bumper sticker.', 'Active', 0),
(25, 'vowens', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '7895 Jesse Cliffs, Kellyburgh, FL 43772', '2004-12-15', 'barronadrian@tate.com', 1, '001-129-593-543', 'M', 'profPic2.jpg', 'I speak fluent sarcasm and bad decisions. Currently writing my autobiography: \"I Can\'t Believe It\'s Not Better\"', 'Active', 0),
(26, 'brookehanson', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '668 Cruz Loop Apt. 558, Jenniferchester, IL 19115', '1986-05-27', 'arielallen@hotmail.com', 1, '1018329202', 'R', 'profPic6.jpg', 'I\'m 99% caffeine and 1% questionable life choices. My hobbies include starting projects with enthusiasm and finishing them with existential dread.', 'Active', 0),
(27, 'lbell', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '533 Jones Loaf Apt. 979, Michaelberg, NH 82682', '2003-09-19', 'jennifer07@olson.com', 1, '(149)397-3244x8', 'M', 'profPic4.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice while waving my hands dramatically. Also, I can recite the entire script of Monty Python and the Holy Grail.', 'Blocked', 0),
(28, 'qhicks', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '158 Meredith Gateway, Georgeshire, MN 03325', '1993-06-14', 'alexander89@gmail.com', 0, '+1-800-991-0780', 'R', 'profPic5.jpg', 'I\'m not short, I\'m concentrated awesome. My spirit animal is a disgruntled raccoon who\'s judging your life choices from the dumpster.', 'Blocked', 0),
(29, 'jonescarolyn', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '126 William Loop Apt. 535, Port Stephanieside, LA 12818', '1999-11-03', 'cgonzalez@gmail.com', 1, '984-698-1356x48', 'R', 'profPic6.jpg', 'I\'m not weird, I\'m a limited edition. My brain has too many tabs open and they\'re all playing different songs at the same time while buffering.', 'Active', 1),
(30, 'westnancy', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '22470 Angela Canyon, Thomasside, DC 46664', '1988-10-25', 'toddmunoz@hotmail.com', 1, '001-984-016-964', 'F', 'profPic7.jpg', 'I\'m not lazy, I\'m just in energy-saving mode. My spirit animal is a panda who\'s given up on bamboo and is now mainlining espresso.', 'Blocked', 0),
(31, 'larsenbrandon', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '2346 Nathan Stream, East Robert, DE 77107', '1994-07-10', 'ikirk@sparks-mason.com', 0, '+1-741-420-8183', 'R', 'profPic2.jpg', 'I\'m 98% caffeine and 2% questionable decisions. My hobbies include misplacing important items and finding them immediately after replacing them.', 'Active', 1),
(32, 'hollandandrew', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '8184 Taylor River Suite 237, Port David, MN 95270', '1998-08-03', 'byrdstephanie@hotmail.com', 0, '(921)488-4421', 'M', 'profPic10.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice while waving my hands dramatically. Also, I can identify every Pokemon but can\'t remember where I left my keys.', 'Blocked', 0),
(33, 'fberry', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '5604 Diane Trail, Johnton, IA 68097', '1988-01-09', 'michael19@peters-jackson.com', 1, '001-409-737-704', 'R', 'profPic1.jpg', 'I\'m not short, I\'m fun-sized. My spirit animal is a sloth riding a turtle with a \"Go Faster\" bumper sticker while reading a self-help book.', 'Active', 0),
(34, 'jenny91', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '98181 Calvin Falls Suite 559, Shafferview, VA 66824', '1991-05-30', 'claytonleslie@johnson.com', 0, '(456)796-5426x1', 'R', 'profPic5.jpg', 'I\'m not weird, I\'m a limited edition. My brain is like an internet browser: 20 tabs open, 3 are frozen, and I have no idea where the music is coming from.', 'Blocked', 0),
(35, 'reyesstephanie', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '2932 Flynn Extensions, West Shannon, MA 71984', '1998-05-18', 'sandersjanet@gmail.com', 0, '491-354-4593x72', 'R', 'profPic4.jpg', 'I\'m not lazy, I\'m just in energy-saving mode. My hobbies include starting books I\'ll never finish and finishing snacks I probably shouldn\'t have started.', 'Blocked', 0),
(36, 'katiemendoza', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '96580 Pitts Ways Apt. 582, South Brandonmouth, IA 01797', '2004-11-15', 'jenny34@klein.net', 1, '+1-158-550-3110', 'R', 'profPic2.jpg', 'I speak fluent sarcasm and bad decisions. Currently writing my autobiography: \"Oops: A Series of Unfortunate Events\"', 'Active', 0),
(37, 'ibaker', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '64769 Eileen Lodge Suite 503, New Monica, AL 58284', '1989-06-15', 'jshah@gmail.com', 1, '+1-232-584-0674', 'F', 'profPic9.jpg', 'I\'m 99% caffeine and 1% questionable life choices. My spirit animal is a raccoon who\'s just stolen your leftovers and is judging your Netflix queue.', 'Active', 0),
(38, 'bryan52', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '0992 Sanchez Inlet, Garciafort, ND 86825', '2004-07-09', 'martinezjeremy@gmail.com', 0, '(566)252-8665x7', 'F', 'profPic5.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice. My hobbies include correcting people\'s grammar and then immediately making typos in my own messages.', 'Active', 0),
(39, 'matthewwilson', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '78843 Harmon Row, Kochton, MO 41029', '2005-08-28', 'meghanbishop@yahoo.com', 1, '127.827.7407x81', 'M', 'profPic3.jpg', 'I\'m not weird, I\'m a limited edition. My brain has too many tabs open and they\'re all playing different songs at the same time while buffering.', 'Active', 0),
(40, 'toddhopkins', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '94211 William Valleys, Kathleenfort, NH 66752', '2007-02-17', 'moralesdaniel@hotmail.com', 1, '+1-089-971-3863', 'F', 'profPic6.jpg', 'I\'m not lazy, I\'m just on energy-saving mode. My spirit animal is a sloth riding a turtle with a \"Go Faster\" bumper sticker while reading a self-help book.', 'Blocked', 0),
(41, 'herbert35', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '95360 Wright Forges, East Karenland, WI 45002', '1989-06-23', 'danielle36@gmail.com', 1, '001-592-697-970', 'R', 'profPic7.jpg', 'I speak fluent sarcasm and bad decisions. Currently writing my memoir: \"The Art of Selective Listening (When I Feel Like It)\"', 'Blocked', 0),
(42, 'zacharyeaton', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '99338 Williams Hill, Port Alexisbury, TN 95919', '1985-07-09', 'maria64@gmail.com', 0, '657.411.0943', 'R', 'profPic8.jpg', 'I\'m not short, I\'m concentrated awesome. My hobbies include starting projects with enthusiasm and finishing them with existential dread.', 'Active', 0),
(43, 'jason31', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '2434 Warren Lock Apt. 786, West Michael, LA 99802', '2001-01-15', 'wattsevelyn@yahoo.com', 0, '3393153990', 'M', 'profPic1.jpg', 'I\'m 98% caffeine and 2% questionable decisions. My spirit animal is a honey badger who\'s had too much coffee and is now questioning all life choices.', 'Active', 1),
(44, 'donaldarias', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '93793 Amanda Locks, Ortizhaven, AK 57544', '2006-05-02', 'ashleydaniel@hotmail.com', 0, '+1-389-272-9299', 'F', 'profPic7.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice. My hobbies include misplacing important items and finding them immediately after replacing them.', 'Blocked', 0),
(45, 'jennifer60', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '79216 Russell Summit Apt. 775, Linchester, OH 88895', '2000-07-22', 'richardsongloria@hotmail.com', 0, '(675)684-7044x5', 'M', 'profPic1.jpg', 'I\'m not weird, I\'m a limited edition. My brain is like an internet browser: 20 tabs open, 3 are frozen, and I have no idea where the music is coming from.', 'Blocked', 0),
(46, 'brandyrichard', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '08546 Cohen Plain Apt. 027, Beckshire, NC 75899', '2000-01-08', 'contreraslisa@hotmail.com', 1, '382.734.3641x00', 'M', 'profPic1.jpg', 'I\'m not lazy, I\'m just in energy-saving mode. My spirit animal is a panda who\'s given up on bamboo and is now mainlining espresso.', 'Active', 0),
(47, 'xwhite', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '05259 Christopher Heights Suite 197, Marcburgh, MA 98772', '1994-11-29', 'gainesryan@yahoo.com', 1, '045.079.7332x92', 'M', 'profPic3.jpg', 'I speak fluent sarcasm and bad decisions. Currently writing my autobiography: \"I Can\'t Believe It\'s Not Better: The Director\'s Cut\"', 'Blocked', 0),
(48, 'carlsonsherri', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '509 Kristine Mission, Wilsonland, MI 40445', '1990-04-20', 'djones@gmail.com', 1, '962.076.7835x73', 'M', 'profPic1.jpg', 'I\'m not short, I\'m concentrated awesome. My hobbies include correcting people who use \"literally\" figuratively and pretending to understand blockchain.', 'Active', 0),
(49, 'dianecasey', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '3806 Berry Trafficway, New Monicashire, WI 90514', '1998-02-02', 'dgonzalez@vang.biz', 1, '+1-697-839-5454', 'F', 'profPic5.jpg', 'I\'m 99% caffeine and 1% questionable life choices. My spirit animal is a raccoon who\'s just stolen your leftovers and is judging your Netflix queue.', 'Blocked', 0),
(50, 'baileytiffany', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '811 Dunn Village, North Jessicaside, NY 44776', '1994-12-10', 'kevin05@yahoo.com', 0, '001-049-881-906', 'M', 'profPic4.jpg', 'I\'m not arguing, I\'m just explaining why I\'m right in a louder voice while waving my hands dramatically. Also, I can recite the entire script of The Princess Bride backwards.', 'Active', 0),
(51, 'andrew13', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '86344 Sara Fort, Phillipsfurt, MS 83572', '1987-10-17', 'stevenjackson@sanders-trujillo.info', 1, '667-777-7507x60', 'M', 'profPic8.jpg', 'I\'m not weird, I\'m a limited edition. My brain has too many tabs open and they\'re all playing different songs at the same time while buffering.', 'Blocked', 0),
(52, 'troymiller', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '0499 Brittney Rapid, Port Deborah, KY 85990', '2000-03-11', 'edward05@hansen-taylor.com', 1, '001-139-945-788', 'F', 'profPic4.jpg', 'I\'m not lazy, I\'m just on energy-saving mode. My spirit animal is a sloth riding a turtle with a \"Go Faster\" bumper sticker while reading a self-help book.', 'Active', 1),
(53, 'huberanita', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '3117 Julia Land, Patrickstad, CO 19181', '1999-06-15', 'rodney78@franklin.info', 0, '+1-350-380-0853', 'M', 'profPic2.jpg', 'I speak fluent sarcasm and bad decisions. Currently writing my autobiography: \"Oops: A Series of Unfortunate Events\"', 'Blocked', 0),
(54, 'duane14', '$2b$12$qCB5Ixo.GRiJ3YvSQWxbiuBUXTI.wIc.E/Z1NAGOuvU2AC4ul.mHq', '6193 Dennis Junctions, Jamesland, MA 15603', '1989-01-14', 'nathanjames@hotmail.com', 0, '6909842246', 'M', 'profPic8.jpg', 'I\'m not short, I\'m concentrated awesome. My hobbies include starting books I\'ll never finish and finishing snacks I probably shouldn\'t have started.', 'Active', 0),
(55, 'wayne', '$2y$10$bRT7HgBLMQLkOBkTvSApee3CDGcqV/KV4f1rJIoby59YzZu7bVkPC', NULL, NULL, 'waynegyw-wm24@student.tarc.edu.my', 0, NULL, 'R', NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- 表的结构 `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `voucherCode` varchar(15) NOT NULL,
  `amount` int(3) NOT NULL,
  `issuedBy` varchar(10) NOT NULL,
  `allowedUsage` int(10) NOT NULL,
  `totalUsage` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `vouchers`
--

INSERT INTO `vouchers` (`voucherCode`, `amount`, `issuedBy`, `allowedUsage`, `totalUsage`) VALUES
('TEST123', 30, 'A003', 10, 0);

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `blockeduser`
--
ALTER TABLE `blockeduser`
  ADD PRIMARY KEY (`blockedUserID`);

--
-- 表的索引 `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`userID`,`productID`,`sizeID`),
  ADD KEY `productID` (`productID`,`sizeID`);

--
-- 表的索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `senderID` (`senderID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- 表的索引 `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderId`,`productId`,`gripSize`),
  ADD KEY `productId` (`productId`),
  ADD KEY `order_items_ibfk_2` (`productId`,`gripSize`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `seriesID` (`seriesID`);

--
-- 表的索引 `productstock`
--
ALTER TABLE `productstock`
  ADD PRIMARY KEY (`productID`,`sizeID`),
  ADD UNIQUE KEY `qr_token` (`qr_token`);

--
-- 表的索引 `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`);

--
-- 表的索引 `restock_history`
--
ALTER TABLE `restock_history`
  ADD PRIMARY KEY (`restockID`),
  ADD KEY `productID` (`productID`,`sizeID`);

--
-- 表的索引 `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD PRIMARY KEY (`addressIndex`),
  ADD KEY `userID` (`userID`);

--
-- 表的索引 `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`seriesID`);

--
-- 表的索引 `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID-fk` (`userID`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- 表的索引 `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucherCode`),
  ADD KEY `issuedBy` (`issuedBy`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12355;

--
-- 使用表AUTO_INCREMENT `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- 使用表AUTO_INCREMENT `restock_history`
--
ALTER TABLE `restock_history`
  MODIFY `restockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- 使用表AUTO_INCREMENT `savedaddress`
--
ALTER TABLE `savedaddress`
  MODIFY `addressIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- 限制导出的表
--

--
-- 限制表 `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productstock` (`productID`, `sizeID`),
  ADD CONSTRAINT `userid_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- 限制表 `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`senderID`) REFERENCES `user` (`userID`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- 限制表 `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productId`,`gripSize`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`seriesID`) REFERENCES `series` (`seriesID`);

--
-- 限制表 `productstock`
--
ALTER TABLE `productstock`
  ADD CONSTRAINT `productStock_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- 限制表 `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;

--
-- 限制表 `restock_history`
--
ALTER TABLE `restock_history`
  ADD CONSTRAINT `restock_history_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `restock_history_ibfk_2` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- 限制表 `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD CONSTRAINT `savedaddress_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- 限制表 `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `userID-fk` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- 限制表 `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_ibfk_1` FOREIGN KEY (`issuedBy`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
