-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 09:11 AM
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
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(75, 1, 'God of War', 123, 1, 'godofwar.jpg'),
(85, 5, 'Test', 180, 1, 'the-godfather.jpg'),
(87, 1, 'Lord of the Rings', 800, 0, '51eq24cRtRL__98083.jpg');

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
(57, 1, 5, 'Contact request regarding product: Hunger Games. My details - Name: , Email: , Number: , Message: ', '2024-05-10 12:53:10', 0),
(58, 1, 5, 'Contact request regarding product: Hunger Games. My details - Name: , Email: miltonbautista60@gmail.com, Number: , Message: ', '2024-05-10 12:53:35', 0),
(59, 1, 5, 'Contact request regarding product: Hunger Games. My details - Name: , Email: miltonbautista60@gmail.com, Number: , Message: ', '2024-05-10 12:56:30', 0),
(60, 1, 5, 'Contact request regarding product: Nemo. My details - Name: , Email: , Number: , Message: ', '2024-05-10 13:01:32', 0),
(61, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: , Number: , Message: ', '2024-05-10 13:05:45', 0),
(62, 1, 5, 'Contact request regarding product: Hunger Games. My details - Name: , Email: <br />\r\n<b>Warning</b>:  Undefined array key , Number: , Message: ', '2024-05-10 13:22:31', 0),
(63, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: <br />\r\n<b>Warning</b>:  Undefined variable $fetch_email in <b>C:\\Users\\My PC\\Documents\\GitHub\\Bookworms-application\\shop.php</b> on line <b>89</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\Users\\My PC\\Documents\\GitHub\\Bookworms-application\\shop.php</b> on line <b>89</b><br />\r\n, Number: , Message: ', '2024-05-10 13:24:15', 0),
(64, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: <br />\r\n<b>Warning</b>:  Undefined variable $fetch_email in <b>C:\\Users\\My PC\\Documents\\GitHub\\Bookworms-application\\shop.php</b> on line <b>89</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\Users\\My PC\\Documents\\GitHub\\Bookworms-application\\shop.php</b> on line <b>89</b><br />\r\n, Number: , Message: ', '2024-05-10 13:24:29', 0),
(65, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: , Number: , Message: ', '2024-05-10 13:24:59', 0),
(66, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: hahahaha@haha, Number: , Message: ', '2024-05-10 13:25:18', 0),
(67, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: miltonbautista60@gmail.com, Number: , Message: ', '2024-05-10 13:25:33', 0),
(68, 1, 4, 'Contact request regarding product: God of War. My details - Name: , Email: miltonbautista60@gmail.com, Number: , Message: ', '2024-05-10 13:41:21', 0),
(69, 1, 5, 'Contact request regarding product: Nemo. My details - Name: , Email: miltonbautista60@gmail.com, Number: ', '2024-05-10 14:05:10', 0),
(70, 1, 4, 'Contact request regarding product: God of War. My details - Name: , Email: miltonbautista60@gmail.com, Number: ', '2024-05-10 14:12:05', 0),
(71, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: miltonbautista60@gmail.com, Number: ', '2024-05-10 14:24:01', 0),
(72, 1, 5, 'Contact request regarding product: Nemo. My details - Name: , Email: miltonbautista60@gmail.com, Number: ', '2024-05-10 14:26:14', 0),
(73, 1, 5, 'Contact request regarding product: Lord of the Rings. My details - Name: , Email: miltonbautista60@gmail.com, Number: ', '2024-05-10 14:30:31', 0),
(74, 1, 5, 'Contact request regarding product: Lord of the Rings. Email: miltonbautista60@gmail.com ', '2024-05-10 14:33:13', 0);

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
(28, 4, 'Milton Bautista', 'Miltonyupo', '09565017076', 'miltonyupo@gmail.com', 'cash on delivery', 'flat no. 5807, Tramo Street San Dionisio, Paranaque City, Philippines - 1700', ', Petalsforkite (1) ', 1000, '09-May-2024', 'completed', 4);

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
(16, 28, 23, 1);

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
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `author`, `price`, `bookcondition`, `image`, `seller_id`) VALUES
(6, 'God of War', '', 123, '', 'godofwar.jpg', 4),
(14, 'Lord of the Rings', 'J.R.R Tolkien', 800, 'Old', '51eq24cRtRL__98083.jpg', 5),
(15, 'Nemo', 'Dory', 654, 'New', 'Screenshot 2024-04-29 204217.png', 5),
(22, 'Hunger Games', 'Katniss Everdeen', 111, 'Used', 'hungergamesimages (1).jpg', 5),
(23, 'Petalsforkite', 'MILTONYU', 1000, 'New', 'pfp.png', 1);

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
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `birthdate`, `bookshop_name`, `gender`, `image`, `number`) VALUES
(1, 'Milton', 'miltonbautista60@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', 'National Notlim', 'male', '', '09565017076'),
(2, 'Milton', 'miltonbautistapogii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', ''),
(3, 'miltonyu01', 'miltonbautistapogiii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', ''),
(4, 'Miltonyupo', 'miltonyupo@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', NULL, NULL, NULL, '', ''),
(5, 'Yoshiroyo', 'yoshiro@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2001-10-08', 'Yoshiroyo Bookshop', 'male', '', ''),
(6, 'minimoy', 'minimoy@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL, NULL, '', '');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
