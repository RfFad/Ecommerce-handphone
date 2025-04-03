-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2025 at 07:24 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handphone`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id_checkout` int NOT NULL,
  `id_user` int NOT NULL,
  `tgl` date NOT NULL,
  `alamat` text NOT NULL,
  `item_qty` int NOT NULL,
  `total` int NOT NULL,
  `status` enum('menunggu','diproses','dikirim','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id_checkout`, `id_user`, `tgl`, `alamat`, `item_qty`, `total`, `status`) VALUES
(6, 1, '2025-02-25', 'Kuningan', 3, 10100000, 'dikirim'),
(7, 1, '2025-02-25', 'Kuningan', 1, 3200000, 'menunggu'),
(8, 2, '2025-02-26', 'Cirebon', 3, 6000000, 'dikirim'),
(9, 1, '2025-02-26', 'Kuningan', 1, 7200000, 'diproses');

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_detail` int NOT NULL,
  `id_checkout` int NOT NULL,
  `item_quantity` int NOT NULL,
  `id_produk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_detail`, `id_checkout`, `item_quantity`, `id_produk`) VALUES
(6, 6, 1, 10),
(7, 6, 1, 5),
(8, 6, 1, 12),
(9, 7, 1, 3),
(10, 8, 1, 3),
(11, 8, 1, 6),
(12, 9, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int NOT NULL,
  `id_produk` int NOT NULL,
  `qty` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_produk`, `qty`, `id_user`) VALUES
(39, 1, 1, 2),
(41, 9, 1, 1),
(42, 13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_user` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_user`, `username`, `email`, `password`, `no_hp`, `alamat`) VALUES
(1, '', 'refanfadillah@gmail.com', 'refan', '085803290738', 'jambar'),
(2, '', 'azzi@gmail.com', 'azzi', '083803290738', 'awn'),
(3, 'refan', 'refanfadillah2007@gmail.com', 'rfn', '085803290738', 'jambar'),
(4, 'aldan', 'ashiap135@gmail.com', 'aldanajah', '0895364434917', 'Jalan Jenderal Sudirman Halimpu Beber');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL,
  `produk` text COLLATE utf8mb4_general_ci NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `harga`, `produk`, `stok`) VALUES
(1, 'asus rog phone 5', 8200000, 'asus rog phone 5.png', 69),
(3, 'POCO M3', 3200000, 'POCO-M3.jpg', 2),
(4, 'redmi 10(2022)', 2000000, 'redmi10(2022).png', 3),
(5, 'poco f5', 3600000, 'pocof5.jpg', 6),
(6, 'poco x3 pro', 2800000, 'poco-x3-pro.png', 3),
(7, 'OPPO A55', 2000000, 'OppoA55.jpg', 8),
(9, 'iphone 11 pro max', 11000000, 'iphone 11 pro max.jpg', 3),
(10, 'redmi note 9', 3000000, 'Redminote9.webp', 3),
(11, 'redmi 12 c', 3200000, 'Redmi-12Cwebp.webp', 3),
(12, 'Redmi Note 12 pro 5G', 3500000, 'Redmi-Note-12-Pro-5G.webp', 5),
(13, 'Xiomi Redmi Note 11 Pro 5G', 2600000, 'Xiaomi-Redmi-Note-11-Pro-5G.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `telepon`, `alamat`, `role`) VALUES
(1, 'refan', 'refan27', 'refanfadillah@gmail.com', '', 'Kuningan', 'user'),
(2, 'aldan', 'aldan', 'aldan123@gmail.com', '', '', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id_checkout`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id_checkout` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
