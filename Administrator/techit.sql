-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 06:49 AM
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
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  `account_status` enum('activate','deactivate') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user_id`, `email`, `password`, `role`, `profile_img`, `account_status`) VALUES
(37, 48, 'asher@example.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'admin', '67468ac7149af2.41553869.png', 'activate'),
(38, 49, 'tolits@example.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'user', '67468af69414e8.80576942.jpg', 'activate');

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
(18, 'Gaming'),
(10, 'Laptop'),
(16, 'Mouse'),
(14, 'Uncategorized'),
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

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_details_view`
-- (See below for the actual view)
--
CREATE TABLE `order_details_view` (
`order_id` int(11)
,`account_id` int(11)
,`orderDate` datetime
,`total_amount` int(11)
,`status` enum('pending','shipped')
,`product_id` int(11)
,`product_name` varchar(100)
,`product_img` varchar(255)
,`quantity` int(11)
,`unit_price` int(11)
,`total_price` int(11)
,`created` datetime
);

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
(5, 'Ryzen 9 3900XT', 700, 'The **AMD Ryzen 9 3900XT** is a high-performance desktop processor designed for gamers and creators. It features 12 cores and 24 threads, with a boost clock of up to 4.7 GHz, delivering exceptional multitasking and gaming capabilities. Built on the 7nm process, it supports PCIe 4.0 for faster data transfer and is compatible with AM4 motherboards. With its impressive single-threaded and multi-threaded performance, it’s ideal for demanding tasks like 4K gaming, video editing, and 3D rendering.', '6746b173b94a36.60412385.png', '2024-11-01 10:12:27'),
(12, 'Acer Nitro 5', 1500, 'acer Nitro 5 Gaming Laptop, 9th Gen Intel Core i5-9300H, NVIDIA GeForce GTX 1650, 15.6\" Full HD IPS Display, WiFi 6, Waves MaxxAudio, Backlit Keyboard (32GB RAM/512GB PCIe SSD/1TB HDD)', '6745d97f8142e2.90072598.png', '2024-11-26 22:21:51'),
(13, 'PRO X SUPERLIGHT 2 DEX', 200, 'PRO X SUPERLIGHT 2 DEX is a 60 g asymmetrical mouse featuring advanced HERO 2 sensor, robust LIGHTSPEED wireless, and LIGHTFORCE switches while delivering up to 95 hours of battery life.', '6745da267084a0.63666419.png', '2024-11-26 22:24:38'),
(14, 'Razer BlackShark V2', 30, 'Audio Quality: Advanced TriForce Titanium 50mm Drivers deliver crystal-clear sound with enhanced highs, mids, and lows.\r\nComfort: Memory foam ear cushions provide exceptional comfort for long hours of use.\r\nMicrophone: Detachable HyperClear Cardioid Mic ensures superior voice clarity and noise isolation.\r\nCompatibility: Works with PC, PlayStation, Xbox, and mobile devices.\r\nExtras: Includes USB sound card for advanced audio tuning.', '67468c7a692a69.00447251.png', '2024-11-27 11:05:30'),
(15, 'ASUS ROG ALLY Z1', 1500, 'The ASUS ROG Ally is a powerful handheld gaming console with a 7-inch Full HD 120Hz touchscreen, AMD Ryzen Z1 processors, and Windows 11 support. It offers seamless access to PC games, ergonomic controls, and expandable storage for gaming on the go.', '67468d6baff0d0.12197653.png', '2024-11-27 11:09:31'),
(16, 'Intel Iris Xe i5-1235u', 200, 'The **Intel Iris Xe** is an integrated GPU found in Intel’s 11th Gen Core processors, designed for casual gaming, creative tasks, and productivity. It supports modern features like **4K video playback**, **DirectX 12**, and **AI-powered enhancements**, offering decent performance for lightweight gaming and multimedia editing. While not as powerful as discrete GPUs, it’s a great option for thin and light laptops.', '67468dcb69f531.57232761.png', '2024-11-27 11:11:07'),
(17, 'Seagate 1TB HDD', 50, '\r\nAn HDD (Hard Disk Drive) is a traditional data storage device that uses spinning magnetic disks to store and retrieve data. It offers large storage capacities at an affordable price, making it ideal for storing extensive files like movies, games, and backups. However, it is slower and less durable compared to modern SSDs due to its mechanical components.', '67468e23a93790.18612314.png', '2024-11-27 11:12:35'),
(18, 'ASUS ROG STRIX LC II 360 RGB All-in-One Liquid CPU Cooler Fan', 120, 'Seventh Gen Asetek pump delivers exceptional cooling and minimal noise with an operating range starting at 840 rpm.\r\nThree ROG-designed radiator fans provide optimized airflow and static pressure.', '67468e751bfc02.95572904.png', '2024-11-27 11:13:57'),
(19, 'Mystery Screwdriver', 40, 'TRADE OFFER: you give us $39.99, we give you the best screwdriver on the market - in a color of our choice! This is THE BEST PRICE we’ve ever offered on the LTT Screwdriver, and I wouldn’t expect to see a deal like this again for a long time… so don’t hesitate to snatch one up!\r\n\r\nUltra-satisfying ratchet feel & sound\r\nOptimized for smoothness and the most satisfying feel and sound, tightening every screw is a moment in itself. We don’t blame you if you find excuses to use it! ', '67468ef092e711.09772530.png', '2024-11-27 11:16:00'),
(20, 'NZXT Capsule Mini', 50, 'For gaming, a good microphone ensures clear communication and a better overall experience. The **HyperX QuadCast S** is a popular choice, offering excellent sound quality with RGB lighting for a stylish look. It includes a built-in pop filter and shock mount to reduce noise and vibration, making it ideal for both gaming and streaming. Another great option is the **Blue Yeti**, known for its versatile design and exceptional audio clarity. It\'s a reliable USB mic that\'s easy to set up and works well for gaming, podcasting, or streaming. Both are top-notch picks for gamers who value audio quality.', '6746b0d81a96c9.34158394.png', '2024-11-27 13:40:40');

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
(8, 5),
(10, 12),
(16, 13),
(18, 14),
(14, 15),
(10, 16),
(10, 17),
(14, 18),
(14, 19),
(18, 20);

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
(5, 13),
(12, 14),
(13, 14),
(14, 16),
(15, 10),
(16, 20),
(17, 14),
(18, 17),
(19, 14),
(20, 20);

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
(48, 'Levi', 'Penaverde', 20, 'Male', '09385736287'),
(49, 'Angelito', 'Jacalan', 20, 'Male', '09501841852');

-- --------------------------------------------------------

--
-- Structure for view `order_details_view`
--
DROP TABLE IF EXISTS `order_details_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_details_view`  AS SELECT `o`.`order_id` AS `order_id`, `o`.`account_id` AS `account_id`, `o`.`orderDate` AS `orderDate`, `o`.`total_amount` AS `total_amount`, `o`.`status` AS `status`, `ol`.`product_id` AS `product_id`, `p`.`product_name` AS `product_name`, `p`.`product_img` AS `product_img`, `ol`.`quantity` AS `quantity`, `ol`.`unit_price` AS `unit_price`, `ol`.`total_price` AS `total_price`, `ol`.`created` AS `created` FROM ((`orders` `o` join `orderline` `ol` on(`o`.`order_id` = `ol`.`order_id`)) join `product` `p` on(`ol`.`product_id` = `p`.`product_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `username` (`email`),
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
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `orderline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
