<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/menu.css" />
    <title>Makanan</title>
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- BACKGROUND -->
    <div class="atas"></div>
    <div class="bawah"></div>
    <!-- background -->

    <div class="container">
      <div class="box">
        <div class="header">
          <p>ORION COFFESHOP</p>

          <div class="admin">
            <a href="login.html">
              <img src="Image/admin.png" alt="" />
            </a>
          </div>
        </div>
        <nav class="navbar">
          <a href="index.php"><p>Rekomendasi</p></a>
          <a href="makanan.php"><p>Makanan</p></a>
          <a href="minuman.php"><p>Minuman</p></a>
          <div class = "animation start-makanan"></div>
        </nav>
        <div class="content">
          <div class="card-container">
            <?php
            include "crud/koneksi.php";
  
            if ($koneksi->connect_error) {
              die("Koneksi gagal: " . $koneksi->connect_error);
          }
  
          $sql = "SELECT * FROM produk WHERE kategori = 'makanan' ORDER BY id ASC";
          $result = $koneksi->query($sql);
  
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card" onclick="showPopup(\'' . htmlspecialchars($row['nama_produk']) . '\', \'crud/images/' . htmlspecialchars($row['gambar_produk']) . '\', ' . $row['harga'] . ')">';
                echo '<div class="produk">';
                echo '<img src="crud/images/' . htmlspecialchars($row['gambar_produk']) . '" alt="" />';
                echo '</div>';
                echo '<p class="nama-produk">' . $row['nama_produk'] . '</p>';
                echo '<p class="harga-produk">Rp. ' . number_format($row['harga'], 0, ',', '.') . '</p>';
                echo '</div>';
            }
        } else {
            echo "Tidak ada produk ditemukan.";
        }
  
        // Tutup koneksi
        $koneksi->close();
      ?>

<div class="popup" id="popup">
    <div class="overlay" onclick="closePopup()"></div>
    <div class="card-popup">
        <div class="content-popup">
            <div class="image">
                <img id="popup-image" src="" alt="">
            </div>
            <hr>
            <p class="nama-produk" id="popup-nama-produk"></p>
            <p class="harga-produk" id="popup-harga-produk"></p>
            <p class="jumlah">Jumlah</p>
            <div class="pilihan-container">
                <div class="pilihan">
                    <button> <i data-feather="minus"></i></button>
                    <p id="jumlah">1</p>
                    <button> <i data-feather="plus"></i></button>
                </div>
            </div>
            <div class="aksi">
                <button onclick="closePopup()">Batal</button>
                <button class="tambah">Tambahkan ke Pesanan</button>
            </div>
        </div>
    </div>
</div>


      </div>
    </div>
        <div class="footer">
            <div class="total-box">
                <div class="total">
                    <p>SILAHKAN MEMILIH </p>
                    <a href="keranjang.html"><button>NEXT</button></a>
                </div>
            </div>

        </div>


        <script>
          
          feather.replace();
        </script>

        <script>
            function showPopup(namaProduk, gambarProduk, harga) {
                document.getElementById('popup-nama-produk').innerText = namaProduk;
                document.getElementById('popup-image').src = gambarProduk;
                document.getElementById('popup-harga-produk').innerText = 'Rp. ' + harga.toLocaleString('id-ID');
                document.getElementById('popup').classList.toggle("active");
            }
            function closePopup() {
                document.getElementById('popup').classList.toggle("active");
            }
        </script>

  </body>
</html>
