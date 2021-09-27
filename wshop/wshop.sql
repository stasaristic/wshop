-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2021 at 09:26 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) NOT NULL,
  `seller` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category`, `seller`) VALUES
(4, 'Haljina', NULL, 8000, 1, 'odeca', 'petarmarkovic'),
(5, 'Converse ranac', 'Converse ranac za smestaj Vama najpotrebnijih svakodnevnih stvari.', 3500, 3, 'ranac', 'petarmarkovic'),
(10, 'Ugaona garnitura GALIJA LUX M ', 'Ugaona garnitura, kao sto se moze videti na slici', 40000, 1, 'namestaj', 'jadrankajadic'),
(11, 'Regal PRATO ', 'Odlican regal visokog kvaliteta za Vas dom.\r\nNapomena: Uz regal ne dolazi televizor, biljke i ostali dodaci.', 28490, 9, 'namestaj', 'jadrankajadic'),
(12, 'Fotelja NEW YORK ', 'Fotelja New York model, odlican dodatak svakoj dnevnoj sobi.', 29000, 3, 'namestaj', 'jadrankajadic'),
(13, 'JBL bežične bubice LIVE 300TWS (Bele)', 'JBL slusalice', 9999, 3, 'slusalice', 'milicamilicevic');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `product_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`product_id`, `path`) VALUES
(4, './media/14-20-5d62040ak042_green_1b.webp'),
(4, './media/14-54-cfd558d4k042_green_2b.webp'),
(4, './media/14-60-fe81b47cK042_ZIELONY.webp'),
(5, './media/1-f2-e475391d71027403_xxl.webp'),
(5, './media/71027403_xxl_a1.webp'),
(10, './media/21028866.jpg'),
(10, './media/csm_21028866_b0f3e53a6b.jpg'),
(11, './media/11008777.jpg'),
(11, './media/11008777.png'),
(11, './media/csm_11008777_bf1cde2271.jpg'),
(12, './media/csm_21016298_a3736cd568.jpg'),
(13, './media/image5dc18aad78076.jpg'),
(13, './media/image5dc18aaf6602d.png'),
(13, './media/image5dc18ab0656a3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `payment_option` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `product_id`, `quantity`, `username`, `first_name`, `last_name`, `country`, `city`, `address`, `zip_code`, `payment_option`, `order_date`, `status`) VALUES
(6, 13, 1, 'jovicastevic', 'Jovica', 'Stevic', 'Srbija', 'Cacak', 'Kneza Lazara 2', '32210', 0, '2021-08-27 23:52:46', 1),
(7, 11, 1, 'jovicastevic', 'Petar', 'Jovanovic', 'Srbija', 'Valjevo', 'Karadjorjeva 3', '30000', 1, '2021-08-27 23:53:34', 1),
(8, 5, 1, 'pericamikic', 'Perica', 'Mikic', 'Srbija', 'Novi Sad', 'Kralja Aleksandra 12', '27000', 0, '2021-08-28 13:11:53', 1),
(9, 4, 1, 'pericamikic', 'Perica', 'Mikic', 'Srbija', 'Novi Sad', 'Kralja Aleksandra 12', '27000', 0, '2021-08-28 13:11:53', 1),
(11, 5, 1, 'milanmiljkovic', 'Aleksandar', 'Markovic', 'Srbija', 'Valjevo', 'Jovana Sremca', '4500', 1, '2021-08-28 13:13:33', 1),
(12, 4, 1, 'milanmiljkovic', 'Aleksandar', 'Markovic', 'Srbija', 'Valjevo', 'Jovana Sremca', '4500', 1, '2021-08-28 13:13:33', 1),
(13, 12, 1, 'milanmiljkovic', 'Aleksandar', 'Markovic', 'Srbija', 'Valjevo', 'Jovana Sremca', '4500', 1, '2021-08-28 13:13:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `grade` int(11) NOT NULL,
  `review` varchar(255) NOT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `username`, `grade`, `review`, `review_date`) VALUES
(2, 13, 'jovicastevic', 5, 'Sjajne slusalice za pristupacnu cenu', '2021-08-28 13:10:37'),
(3, 11, 'jovicastevic', 3, 'Kvalitet moze biti bolji', '2021-08-28 13:10:51'),
(4, 5, 'pericamikic', 4, 'Sjajan rancic za svaki dan, mada kvalitet savova moze biti boji', '2021-08-28 13:15:08'),
(5, 4, 'pericamikic', 5, 'Udobna haljina', '2021-08-28 13:15:28'),
(6, 5, 'milanmiljkovic', 3, 'Kupio sam ga jer su ga svi hvalili, nista posebno', '2021-08-28 13:16:17'),
(7, 12, 'milanmiljkovic', 5, 'JAKO udobna fotelja', '2021-08-28 13:16:28'),
(8, 4, 'milanmiljkovic', 5, 'Preudobno', '2021-08-28 13:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `password`, `type`) VALUES
('admin', 'Admin', 'Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
('aleksandrapetrovic', 'Aleksandra', 'Petrovic', 'aleksandrapetrovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac'),
('filipfilipovic', 'Filip', 'Filipovic', 'filipfilipovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac'),
('jadrankajadic', 'Jadranka', 'Jadic', 'jadrankajadic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac'),
('jelenamilenkovic', 'Jelena', 'Milenkovic', 'jelenamilenkovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac'),
('jovicastevic', 'Jovica', 'Stevic', 'jovicastevic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'kupac'),
('lazarlazic', 'Lazar', 'Lazic', 'lazarlazic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'kupac'),
('milanmiljkovic', 'Milan', 'Miljkovic', 'milanmiljkovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'kupac'),
('milicamilicevic', 'Milica', 'Milicevic', 'milicamilicevic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac'),
('pericamikic', 'Perica', 'Mikic', 'pericamikic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'kupac'),
('petarmarkovic', 'Petar', 'Markovic', 'petarmarkovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'prodavac');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller` (`seller`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_orders_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
