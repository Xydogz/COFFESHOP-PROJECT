<?php
include "koneksi.php";

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Ambil info gambar
    $sql = "SELECT gambar_produk FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    // Hapus file gambar
    if($data['gambar_produk'] && file_exists("images/".$data['gambar_produk'])) {
        unlink("images/".$data['gambar_produk']);
    }
    
    // Hapus data dari database
    $sql = "DELETE FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location='admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($koneksi) . "');
                window.location='admin.php';
              </script>";
    }
} else {
    header("Location: admin.php");
}
?>