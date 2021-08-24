-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2021 at 02:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `t`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders_product_table`
--

CREATE TABLE `orders_product_table` (
  `order_product_id` int(11) NOT NULL DEFAULT 1001,
  `order_id` int(11) NOT NULL,
  `Item_name` text NOT NULL,
  `Normal_Price` decimal(10,2) NOT NULL,
  `Promotion_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_product_table`
--

INSERT INTO `orders_product_table` (`order_product_id`, `order_id`, `Item_name`, `Normal_Price`, `Promotion_price`) VALUES
(2000, 1001, 'Radio', '800.00', '713.00'),
(2001, 1002, 'Portable Audio', '16.00', '15.00'),
(2002, 1002, 'THE SIMS', '10.00', '9.00'),
(2003, 1003, 'Radio', '800.00', '713.00'),
(2004, 1004, 'Scanner', '124.00', '120.00'),
(2005, 1005, 'Portable Audio', '16.00', '15.00'),
(2006, 1005, 'Radio', '800.00', '713.00'),
(2007, 1006, 'Camcorders', '359.00', '303.00'),
(2008, 1006, 'Radio', '800.00', '713.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `orders_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sales_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`orders_id`, `order_date`, `sales_type`) VALUES
(1001, '2007-05-07 05:28:55', 'Normal'),
(1002, '2007-05-01 12:10:10', 'Normal'),
(1003, '2007-05-19 17:17:00', 'Promotion'),
(1004, '2007-05-22 22:47:16', 'Promotion'),
(1005, '2007-05-27 18:15:07', 'Promotion'),
(1006, '2007-06-01 06:35:59', 'Normal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders_product_table`
--
ALTER TABLE `orders_product_table`
  ADD PRIMARY KEY (`order_product_id`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`orders_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
