-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 12:03 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ap_shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(56, 'shoe', 'shoe', '2020-09-22 15:15:14', '2020-09-22 15:15:14'),
(57, 'T shirt', 'T shirt', '2020-09-22 15:15:32', '2020-09-22 15:15:32'),
(58, 'something', 'something', '2020-10-02 23:09:36', '2020-10-02 23:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `quantity`, `price`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Faded SkyBlu Denim Jeans', 'Mill Oil is an innovative oil filled radiator with the most modern technology. If you are looking for something that can make your interior look awesome, and at the same time give you the pleasant warm feeling during the winter.', 56, 9, 10000, 'pic1.jpg', '2020-09-21 00:54:16', '2020-09-20 21:42:55'),
(3, 'T shirt', 'T shirt', 57, 6, 10000, 'pic1.jpg', '2020-09-21 01:03:04', '2020-09-21 01:03:04'),
(4, 'shoe2', 'shoe', 56, 3, 100, 'pic1.jpg', '2020-09-21 00:54:16', '2020-09-20 21:42:55'),
(5, 'shoe3', 'shoe', 56, 0, 100, 'pic1.jpg', '2020-09-21 00:54:16', '2020-09-20 21:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `sale_orders`
--

CREATE TABLE `sale_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_orders`
--

INSERT INTO `sale_orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(12, 1, 50500, '2020-09-30 14:10:35'),
(13, 1, 300, '2020-07-30 14:22:09'),
(14, 9, 100, '2020-09-30 19:10:31'),
(15, 9, 100, '2020-08-30 19:20:08'),
(16, 1, 100, '2020-10-02 18:36:58'),
(17, 1, 500, '2020-10-02 18:47:25'),
(18, 1, 100, '2020-10-02 18:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `sale_order_detail`
--

CREATE TABLE `sale_order_detail` (
  `id` int(11) NOT NULL,
  `sale_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_order_detail`
--

INSERT INTO `sale_order_detail` (`id`, `sale_order_id`, `product_id`, `quantity`, `order_date`) VALUES
(23, 12, 5, 3, '2020-09-30 18:40:35'),
(24, 12, 4, 2, '2020-09-30 18:40:35'),
(25, 12, 3, 4, '2020-09-30 18:40:35'),
(26, 12, 2, 1, '2020-09-30 18:40:36'),
(27, 13, 5, 3, '2020-09-30 18:52:09'),
(28, 14, 5, 1, '2020-09-30 23:40:31'),
(29, 15, 5, 1, '2020-09-30 23:50:08'),
(30, 16, 5, 1, '2020-10-02 23:06:58'),
(31, 17, 4, 5, '2020-10-02 23:17:25'),
(32, 18, 5, 1, '2020-10-02 23:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(100) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$pjCEzbuUZP7LD/iSalCpq.66aI3eS/WlRhIM/aUixpnbfO/HE.Cxi', 'Yangon', '0912345678', 1, '2020-09-11 14:44:20', '2020-09-11 14:44:20'),
(7, 'customer', 'customer@gmail.com', '$2y$10$PjGf9ltKuGcl0dfnfBmcpOEBdy/vg/L4LUy3orpq2z06aZ3zZA0yq', 'Yangon', '0912345677', 0, '2020-09-21 23:24:02', '2020-09-21 23:24:02'),
(8, 'customer1', 'customer1@gmail.com', '$2y$10$PcFYB6zsYEX45yvHAPpPUuKfjfD/Zj/8hqO5rS8Mce9pmHJLmoSk2', 'Yangon', '+959962265604', 0, '2020-09-22 00:11:25', '2020-09-22 00:11:25'),
(9, 'kyawKyawLin', 'kyaw@gmail.com', '$2y$10$rP943n3aFiiuwZLfW9q8WOgbRV1bPwqnSJPB.B0tT08CWXinWnoJa', 'Yangon', '0912345677', 0, '2020-09-30 23:39:23', '2020-09-30 23:39:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_orders`
--
ALTER TABLE `sale_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_order_detail`
--
ALTER TABLE `sale_order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sale_orders`
--
ALTER TABLE `sale_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sale_order_detail`
--
ALTER TABLE `sale_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
