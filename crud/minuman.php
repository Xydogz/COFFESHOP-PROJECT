<?php
session_start();
include "koneksi.php";

// Query untuk mengambil data rekomendasi
$sql = "SELECT * FROM produk WHERE kategori = 'minuman' ORDER BY id ASC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Minuman</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <!-- Background Elements -->
    <div class="atas"></div>
    <div class="bawah"></div>

    <!-- Main Content -->
    <div class="container">
        <div class="box">
            <!-- Header Section -->
            <div class="header">
                <p>ORION COFFESHOP : Minuman</p>
                <div class="back">
                    <a href="kategori.html"><button>BACK</button></a>
                </div>
            </div>
            <div class="add">
                        <a href="add-minuman.php"><button>ADD</button></a>
                    </div>
            <!-- Content Section -->
            <div class="content">
                
                <div class="table-container">
                    <!-- Add Button -->


                    <!-- Table -->
                    <table>
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th width="250px">Nama</th>
                                <th width="150px">Harga</th>
                                <th width="140px">Stock</th>
                                <th width="200px">Foto Produk</th>
                                <th width="100px" >Rekomendasi</th>
                                <th width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php 
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td>
                                            <img style="height: 50px;" 
                                                 src="images/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                                                 class="product-image">
                                        </td>

                                        <td><?= htmlspecialchars($row['rekomendasi']) ?></td>

                                        <td>
                                            <a href="edit.php?id=<?= $row['id'] ?> &from=minuman.php">
                                                <button class="btn-edit">Edit</button>
                                            </a>
                                            <button onclick="confirmDelete(<?= $row['id'] ?>)" 
                                                    class="btn-hapus">Hapus</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data produk</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                window.location.href = 'hapus.php?id=' + id + '&from=minuman.php';
            }
        }
    </script>
</body>
</html>