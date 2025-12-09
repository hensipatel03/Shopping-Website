-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 09:51 AM
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
-- Database: `trendvibe`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_user`
--

CREATE TABLE `login_user` (
  `user_id` int(100) NOT NULL,
  `user_fname` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pwd` varchar(100) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_address` text NOT NULL,
  `user_role` varchar(50) NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_user`
--

INSERT INTO `login_user` (`user_id`, `user_fname`, `user_email`, `user_pwd`, `user_phone`, `user_address`, `user_role`) VALUES
(9, 'Admin', 'admin@gmail.com', 'admin', '6352696949', 'Gujarat, India', 'admin'),
(30, 'Fenil Patel', 'fenil@gmail.com', '1234', '9865326578', 'patan,gujarat', 'normal'),
(32, 'Patel hensi Jitendrakumar ', 'hdp@gmail.com', '1234', '7845125489', '4, vedant society,  80 foot ring road ,unjha', 'normal'),
(33, 'Shah Vikram Rahulbhai', 'svp@gmail.com', '1234', '8965235689', '3,Bha park,Palanpur', 'normal'),
(35, 'Patel Prey Amitkumar', 'pap@gmail.com', '1234', '7854125489', 'Ahemdabad, India', 'normal'),
(36, 'Patel Mudra Pareshbhai', 'mdp@gmail.com', '1234', '7845895632', 'Surat, India', 'normal'),
(37, 'Panchal vishva kaushikbhai', 'pvk@gmail.com', '1234', '9856238965', 'Bhapark, unjha', 'normal'),
(38, 'Joshi Purva', 'jp@gmail.com', '1234', '9865328965', 'Surat, India', 'normal'),
(39, 'Prajapati Shubh', 'shubh@gmail.com', '1234', '9898656532', 'Bhavnagar, India', 'normal'),
(40, 'Puja Joshi', 'puja@gmail.com', '1234', '7946131346', 'Surat, India', 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` varchar(50) NOT NULL,
  `user_id` int(100) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Success'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `user_id`, `product_id`, `order_date`, `payment_amount`, `payment_id`, `status`) VALUES
('ORD14123FB8-1', 30, 43, '2025-10-12 02:04:03', 3998.00, 'PAY7759', 'Success'),
('ORD14123FB8-2', 30, 53, '2025-10-12 02:04:03', 8100.00, 'PAY7759', 'Success'),
('ORD14123FB8-3', 30, 61, '2025-10-12 02:04:03', 1999.00, 'PAY7759', 'Success'),
('ORD54D55D94-1', 30, 48, '2025-10-12 02:09:57', 1998.00, 'PAY8157', 'Success'),
('ORD54D55D94-3', 30, 47, '2025-10-12 02:09:57', 26991.00, 'PAY8157', 'Success'),
('ORD8729BA70-1', 32, 48, '2025-10-11 22:37:50', 999.00, 'PAY4618', 'Success'),
('ORDCE59DF8D-1', 38, 57, '2025-10-12 01:55:21', 5997.00, 'PAY9804', 'Success'),
('ORDDD243F62-1', 30, 43, '2025-10-11 22:33:00', 1999.00, 'PAY7453', 'Success'),
('ORDE74D3519-1', 39, 45, '2025-10-12 14:07:18', 1424.00, 'PAY7099', 'Success'),
('ORDEF3E17BE-1', 33, 61, '2025-10-11 22:46:44', 1999.00, 'PAY2019', 'Success'),
('ORDF51AC23B-1', 40, 42, '2025-10-13 08:55:13', 1800.00, 'PAY7948', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_catag` varchar(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` double(10,2) NOT NULL,
  `product_desc` text NOT NULL,
  `product_date` datetime NOT NULL,
  `product_img` text NOT NULL,
  `product_quantity` int(100) NOT NULL,
  `product_author` varchar(100) NOT NULL,
  `category_id` int(10) NOT NULL,
  `section_id` int(10) DEFAULT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `image_1` varchar(50) NOT NULL,
  `image_2` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `product_size` enum('S','M','X','XL','XXL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_catag`, `product_title`, `product_price`, `product_desc`, `product_date`, `product_img`, `product_quantity`, `product_author`, `category_id`, `section_id`, `discounted_price`, `image_1`, `image_2`, `created_at`, `updated_at`, `status`, `product_size`) VALUES
(38, 'women', 'Women White Dress', 1999.00, 'Women Regular White Dress', '2025-10-06 15:59:45', 'women1.jpg', 8, 'Admin', 0, NULL, 999.00, '', NULL, '2025-10-06 13:59:45', '2025-10-06 19:29:45', NULL, 'S'),
(39, 'men', 'Men Oversized White T-Shirt', 2999.00, 'Men Oversized White T-Shirt', '2025-10-06 16:00:32', 'men2.jpg', 7, 'Admin', 0, NULL, 900.00, '', NULL, '2025-10-06 14:00:32', '2025-10-06 19:30:32', NULL, 'S'),
(40, 'kids', 'Girl Cotton Casual Dress', 2945.00, 'Girl Cotton Casual Dress', '2025-10-06 16:01:03', 'kids1.jpg', 3, 'Admin', 0, NULL, 1999.00, '', NULL, '2025-10-06 14:01:03', '2025-10-06 19:31:03', NULL, 'S'),
(41, 'women', 'Women Striped Regular Kurta With Trousers', 3998.00, 'Women Striped Regular Purple Kurta With Trousers', '2025-10-06 16:02:32', 'women4.jpg', 2, 'Admin', 0, NULL, 1599.00, '', NULL, '2025-10-06 14:02:32', '2025-10-06 19:32:32', NULL, 'S'),
(42, 'women', 'Women Denim Jacket', 1999.00, 'Women BlueDenim Jacket', '2025-10-06 16:03:10', 'women2.jpg', 3, 'Admin', 0, NULL, 900.00, '', NULL, '2025-10-06 14:03:10', '2025-10-06 19:33:10', NULL, 'S'),
(43, 'men', 'Men Pure Cotton Brown Shirt', 2935.00, 'Men Pure Cotton Brown Shirt', '2025-10-06 16:04:43', 'men8.jpg', 4, 'Admin', 0, NULL, 1999.00, '', NULL, '2025-10-06 14:04:43', '2025-10-06 19:34:43', NULL, 'S'),
(44, 'all', 'Women yellow Kurta With Trousers & With Dupatta', 4999.00, 'Women Regular Striped yellow Kurta With Trousers & With Dupatta', '2025-10-06 16:06:29', 'women5.jpg', 2, 'Admin', 0, NULL, 1999.00, '', NULL, '2025-10-06 14:06:29', '2025-10-06 19:36:29', NULL, 'S'),
(45, 'kids', 'Boy Pure Cotton Clothing Set ', 1619.00, 'Boy Pure Cotton Clothing Set ', '2025-10-06 16:08:01', 'kids4.jpg', 2, 'Admin', 0, NULL, 712.00, '', NULL, '2025-10-06 14:08:01', '2025-10-06 19:38:01', NULL, 'S'),
(47, 'women', 'Women Puff Sleeve Cotton Crop Top', 3999.00, 'Women White Puff Sleeve Cotton Crop Top', '2025-10-06 16:10:16', 'women7.jpg', 5, 'Admin', 0, NULL, 2999.00, '', NULL, '2025-10-06 14:10:16', '2025-10-06 19:40:16', NULL, 'S'),
(48, 'women', 'Women Floral Printed Bell Sleeve Top', 1999.00, 'Women Yellow Floral Printed Bell Sleeve Top', '2025-10-06 16:12:54', 'women9.jpg', 7, 'Admin', 0, NULL, 999.00, '', NULL, '2025-10-06 14:12:54', '2025-10-06 19:42:54', NULL, 'S'),
(49, 'kids', 'Girl Casual Top', 2945.00, 'Girl Blue Casual Top', '2025-10-06 16:13:58', 'kids2.jpg', 1, 'Admin', 0, NULL, 900.00, '', NULL, '2025-10-06 14:13:58', '2025-10-06 19:43:58', NULL, 'S'),
(50, 'men', 'Men Nevyblue Jacket', 3999.00, 'Men Regular Nevyblue Jacket', '2025-10-06 16:14:42', 'men3.jpg', 3, 'Admin', 0, NULL, 2999.00, '', NULL, '2025-10-06 14:14:42', '2025-10-06 19:44:42', NULL, 'S'),
(52, 'women', 'Women White Gown', 4945.00, 'Women Regular Pure Cotton White Gown', '2025-10-06 16:17:25', 'women6.jpg', 2, 'Admin', 0, NULL, 2999.00, '', NULL, '2025-10-06 14:17:25', '2025-10-06 19:47:25', NULL, 'S'),
(53, 'men', 'Men Brown T-shirt', 1999.00, 'Men Pure Cotton Brown T-shirt', '2025-10-06 16:18:49', 'men6.jpg', 3, 'Admin', 0, NULL, 900.00, '', NULL, '2025-10-06 14:18:49', '2025-10-06 19:48:49', NULL, 'S'),
(54, 'men', 'Men Green Regular Shirt', 2999.00, 'Men Green Regular Shirt', '2025-10-06 16:19:54', 'men7.jpg', 2, 'Admin', 0, NULL, 999.00, '', NULL, '2025-10-06 14:19:54', '2025-10-06 19:49:54', NULL, 'S'),
(55, 'women', 'Women Kurta With Trouser & Dupatta', 4945.00, 'Women Kurta With Trouser & Dupatta', '2025-10-06 16:21:15', 'women3.jpg', 6, 'Admin', 0, NULL, 3999.00, '', NULL, '2025-10-06 14:21:15', '2025-10-06 19:51:15', NULL, 'S'),
(56, 'women', 'Women Puff Sleeve Cotton Crop Top', 2999.00, 'Women Puff Sleeve Cotton Crop Top', '2025-10-06 16:21:55', 'women8.jpg', 20, 'Admin', 0, NULL, 999.00, '', NULL, '2025-10-06 14:21:55', '2025-10-06 19:51:55', NULL, 'S'),
(57, 'kids', 'Girls Floral Fit & Flare Top', 2945.00, 'Girls Blue Floral Fit & Flare Top', '2025-10-06 16:23:02', 'kids5.jpg', 5, 'Admin', 0, NULL, 1999.00, '', NULL, '2025-10-06 14:23:02', '2025-10-06 19:53:02', NULL, 'S'),
(58, 'women', 'Women Blue Wide-Leg Rise Light Classic Cotton Jeans', 3379.00, 'Women Blue Wide-Leg Rise Light Classic Cotton Jeans', '2025-10-06 16:24:48', 'women10.jpg', 9, 'Admin', 0, NULL, 1236.00, '', NULL, '2025-10-06 14:24:48', '2025-10-06 19:54:48', NULL, 'S'),
(59, 'men', 'Men Blue Cotton Straight Kurta ', 4599.00, 'Men Blue Cotton Straight Kurta ', '2025-10-06 16:27:09', 'men9.jpg', 5, 'Admin', 0, NULL, 999.00, '', NULL, '2025-10-06 14:27:09', '2025-10-06 19:57:09', NULL, 'S'),
(60, 'kids', 'Boy Pure Cotton T-shirt', 1999.00, 'Boy Regular Pure Cotton Blue and White T-shirt', '2025-10-06 16:28:06', 'kids3.jpg', 3, 'Admin', 0, NULL, 900.00, '', NULL, '2025-10-06 14:28:06', '2025-10-06 19:58:06', NULL, 'S'),
(61, 'men', 'Men Cotton Baggy Jeans', 2999.00, 'Men Cotton Baggy Jeans', '2025-10-06 19:08:55', 'men5.jpg', 6, 'Admin', 0, NULL, 1999.00, '', NULL, '2025-10-06 17:08:55', '2025-10-06 22:38:55', NULL, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `review` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_email`, `review`, `user_id`, `product_id`, `date`) VALUES
(1, 'hdp@gmail.com', 'Good Fabric...!!', 0, 56, '2025-10-11 21:47:46'),
(2, 'hdp@gmail.com', 'Color is too Good...!!', 32, 48, '2025-10-11 22:36:26'),
(3, 'fenil@gmail.com', 'Perfect Fit & Great Quality!', 30, 43, '2025-10-11 22:40:46'),
(4, 'pap@gmail.com', 'Stylish and Confortable', 35, 39, '2025-10-11 22:50:06'),
(5, 'mdp@gmail.com', 'Love it! Looks Premium', 36, 52, '2025-10-11 22:52:43'),
(6, 'pvk@gmail.com', 'Prefect Comfort and fit...!!', 37, 60, '2025-10-11 23:01:48'),
(7, 'fenil@gmail.com', 'Perfect Fit & Great Comfortable With Quality!!', 30, 53, '2025-10-11 23:13:36'),
(8, 'jp@gmail.com', 'It\'s Amazing...!!', 38, 57, '2025-10-12 01:49:51'),
(9, 'puja@gmail.com', 'Is\'s much good...!!', 40, 42, '2025-10-13 08:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` int(11) DEFAULT 31
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `name`, `status`) VALUES
(2, 'new_arrival', 1),
(3, 'trending', 1),
(4, 'top_rated', 1),
(7, 'new_products', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `website_name` varchar(60) NOT NULL,
  `website_logo` varchar(50) NOT NULL,
  `website_footer` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`website_name`, `website_logo`, `website_footer`, `id`) VALUES
('Trend Vibe', 'Trendvibe.png', 'Trend Vibe', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_user`
--
ALTER TABLE `login_user`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `login_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
