<?php
include "../check_supplier.php";
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      
        $nama_produk = filter_input(INPUT_POST, 'nama_produk', FILTER_SANITIZE_STRING);
        $harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
        $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
        $rekomendasi = isset($_POST['rekomendasi']) ? 'iya' : 'tidak';

        if (!$nama_produk || !$harga) {
            throw new Exception("Data produk tidak valid!");
        }

        
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
        $uploadPath = __DIR__ . '/../images/' . $filename;

        if (!is_writable(dirname($uploadPath))) {
            throw new Exception("Upload directory is not writable");
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception("Gagal mengupload file!");
        }

      
        $stmt = mysqli_prepare($koneksi, 
            "INSERT INTO produk (nama_produk, harga, stok, gambar_produk, kategori, rekomendasi) VALUES (?, ?, ?, ?, 'makanan', ?)"
        );
        mysqli_stmt_bind_param($stmt, "siiss", $nama_produk, $harga, $stok, $filename, $rekomendasi);
        
        if (mysqli_stmt_execute($stmt)) {
            $last_id = mysqli_insert_id($koneksi);
            if ($last_id) {
                $code = rand(1, 999999);
                $id_makanan = "F_" . $code . "_" . $last_id;

                $query = "UPDATE produk SET id_makanan = ? WHERE id = ?";
                $stmt_update = mysqli_prepare($koneksi, $query);
                mysqli_stmt_bind_param($stmt_update, "si", $id_makanan, $last_id);

                if (!mysqli_stmt_execute($stmt_update)) {
                    throw new Exception(mysqli_error($koneksi));
                }
                mysqli_stmt_close($stmt_update);
            }
        } else {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_close($stmt);
        $_SESSION['success'] = "Produk berhasil ditambahkan!";
        header("Location: makanan.php");
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
    <title>Tambah Produk Makanan</title>
    <link rel="stylesheet" href="../../style/admin.css">
</head>
<body>
    <div class="atas"></div>
    <div class="bawah"></div>

    <div class="container">
        <div class="box">
            <div class="back">
                <a href="javascript:history.back()"><button>BACK</button></a>
            </div>

            <h1>TAMBAH PRODUK MAKANAN</h1>

            <div class="content">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="product-form">
                    <div class="add">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" required>

                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" required min="0">

                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" required min="0">

                        <label for="foto">Foto Produk</label>
                        <input type="file" id="foto" name="foto" required accept="image/*">

                        <label for="rekomendasi">Rekomendasi</label>
                        <input type="checkbox" id="rekomendasi" name="rekomendasi">
                    </div>

                    <div class="aksi">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>