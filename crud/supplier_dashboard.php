<?php
include "check_supplier.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <div class="atas"></div>
    <div class="bawah"></div>
    
    <div class="container">
        <div class="box">
            <div class="back">
                <a href="../logout.php"><button>LOGOUT</button></a>
            </div>
            
            <h1>Supplier Dashboard</h1>
            <div class="content">
                <p>Selamat datang, <?php echo $_SESSION['nama']; ?></p>
            </div>
        </div>
    </div>
    <?php
    mysqli_close($koneksi);
    ?>
</body>
</html>