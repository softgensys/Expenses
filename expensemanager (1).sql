-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2024 at 06:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expensemanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `address1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch`, `address1`) VALUES
(2, 'ND94', 'NOIDA SECTOR-94');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Salary'),
(2, 'Vehicle'),
(3, 'Travel');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `details` text NOT NULL,
  `branch_id` varchar(50) NOT NULL,
  `party_id` varchar(50) NOT NULL,
  `trans_type` varchar(10) NOT NULL,
  `pay_mode` varchar(100) NOT NULL,
  `added_on` datetime NOT NULL,
  `expenses_date` date NOT NULL,
  `added_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `item`, `price`, `details`, `branch_id`, `party_id`, `trans_type`, `pay_mode`, `added_on`, `expenses_date`, `added_by`) VALUES
('2425000001', 2, '', 1000, 'Meeting', '2', 'RAJEEV', 'Expense', '', '2024-07-23 07:11:07', '2024-07-23', 'shivi'),
('2425000002', 3, '', 70000, 'All Employees meeting', '2', 'RAJEEV', 'Expense', '', '2024-07-23 11:40:42', '2024-07-22', 'shivi'),
('2425000003', 2, '', 5000, 'Late Night Work', '2', 'RAJEEV', 'Expense', '', '2024-07-24 03:48:00', '2024-07-24', 'shivi'),
('2425100001', 1, '', 50000, 'Got Salary Amount', '2', 'RAJEEV', 'Income', '', '2024-07-23 07:10:20', '2024-07-23', 'shivi'),
('2425100002', 3, '', 10000, 'Recvd. from rajeev', '2', 'RAJEEV', 'Income', '', '2024-07-24 03:23:47', '2024-07-24', 'shivi');

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `party_id` varchar(50) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `op_bal` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`party_id`, `party_name`, `address1`, `op_bal`) VALUES
('ADY', 'ADYCON PVT LTD', 'NOIDA', 1000.00),
('RAJEEV', 'RAJEEV', 'ADYCON 94', 25000.00),
('VM TRADERS', 'V M TRADERS', 'ABC', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_mode_id` varchar(20) NOT NULL,
  `pay_mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'shivi', 'shivi');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_gen`
--

CREATE TABLE `voucher_gen` (
  `voucher_no` varchar(20) NOT NULL,
  `type` varchar(60) NOT NULL,
  `next_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher_gen`
--

INSERT INTO `voucher_gen` (`voucher_no`, `type`, `next_no`) VALUES
('2425000001', 'Expense', '2425000004'),
('2425100001', 'Income', '2425100003');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_mode_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_gen`
--
ALTER TABLE `voucher_gen`
  ADD PRIMARY KEY (`voucher_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
