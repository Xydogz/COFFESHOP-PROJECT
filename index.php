<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/menu.css" />
    <title>Rekomendasi</title>
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body> 

    <div class="atas"></div>
    <div class="bawah"></div>


    <div class="container">
      <div class="box">
        <div class="header">
          <p>ORION COFFESHOP</p>

          <div class="cart">
            <a href="keranjang.php">
            <img src="image/cart.png" alt="">
            </a>
          </div>
        </div>
        <nav class="navbar">
          <a href="index.php"><p>Rekomendasi</p></a>
          <a href="makanan.php"><p>Makanan</p></a>
          <a href="minuman.php"><p>Minuman</p></a>
          <div class = "animation start-index"></div>
        </nav>
        <div class="content">
          <div class="card-container">

          <?php
          include "crud/koneksi.php";

          if ($koneksi->connect_error) {
            die("Koneksi gagal: " . $koneksi->connect_error);
        }

        $sql = "SELECT * FROM produk WHERE rekomendasi = 'iya' ORDER BY id ASC";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo '<div class="card" onclick="showPopup(\'' . htmlspecialchars($row['nama_produk']) . '\', \'crud/images/' . htmlspecialchars($row['gambar_produk']) . '\', ' . $row['harga'] . ', ' . $row['id'] . ' ,' . $row['stok'] .')">';
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
            <p class="stok" id="popup-stok-produk"></p>
            <p class="jumlah">Jumlah</p>
            <div class="pilihan-container">
                <div class="pilihan">
                    <button onclick="updateQuantity(-1)"> <i data-feather="minus"></i></button>
                    <p id="jumlah">1</p>
                    <button onclick="updateQuantity(1)"> <i data-feather="plus"></i></button>
                </div>
            </div>
            <div class="aksi">
                <button onclick="closePopup()">Batal</button>
                <button onclick="saveQuantityToDatabase(currentProductId)" class="tambah">Tambahkan ke Pesanan</button>
            </div>
        </div>
    </div>
</div>

    
    </div>
    </div>
    </div>
    </div>

        <script>
          feather.replace();
        </script>

        <script>
            let currentProductId;
            let quantity = 1;

            function showPopup(namaProduk,  gambarProduk, harga, productId, stok) {
                currentProductId = productId;
                document.getElementById('popup-nama-produk').innerText = namaProduk;
                document.getElementById('popup-stok-produk').innerText = 'Stok : ' + stok;
                document.getElementById('popup-image').src = gambarProduk;
                document.getElementById('popup-harga-produk').innerText = 'Rp. ' + harga.toLocaleString('id-ID');
                document.getElementById('jumlah').innerText = quantity;
                document.getElementById('popup').classList.toggle("active");
            }

            function updateQuantity(change) {
                let quantityElement = document.getElementById('jumlah');
                let currentQuantity = parseInt(quantityElement.innerText);
                currentQuantity += change;
                if (currentQuantity < 1) currentQuantity = 1;
                quantityElement.innerText = currentQuantity;
            }

            function saveQuantityToDatabase(productId) {
                let quantity = document.getElementById('jumlah').innerText;
                window.location.href = 'update_stock.php?id=' + productId + '&quantity=' + quantity;
            }

            function closePopup() {
                document.getElementById('popup').classList.toggle("active");
            }
        </script>

  </body>
</html>
