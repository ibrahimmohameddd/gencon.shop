-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 09:53 PM
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
-- Database: `gencon`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `user` varchar(50) NOT NULL,
  `pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`user`, `pass`) VALUES
('ibrahim', 123456),
('ibrahim2', 123);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category`, `pic`, `name`, `description`, `price`) VALUES
(9, 'outdoor-sofas', 'uploads/1757866659_sofa.jpg', 'white sofa', 'aiufgiwsgowh', 50.00),
(10, 'sofas', 'uploads/1757934280_1757866789_sofa.jpg', 'white sofa', 'ugif8ii', 50.00),
(27, 'bedroom-sets', 'uploads/1757876776_dinning-table.jpg', 'dinning table', 'kuyioydioafw', 10.00),
(28, 'dining-tables', 'uploads/1757934327_1757866659_sofa.jpg', 'dinning table', 'kuyioydioafw hello', 20.00),
(29, '', 'uploads/1757884676_dinning-table.jpg', 'table', '', 10.00),
(31, 'sofas', 'uploads/1757877126_dinning-table.jpg', 'dinning table', 'changed333', 10.00),
(32, '', 'uploads/1757886198_dinning-table.jpg', 'white sofa', 'FOIHOWIHGF', 20.00),
(33, '', 'uploads/1757886215_dinning-table.jpg', 'white sofa', 'FOIHOWIHGF', 20.00),
(34, '', 'uploads/1757886705_dinning-table.jpg', 'white sofa', 'FOIHOWIHGF', 20.00),
(35, '', 'uploads/1757934447_chair.jpg', 'chair', 'this is a chair', 3.00),
(36, '', 'uploads/1757934456_chair.jpg', 'chair', 'this is a chair', 5.00),
(37, 'chairs', 'uploads/1757937223_chair.jpg', 'chair', 'diehoegg', 6.00),
(38, 'coffee-tables', 'uploads/1757939847_chair.jpg', 'arm chair', 'ksnoisgj', 5.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
