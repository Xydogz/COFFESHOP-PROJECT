<?php
include "crud/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

  
    $sql = "SELECT * FROM user WHERE password = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
     
        header("Location: admin_dashboard.php");
    } else {
      
        echo "Kode akses salah.";
    }


    $stmt->close();
    $koneksi->close();
}
?> 