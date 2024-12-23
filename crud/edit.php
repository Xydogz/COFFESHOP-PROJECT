<?php
include "check_admin.php";
include "koneksi.php";

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if(!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='kategori.html';</script>";
        exit;
    }
} else {
    header("Location: kategori.html");
    exit;
}

if(isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);
    if ($harga === false) {
        throw new Exception("Harga tidak valid!");
    }
    $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
    $rekomendasi = isset($_POST['rekomendasi']) ? 'iya' : 'tidak';
    
    if($_FILES['foto']['name']) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(!in_array($ext, $allowed)) {
            echo "<script>alert('Format file tidak diizinkan!');</script>";
            exit;
        }
        
        if($_FILES['foto']['size'] > 2097152) {
            echo "<script>alert('Ukuran file terlalu besar! Max 2MB');</script>";
            exit;
        }
        
        $fotobaru = date('dmYHis') . "_" . $filename;
        $path = "images/" . $fotobaru;
        
        $actualMimeType = mime_content_type($_FILES['foto']['tmp_name']);
        if (!in_array($actualMimeType, $allowed)) {
            throw new Exception("Format file tidak diizinkan!");
        }
        
        move_uploaded_file($_FILES['foto']['tmp_name'], $path);
        
        if($data['gambar_produk'] && file_exists("images/".$data['gambar_produk'])) {
            unlink("images/".$data['gambar_produk']);
        }
    } else {
        $fotobaru = $data['gambar_produk'];
    }
    
    $sql = "UPDATE produk SET nama_produk=?, harga=?, stok=?, gambar_produk=?, rekomendasi=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "siissi", $nama_produk, $harga, $stok, $fotobaru, $rekomendasi, $id);
    
    $from = isset($_GET['from']) ? $_GET['from'] : 'kategori.html';
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil diupdate!');
                window.location.href = '{$from}';
              </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>

        @font-face {
            font-family: "Russo-One";
            src: url("../Fonts/RussoOne-Regular.ttf");
            font-weight: normal;
            font-style: normal;
          }

        html {
            scroll-behavior: smooth;
          }
          
          body {
            padding: 0;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
          }

          .atas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            height: 35vh;
            width: 100%;
            background-color: white;
          }
          
          .bawah {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: -2;
            height: 65vh;
            width: 100%;
            background-color: rgb(254, 210, 159);
          }
 
          .box {
            border: solid 5px black;
            border-radius: 20px;
            width: 90vw;
            height: 90vh;
            margin: auto;
            background-color: white;
            display: flex;
            align-items: center;
            position: relative;
            flex-direction: column;
          }

          .back {
            position: absolute;
            right: 20px;
            top: 20px;
          }   

          .back button {
            font-weight: bold;
            background-color: #8c594a;
            height: 50px;
            width: 7vw;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.2s ease;
          }
          
          .back button:hover {
            color: black;
            background-color: rgb(254, 210, 159);
          }
        

          .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50vw;
            background-color: #8c594a;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
          }

          h1 {
            font-family: "Russo-One";
            color: #8c594a;
            margin-top: 10vh;
          }

          .add {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            font-size: 20px;
            font-weight: 600;
          }

          .add label{
            margin-top: 15px;
          }
          
          input {
            width: 80%;
            height: 30px;
            border-radius: 10px;
          }

          .aksi {
            margin-top: 20px;
            display: flex;
            justify-content: center;
          }

          .aksi button {
            height: 50px;
            width: 7vw;
            border-radius: 20px;
            background-color: white;
            font-weight: bold;
            cursor: pointer;
            transition: ease-in-out 0.2s;
          }

          .aksi button:hover {
            background-color: rgb(254, 210, 159);
          }
    </style>

</head>
<body>

    <div class="background">
        <div class="atas"></div>
        <div class="bawah"></div>
    </div>

    <div class="container">
        <div class="box">
            <div class="back">
                    <a
                    href="javascript:history.back()"
                    ><button>BACK</button></a
                    >
                </div>

                <h1>EDIT PRODUK</h1>

                <div class="content">
        <form method="POST" enctype="multipart/form-data">
            <div class="add">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
                
                <label for="harga">Harga</label>
                <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
                
                <label for="stok">Stok</label>
                <input type="number" name="stok" value="<?= $data['stok'] ?>" required>
                
                <label for="foto">Foto Produk</label>
                <input type="file" name="foto">
                <?php if($data['gambar_produk']): ?>
                    <img height="50px" src="images/<?= $data['gambar_produk'] ?>" alt="Current Image" style="max-width:100px;">
                <?php endif; ?>
                
                <label for="rekomendasi">Rekomendasi</label>
                <input type="checkbox" id="rekomendasi" name="rekomendasi" value="<?=$data['rekomendasi'] ?>"> 
            </div>

            <div class="aksi">
                <button type="submit" name="update">UPDATE</button>
            </div>
        </form>
    </div>
        </div>
    </div>

</body>
</html>