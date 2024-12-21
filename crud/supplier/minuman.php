<?php
include "../check_supplier.php";
include "../koneksi.php";

$sql = "SELECT * FROM produk WHERE kategori = 'minuman' ORDER BY id ASC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Panel - Rekomendasi</title>
    <link rel="stylesheet" href="../../style/admin.css">
</head>
<body>
    <div class="atas"></div>
    <div class="bawah"></div>
    <div class="container">
        <div class="box">
            <div class="header">
                <p>ORION COFFESHOP : Rekomendasi</p>
                <div class="back">
                    <a href="kategori.html"><button>BACK</button></a>
                </div>
            </div>
            <div class="content">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th width="250px">Nama</th>
                                <th width="150px">Harga</th>
                                <th width="140px">Stock</th>
                                <th width="200px">Foto Produk</th>
                                <th width="100px">Rekomendasi</th>
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
                                                 src="../images/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                                                 class="product-image">
                                        </td>
                                        <td><?= htmlspecialchars($row['rekomendasi']) ?></td>
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
</body>
</html> 