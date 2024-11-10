-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 03:29 PM
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
-- Database: `coffeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `kd_customer` int(11) NOT NULL,
  `nama_customer` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_invoice`
--

CREATE TABLE `detail_invoice` (
  `kd_invoice` int(11) NOT NULL,
  `kd_produk` int(11) NOT NULL,
  `jumlah` varchar(25) DEFAULT NULL,
  `subtotal` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `kd_invoice` int(11) NOT NULL,
  `kd_customer` int(11) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `nomor_meja` int(11) DEFAULT NULL,
  `total` varchar(15) DEFAULT NULL,
  `kd_pembayaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `kd_metode` int(11) NOT NULL,
  `nama_pembayaran` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_makanan` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(5) NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `rekomendasi` enum('iya','tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_makanan`, `nama_produk`, `harga`, `stok`, `gambar_produk`, `kategori`, `rekomendasi`) VALUES
(1, 'F_725600_1', 'Pancong', 8000, 100, '20241110075924_pancong.png', 'makanan', 'iya'),
(2, 'F_154735_2', 'Croissant', 8000, 100, '20241110080056_molen.png', 'makanan', 'tidak'),
(3, 'F_602650_3', 'French Fries', 10000, 100, '20241110080125_french fries.png', 'makanan', 'iya'),
(4, 'F_42158_4', 'Chicken Katsu', 20000, 100, '20241110080149_chicken katsu.png', 'makanan', 'tidak'),
(5, 'F_41028_5', 'Burger', 17000, 100, '20241110080216_burger.png', 'makanan', 'tidak'),
(6, 'F_672022_6', 'Sandwich', 12000, 100, '20241110080237_sandwich.png', 'makanan', 'tidak'),
(7, 'F_869858_7', 'Cookies', 8000, 100, '20241110080301_kukiss.png', 'makanan', 'tidak'),
(8, 'F_758230_8', 'Pancake', 12000, 100, '20241110080321_pancake.png', 'makanan', 'tidak'),
(9, 'D_443768_9', 'Cappucino', 14000, 100, '20241110081206_cappucino.png', 'minuman', 'iya'),
(10, 'D_185767_10', 'Americano', 12000, 100, '20241110081358_americano.png', 'minuman', 'tidak'),
(11, 'D_256015_11', 'Latte', 12000, 100, '20241110081426_latte.png', 'minuman', 'tidak'),
(12, 'D_273248_12', 'Expresso', 12000, 100, '20241110081446_expresso.png', 'minuman', 'tidak'),
(13, 'D_925939_13', 'Macchiato', 12000, 100, '20241110081510_macchiato.png', 'minuman', 'tidak'),
(14, 'D_556724_14', 'Kopi Tubruk', 12000, 100, '20241110081528_kopi tubruk.png', 'minuman', 'tidak'),
(15, 'D_472997_15', 'Kopi Hitam', 5000, 100, '20241110081547_kopi hitam.png', 'minuman', 'tidak'),
(16, 'D_578019_16', 'Chocolate', 14000, 100, '20241110081602_nyoklat.png', 'minuman', 'tidak'),
(17, 'D_195177_17', 'Frappe Matcha', 16000, 100, '10112024082018_Frappe Matcha.png', 'minuman', 'iya'),
(18, 'D_419391_18', 'Frappe Red Velvet', 16000, 100, '20241110082012_Frappe Red Velvet.png', 'minuman', 'iya'),
(19, 'D_255698_19', 'Creamy Latte', 12000, 100, '20241110082035_Creamy latte.png', 'minuman', 'iya');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `kd_role` int(11) NOT NULL,
  `nama_role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`kd_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'Customer'),
(3, 'Supplier');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kd_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kd_customer`);

--
-- Indexes for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD PRIMARY KEY (`kd_invoice`,`kd_produk`),
  ADD KEY `kd_produk` (`kd_produk`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`kd_invoice`),
  ADD KEY `kd_customer` (`kd_customer`),
  ADD KEY `kd_pembayaran` (`kd_pembayaran`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`kd_metode`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`kd_role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_role` (`kd_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD CONSTRAINT `detail_invoice_ibfk_1` FOREIGN KEY (`kd_invoice`) REFERENCES `invoice` (`kd_invoice`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`kd_customer`) REFERENCES `customer` (`kd_customer`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`kd_pembayaran`) REFERENCES `metode_pembayaran` (`kd_metode`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`kd_role`) REFERENCES `roles` (`kd_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
