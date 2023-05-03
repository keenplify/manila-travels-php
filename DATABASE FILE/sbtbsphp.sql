-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2023 at 08:49 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbtbsphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(100) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `customer_route` varchar(200) NOT NULL,
  `booked_amount` int(100) NOT NULL,
  `booked_seat` varchar(100) NOT NULL,
  `booking_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `customer_id`, `route_id`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES
(78, 'C13Z678', 'CUST-5585037', '', 'PASIG CITY &rarr; MANILA', 0, '23', '2023-03-15 00:03:47'),
(84, '50ZM284', 'CUST-9474738', '', 'MANILA &rarr; VALENZUELA', 0, '15', '2023-03-19 15:31:30'),
(85, 'EXBVD85', 'CUST-2017936', '', 'CALOOCAN &rarr; NAVOTAS', 0, '22', '2023-03-19 15:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(100) NOT NULL,
  `bus_no` varchar(255) NOT NULL,
  `bus_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `bus_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_no`, `bus_assigned`, `bus_created`) VALUES
(46, 'XYZ7890', 0, '2021-10-17 22:33:15'),
(47, 'BCC9999', 0, '2021-10-17 22:33:22'),
(48, 'RDH4255', 1, '2021-10-17 22:33:36'),
(49, 'TTH8888', 0, '2021-10-18 00:05:32'),
(50, 'MMM9969', 1, '2021-10-18 00:06:02'),
(51, 'LLL7699', 1, '2021-10-18 00:06:42'),
(52, 'SSX6633', 1, '2021-10-18 00:06:52'),
(53, 'NBS4455', 0, '2021-10-18 09:27:49'),
(54, 'ABC123', 1, '2021-10-18 09:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `customer_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_created`) VALUES
(36, 'CUST-2017936', 'John Chris Titong', '0923548754', '2021-10-17 22:30:53'),
(37, 'CUST-5585037', 'Christian Nocillado', '0923247745', '2021-10-17 22:31:20'),
(38, 'CUST-9474738', 'Emmanuel Malbas', '0906411309', '2021-10-18 09:32:02'),
(40, 'CUST-9997540', 'Louvell Ibarra', '0942545445', '2021-10-18 09:39:10'),
(41, 'CUST-3729641', 'Anthony Joven', '0931017700', '2023-02-27 20:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(100) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `bus_no` varchar(155) NOT NULL,
  `route_location` varchar(255) NOT NULL,
  `route_dep_date` date NOT NULL,
  `route_dep_time` time NOT NULL,
  `route_step_cost` int(100) NOT NULL,
  `route_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_id`, `bus_no`, `route_location`, `route_dep_date`, `route_dep_time`, `route_step_cost`, `route_created`) VALUES
(62, 'RT-3821462', 'NBS4455', 'TANDANG SORA, TAYUMAN', '2023-03-21', '15:05:00', 50, '2023-03-13 13:04:56'),
(64, 'RT-6211064', 'LLL7699', 'PASIG CITY, MANILA', '2023-03-22', '19:50:00', 100, '2023-03-13 13:11:56'),
(68, 'RT-6515668', 'ABC123', 'CALOOCAN,NAVOTAS', '2023-03-30', '14:00:00', 250, '2023-03-14 23:57:27'),
(69, 'RT-5497169', 'RDH4255', 'PASIG CITY,MANILA', '2023-07-19', '16:00:00', 150, '2023-03-15 00:03:00'),
(70, 'RT-3451170', 'MMM9969', 'MANILA,PASIG CITY', '2023-03-26', '17:00:00', 200, '2023-03-15 00:08:27'),
(72, 'RT-1587672', 'SSX6633', 'MANILA,VALENZUELA', '2023-03-20', '04:00:00', 250, '2023-03-19 15:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `bus_no` varchar(155) NOT NULL,
  `seat_booked` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`bus_no`, `seat_booked`) VALUES
('BCC9999', NULL),
('CAS3300', '16'),
('LLL7699', NULL),
('MMM9969', '2,15,6,18'),
('NBS4455', NULL),
('RDH4255', '15'),
('SSX6633', NULL),
('TTH8888', NULL),
('XYZ7890', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_name`, `user_password`, `user_created`) VALUES
(7, 'Audrey Herrera', 'audrey', '$2y$10$MsAKCiC4Rt7nUmbrjTOIHu7ltqonWKj2VZATMMgwkY5YeOhLprfdW', '2023-02-27 20:48:16'),
(8, 'Emmanuel Malbas', 'emalbas@gmail.com', '$2y$10$pKp95ZjoRdIvxrHXG8JjwehKm5HXChJUslBxvBfkzG9kfPvHOvpSu', '2023-03-13 14:01:39'),
(9, 'Anthony Joven', 'anthony', '$2y$10$JT.kSHTZHaPYB3eYpGIO.O2k.FlKqKJkwZTyHCG0bQW3113vaD.d.', '2023-03-14 23:45:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`bus_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
