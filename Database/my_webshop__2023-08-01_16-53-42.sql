-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 01, 2023 at 04:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(6) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `date`, `user_id`) VALUES
(9903, '2023-08-01 14:24:48', 101),
(9904, '2023-08-01 14:48:43', 102);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `brand`, `description`, `price`, `filename`) VALUES
(1003, 'Fenix 7X Sapphire solar smartwatch', 'Garmin', 'A week has 7 days. And the fenix® 7X Sapphire Solar multisport GPS watch is built to perform every day. With a large 1.40” screen, a built-in LED flashlight and a Power Sapphire™ lens for solar charging, the battery has a long life that can effortlessly power through your sporting and outdoor challenges. Use familiar buttons or the new touch screen interface to make selections. Get insights into achievements and stats that help you track your effort and build stamina. Optimize recovery with 24/7 health and wellness monitoring of heart rate, respiration, stress, sleep and more. Outdoor navigation sensors and multi-band GNSS technology help you pinpoint your position with greater accuracy, even in challenging environments. Plus, you have preloaded TopoActive maps and worldwide ski and golf maps on your wrist. To complement your quieter days, there are connected features such as smart notifications, music storage and contactless payments via Garmin Pay™.', 749.00, 'garmin_watch.jpg'),
(1004, 'Baker watch', 'Tommy Hilfiger ', 'This silver Tommy Hilfiger men\'s watch \"TH1710448\" is a real eye-catcher. With its multifunctional blue dial with beautiful details, this watch is an indispensable accessory and completes your entire outfit!\r\n\r\nThe Brand: Since the brand\'s launch in 1985, Tommy Hilfiger has become known worldwide as a pioneer of classic American cool style. Inspired by iconic pop culture and American heritage. This season\'s women\'s and men\'s collection features minimalist silhouettes and rustic leather details. The men\'s watch collection offers iconic timepieces with stainless steel, leather and silicone straps.\r\n\r\nSpecifications - TH1710448 - EAN: 7613272425926 - Round case shape - Quartz movement - 5 ATM (rain & splash proof) - Color watch case: Silver colored - Color dial: Blue - Color watch strap: Silver colored - Mineral glass', 179.00, 'tommy_watch.jpg'),
(1005, 'Coussin Shape watch', 'Gc Watches', 'Stylish men\'s watch from the Gc Spirit Coussin Shape series. The chronograph has a dial with steel details. Both the hands and indices have a Super-LumiNova coating. The watch is water resistant up to 10 ATM. The strap is made of silicone for optimal comfort and durability. Model: Y99006G2MF.', 649.00, 'gc_watch.jpg'),
(1006, 'Seiko 5 Sports watch', 'Seiko', 'Seiko 5 Sports GMT, luxury steel strap and glass bezel and hardened mineral glass with magnifying glass above the date. The timepiece has a transparent case back so that the timepiece can be admired.', 490.00, 'seiko_watch.jpg'),
(1007, 'Galaxy Watch 5 smartwatch', 'Samsung', 'Samsung Galaxy Watch5 SA.R900SM Smartwatch Silver Milanese 40mm\r\n\r\n\r\nThe Galaxy Watch combines the look of a luxury watch with the advanced features of SAMSUNG smartwatches. These unique watches are equipped with interchangeable watch straps: a specially designed stainless steel and a silicone watch strap. The Galaxy Watch5 is a smartwatch with Wear OS from SAMSUNG that gives you access to your favorite apps, all on your wrist. The Galaxy Watch is not only very stylish, but also user-friendly. To scroll through apps, messages and text, all you have to do is turn the rotating bezel. The Galaxy Watch is dust and splash proof and 5 ATM certified, so it can also be used for swimming. The extra features, such as the compass, the bioactive sensor, GPS routing make the Galaxy Watch5 even more complete.\r\n\r\n\r\nThe Galaxy Watch has an Always On display, so you don\'t have to press a button to display the time. The AMOLED display can be set to a continuous time display, so that you can see the time day and night.\r\n\r\n\r\nHighlights: - Suitable for Android - The Galaxy Watch5 has an IP68 certification. The watch is 5 ATM - Thanks to the built-in speaker and microphone, you can also make calls with the watch - Receive all messages from your phone on your watch and respond immediately with quick replies - Recognizes more than 35 different activities - The different meters and counters make it possible to measure heart rate, steps, speed, sleep, air pressure, stress, height and depth the built-in GPS, it is possible to navigate offline and look back on your route afterwards (without the phone nearby) - Listen to music without a smartphone with Spotify premium', 369.00, 'samsung_watch.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `product_id` int(6) NOT NULL,
  `order_id` int(6) NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`product_id`, `order_id`, `quantity`) VALUES
(1003, 9903, 1),
(1003, 9904, 1),
(1005, 9903, 1),
(1005, 9904, 1),
(1007, 9904, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(6) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `name`, `password`) VALUES
(101, 'coach@man-kind.nl', 'Geert Weggemans', 'halt!!'),
(102, 'quincy.tromp@hotmail.com', 'Quincy Tromp', 'pass');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`product_id`,`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9905;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
