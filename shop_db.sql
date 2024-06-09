-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 06:07 PM
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
(135, 9, 'Petalsforkite', '', '', 1000, 1, 'pfp.png'),
(144, 7, 'Nemo', 'Disney', '', 654, 1, 'Screenshot 2024-04-29 204217.png'),
(145, 7, ' Games', 'Katniss Everdeen', '', 111, 1, 'hungergamesimages (1).jpg'),
(146, 5, 'God of War', '', '', 123, 1, 'godofwar.jpg');

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
(10, 1, 'Milton Bautista', 'miltonbautista60@gmail.com', '09565017076', 'Hi sir milton! Maybe you could contact me for a business opportunity? Here is my contact:\r\n\r\n09565017076'),
(12, 7, 'JC', 'jc@gmail.com', '098756441445', 'Hello Admin! Your System helps me a lot to find, buy and trade books. Thank You!');

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
(169, 9, 1, 'Contact request regarding product: Petalsforkite. Email: petalskite@gmail.com ', '2024-05-31 02:37:36', 0),
(170, 1, 9, 'You want that?', '2024-05-31 02:37:56', 0),
(171, 9, 1, 'Yes Can I buy it?', '2024-05-31 02:38:07', 0),
(172, 1, 9, 'For sure', '2024-05-31 02:38:11', 0),
(173, 1, 9, 'hahahahaha', '2024-05-31 02:43:55', 0),
(174, 9, 1, 'ano gawa mo', '2024-05-31 02:44:06', 0),
(175, 1, 9, 'wala naman nakaupo lang', '2024-05-31 02:44:12', 0),
(176, 9, 1, 'GANUN OKAY TANGIANH MO POH', '2024-05-31 02:44:17', 0),
(177, 1, 9, 'hahaha', '2024-05-31 02:50:43', 0),
(178, 9, 1, 'asdhadfga', '2024-05-31 02:50:56', 0),
(179, 9, 1, 'gawa MO PRE', '2024-05-31 02:50:59', 0),
(180, 9, 1, 'WTF', '2024-05-31 02:51:30', 0),
(181, 1, 9, 'GHADFGADF', '2024-05-31 02:51:54', 0),
(182, 7, 5, 'Contact request regarding product: Nemo. Email: jc@gmail.com ', '2024-06-02 21:36:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` enum('message','order','cart') NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `buyer_name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `buyer_id`, `seller_id`) VALUES
(29, 9, 'Milton Bautista', 'Milton Bautista', '09565017076', 'miltonbautista60@gmail.com', 'cash on delivery', 'flat no. 5807, Tramo Street San Dionisio, Paranaque City, Philippines - 1700', ', Verification Subscription (1) ', 100, '21-May-2024', 'pending', 9, 0),
(32, 7, 'jc', 'jc', '23123213', 'jc@gmail.com', 'paypal', 'flat no. 23121, 3123213213213, Paranaque, Philippines - 1700', 'Nemo (1), New Moon (1)', 1108, '02-Jun-2024', 'pending', 7, 5),
(33, 7, 'jc', 'jc', '587678', 'jc@gmail.com', 'paypal', 'flat no. 2131231, fgfdgfdgfgdfgdfgdgfgddf, Paranaue, Philippines - 1700', 'Lord of the Rings (1)', 700, '02-Jun-2024', 'pending', 7, 5),
(34, 7, 'jc', 'jc', '587678', 'jc@gmail.com', 'paypal', 'flat no. 2131231, fgfdgfdgfgdfgdfgdgfgddf, Paranaue, Philippines - 1700', 'Adventures of Notlim (1)', 150, '02-Jun-2024', 'pending', 7, 9);

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
(23, 32, 15, 1),
(24, 32, 29, 1),
(25, 33, 14, 1),
(26, 34, 36, 1);

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
  `bookgenre` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `tradestatus` enum('Yes','No') NOT NULL DEFAULT 'No',
  `isbn` varchar(1000) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `author`, `price`, `bookcondition`, `bookgenre`, `image`, `seller_id`, `tradestatus`, `isbn`, `description`) VALUES
(6, 'God of War', 'You', 123, '', 'Action/Adventure', 'godofwar.jpg', 4, 'No', '456', NULL),
(14, 'Lord of the Rings', 'J.R.R Tolkien', 700, 'Old', 'Novel', '51eq24cRtRL__98083.jpg', 5, 'No', '', NULL),
(15, 'Nemo', 'Disney', 654, 'Old', 'Science', 'Screenshot 2024-04-29 204217.png', 5, 'No', '', NULL),
(22, ' Games', 'Katniss Everdeen', 111, 'Old', 'Philosophy', 'hungergamesimages (1).jpg', 5, 'No', '', NULL),
(23, 'Petalsforkite', 'MILTONYU', 1000, 'New', 'Action/Adventure', 'pfp.png', 1, 'Yes', '12315', 'testing of description'),
(29, 'New Moon', 'Stephanie Meyer', 454, 'Old', 'Thriller', 's-l1200.jpg', 5, 'No', '', NULL),
(30, 'Don Quixote', 'Miguel de Cervantes', 665, 'Old', 'Art/Architecture', 'donkihot.jpg', 7, 'Yes', '4984', NULL),
(31, 'the fox and the lamb', 'Jomarz', 888, 'New', 'Drama', 'frog and the ox.jpg', 7, 'Yes', '8884', NULL),
(32, 'the fox and the lamb', 'YOUrk', 111, 'Old', 'Thriller', 'frog and the ox.jpg', 5, 'No', '', NULL),
(33, 'book me', 'YOUrk', 444, 'Old', 'Math', 'unnamed.png', 5, 'No', '', NULL),
(36, 'Adventures of Notlim', 'Milton Bautista', 150, 'New', 'Action/Adventure', '1263.png', 9, 'Yes', '123456789', NULL),
(37, 'How to Kill a Mocking Bird', 'Harper Lee ', 777, 'Used', 'Horror', '1200px-To_Kill_a_Mockingbird_(first_edition_cover).jpg', 7, 'Yes', '123555', NULL);

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
  `contact_no` varchar(20) NOT NULL,
  `bookwishlist1` varchar(100) NOT NULL,
  `bookwishlist2` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT '',
  `verified` tinyint(1) DEFAULT 0,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `birthdate`, `bookshop_name`, `gender`, `contact_no`, `bookwishlist1`, `bookwishlist2`, `image`, `verified`, `otp`, `otp_expiration`, `reset_token`, `reset_expiration`) VALUES
(1, 'Milton', 'miltonbautista60@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', 'National Notlim', 'male', '', '', '', '', 0, NULL, NULL, 'df913d688afe7d925effe50c669090ba', '2024-05-30 07:53:42'),
(2, 'Milton', 'miltonbautistapogii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL),
(3, 'miltonyu01', 'miltonbautistapogiii@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'admin', NULL, NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL),
(4, 'Miltonyupo', 'miltonyupo@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', NULL, NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL),
(5, 'Yoshiroyo', 'yoshiro@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2001-10-08', 'Yoshiroyo Bookshop', 'male', '095551212', 'Advent Time', 'Scooby doo', '', 0, NULL, NULL, NULL, NULL),
(6, 'minimoy', 'minimoy@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL),
(7, 'jc', 'jc@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-04-28', '', 'female', '78945', '', '', '', 0, NULL, NULL, NULL, NULL),
(9, 'Milton Bautista', 'petalskite@gmail.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', 'National Milton', 'male', '', '', '', '', 1, NULL, NULL, '4ea38aa08c5abbae0f4a53759a434a72', '2024-05-30 07:55:10'),
(24, 'Test Account', 'figehir311@javnoi.com', '1ef8c11e22aaf90ac6be87f5a2eff660', 'user', '2001-08-10', NULL, 'male', '', '', '', '', 0, '792774', '2024-05-21 17:46:24', NULL, NULL),
(29, 'katakana', 'katakana@gmai.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-05-15', '', 'male', '09564271546', 'CatDog', 'Spongebob ', '', 0, NULL, NULL, NULL, NULL),
(30, 'Mikha', 'mikha@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2001-06-20', NULL, 'male', '09874552', 'Twilight', 'Hunger Games', '', 0, NULL, NULL, NULL, NULL);

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
(1, 9, '7f55ca94eca847207554373937148384598fdf70ff0427bbbcee4acdb37f20b9', 'approved'),
(3, 7, '61b02003f7db9915197fb25b32bb8c05c8813480d73d5fdafbf1c9238067b39b', 'rejected'),
(4, 7, '332c3dd760d7c4a17edd746367500c5409a89e4c1e1dec2b6401a71befa8aacd', 'rejected'),
(5, 7, 'b422162632170365f7800d6295b8c2e670dc7c782e39fb7f61d576ca7b2ad20f', 'approved');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_messages_users_timestamp` (`sender_id`,`receiver_id`,`timestamp`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `verification_requests`
--
ALTER TABLE `verification_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

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
