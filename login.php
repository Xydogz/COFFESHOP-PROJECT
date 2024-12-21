<?php
session_start();
include "crud/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_akses = $_POST['kode_akses'];

  
    $sql = "SELECT u.*, r.nama_role 
            FROM user u 
            JOIN roles r ON u.kd_role = r.kd_role 
            WHERE u.kode_akses = ?";
            
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $kode_akses);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
   
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['nama_role'];

     
        header("Location: crud/kategori.html");
        exit();
    } else {
        $error = "Kode akses tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="atas"></div>
    <div class="bawah"></div>
    
    <div class="container">
        <div class="box">
            <div class="back">
                <a href="index.php"><button>BACK</button></a>
            </div>
            
            <div class="login-box">
                <h1>LOGIN</h1>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?= $error ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <input type="password" name="kode_akses" placeholder="Masukkan Kode Akses" required>
                    <div class="login-btn">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
