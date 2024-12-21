<?php
session_start();
include "crud/koneksi.php"; // Include database connection

// Ambil data dari notifikasi
$input = file_get_contents('php://input');
$paymentData = json_decode($input, true);

// Validasi data
if (isset($paymentData['status'], $paymentData['transaction_id'], $paymentData['total_amount'], $paymentData['user_id']) &&
    $paymentData['status'] === 'success') {
    
    // Ambil data yang diperlukan
    $transactionId = $paymentData['transaction_id'];
    $totalAmount = $paymentData['total_amount'];
    $userId = $paymentData['user_id'];

    // Simpan data transaksi ke database
    $sql = "INSERT INTO transactions (transaction_id, user_id, total_amount, status) VALUES (?, ?, ?, 'completed')";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sid", $transactionId, $userId, $totalAmount);
    $stmt->execute();

    // Generate invoice
    header("Location: invoice.php?transaction_id=" . urlencode($transactionId));
    exit();
}
?>
