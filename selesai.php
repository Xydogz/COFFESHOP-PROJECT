<?php
include "crud/koneksi.php";
session_start();

// Check if transaction ID exists
if (isset($_GET['transaction_id'])) {
    $transactionId = $_GET['transaction_id'];

    // Fetch transaction details
    $sqlTransaction = "SELECT * FROM transactions WHERE transaction_id = ?";
    $stmtTransaction = $koneksi->prepare($sqlTransaction);
    $stmtTransaction->bind_param("s", $transactionId);
    $stmtTransaction->execute();
    $resultTransaction = $stmtTransaction->get_result();
    $transaction = $resultTransaction->fetch_assoc();

    if (!$transaction) {
        die("Transaction not found.");
    }

    // Fetch invoice items
    $sqlItems = "SELECT * FROM invoice WHERE kd_invoice = ?";
    $stmtItems = $koneksi->prepare($sqlItems);
    $stmtItems->bind_param("s", $transactionId);
    $stmtItems->execute();
    $resultItems = $stmtItems->get_result();

    // Update transaction status to 'completed'
    $sqlUpdate = "UPDATE transactions SET status = 'completed' WHERE transaction_id = ?";
    $stmtUpdate = $koneksi->prepare($sqlUpdate);
    $stmtUpdate->bind_param("s", $transactionId);
    $stmtUpdate->execute();
} else {
    die("Transaction ID is missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="style/invoice.css">
</head>
<body>
    <div class="invoice-container">
        <h1>Invoice</h1>

        <!-- Customer Information -->
        <div class="customer-info">
            <p>Customer Name: <?php echo htmlspecialchars($_SESSION['input_nama_plgn']); ?></p>
            <p>Table Number: <?php echo htmlspecialchars($_SESSION['input_kd_meja']); ?></p>
            <p>Date: <?php echo htmlspecialchars($transaction['created_at']); ?></p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total = 0;
                    while ($item = $resultItems->fetch_assoc()):
                        $total += $item['subtotal'];
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                            <td><?php echo htmlspecialchars($item['jumlah']); ?></td>
                            <td>Rp. <?php echo number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                            <td>Rp. <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td><strong>Rp. <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="payment-info">
            <p>Total Payment: Rp. <?php echo number_format($transaction['total_amount'], 0, ',', '.'); ?></p>
            <p>Payment Status: <?php echo htmlspecialchars($transaction['status']); ?></p>
        </div>

        <!-- Completion Message -->
        <div class="completion-message">
            <p>Thank you for your payment! Your transaction is now completed.</p>
        </div>
    </div>
</body>
</html>
