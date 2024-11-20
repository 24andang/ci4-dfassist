-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 10:57 AM
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
-- Database: `ci4maklon`
--

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `registrasi_id` int(11) DEFAULT NULL,
  `dp` tinyint(1) DEFAULT NULL,
  `rmpm` tinyint(1) DEFAULT NULL,
  `desain_mockup` tinyint(1) DEFAULT NULL,
  `produksi` tinyint(1) DEFAULT NULL,
  `surat_jalan` tinyint(1) DEFAULT NULL,
  `pelunasan` tinyint(1) DEFAULT NULL,
  `pengiriman` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `registrasi_id`, `dp`, `rmpm`, `desain_mockup`, `produksi`, `surat_jalan`, `pelunasan`, `pengiriman`) VALUES
(19, 19, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id` int(11) NOT NULL,
  `tanggal_mou` date DEFAULT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `akhir_kontrak` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id`, `tanggal_mou`, `nomor_surat`, `nama_perusahaan`, `user`, `merk`, `akhir_kontrak`) VALUES
(19, '2024-07-12', '4353465346', 'PT Testa', 'it.spv@dionfarmaabadi.co.id', 'testa', '2024-07-12'),
(20, '2024-07-12', '4353465346', 'PT Test', 'abc', 'aqbc', '2024-08-09'),
(21, '2024-07-12', '124321432432', 'PT Testing', 'Mr Nobody', 'Nothing', '2025-06-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
