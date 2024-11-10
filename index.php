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
              echo '<div class="card">';
              echo '<div class="produk">';
              echo '<img src="crud/images/' . htmlspecialchars($row['gambar_produk']) . '" alt="" />';
              echo '</div>';
              echo '<p class="nama-produk">' . $row['nama_produk'] . '</p>';
              echo '<p class="harga-produk">Rp. ' . number_format($row['harga'], 0, ',', '.') . '</p>';
              echo '<div class="pilihan">';
              echo '<button><i id="tambah" data-feather="minus-circle"></i></button>';
              echo '<p>0</p>';
              echo '<button><i id="kurang" data-feather="plus-circle"></i></button>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo "Tidak ada produk ditemukan.";
      }

      // Tutup koneksi
      $koneksi->close();
    ?>
    
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
    </div>
    </div>

        <script>
          feather.replace();
        </script>

  </body>
</html>
