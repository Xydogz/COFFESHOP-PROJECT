<?php
 include "check_admin.php"; // Ensure only admin can access
 include "koneksi.php";
 
 // Query for daily sales
 $daily_sales_query = "SELECT SUM(total) as daily_total FROM sales WHERE DATE(sale_date) = CURDATE()";
 $daily_sales_result = mysqli_query($koneksi, $daily_sales_query);
 $daily_sales = mysqli_fetch_assoc($daily_sales_result)['daily_total'] ?? 0;
 
 // Query for monthly sales
 $monthly_sales_query = "SELECT SUM(total) as monthly_total FROM sales WHERE MONTH(sale_date) = MONTH(CURDATE()) AND YEAR(sale_date) = YEAR(CURDATE())";
 $monthly_sales_result = mysqli_query($koneksi, $monthly_sales_query);
 $monthly_sales = mysqli_fetch_assoc($monthly_sales_result)['monthly_total'] ?? 0;
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin Dashboard</title>
     <link rel="stylesheet" href="../style/admin.css">
 </head>
 <body>
     <div class="container">
         <h1>Admin Dashboard</h1>
         <div class="sales-recap">
             <h2>Sales Recap</h2>
             <p>Daily Sales: Rp. <?= number_format($daily_sales, 0, ',', '.') ?></p>
             <p>Monthly Sales: Rp. <?= number_format($monthly_sales, 0, ',', '.') ?></p>
         </div>
         <!-- Other dashboard content -->
     </div>
 </body>
 </html> 