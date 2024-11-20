<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffeshop');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$koneksi) {
        throw new Exception(mysqli_connect_error());
    }
    
    mysqli_set_charset($koneksi, "utf8mb4");
    
} catch (Exception $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?> 