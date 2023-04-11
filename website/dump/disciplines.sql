-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.info.unicaen.fr:3306
-- Generation Time: Nov 27, 2022 at 07:31 PM
-- Server version: 10.5.11-MariaDB-1
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toure215_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `teams` varchar(255) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `champion` varchar(255) NOT NULL,
  `junior` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`id`, `name`, `category`, `teams`, `duration`, `champion`, `junior`) VALUES
(1, 'Formula1', 'Single-seater', 'Mercedes,Ferrari,RedBull,Mclaren', 90, 'Verstappen', 'F2,F3'),
(2, 'World_Endurance_Championship', 'endurance_racing', 'Toyota,Peugeot,Porsche,Corvette', 360, 'N°7', ''),
(3, 'MotoGp', 'motor_bike_racing', 'Honda,Yamaha,Ducatti', 50, 'Quartararo', 'moto2'),
(4, 'Moto2', 'motor_bike_racing', 'American_racing,RedBull_ktm', 40, 'Remy_Gardner', ''),
(5, 'Formula2', 'open_wheel_single_seater', 'Prema,ART,Dams,MP_Motorsport', 45, 'Piastri', 'f3'),
(6, 'Formula3', 'open_wheel_single_seater', 'Prema,ART,Carlin,Trident', 30, 'Victor_Martins', 'f4,karting');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
