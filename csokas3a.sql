-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 11:49 AM
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
-- Database: `csokas3a`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_produkt`
--

CREATE TABLE `t_produkt` (
  `id` int(11) NOT NULL,
  `nazov` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_produkt`
--

INSERT INTO `t_produkt` (`id`, `nazov`) VALUES
(1, 'vyfuk'),
(2, 'auto'),
(3, 'koleso'),
(4, 'motor'),
(5, 'sedadlo'),
(6, 'servo'),
(7, 'ABS modul'),
(8, 'jablko'),
(9, 'hruska'),
(10, 'melon');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `username`, `password`, `email`) VALUES
(1, 'jozko', '123', 'jozko@gmail.com'),
(3, 'anicka', '$2y$10$pijSaeImh7FRrMR2ntRQU.gsRegfWAJSLpPfYiSZj3IY9sNe83U9S', 'anicka@a.sk'),
(4, 'evka', '$2y$10$QSjtodjxA03YHzHE.tK2W.27Wr6Q9so52xnsPXdp92H3x.Kxs2FVe', ''),
(5, 'csokas3a', '$2y$10$khODuymgh36dbgiaNgHHFO3DbCebn5CFiaW5nI7DRgtydrvOQEPq.', ''),
(6, 'milka', '$2y$10$ymXSrGC/urWmBePjhfgzMO6d./xoawGmn4i1C3FB0pA4TXvBbhkaC', ''),
(7, 'jozik', '$2y$10$TwRqipcjvhyQxqzmNYlvOOtzwePw9MY6tfr5PJMUbRcWsAp6LHf9C', ''),
(8, 'csokas', '$2y$10$FNx38CIYG/cmNKJbXqlslO/VPbWApIjUE8BI0prxiDqO8N7j1u/Le', ''),
(9, 'asd12', '$2y$10$HketPKgtr9GKG/vo1YbzRO088RllNj9TZkOCVENW1XbjnveAugzwm', 'asd12@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_produkt`
--
ALTER TABLE `t_produkt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_produkt`
--
ALTER TABLE `t_produkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
