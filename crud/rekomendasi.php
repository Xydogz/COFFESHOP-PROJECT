<?php
session_start();
include "koneksi.php";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM produk ORDER BY id DESC LIMIT ?, ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ii", $start, $limit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get total records for pagination
$total_records = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM produk"))[0];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <!-- BACKGROUND -->
      <div class="atas"></div>
      <div class="bawah"></div>
    <!-- background -->

    <div class="container">
      <div class="box">
        <div class="header">
          <p>ORION COFFESHOP</p>

          <div class="back">
            <a href="javascript:history.back()"><button>BACK</button></a>
          </div>
      </div>

      <div class="content">
      <div class="table-container">
        <div class="add">
            <a href="add.php"><button>ADD</button></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th width="250px">Nama</th>
                    <th width="150px">Harga</th>
                    <th width="140px">Stock</th>
                    <th width="300px">Foto Produk</th>
                    <th width="200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0):
                    $no = $start + 1;
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td>
                            <img style="height: 50px;" src="images/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                                 class="product-image">
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit"><button>Edit</button></a>
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn-hapus">Hapus</button>
                        </td>
                    </tr>
                <?php 
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data produk</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

      </div>

      </div>

    </div>
    </div>

    <script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            window.location.href = 'hapus.php?id=' + id;
        }
    }
    </script>
</body>
</html>