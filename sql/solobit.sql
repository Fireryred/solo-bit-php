-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2020 at 03:41 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solobit`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `qty` int(11) DEFAULT NULL,
  `order_id` int(6) UNSIGNED DEFAULT NULL,
  `product_id` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`qty`, `order_id`, `product_id`) VALUES
(1, 5, 3),
(1, 6, 2),
(1, 6, 1),
(NULL, 6, NULL),
(1, 6, 4),
(1, 8, 2),
(2, 8, 3),
(NULL, 9, NULL),
(NULL, 9, NULL),
(NULL, 9, NULL),
(NULL, 9, NULL),
(NULL, 9, NULL),
(1, 9, 3),
(2, 10, 2),
(1, 11, 3),
(1, 12, 3),
(1, 13, 3),
(1, 14, 2),
(2, 14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_number`
--

CREATE TABLE `order_number` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_number`
--

INSERT INTO `order_number` (`id`, `user_id`) VALUES
(5, 19),
(6, 19),
(7, 19),
(8, 19),
(9, 19),
(10, 19),
(11, 19),
(12, 19),
(13, 19),
(14, 19);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `price`) VALUES
(1, 'HP elite dragonfly', 'https://cdn.mos.cms.futurecdn.net/B9aqeGasQPAvzmhifDhxMg.jpg', '81440'),
(2, 'Asus ROG Zephyrus G14', 'https://www.esquireme.com/public/images/2020/05/12/Asus-ROG-Zephyrus-G14.jpg', '99995'),
(3, 'Lenovo Chromebook Duet', 'https://cdn.mos.cms.futurecdn.net/tsCJKe4Q7DMoNQRpgDGfdK.jpg', '14000'),
(4, 'Asus Vivobook 5', 'https://www.evetech.co.za/repository/ProductImages/asus-vivobook-15-x505za-amd-ryzen-5-laptop-deal-730px-v4.jpg', '29995'),
(5, 'Acer Swift 3', 'https://cdn.mos.cms.futurecdn.net/remTbAfAzFjAhaJwbqMULL.jpg', '27999'),
(6, 'One Plus 8 Pro', 'https://fdn.gsmarena.com/imgroot/reviews/20/oneplus-8-pro/lifestyle/-727w2/gsmarena_001.jpg', '38044'),
(7, 'Google Pixel 4', 'https://icdn2.digitaltrends.com/image/digitaltrends/pixel-4-xl-rear-sticking-out.jpg', '36980'),
(8, 'Xiaomi Mi 9', 'https://secureservercdn.net/166.62.108.43/7x3.214.myftpupload.com/wp-content/uploads/2019/02/Xiaomi-Mi-9-image-render-price-specs-Revu-Philippines-881x496.jpg', '22990'),
(9, 'Moto G8', 'https://cdn1.expertreviews.co.uk/sites/expertreviews/files/styles/er_main_wide/public/2019/11/motorola_moto_g8_plus_014.jpg?itok=7gwO5iis', '15899'),
(10, 'TCL 10L', 'https://www.androidcentral.com/sites/androidcentral.com/files/styles/mediumplus/public/article_images/2020/05/tcl-10-series-review-7.jpg?itok=UZFbX-1-', '22234');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category` varchar(255) DEFAULT NULL,
  `product_id` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category`, `product_id`) VALUES
('laptop', 1),
('laptop', 2),
('laptop', 3),
('laptop', 4),
('laptop', 5),
('smartphone', 6),
('smartphone', 7),
('smartphone', 8),
('smartphone', 9),
('smartphone', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `address` varchar(255) DEFAULT NULL,
  `payment` varchar(255) NOT NULL,
  `user_id` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`address`, `payment`, `user_id`) VALUES
('219 Guanio St Maybunga Pasig City', 'onDelivery', 19);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `username`, `password`, `email`, `full_name`) VALUES
(19, 'Syrus', 'baee3809ecff8dcfb212179e0ece58de1fe923004021f0a6b76b8ae7e0578ba049cfd17f65ca089bd85bc8a93c1839165224bfd05b389f409ea426052388cbd4', 'gershomgruta06@gmail.com', 'Gershom Guasis Gruta');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_number`
--
ALTER TABLE `order_number`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_number`
--
ALTER TABLE `order_number`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_number` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order_number`
--
ALTER TABLE `order_number`
  ADD CONSTRAINT `order_number_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`);

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
