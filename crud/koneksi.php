<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffeshop');

try {
    $koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$koneksi) {
        throw new Exception(mysqli_connect_error());
    }
    
    // Set charset to prevent encoding issues
    mysqli_set_charset($koneksi, "utf8mb4");
    
} catch (Exception $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?> 