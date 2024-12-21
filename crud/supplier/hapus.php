<?php
include "../check_supplier.php";
include "../koneksi.php";

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    
    $sql = "SELECT gambar_produk FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    
    if($data['gambar_produk'] && file_exists("../images/".$data['gambar_produk'])) {
        unlink("../images/".$data['gambar_produk']);
    }
    
    
    $sql = "DELETE FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    $from = isset($_GET['from']) ? $_GET['from'] : 'kategori.html';
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = '{$from}';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($koneksi) . "');
                window.location.href = '{$from}';
              </script>";
    }
} else {
    header("Location: kategori.html");
}
?>