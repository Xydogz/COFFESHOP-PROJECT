-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 06:05 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(3) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `jumlah_produk` int(5) NOT NULL,
  `subtotal` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `nama_produk`, `gambar_produk`, `harga_satuan`, `jumlah_produk`, `subtotal`) VALUES
(75, 'Cappucino', '20241110081206_cappucino.png', 14000, 1, 14000);

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
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `produk` varchar(255) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `produk`, `harga_satuan`, `jumlah_produk`, `total`, `tanggal`) VALUES
(1, 'Frappe Matcha', 16000.00, 1, 16000.00, '2024-12-16 03:12:08'),
(2, 'Cappucino', 14000.00, 2, 28000.00, '2024-12-16 03:16:39'),
(3, 'Pancong', 8000.00, 2, 16000.00, '2024-12-16 03:19:10'),
(4, 'Frappe Matcha', 16000.00, 1, 16000.00, '2024-12-16 03:31:43'),
(5, 'Frappe Matcha', 16000.00, 1, 16000.00, '2024-12-16 03:33:21'),
(6, 'French Fries', 10000.00, 1, 10000.00, '2024-12-16 03:36:32'),
(7, 'Cappucino', 14000.00, 1, 14000.00, '2024-12-16 03:38:24'),
(8, 'Cappucino', 14000.00, 1, 14000.00, '2024-12-16 03:45:50'),
(9, 'Pancong', 8000.00, 5, 40000.00, '2024-12-16 04:07:05'),
(10, 'Frappe Red Velvet', 16000.00, 4, 64000.00, '2024-12-16 04:07:05'),
(11, 'Croissant', 8000.00, 1, 8000.00, '2024-12-16 04:07:05'),
(12, 'Frappe Red Velvet', 16000.00, 10, 160000.00, '2024-12-16 04:08:18'),
(13, 'Frappe Red Velvet', 16000.00, 4, 64000.00, '2024-12-16 04:09:25'),
(14, 'Pancong', 8000.00, 4, 32000.00, '2024-12-16 04:10:24'),
(15, 'Es Teh Hangat', 5000.00, 3, 15000.00, '2024-12-16 04:21:49'),
(16, 'Pancake', 12000.00, 10, 120000.00, '2024-12-16 04:21:49'),
(17, 'Cappucino', 14000.00, 3, 42000.00, '2024-12-21 16:34:29'),
(18, 'French Fries', 10000.00, 1, 10000.00, '2024-12-21 16:34:29'),
(19, 'Es Teh Hangat', 5000.00, 2, 10000.00, '2024-12-21 16:34:29'),
(20, 'Sandwich', 12000.00, 1, 12000.00, '2024-12-21 16:34:29'),
(21, 'Frappe Red Velvet', 16000.00, 1, 16000.00, '2024-12-21 16:34:29'),
(22, 'Americano', 12000.00, 3, 36000.00, '2024-12-21 16:34:29'),
(23, 'Macchiato', 12000.00, 3, 36000.00, '2024-12-21 16:34:29'),
(24, 'Frappe Red Velvet', 16000.00, 5, 80000.00, '2024-12-21 17:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `kd_invoice` varchar(255) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `harga_satuan` decimal(10,2) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kd_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `kd_role`) VALUES
(1, 'admin', '$2y$10$YourHashedPasswordHere', 1),
(2, 'supplier', '$2y$10$YourHashedPasswordHere', 3);

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
  `kd_produk` varchar(255) NOT NULL,
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

INSERT INTO `produk` (`id`, `kd_produk`, `nama_produk`, `harga`, `stok`, `gambar_produk`, `kategori`, `rekomendasi`) VALUES
(1, 'F_725600_1', 'Habob', 8000, 100, '20241110075924_pancong.png', 'makanan', 'tidak'),
(2, 'F_154735_2', 'Croissant', 8000, 100, '20241110080056_molen.png', 'makanan', 'tidak'),
(3, 'F_602650_3', 'French Fries', 10000, 93, '20241110080125_french fries.png', 'makanan', 'iya'),
(5, 'F_41028_5', 'Burger', 17000, 100, '20241110080216_burger.png', 'makanan', 'tidak'),
(6, 'F_672022_6', 'Sandwich', 12000, 100, '20241110080237_sandwich.png', 'makanan', 'tidak'),
(7, 'F_869858_7', 'Cookies', 8000, 100, '20241110080301_kukiss.png', 'makanan', 'tidak'),
(8, 'F_758230_8', 'Pancake', 12000, 100, '20241110080321_pancake.png', 'makanan', 'tidak'),
(9, 'D_443768_9', 'Cappucino', 14000, 98, '20241110081206_cappucino.png', 'minuman', 'iya'),
(10, 'D_185767_10', 'Americano', 12000, 100, '20241110081358_americano.png', 'minuman', 'tidak'),
(11, 'D_256015_11', 'Latte', 12000, 100, '20241110081426_latte.png', 'minuman', 'tidak'),
(12, 'D_273248_12', 'Expresso', 12000, 100, '20241110081446_expresso.png', 'minuman', 'tidak'),
(13, 'D_925939_13', 'Macchiato', 12000, 100, '20241110081510_macchiato.png', 'minuman', 'tidak'),
(14, 'D_556724_14', 'Kopi Tubruk', 12000, 100, '20241110081528_kopi tubruk.png', 'minuman', 'tidak'),
(15, 'D_472997_15', 'Kopi Hitam', 5000, 100, '20241110081547_kopi hitam.png', 'minuman', 'tidak'),
(16, 'D_578019_16', 'Chocolate', 14000, 100, '20241110081602_nyoklat.png', 'minuman', 'tidak'),
(17, 'D_195177_17', 'Frappe Matcha', 16000, 97, '10112024082018_Frappe Matcha.png', 'minuman', 'iya'),
(18, 'D_419391_18', 'Frappe Red Velvet', 16000, 95, '20241110082012_Frappe Red Velvet.png', 'minuman', 'iya'),
(19, 'D_255698_19', 'Creamy Latte', 12000, 100, '20241110082035_Creamy latte.png', 'minuman', 'iya'),
(20, 'D_166379_20', 'Es Teh Hangat', 5000, 100, '20241115030245_gopay cik.jpg', 'minuman', 'iya');

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
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `sale_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kode_akses` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kd_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `kode_akses`, `username`, `password`, `kd_role`) VALUES
(0, 'Administrator', '123456', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(0, 'Supplier', '654321', 'supplier', '$2y$10$zxv4R2W8v/6.XoGDV3zWn.h3QFQZRQ7G8vE5C0q7pJ5u4kQgH5O2i', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kd_customer`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_transaction` (`kd_invoice`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_role` (`kd_role`);

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invoice_transaction` FOREIGN KEY (`kd_invoice`) REFERENCES `transactions` (`transaction_id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`kd_role`) REFERENCES `roles` (`kd_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
