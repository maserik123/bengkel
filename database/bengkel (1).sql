-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2021 at 04:43 PM
-- Server version: 5.7.34-0ubuntu0.18.04.1
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bengkel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bengkel`
--

CREATE TABLE `bengkel` (
  `id_bengkel` int(45) NOT NULL,
  `nama_bengkel` varchar(115) NOT NULL,
  `alamat` varchar(1045) NOT NULL,
  `no_hp` varchar(45) NOT NULL,
  `id_pemilik_bengkel` int(45) NOT NULL,
  `id_jenis_bengkel` int(45) NOT NULL,
  `layanan` varchar(500) NOT NULL,
  `jadwal_buka` varchar(45) NOT NULL,
  `jadwal_tutup` varchar(45) NOT NULL,
  `latitude` varchar(45) NOT NULL,
  `longitude` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bengkel`
--

INSERT INTO `bengkel` (`id_bengkel`, `nama_bengkel`, `alamat`, `no_hp`, `id_pemilik_bengkel`, `id_jenis_bengkel`, `layanan`, `jadwal_buka`, `jadwal_tutup`, `latitude`, `longitude`) VALUES
(1, 'Bengkel Maju Jaya Motor', 'Jl.Medan, Pekanbaru, Riau', '08233991122', 1, 1, 'Indonesia', '06:13', '07:14', '0.23753185756005174', '101.46942027328629'),
(2, 'Asia Global Asia', 'Jl.Merdeka, Pandan, Indonesia', '082399222333', 1, 1, 'Indonesia', '05:11', '18:12', '0.5234873907153951', '101.28315706782472');

-- --------------------------------------------------------

--
-- Table structure for table `b_user_log`
--

CREATE TABLE `b_user_log` (
  `log_id` int(11) NOT NULL,
  `jenis_aksi` varchar(55) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `tgl` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `ip_addr` varchar(17) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `b_user_log`
--

INSERT INTO `b_user_log` (`log_id`, `jenis_aksi`, `keterangan`, `tgl`, `status`, `ip_addr`, `user_id`) VALUES
(1, 'Login System', 'First Administrator Login ke System', '2021-07-10 09:49:38', 1, '::1', 42),
(2, 'Login System', 'First Administrator Login ke System', '2021-07-10 09:57:11', 1, '::1', 42),
(3, 'Login System', 'First Administrator Login ke System', '2021-07-10 11:42:35', 1, '::1', 42),
(4, 'Login System', 'First Administrator Login ke System', '2021-07-11 11:50:34', 1, '::1', 42),
(5, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 12:08:26', 1, '::1', 50),
(6, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 12:09:05', 1, '::1', 50),
(7, 'Login System', 'First Administrator Login ke System', '2021-07-11 12:10:26', 1, '::1', 42),
(8, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 13:34:26', 1, '::1', 50),
(9, 'Login System', 'First Administrator Login ke System', '2021-07-11 14:22:25', 1, '::1', 42),
(10, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 14:23:10', 1, '::1', 50),
(11, 'Login System', 'First Administrator Login ke System', '2021-07-11 14:28:51', 1, '::1', 42),
(12, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 14:36:11', 1, '::1', 50),
(13, 'Login System', 'First Administrator Login ke System', '2021-07-11 15:47:54', 1, '::1', 42),
(14, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 15:49:49', 1, '::1', 50),
(15, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 15:53:05', 1, '::1', 50),
(16, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 15:55:17', 1, '::1', 50),
(17, 'Login System', 'First Administrator Login ke System', '2021-07-11 15:56:54', 1, '::1', 42),
(18, 'Login System', 'Fitra Arrafiq Login ke System', '2021-07-11 16:42:54', 1, '::1', 50);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_bengkel`
--

CREATE TABLE `jenis_bengkel` (
  `id_jenis_bengkel` int(11) NOT NULL,
  `judul` varchar(45) DEFAULT NULL,
  `keterangan` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_bengkel`
--

INSERT INTO `jenis_bengkel` (`id_jenis_bengkel`, `judul`, `keterangan`) VALUES
(1, 'Pengenalan Tableau', 'kjgkgkj');

-- --------------------------------------------------------

--
-- Table structure for table `pemilik_bengkel`
--

CREATE TABLE `pemilik_bengkel` (
  `id_pemilik_bengkel` int(11) NOT NULL,
  `nama_pemilik` text NOT NULL,
  `alamat` varchar(45) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `create_date` date NOT NULL,
  `id_users` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemilik_bengkel`
--

INSERT INTO `pemilik_bengkel` (`id_pemilik_bengkel`, `nama_pemilik`, `alamat`, `no_hp`, `email`, `create_date`, `id_users`) VALUES
(1, 'Fitra Arrafiq', 'Jl.Telagasari', '08239922332', 'fitraarrafiq@gmail.com', '2021-07-11', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('administrator','owner') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `block_status` int(3) NOT NULL,
  `online_status` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `time_online` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_offline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_unit` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `address`, `gender`, `locale`, `picture`, `link`, `role`, `created`, `modified`, `block_status`, `online_status`, `time_online`, `time_offline`, `id_unit`) VALUES
(42, '', '', 'First', 'Administrator', 'admin_sistem', '0192023a7bbd73250516f069df18b500', '', '081562442811', 'Jalan Dr. Setia Budhi No. 57, Rintis, Lima Puluh, Kota Pekanbaru, Riau (28141)', NULL, NULL, NULL, '', 'administrator', '2021-07-11 11:50:34', '2021-07-11 11:50:34', 0, 'offline', '2021-07-11 08:57:23', '2021-07-11 08:57:23', ''),
(50, '', '', 'Fitra', 'Arrafiq', 'owner123', '5be057accb25758101fa5eadbbd79503', '', '081562442811', 'Jalan Dr. Setia Budhi No. 57, Rintis, Lima Puluh, Kota Pekanbaru, Riau (28141)', NULL, NULL, NULL, '', 'owner', '2021-07-11 11:50:34', '2021-07-11 11:50:34', 0, 'offline', '2021-07-11 09:43:06', '2021-07-11 09:43:06', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bengkel`
--
ALTER TABLE `bengkel`
  ADD PRIMARY KEY (`id_bengkel`);

--
-- Indexes for table `b_user_log`
--
ALTER TABLE `b_user_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `jenis_bengkel`
--
ALTER TABLE `jenis_bengkel`
  ADD PRIMARY KEY (`id_jenis_bengkel`);

--
-- Indexes for table `pemilik_bengkel`
--
ALTER TABLE `pemilik_bengkel`
  ADD PRIMARY KEY (`id_pemilik_bengkel`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bengkel`
--
ALTER TABLE `bengkel`
  MODIFY `id_bengkel` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `b_user_log`
--
ALTER TABLE `b_user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jenis_bengkel`
--
ALTER TABLE `jenis_bengkel`
  MODIFY `id_jenis_bengkel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemilik_bengkel`
--
ALTER TABLE `pemilik_bengkel`
  MODIFY `id_pemilik_bengkel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
