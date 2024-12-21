<?php
session_start();
include "crud/koneksi.php";

// Ambil data keranjang
$stmt = $koneksi->prepare("SELECT * FROM cart ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

$total = 0;

// Hitung total harga
foreach ($cart_items as $item) {
    $subtotal = $item['harga_satuan'] * $item['jumlah_produk'];
    $total += $subtotal;
}

// Ambil data uang yang diberikan dari input sebelumnya
$uang_diberikan = isset($_POST['uang_diberikan']) ? intval($_POST['uang_diberikan']) : 0;
$kembalian = $uang_diberikan - $total;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.....................................................................................................................................................................................................................................</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h2, h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        .total {
            font-weight: bold;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
        }

        .summary p {
            margin: 5px 0;
        }
    </style>
</head>
<body onload="window.print()">
    <h2>Invoice Pembelian</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $no = 1;
        foreach ($cart_items as $item): 
            $subtotal = $item['harga_satuan'] * $item['jumlah_produk'];
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($item['nama_produk']); ?></td>
            <td><?= $item['jumlah_produk']; ?></td>
            <td>Rp. <?= number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
            <td>Rp. <?= number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Bagian Total dan Uang -->
    <div class="summary">
        <p class="total">Total Pembelian: Rp. <?= number_format($total, 0, ',', '.'); ?></p>
        <p>Uang Diberikan: Rp. <?= number_format($uang_diberikan, 0, ',', '.'); ?></p>
        <p>Kembalian: Rp. <?= number_format($kembalian, 0, ',', '.'); ?></p>
    </div>
    <h3>Terima Kasih Telah Berbelanja!</h3>
</body>
</html>
