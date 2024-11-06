<?php
include "koneksi.php";

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if(!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='admin.php';</script>";
        exit;
    }
} else {
    header("Location: admin.php");
    exit;
}

if(isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = isset($_POST['stok']) ? 'Ada' : 'Tidak Ada';
    
    if($_FILES['foto']['name']) {
        // Proses upload file baru
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(!in_array($ext, $allowed)) {
            echo "<script>alert('Format file tidak diizinkan!');</script>";
            exit;
        }
        
        if($_FILES['foto']['size'] > 2097152) {
            echo "<script>alert('Ukuran file terlalu besar! Max 2MB');</script>";
            exit;
        }
        
        $fotobaru = date('dmYHis') . "_" . $filename;
        $path = "images/" . $fotobaru;
        
        move_uploaded_file($_FILES['foto']['tmp_name'], $path);
        
        // Hapus foto lama
        if($data['gambar_produk'] && file_exists("images/".$data['gambar_produk'])) {
            unlink("images/".$data['gambar_produk']);
        }
    } else {
        $fotobaru = $data['gambar_produk'];
    }
    
    $sql = "UPDATE produk SET nama_produk=?, harga=?, stok=?, gambar_produk=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_produk, $harga, $stok, $fotobaru, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil diupdate!');
                window.location='admin.php';
              </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<!-- ... existing HTML head ... -->
<body>
    <!-- ... existing divs ... -->
    <div class="content">
        <form method="POST" enctype="multipart/form-data">
            <div class="add">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
                
                <label for="harga">Harga</label>
                <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
                
                <label for="stok">Stok</label>
                <input type="checkbox" name="stok" <?= $data['stok'] == 'Ada' ? 'checked' : '' ?>>
                
                <label for="foto">Foto Produk</label>
                <input type="file" name="foto">
                <?php if($data['gambar_produk']): ?>
                    <img src="images/<?= $data['gambar_produk'] ?>" alt="Current Image" style="max-width:100px;">
                <?php endif; ?>
            </div>

            <div class="aksi">
                <button type="submit" name="update">UPDATE</button>
            </div>
        </form>
    </div>
    <!-- ... existing closing tags ... -->
</body>
</html>