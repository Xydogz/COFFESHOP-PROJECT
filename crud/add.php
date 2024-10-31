<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD</title>
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
  
  /* html width 1520px height 740 */
  
  /* BACKGROUND */
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
  /* background */
  
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
    <?php
    include "koneksi.php";
    
    if(isset($_POST['simpan'])) {
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok = isset($_POST['stok']) ? 'Ada' : 'Tidak Ada';
        
        // Upload foto
        $gambar_produk = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $fotobaru = date('dmYHis').$gambar_produk;
        $path = "images/".$fotobaru;
        
        if(move_uploaded_file($tmp, $path)) {
            $sql = "INSERT INTO produk (nama_produk, harga, stok, gambar_produk) 
                    VALUES ('$nama_produk', '$harga', '$stok', '$gambar_produk')";
            
            if(mysqli_query($koneksi, $sql)) {
                echo "<script>
                        alert('Data berhasil disimpan!');
                        window.location='admin.html';
                      </script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }
        }
    }
    ?>

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
            <form method="POST" enctype="multipart/form-data">
            <div class="add">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" required>
                <label for="harga">Harga</label>
                <input type="number" name="harga" required>
                <label for="stok">Stok</label>
                <input type="checkbox" name="stok">
                <label for="foto">Foto Produk</label>
                <input type="file" name="foto" required>
            </div>

            <div class="aksi">
                <button type="submit" name="simpan">SAVE</button>
            </div>
        </form>
                </div>
            </div>

            

        </div>

    </div>

    
    <!-- ... kode penutup tetap sama ... -->
</body>
</html> 