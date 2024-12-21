<?php
session_start();
include "crud/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
        // Generate a unique transaction ID
        $transactionId = uniqid('txn_'); // Generate a unique transaction ID
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
        $totalAmount = 0;

        // Insert transaction into the database
        $sqlTransaction = "INSERT INTO transactions (transaction_id, user_id, total_amount) VALUES (?, ?, ?)";
        $stmtTransaction = $koneksi->prepare($sqlTransaction);
        $stmtTransaction->bind_param("sid", $transactionId, $userId, $totalAmount);
        $stmtTransaction->execute();

        // Insert each item in the cart into the invoice table
        foreach ($_SESSION['keranjang'] as $item) {
            $subtotal = $item['harga_produk'] * $item['qty'];
            $totalAmount += $subtotal; // Accumulate total

            $sqlInvoice = "INSERT INTO invoice (kd_invoice, nama_produk, harga_satuan, jumlah, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmtInvoice = $koneksi->prepare($sqlInvoice);
            $stmtInvoice->bind_param("ssdis", $transactionId, $item['nama_produk'], $item['harga_produk'], $item['qty'], $subtotal);
            $stmtInvoice->execute();
        }

        // Update the total amount in the transactions table
        $sqlUpdate = "UPDATE transactions SET total_amount = ? WHERE transaction_id = ?";
        $stmtUpdate = $koneksi->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ds", $totalAmount, $transactionId);
        $stmtUpdate->execute();

        // Redirect to the invoice page
        header("Location: invoice.php?transaction_id=" . urlencode($transactionId));
        exit();
    } else {
        echo "<script>alert('Your cart is empty. Please add items to your cart.'); window.location.href='keranjang.php';</script>";
        exit();
    }
}
?> 