<?php
include "crud/koneksi.php"; // Pastikan untuk menyertakan koneksi database

// Ambil data dari query string
$id = $_GET['id'];
$quantity = $_GET['quantity'];

// Ambil harga, nama, dan gambar produk dari database
$sql = "SELECT harga, nama_produk, gambar_produk FROM produk WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product) {
    $price = $product['harga'];
    $nama = $product['nama_produk'];
    $image = $product['gambar_produk'];

    // Memeriksa apakah produk sudah ada di keranjang
    $sqlCheck = "SELECT jumlah_produk FROM cart WHERE nama_produk = ?";
    $stmtCheck = $koneksi->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $nama);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Jika produk sudah ada, ambil jumlah saat ini dan tambahkan
        $row = $resultCheck->fetch_assoc();
        $newQuantity = $row['jumlah_produk'] + $quantity;
        $subtotal = $newQuantity * $price; // Menghitung subtotal baru

        // Memperbarui jumlah produk di keranjang
        $sqlUpdateCart = "UPDATE cart SET jumlah_produk = ?, subtotal = ? WHERE nama_produk = ?";
        $stmtUpdateCart = $koneksi->prepare($sqlUpdateCart);
        $stmtUpdateCart->bind_param("ids", $newQuantity, $subtotal, $nama);
        $stmtUpdateCart->execute();
    } else {
        // Jika produk belum ada, masukkan ke keranjang
        $subtotal = $quantity * $price; // Menghitung subtotal
        $sqlInsert = "INSERT INTO cart (nama_produk, gambar_produk, harga_satuan, jumlah_produk, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $koneksi->prepare($sqlInsert);
        $stmtInsert->bind_param("ssdid", $nama, $image, $price, $quantity, $subtotal);
        $stmtInsert->execute();
    }

    // Menampilkan pesan berdasarkan hasil update atau insert
    if ($stmtUpdateCart->affected_rows > 0 || $stmtInsert->affected_rows > 0) {
        echo "<script>alert('Stok berhasil diperbarui dan detail invoice ditambahkan.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui stok atau menambahkan detail invoice.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Produk tidak ditemukan.'); window.location.href='index.php';</script>";
}

$stmt->close();
$stmtCheck->close();
$stmtUpdateCart->close();
$stmtInsert->close();
$koneksi->close();
?> 