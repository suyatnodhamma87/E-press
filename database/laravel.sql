-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 02:34 PM
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
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `anakperusahaan`
--

CREATE TABLE `anakperusahaan` (
  `kode_anper` char(10) NOT NULL,
  `nama_anper` varchar(255) NOT NULL,
  `lokasi_anper` varchar(255) NOT NULL,
  `radius_anper` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anakperusahaan`
--

INSERT INTO `anakperusahaan` (`kode_anper`, `nama_anper`, `lokasi_anper`, `radius_anper`) VALUES
('3M', 'Maju Mantab Mandiri', '-6.1727603127091415, 107.05206054762596', '100'),
('GTI', 'Garuda Teknik Indonesia', '-6.172417499470148, 107.05294348491945', '100'),
('PPJM', 'Putra Pratama Jaya Mandiri', '-6.172417499470148, 107.05294348491945', '100'),
('RPE', 'Rajawali Parama Elektrindo', '-6.172417499470148, 107.05294348491945', '200');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `kode_div` char(5) NOT NULL,
  `nama_div` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`kode_div`, `nama_div`) VALUES
('IT', 'Infotmation Technology a'),
('MEP', 'Mechanical, Electric, Plumbing'),
('SCRT', 'Security');

-- --------------------------------------------------------

--
-- Table structure for table `ijin`
--

CREATE TABLE `ijin` (
  `id` int(11) NOT NULL,
  `nip` char(10) NOT NULL,
  `tgl_ijin` date NOT NULL,
  `status` char(1) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_approval` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nip` char(7) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(30) NOT NULL,
  `kode_div` char(10) NOT NULL,
  `kode_anper` char(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nip`, `nama_lengkap`, `jabatan`, `no_hp`, `foto`, `kode_div`, `kode_anper`, `password`, `remember_token`) VALUES
('111001', 'Sujilan', 'Security', '086879765868', '111001.png', 'SCRT', 'RPE', '$2y$10$220EYVWPBK2.CmMudbcT1uOimWhUnozb1x1VhMZz5dZCrBGpM6L16', ''),
('111002', 'Mamat', 'Staff Legal', '0869767575789', '111002.jpg', 'SCRT', 'PPJM', '$2y$10$Ree78o83HMyGzsV3XYfdauBaUGhMG2SCk8rPQ1M1jPb8D3xlgP426', NULL),
('111003', 'Rangga a', 'Staff Accounting', '0869767575789', '111003.jpg', 'IT', '3M', '$2y$10$lFuvbqz33fSV7h8r00AviulVWE.tbFiK29Z4s/bAgFOTWY.T1K7mC', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `nip` int(11) NOT NULL,
  `tgl_presensi` date DEFAULT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) DEFAULT NULL,
  `foto_out` varchar(255) DEFAULT NULL,
  `lokasi_in` text NOT NULL,
  `lokasi_out` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `nip`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`) VALUES
(1, 111001, '2023-12-04', '00:35:14', '12:15:02', '111001-2023-12-04-in.png', '111001-2023-12-04-out.png', '-6.1717225,107.05219499999998', '-6.171638,107.05223749999999'),
(2, 111002, '2023-12-05', '14:28:28', '17:09:43', '111002-2023-12-05-in.png', '111002-2023-12-05-out.png', '-6.172133,107.052589', '-6.171638,107.05223749999999'),
(3, 111003, '2023-12-05', '14:53:52', '15:00:26', '111003-2023-12-05-in.png', '111003-2023-12-05-out.png', '-6.172133,107.052589', '-6.172133,107.052589'),
(4, 111001, '2023-12-05', '18:41:51', NULL, '111001-2023-12-05-in.png', NULL, '-6.171590833333333,107.05203816666666', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settingradius`
--

CREATE TABLE `settingradius` (
  `id` int(11) NOT NULL,
  `lokasi_kantor` varchar(255) NOT NULL,
  `radius` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settingradius`
--

INSERT INTO `settingradius` (`id`, `lokasi_kantor`, `radius`) VALUES
(1, '-6.171628678920754, 107.05270377664988', 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`) VALUES
(1, 'Suyatno', 'suyatno@gmail.com', '$2y$10$zLFcEisK7k6UGIZoDlAO4.SWc92jH6PClxWPhB3k0.O9aeIoJVkE2', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anakperusahaan`
--
ALTER TABLE `anakperusahaan`
  ADD PRIMARY KEY (`kode_anper`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`kode_div`);

--
-- Indexes for table `ijin`
--
ALTER TABLE `ijin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settingradius`
--
ALTER TABLE `settingradius`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ijin`
--
ALTER TABLE `ijin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settingradius`
--
ALTER TABLE `settingradius`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
