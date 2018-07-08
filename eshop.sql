-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2018 at 09:11 PM
-- Server version: 10.2.16-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `products` varchar(250) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `description` varchar(255) DEFAULT NULL,
  `order_type` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user`, `name`, `products`, `status`, `description`, `order_type`, `created_at`) VALUES
(1, 1, 'Mock up order', '6', 'pending', 'none', 'paid', '2018-06-23 22:37:20'),
(2, 1, 'Mock up order 2', '6,7,6', 'pending', 'I hate descriptions', 'Be paid', '2018-06-25 08:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `category` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT './pics/product/unavailable.png',
  `availability` enum('Available','Waiting','Unavailable') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `manufacturer`, `name`, `category`, `description`, `price`, `image`, `availability`) VALUES
(1, 'Gardener', 'Kytkáč', 'garden', 'Kytkáč. Co nechápeš?', 30, './pics/product/Screenshot from 2018-02-16 19-30-28.png', 'Available'),
(6, 'Gardener', 'Alien strain', 'leafs', 'Oh I see.', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(7, 'asus', 'bla', 'pc', 'bla', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(8, 'asus', 'bla', 'pc', 'bla', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(9, 'asus', 'bla', 'pc', 'bla', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(10, 'Somebody', 'Bla', 'some', 'Produkt desc', 30, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(11, 'Somebody', 'Produkt', 'some', 'bla', 30, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(12, 'Somebody', 'Produkt', 'some', 'Produkt desc', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(13, 'Somebody', 'Produkt', 'some', 'Produkt desc', 40, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available'),
(14, 'Somebody', 'Produkt', 'some', 'bla', 30, './pics/product/6ca7b8929c9cf505c7fa006f240db07d.jpg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(24) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `residence` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ico` int(24) DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `name`, `password`, `residence`, `phone`, `ico`, `role`) VALUES
(1, 'test@user.com', 'Test User', 'none', 'Test residence', '+420586489256', 2147483647, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order` FOREIGN KEY (`user`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
