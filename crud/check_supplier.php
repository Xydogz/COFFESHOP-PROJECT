<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SESSION['role'] !== 'Supplier') {
    header("Location: ../../unauthorized.php");
    exit();
}
?>