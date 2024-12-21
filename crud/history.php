<?php
session_start();
include "koneksi.php";

// Ambil data history
$stmt = $koneksi->prepare("SELECT * FROM history ORDER BY tanggal DESC");
$stmt->execute();
$result = $stmt->get_result();
$history_items = $result->fetch_all(MYSQLI_ASSOC);

// Hitung total pendapatan
$total_pendapatan = 0;
foreach ($history_items as $item) {
    $total_pendapatan += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../style/history.css" />
  <title>HISTORY Orion Coffeeshop</title>
</head>
<body>
  <!-- BACKGROUND -->
  <div class="atas"></div>
  <div class="bawah"></div>
  <!-- background -->

  <div class="container">
    <div class="box">
      <h1 class="header-title">ORION COFFEESHOP</h1>
      
      <div class="nota-box">
        <h2 class="nota-title">HISTORY PENJUALAN</h2>
        <h3>REKAP PENJUALAN PER HARI INI</h3>

        <div class="order-item">
          <table class="order-item-table">
            <tr>
              <th>No</th>
              <th>Produk</th>
              <th>Harga Satuan</th>
              <th>Jumlah Terjual</th>
              <th>Total</th>
              <th>Tanggal</th>
            </tr>

            <?php 
            $no = 1;
            foreach ($history_items as $item): 
                $subtotal = $item['harga_satuan'] * $item['jumlah_produk'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($item['produk']); ?></td>
                <td>Rp. <?= number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                <td><?= $item['jumlah_produk']; ?></td>
                <td>Rp. <?= number_format($item['total'], 0, ',', '.'); ?></td>
                <td><?= $item['tanggal']; ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
        </div>

        <!-- Total Pendapatan -->
        <div class="total-pendapatan">
          <h3>Total Pendapatan Hari Ini: 
            <span style="color: green;">Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></span>
          </h3>
        </div>

        <!-- Tombol Kembali -->
        <div class="cetak-btn">
          <button onclick="window.location.href='../index.php'">KEMBALI</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
