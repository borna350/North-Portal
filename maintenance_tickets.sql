-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2020 at 01:03 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal_north`
--

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_tickets`
--

CREATE TABLE `maintenance_tickets` (
  `id` int(222) NOT NULL,
  `emp_id` text NOT NULL,
  `subject` text NOT NULL,
  `website` text NOT NULL,
  `description` text NOT NULL,
  `priority` text NOT NULL,
  `category` text NOT NULL,
  `status` text DEFAULT NULL,
  `delete_status` text DEFAULT NULL,
  `_token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance_tickets`
--

INSERT INTO `maintenance_tickets` (`id`, `emp_id`, `subject`, `website`, `description`, `priority`, `category`, `status`, `delete_status`, `_token`, `created_at`, `updated_at`) VALUES
(1, '1', 'Faiz Khan', 'Website1', 'dcdshcsh sfhshshg', '1', '1', '2', NULL, '8ZWAKVEbCFU8LDfXLjBJEtcHW1xqChO7iTncd1r0', NULL, '2020-01-02 05:34:31'),
(2, '2', 'dcdc', 'Website1', 'sdcsd', '1', '1', NULL, NULL, 'hWqJVmweqxTsTZ7COY7pkTzSjL3deNHTiXhhz85d', NULL, '2020-01-02 02:00:04'),
(3, '2', 'jhdsfvhjs ffhhs', 'Website1', 'dkjghegf regfjhgyhrghjfer gfrefh j', '1', '1', NULL, NULL, 'hWqJVmweqxTsTZ7COY7pkTzSjL3deNHTiXhhz85d', NULL, '2020-01-02 02:01:06'),
(4, '1', 's', 'Website1', 'sqs', '1', '1', NULL, '1', '8ZWAKVEbCFU8LDfXLjBJEtcHW1xqChO7iTncd1r0', NULL, '2020-01-02 01:52:07'),
(5, '1', 's', 'Website1', 'sqs', '1', '1', NULL, '1', '8ZWAKVEbCFU8LDfXLjBJEtcHW1xqChO7iTncd1r0', NULL, '2020-01-02 01:52:20'),
(6, '2', 'sdcsd', 'Website1', 'dcsd', '1', '1', '1', NULL, 'mgPIIN98uC5Qr5qSAB7JwUpc5ebbiUD5VZtVpMxj', NULL, '2020-01-02 05:32:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maintenance_tickets`
--
ALTER TABLE `maintenance_tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maintenance_tickets`
--
ALTER TABLE `maintenance_tickets`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
