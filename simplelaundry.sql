-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 15, 2024 at 02:49 AM
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
-- Database: `simplelaundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `transaksi_id` int DEFAULT NULL,
  `paket_id` int DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  `keterangan` text,
  `total_bayar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `transaksi_id`, `paket_id`, `qty`, `total_harga`, `keterangan`, `total_bayar`) VALUES
(2, 33, 2, 1000, NULL, 'fsefsfsfsf', NULL),
(9, 33, 4, 10, 150000, NULL, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int NOT NULL,
  `nama_member` varchar(100) DEFAULT NULL,
  `alamat_member` text,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp_member` varchar(15) DEFAULT NULL,
  `no_ktp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama_member`, `alamat_member`, `jenis_kelamin`, `telp_member`, `no_ktp`) VALUES
(1, 'Asep ', 'Jl. Sepakat 1', 'L', '0812937283', NULL),
(2, 'Denis', 'Jl. Kampung 3', 'L', '01728283674', NULL),
(3, 'Wati', 'Jl. Kerta 2', 'P', '02782635223', NULL),
(5, 'Diana', 'Jl. Keramat Jati', 'P', '0821340411', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `outlet`
--

CREATE TABLE `outlet` (
  `id_outlet` int NOT NULL,
  `nama_outlet` varchar(100) DEFAULT NULL,
  `alamat_outlet` text,
  `telp_outlet` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `outlet`
--

INSERT INTO `outlet` (`id_outlet`, `nama_outlet`, `alamat_outlet`, `telp_outlet`) VALUES
(1, 'Outlet Cilangkap', 'Jl. Cilangkap Raya ', '8121322343'),
(2, 'Outlet Ceger', 'Jl. Raya Ceger', '083829374738'),
(3, 'Outlet PDR', 'Jl. Raya Pondok Ranggon', '02992920434'),
(4, 'Outlet Cipayung', 'Jl. Cipayung Raya', '038948747384'),
(5, 'Outlet Cibubur', 'Jl. Cibubur', '98765673456'),
(26, 'Outlet Munjul', 'Jl. Munjul', '081243555656');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` int NOT NULL,
  `jenis_paket` enum('kiloan','selimut','bedcover','kaos','lain') DEFAULT NULL,
  `nama_paket` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `outlet_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `jenis_paket`, `nama_paket`, `harga`, `outlet_id`) VALUES
(1, 'selimut', 'Selimut Bersih', 30000, 4),
(2, 'bedcover', 'Sarung Kasur bersih', 15000, 2),
(4, 'kiloan', 'Paket Kering Wangi', 15000, 26),
(5, 'kaos', 'Kaos Remaja', 30000, 3),
(6, 'kiloan', 'Paket Pakaian Bersih', 40000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `outlet_id` int DEFAULT NULL,
  `kode_invoice` varchar(100) DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `status` enum('baru','proses','selesai','diambil') DEFAULT NULL,
  `status_bayar` enum('dibayar','belum') DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `outlet_id`, `kode_invoice`, `member_id`, `tgl`, `tgl_pembayaran`, `status`, `status_bayar`, `user_id`) VALUES
(2, 2, 'DRY2212123122', 3, '2024-02-01 00:00:00', '2024-02-14 00:00:00', 'proses', 'belum', 2),
(10, 2, 'DRY567754', 2, '2024-02-23 00:00:00', '2024-02-24 00:00:00', 'proses', 'belum', 11),
(21, 3, 'DRY87675453565', 2, '2024-02-01 00:00:00', '2024-02-07 00:00:00', 'diambil', 'dibayar', 1),
(33, 1, 'DRY2566433', 1, '2024-02-01 00:00:00', '2024-02-08 00:00:00', 'selesai', 'dibayar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `outlet_id` int DEFAULT NULL,
  `role` enum('admin','kasir','owner') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `outlet_id`, `role`) VALUES
(1, 'Yosua Sinaga', 'owner', '$2y$10$IU.9Nt/Ks/zFNGOZTt5wreVkdxHqisKftG0ph4b5Sy.QUmcfL9p4K', 26, 'owner'),
(2, 'yosua', 'yosua', '$2y$10$n3tRe.k9tYCR4nPRvE52hua.nLEqHZzahmN5twMMrF/nMunq2VDV2', 26, 'admin'),
(3, 'Kucuk', 'cukuk', '$2y$10$7qTxCBS4UH4nlZVh/EgKDOMWNBqy6b/dvfYFNGdGrXvjEXWMEEeCS', 26, 'kasir'),
(11, 'Ucup', 'ucup', '$2y$10$0PxDMK/QLbVzLJjPjfl/1eoifnamgSlJXtIwEF0tvz1i7VllDZF22', 26, 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `paket_id` (`paket_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `outlet_id` (`outlet_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `outlet_id` (`outlet_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `outlet_id` (`outlet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `outlet`
--
ALTER TABLE `outlet`
  MODIFY `id_outlet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81235;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`paket_id`) REFERENCES `paket` (`id_paket`);

--
-- Constraints for table `paket`
--
ALTER TABLE `paket`
  ADD CONSTRAINT `paket_ibfk_1` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id_outlet`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id_outlet`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id_member`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id_outlet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
