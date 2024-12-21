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

// Proses pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uang_diberikan = $_POST['uang_diberikan'];

    if ($uang_diberikan >= $total) {
        // Proses: Masukkan data ke tabel history dan update stok
        foreach ($cart_items as $item) {
            $produk = $item['nama_produk'];
            $harga_satuan = $item['harga_satuan'];
            $jumlah_produk = $item['jumlah_produk'];
            $total_produk = $harga_satuan * $jumlah_produk;

            // Update stok di tabel produk
            $stmt_update = $koneksi->prepare("
                UPDATE produk 
                SET stok = stok - ? 
                WHERE nama_produk = ?
            ");
            $stmt_update->bind_param("is", $jumlah_produk, $produk);
            $stmt_update->execute();

            // Insert ke tabel history
            $stmt_insert = $koneksi->prepare("
                INSERT INTO history (produk, harga_satuan, jumlah_produk, total, tanggal) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt_insert->bind_param("siii", $produk, $harga_satuan, $jumlah_produk, $total_produk);
            $stmt_insert->execute();
        }

        // Kosongkan keranjang setelah pembayaran sukses
        $koneksi->query("DELETE FROM cart");

        // Hitung kembalian
        $kembalian = $uang_diberikan - $total;

        // Tampilkan invoice
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Invoice Pembelian</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                h2, h3 { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                table, th, td { border: 1px solid black; }
                th, td { text-align: left; padding: 8px; }
                .total { font-weight: bold; }
                .summary { margin-top: 20px; text-align: right; }
                .summary p { margin: 5px 0; }
            </style>
        </head>
        <body onload='window.print()'>
            <h2>Invoice Pembelian</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>";

        $no = 1;
        foreach ($cart_items as $item) {
            $subtotal = $item['harga_satuan'] * $item['jumlah_produk'];
            echo "<tr>
                    <td>{$no}</td>
                    <td>" . htmlspecialchars($item['nama_produk']) . "</td>
                    <td>{$item['jumlah_produk']}</td>
                    <td>Rp. " . number_format($item['harga_satuan'], 0, ',', '.') . "</td>
                    <td>Rp. " . number_format($subtotal, 0, ',', '.') . "</td>
                </tr>";
            $no++;
        }

        echo "</table>
            <div class='summary'>
                <p class='total'>Total Pembelian: Rp. " . number_format($total, 0, ',', '.') . "</p>
                <p>Uang Diberikan: Rp. " . number_format($uang_diberikan, 0, ',', '.') . "</p>
                <p>Kembalian: Rp. " . number_format($kembalian, 0, ',', '.') . "</p>
            </div>
            <h3>Terima Kasih Telah Berbelanja!</h3>
        </body>
        </html>";
        exit; // Menghentikan eksekusi setelah menampilkan invoice
    } else {
        $error = "Uang yang diberikan kurang!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Background -->
    <div class="atas"></div>
    <div class="bawah"></div>

    <!-- Invoice -->
    <div class="box">
        <div class="header">
            <h2>Invoice Pembayaran</h2>
            <div class="back">
                <a href="index.php"><button>Kembali</button></a>
            </div>
        </div>

        <div class="content">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php else: ?>
                <form method="POST">
                    <h3>Total Pembelian: Rp. <?= number_format($total, 0, ',', '.'); ?></h3>
                    <label for="uang_diberikan">Uang Diberikan:</label>
                    <input type="number" name="uang_diberikan" id="uang_diberikan" required placeholder="Masukkan jumlah uang">
                    <button type="submit">Bayar</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
