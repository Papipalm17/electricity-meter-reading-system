-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 01:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electric_meter_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_meter_id` varchar(16) NOT NULL,
  `user_pea_id` varchar(16) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_first_name` varchar(60) NOT NULL,
  `user_last_name` varchar(60) NOT NULL,
  `user_phone` varchar(11) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_meter_id`, `user_pea_id`, `user_username`, `user_first_name`, `user_last_name`, `user_phone`, `user_email`, `role_id`, `user_password`, `user_cost`) VALUES
(1, '90554', '444555666', 'Aofpa', 'โชคชัย', 'แจ่มน้อย', '0835323829', 'phanthila.c@rmutsvmail.com', 1, '0835323829', 4),
(2, '456789', '456456456', 'Aonna', 'ภัณฑิลา', 'ชัยรักวงศ์', '0967612543', 'phanthila80@gmail.com', 2, '0967612543', 4),
(4, '111111', '222222', 'test', 'test', 'test', '0611111111', 'test@gmail.com', 1, '1234', 4),
(8, '111111', '222222', 'test', 'test', 'test', '0611111111', 'test@gmail.com', 1, '1234', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_meter`
--

CREATE TABLE `transaction_meter` (
  `id` int(11) NOT NULL,
  `meter_serial` int(11) NOT NULL,
  `input_timestamp` datetime NOT NULL,
  `meter_number` varchar(255) NOT NULL,
  `meter_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_meter`
--

INSERT INTO `transaction_meter` (`id`, `meter_serial`, `input_timestamp`, `meter_number`, `meter_image`) VALUES
(1, 90554, '2024-04-07 02:06:15', '00041900004190', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8-2024-04-06-20-29-42.jpg'),
(2, 90554, '2024-04-07 02:12:47', '00040', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(3, 90554, '2024-04-07 02:17:11', '00040', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(4, 90554, '2024-04-07 02:19:37', '000', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(5, 90554, '2024-04-07 02:21:58', '000', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(6, 90554, '2024-04-07 02:24:09', '00047', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(7, 90554, '2024-04-07 15:26:55', '000005', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(8, 90554, '2024-04-07 15:28:45', '00001', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(9, 90554, '2024-04-07 15:32:27', '01008171', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(10, 90554, '2024-04-07 16:44:32', '0', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(11, 90554, '2024-04-07 16:44:45', '3', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(12, 90554, '2024-04-07 16:45:03', '3', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c8.jpg'),
(13, 90554, '2024-04-07 18:03:28', '1010070', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c82024-04-07_13-03-15.jpg'),
(14, 90554, '2024-04-07 18:03:37', '0110070', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c82024-04-07_13-03-26.jpg'),
(15, 90554, '2024-04-07 18:03:50', '117070', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c82024-04-07_13-03-42.jpg'),
(16, 90554, '2024-04-07 18:03:51', '117070', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c82024-04-07_13-03-42.jpg'),
(17, 90554, '2024-04-07 18:04:07', '117070', 'C:\\xampp\\htdocs\\electricity-meter-reading-system\\uploads\\90554f9ef0c82024-04-07_13-03-42.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `transaction_meter`
--
ALTER TABLE `transaction_meter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction_meter`
--
ALTER TABLE `transaction_meter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
