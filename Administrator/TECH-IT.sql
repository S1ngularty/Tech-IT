-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 02:56 AM
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
-- Database: `techit`
--
CREATE DATABASE IF NOT EXISTS `techit` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `techit`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_fk` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user_id`, `username`, `password`, `role`, `profile_img`) VALUES
(3, 3, 'asher@example.com', '1d30ced9ec7b700e17e7cce7c6c0a6c2c46af29c', 'admin', '67241e8765ed14.94607411.jpg'),
(6, 13, 'melvin@example.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', '672c9f8853d5a3.40038007.png'),
(7, 14, 'hans@example.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', '672ca1871a2d68.59452921.jpg'),
(9, 16, 'cindy@example.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', '672d65cc88af96.16531056.png');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(5, 'Gaming'),
(10, 'Laptops'),
(4, 'Uncategorized'),
(8, 'Upgrade');

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

CREATE TABLE IF NOT EXISTS `orderline` (
  `orderline_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`orderline_id`),
  KEY `order_fk` (`order_id`),
  KEY `product_orderline_fk` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `orderDate` datetime NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` enum('pending','shipped') NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_order_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `product_description` text NOT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`,`product_img`),
  UNIQUE KEY `product_img` (`product_img`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `product_description`, `product_img`, `date_added`) VALUES
(4, 'GPU', 9000, 'A GPU, or graphics processing unit, is an electronic circuit that\'s designed to process graphics and perform mathematical calculations quickly', '67247997b817f0.51533430.jpg', '2024-11-01 09:55:33'),
(5, 'CPU', 5000, ' It is the primary component of a computer that performs most of the processing and control functions', '672479b4d18d24.55399969.jpg', '2024-11-01 10:12:27'),
(7, 'Monitor', 2999, 'A monitor is an electronic output device used to display information being entered and processed on a computer.', '6724ea4c031a79.94144893.jpg', '2024-11-01 22:48:44'),
(8, 'Laptop AL15-5', 25000, ' a portable computer that is small enough to use on ones lap, has its main components (as keyboard and display screen) combined in one unit, and can run on battery power.', '67250a940fa6a1.62943538.jpg', '2024-11-02 01:06:28'),
(9, 'SSD', 5900, 'Solid-state drives (SSDs) are the most common storage drives today. SSDs are smaller and faster than hard disk drives (HDDs). ', '67275ac95e08a1.70537664.jpg', '2024-11-03 19:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  KEY `category_fk` (`category_id`),
  KEY `procat_fk` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `product_id`) VALUES
(5, 4),
(8, 5),
(10, 8),
(5, 7),
(8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`),
  KEY `review_user_fk` (`user_id`),
  KEY `review_product_fk` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `product_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  KEY `product_fk` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`product_id`, `stock`) VALUES
(4, 11),
(5, 15),
(7, 33),
(8, 6),
(9, 13);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `contacts` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `contacts` (`contacts`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `age`, `sex`, `contacts`) VALUES
(3, 'Levi', 'Penaverde', 19, 'Male', 9385736287),
(12, 'Melvin', 'Catuera', 20, 'Male', 97867664),
(13, 'Melvin', 'Catuera', 20, 'Male', 935345),
(14, 'Hans Ivan', 'Penaverde', 14, 'Male', 97654345),
(16, 'Cindy', 'Penaverde', 8, 'Female', 998767546);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderline`
--
ALTER TABLE `orderline`
  ADD CONSTRAINT `order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_orderline_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `user_order_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `procat_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
