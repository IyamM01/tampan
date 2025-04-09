-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3309
-- Generation Time: Apr 09, 2025 at 02:13 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sampah`
--

-- --------------------------------------------------------

--
-- Table structure for table `tempat_sampah`
--

CREATE TABLE `tempat_sampah` (
  `id` int NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `status` enum('kosong','penuh') DEFAULT 'kosong',
  `latitude` double NOT NULL DEFAULT '-7.7956',
  `longitude` double NOT NULL DEFAULT '110.3695'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tempat_sampah`
--

INSERT INTO `tempat_sampah` (`id`, `nama`, `lokasi`, `status`, `latitude`, `longitude`) VALUES
(1, 'Tempat Sampah 1', '-7.7828,110.3671', 'kosong', -7.7956, 110.3695),
(2, 'Tempat Sampah 2', '-7.7890,110.3700', 'penuh', -7.7956, 110.3695),
(3, NULL, NULL, 'kosong', -7.77204, 110.392941),
(4, NULL, NULL, 'penuh', -7.7705, 110.3908);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tempat_sampah`
--
ALTER TABLE `tempat_sampah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tempat_sampah`
--
ALTER TABLE `tempat_sampah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
