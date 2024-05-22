-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 10:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `bookcondition` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `qUantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `author`, `bookcondition`, `price`, `qUantity`, `image`) VALUES
(75, 1, 'God of War', '', '', 123, 1, 'godofwar.jpg'),
(119, 5, 'God of War', '', '', 123, 1, 'godofwar.jpg'),
(123, 7, 'New Moon', 'Stephanie Meyer', 'Old', 454, 1, 's-l1200.jpg'),
(124, 7, 'Petalsforkite', 'MILTONYU', 'New', 1000, 1, 'pfp.png'),
(128, 7, ' Games', 'Katniss Everdeen', '', 111, 1, 'hungergamesimages (1).jpg'),
(129, 5, 'Don Quixote', 'Miguel de Cervantes', 'Old', 665, 1, 'donkihot.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 1, 'Milton Bautista', 'miltonbautista60@gmail.com', '09565017076', 'Hi sir milton! Maybe you could contact me for a business opportunity? Here is my contact:\r\n\r\n09565017076');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `is_read`) VALUES
(56, 1, 4, 'Contact request regarding product: God of War. My details - Name: , Email: miltonbautista60@gmail.com, Number: , Message: ', '2024-05-09 08:59:19', 0),
(74, 7, 5, 'Contact request regarding product: Nemo. My details - Name: , Email: yoshiro@gmail.com, Number: , Message: ', '2024-05-10 04:12:20', 0),
(107, 7, 5, 'Contact request regarding product: Nemo. My details - Name: , Email: yoshiro@gmail.com, Number: , Message: ', '2024-05-10 04:50:20', 0),
(108, 9, 7, 'Contact request regarding product: Don Quixote. Email: petalskite@gmail.com ', '2024-05-20 21:48:35', 0),
(109, 9, 4, 'Contact request regarding product: God of War. Email: petalskite@gmail.com ', '2024-05-20 21:49:57', 0),
(110, 9, 5, 'Contact request regarding product: Nemo. Email: petalskite@gmail.com ', '2024-05-20 21:50:45', 0),
(111, 9, 5, 'Contact request regarding product: Lord of the Rings. Email: petalskite@gmail.com ', '2024-05-20 21:51:59', 0),
(112, 9, 5, 'Contact request regarding product: Lord of the Rings. Email: petalskite@gmail.com ', '2024-05-22 02:03:30', 0),
(113, 9, 1, 'Contact request regarding product: Petalsforkite. Email: petalskite@gmail.com ', '2024-05-22 02:29:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `buyer_name` varchar(100) DEFAULT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `buyer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `buyer_name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `buyer_id`) VALUES
(27, 4, 'Milton Bautista', 'Miltonyupo', '09565017076', 'miltonbautista60@gmail.com', 'cash on delivery', 'flat no. 5807, Tramo Street, Paranaque City, Philippines\\ - 1700', ', Test (1) ', 180, '03-May-2024', 'pending', 4),
(28, 4, 'Milton Bautista', 'Miltonyupo', '09565017076', 'miltonyupo@gmail.com', 'cash on delivery', 'flat no. 5807, Tramo Street San Dionisio, Paranaque City, Philippines - 1700', ', Petalsforkite (1) ', 1000, '09-May-2024', 'completed', 4),
(29, 9, 'Milton Bautista', 'Milton Bautista', '09565017076', 'miltonbautista60@gmail.com', 'cash on delivery', 'flat no. 5807, Tramo Street San Dionisio, Paranaque City, Philippines - 1700', ', Verification Subscription (1) ', 100, '21-May-2024', 'pending', 9);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(13, 27, 0, 1),
(14, 27, 3, 1),
(15, 28, 0, 1),
(16, 28, 23, 1),
(17, 29, 0, 1),
(18, 29, 35, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `bookcondition` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `tradestatus` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `author`, `price`, `bookcondition`, `image`, `seller_id`, `tradestatus`) VALUES
(6, 'God of War', '', 123, '', 'godofwar.jpg', 4, 'No'),
(14, 'Lord of the Rings', 'J.R.R Tolkien', 700, '', '51eq24cRtRL__98083.jpg', 5, 'No'),
(15, 'Nemo', 'Disney', 654, '', 'Screenshot 2024-04-29 204217.png', 5, 'No'),
(22, ' Games', 'Katniss Everdeen', 111, '', 'hungergamesimages (1).jpg', 5, 'No'),
(23, 'Petalsforkite', 'MILTONYU', 1000, 'New', 'pfp.png', 1, 'Yes'),
(29, 'New Moon', 'Stephanie Meyer', 454, 'Old', 's-l1200.jpg', 5, 'No'),
(30, 'Don Quixote', 'Miguel de Cervantes', 665, 'Old', 'donkihot.jpg', 7, 'No'),
(31, 'the fox and the lamb', 'Jomarz', 543, 'New', 'frog and the ox.jpg', 7, 'No'),
(32, 'the fox and the lamb', 'YOUrk', 111, 'Old', 'frog and the ox.jpg', 5, 'No'),
(33, 'book me', 'YOUrk', 444, '', 'banner-5.jpg', 5, 'No'),
(35, 'Verification Subscription', '', 100, '', '', 0, 'No'),
(36, 'Adventures of Notlim', 'Milton Bautista', 150, 'New', '1263.png', 9, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `birthdate` date DEFAULT NULL,
  `bookshop_name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT '',
  `verified` tinyint(1) DEFAULT 0,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `birthdate`, `bookshop_name`, `gender`, `image`, `verified`, `otp`, `otp_expiration`) VALUES
(0, 'verifiedUser', 'verified@gmail.com', '', 'verified', NULL, NULL, NULL, '', 0, NULL, NULL),
(1, 'Milton', 'miltonbautista60@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', 'National Notlim', 'male', '', 0, NULL, NULL),
(2, 'Milton', 'miltonbautistapogii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', 0, NULL, NULL),
(3, 'miltonyu01', 'miltonbautistapogiii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', 0, NULL, NULL),
(4, 'Miltonyupo', 'miltonyupo@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', NULL, NULL, NULL, '', 0, NULL, NULL),
(5, 'Yoshiroyo', 'yoshiro@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2001-10-08', 'Yoshiroyo Bookshop', 'male', '', 0, NULL, NULL),
(6, 'minimoy', 'minimoy@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL, NULL, '', 0, NULL, NULL),
(7, 'jc', 'jc@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-04-28', NULL, 'female', '', 0, NULL, NULL),
(8, 'ikaw at ako', 'ikawako@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-05-30', NULL, 'male', '', 0, NULL, NULL),
(9, 'Milton Bautista', 'petalskite@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', 'National Milton', 'male', '', 1, NULL, NULL),
(24, 'Test Account', 'figehir311@javnoi.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', NULL, 'male', '', 0, '792774', '2024-05-21 17:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `verification_requests`
--

CREATE TABLE `verification_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `valid_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification_requests`
--

INSERT INTO `verification_requests` (`id`, `user_id`, `valid_id`, `status`) VALUES
(1, 9, '7f55ca94eca847207554373937148384598fdf70ff0427bbbcee4acdb37f20b9', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `verification_requests`
--
ALTER TABLE `verification_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD CONSTRAINT `verification_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
