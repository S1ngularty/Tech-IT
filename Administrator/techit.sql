-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 08:46 AM
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

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  `account_status` enum('activate','deactivate') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user_id`, `username`, `password`, `role`, `profile_img`, `account_status`) VALUES
(10, 17, 'Arthur@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', '672e0509748a74.92074139.png', 'activate'),
(12, 19, 'kim@example.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', '67345043bbf208.78801629.png', 'deactivate'),
(21, 30, 'asher@example.com', '1d30ced9ec7b700e17e7cce7c6c0a6c2c46af29c', 'admin', '6742d58338ac56.89428640.jpg', 'activate'),
(22, 31, 'ego@example.com', '8ee7bd92db2d4239c746a393ab1b3dc706c5a44f', 'user', '6742d849b60f43.50373053.jpg', 'activate');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_placed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `account_id`, `product_id`, `quantity`, `date_placed`) VALUES
(32, 10, 4, 1, '2024-11-18 13:36:12'),
(33, 10, 5, 1, '2024-11-18 13:36:14'),
(34, 10, 7, 1, '2024-11-18 13:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `orderline` (
  `orderline_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderline`
--

INSERT INTO `orderline` (`orderline_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `created`) VALUES
(5, 5, 4, 1, 9000, 0, '0000-00-00 00:00:00'),
(6, 5, 5, 1, 5000, 0, '0000-00-00 00:00:00'),
(7, 6, 4, 1, 9000, 0, '0000-00-00 00:00:00'),
(8, 6, 5, 1, 5000, 0, '0000-00-00 00:00:00'),
(9, 6, 7, 1, 2999, 0, '0000-00-00 00:00:00'),
(10, 9, 5, 3, 5000, 0, '0000-00-00 00:00:00'),
(11, 10, 4, 1, 9000, 0, '0000-00-00 00:00:00'),
(12, 10, 5, 1, 5000, 0, '0000-00-00 00:00:00'),
(13, 11, 8, 1, 25000, 0, '0000-00-00 00:00:00'),
(14, 12, 4, 1, 9000, 0, '0000-00-00 00:00:00'),
(15, 13, 4, 1, 9000, 0, '0000-00-00 00:00:00'),
(16, 14, 5, 1, 5000, 0, '0000-00-00 00:00:00'),
(17, 15, 5, 1, 5000, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `orderDate` datetime NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` enum('pending','shipped') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `account_id`, `orderDate`, `total_amount`, `status`) VALUES
(5, 10, '2024-11-12 11:34:12', 14000, 'shipped'),
(6, 10, '2024-11-13 07:48:47', 16999, 'shipped'),
(7, 10, '2024-11-13 07:49:03', 0, 'shipped'),
(8, 10, '2024-11-13 08:02:50', 0, 'shipped'),
(9, 12, '2024-11-13 15:08:45', 15000, 'shipped'),
(10, 10, '2024-11-14 00:03:23', 14000, 'pending'),
(11, 10, '2024-11-14 00:04:34', 25000, 'pending'),
(12, 10, '2024-11-16 21:24:17', 9000, 'pending'),
(13, 10, '2024-11-16 21:31:32', 9000, 'pending'),
(14, 10, '2024-11-16 22:28:08', 5000, 'pending'),
(15, 10, '2024-11-16 22:28:33', 5000, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `product_description` text NOT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
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

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `account_id`, `product_id`, `comment`, `rating`, `create_at`, `update_at`) VALUES
(1, 10, 4, '', 0, '2024-11-16 13:33:39', '2024-11-16 13:33:39'),
(2, 10, 4, '', 1, '2024-11-16 13:41:05', '2024-11-16 13:41:05'),
(3, 10, 4, '', 2, '2024-11-16 14:24:57', '2024-11-16 14:24:57'),
(4, 10, 4, '', 5, '2024-11-16 14:25:25', '2024-11-16 14:25:25'),
(5, 10, 4, 'On you feet, dad.....,,.', 4, '2024-11-16 14:26:25', '2024-11-16 14:26:25'),
(6, 10, 4, '', 5, '2024-11-16 14:26:28', '2024-11-16 14:26:28'),
(7, 10, 5, '', 0, '2024-11-16 14:29:00', '2024-11-16 14:29:00'),
(8, 10, 5, '', 0, '2024-11-16 14:29:34', '2024-11-16 14:29:34'),
(9, 10, 5, 'asdasd', 4, '2024-11-16 14:30:51', '2024-11-16 14:30:51'),
(10, 10, 5, 'asdasda', 1, '2024-11-16 14:32:01', '2024-11-16 14:32:01'),
(11, 10, 5, 'esfdvd', 1, '2024-11-16 14:32:46', '2024-11-16 14:32:46'),
(12, 10, 5, 'esfdvd', 1, '2024-11-16 14:32:47', '2024-11-16 14:32:47'),
(13, 10, 5, 'dasdaasd', 2, '2024-11-16 14:33:21', '2024-11-16 14:33:21'),
(14, 10, 5, 'asdasd', 3, '2024-11-16 14:34:09', '2024-11-16 14:34:09'),
(15, 10, 5, 'Lorem ipsum', 4, '2024-11-16 14:34:40', '2024-11-16 14:34:40'),
(16, 10, 4, '', 0, '2024-11-17 14:26:35', '2024-11-17 14:26:35'),
(17, 10, 4, '', 0, '2024-11-17 14:27:16', '2024-11-17 14:27:16'),
(18, 10, 4, 'Bankai Minazuki', 1, '2024-11-17 14:27:49', '2024-11-17 14:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `product_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
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

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `contacts` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `age`, `sex`, `contacts`) VALUES
(17, 'Arthur', 'Leywin', 25, 'Male', '9121233214'),
(19, 'Kim', 'Yebes', 19, 'Male', '98766765'),
(30, 'Levi Asher', 'Penaverde', 19, 'Male', '09385736287'),
(31, 'Ianzaee', 'Ego', 69, 'Female', '09123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_fk` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_cart_fk` (`product_id`),
  ADD KEY `account_cart_fk` (`account_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`orderline_id`),
  ADD KEY `order_fk` (`order_id`),
  ADD KEY `product_orderline_fk` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `account_order_fk` (`account_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`,`product_img`),
  ADD UNIQUE KEY `product_img` (`product_img`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD KEY `category_fk` (`category_id`),
  ADD KEY `procat_fk` (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_product_fk` (`product_id`),
  ADD KEY `review_account_fk` (`account_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD KEY `product_fk` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `contacts` (`contacts`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `orderline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `account_cart_fk` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_cart_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `account_order_fk` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `review_account_fk` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
