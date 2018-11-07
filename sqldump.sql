-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Nov 07, 2018 at 10:31 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbname`
--

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE `trades` (
  `id` int(10) NOT NULL,
  `type` enum('buy','sell') CHARACTER SET utf8 DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `symbol` char(8) CHARACTER SET utf8 NOT NULL,
  `shares` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trades`
--

INSERT INTO `trades` (`id`, `type`, `userId`, `symbol`, `shares`, `price`, `timestamp`) VALUES
(1, 'buy', 1, 'ACC', 12, '12.22', '2018-11-07 13:07:32'),
(2, 'sell', 1, 'ACC', 11, '13.22', '2018-11-07 13:07:50'),
(3, 'buy', 1, 'BCC', 342, '12.43', '2018-11-07 15:03:30'),
(4, 'buy', 1, 'ACC', 323, '10.32', '2018-11-07 15:07:56'),
(5, 'buy', 1, 'ACC', 323, '14.32', '2018-11-07 15:08:23'),
(9, 'buy', 1, 'AC', 28, '162.17', '2014-06-14 13:13:13'),
(10, 'buy', 1, 'AC', 28, '162.17', '2014-06-14 13:13:13'),
(11, 'buy', 1, 'AC', 28, '162.17', '2014-06-14 13:13:13'),
(12, 'buy', 1, 'AC', 28, '162.17', '2014-06-14 13:13:13'),
(13, 'buy', 1, 'AC', 28, '162.17', '2014-06-14 13:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'Max Mustermann');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trades`
--
ALTER TABLE `trades`
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
