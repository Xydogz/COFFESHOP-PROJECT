<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $nama_produk = filter_input(INPUT_POST, 'nama_produk', FILTER_SANITIZE_STRING);
        $harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
        $stok = isset($_POST['stok']) ? 'Ada' : 'Tidak Ada';

        if (!$nama_produk || !$harga) {
            throw new Exception("Data produk tidak valid!");
        }

        // File upload handling
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception("Foto produk wajib diupload!");
        }

        $file = $_FILES['foto'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!in_array($file['type'], $allowed)) {
            throw new Exception("Format file tidak diizinkan!");
        }
        
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran file maksimal 2MB!");
        }

        $filename = date('YmdHis') . '_' . basename($file['name']);
        $uploadPath = __DIR__ . '/images/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception("Gagal mengupload file!");
        }

        // Database insert
        $stmt = mysqli_prepare($koneksi, 
            "INSERT INTO produk (nama_produk, harga, stok, gambar_produk) VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "siss", $nama_produk, $harga, $stok, $filename);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($koneksi));
        }

        $_SESSION['success'] = "Produk berhasil ditambahkan!";
        header("Location: admin.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" required min="0">
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="checkbox" id="stok" name="stok">
            </div>

            <div class="form-group">
                <label for="foto">Foto Produk</label>
                <input type="file" id="foto" name="foto" required accept="image/*">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="admin.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>