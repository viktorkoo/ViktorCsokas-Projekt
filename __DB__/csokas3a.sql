-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 10:03 AM
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
-- Table structure for table `auto`
--

CREATE TABLE `auto` (
  `id` int(11) NOT NULL,
  `model_auta` varchar(150) NOT NULL,
  `rok_vyroby` int(11) NOT NULL,
  `cena` float NOT NULL,
  `vyrobca` varchar(100) NOT NULL,
  `typ_auta` int(11) NOT NULL,
  `najazdene_km` float NOT NULL,
  `fotka` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auto`
--

INSERT INTO `auto` (`id`, `model_auta`, `rok_vyroby`, `cena`, `vyrobca`, `typ_auta`, `najazdene_km`, `fotka`) VALUES
(1, '911 GT3RS', 2021, 250000, 'Porsche', 2, 2700, 'img/porsche911gt3rs.jpeg'),
(3, 'C 63 S AMG', 2017, 89900, 'Mercedes', 4, 25000, 'img/c63s.jpg'),
(4, 'Camry', 2015, 25000, 'Toyota', 3, 140000, 'img/camry.jpg'),
(5, 'Meriva', 2014, 6500, 'Opel', 1, 105000, 'img/meriva.jpg'),
(6, 'Fiat Multipla', 2002, 1520, 'Fiat', 1, 400000, 'img/multipla.jpg'),
(7, 'BMW M5 Competition', 2021, 91500, 'BMW', 3, 1200, 'img/m5.jpg'),
(8, 'Hyundai i20 n', 2021, 31500, 'Hyundai', 5, 12400, 'img/i20n.jpg'),
(9, 'Lamborghini Aventador LP700-4', 2015, 397050, 'Lamborghini', 2, 5079, 'img/lambo.jpg'),
(10, 'Ferrari F40', 1988, 2400600, 'Ferrari', 2, 743, 'img/f40.jpg'),
(11, 'Audi RS6 avant', 2022, 112500, 'Audi', 6, 23006, 'img/rs6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `typ_auta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`id`, `typ_auta`) VALUES
(1, 'Mini MPV'),
(2, 'Šport'),
(3, 'Sedán'),
(4, 'Coupé'),
(5, 'Hatchback'),
(6, 'Kombi');

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
(9, 'asd12', '$2y$10$HketPKgtr9GKG/vo1YbzRO088RllNj9TZkOCVENW1XbjnveAugzwm', 'asd12@gmail.com'),
(10, 'asdasd', 'asd123', 'asdasd@gmail.com'),
(11, 'asder', '$2y$10$l8GJb64dImuyEv12rKfm3OO/37Y6OWKL/InY78w5eWOFkBo2IqY/i', 'asder@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoria`
--
ALTER TABLE `kategoria`
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
-- AUTO_INCREMENT for table `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
