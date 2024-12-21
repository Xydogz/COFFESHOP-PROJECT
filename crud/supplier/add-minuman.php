<?php
include "check_admin.php";
session_start();
include "koneksi.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $nama_produk = filter_input(INPUT_POST, 'nama_produk', FILTER_SANITIZE_STRING);
        $harga = filter_input(INPUT_POST, 'harga', FILTER_VALIDATE_INT);
        $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
        $rekomendasi = isset($_POST['rekomendasi']) ? 'iya' : 'tidak';

        if (!$nama_produk || !$harga) {
            throw new Exception("Data produk tidak valid!");
        }



       
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception("Foto produk wajib diupload!");
        }

        $file = $_FILES['foto'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!in_array($file['type'], $allowed)) {
            throw new Exception("Format file tidak diizinkan!");
        }
        
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran file maksimal 2MB!");
        }

        $filename = date('YmdHis') . '_' . basename($file['name']);
        $uploadPath = __DIR__ . '/images/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception("Gagal mengupload file!");
        }

        
        $stmt = mysqli_prepare($koneksi, 
            "INSERT INTO produk (nama_produk, harga, stok, gambar_produk, kategori, rekomendasi) VALUES (?, ?, ?, ?, 'minuman', ?)"
        );
        mysqli_stmt_bind_param($stmt, "siiss", $nama_produk, $harga, $stok, $filename, $rekomendasi);
        
        if (mysqli_stmt_execute($stmt)) {
          // Mengambil ID terakhir yang disisipkan
          $last_id = mysqli_insert_id($koneksi);
          if ($last_id) {
              $code = rand(1, 999999);
              $id_makanan = "D_" . $code . "_" . $last_id;

             
              $query = "UPDATE produk SET id_makanan = ? WHERE id = ?";
              $stmt_update = mysqli_prepare($koneksi, $query);

            
              mysqli_stmt_bind_param($stmt_update, "si", $id_makanan, $last_id);

             
              if (!mysqli_stmt_execute($stmt_update)) {
                  throw new Exception(mysqli_error($koneksi));
              }

            
              mysqli_stmt_close($stmt_update);
          }
      } else {
          throw new Exception(mysqli_error($koneksi));
      }

     
      mysqli_stmt_close($stmt);

        $_SESSION['success'] = "Produk berhasil ditambahkan!";
        header("Location: minuman.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
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

              <h1>TAMBAH PRODUK</h1>

              <div class="content">
              <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="product-form">
            <div class="add">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" required>

                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" required min="0">

                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" required min="0">

                <label for="foto">Foto Produk</label>
                <input type="file" id="foto" name="foto" required accept="image/*">

                <label for="rekomendasi">Rekomendasi</label>
                <input type="checkbox" id="rekomendasi" name="rekomendasi" > 
            </div>

            <div class="aksi">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
              </div>

        </div>

    </div>
</body>
</html>