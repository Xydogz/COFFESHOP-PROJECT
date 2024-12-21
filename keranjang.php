<?php
include "crud/koneksi.php";

$sql = "SELECT * FROM cart ORDER BY id ASC";
$result = mysqli_query($koneksi, $sql);

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM cart WHERE id = $delete_id";
    mysqli_query($koneksi, $delete_sql);
    header("Location: keranjang1.php"); // Redirect setelah penghapusan
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/keranjang.css" />
    <title>Keranjang</title>
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>

        <!-- BACKGROUND -->
        <div>
            <div class="atas"></div>
            <div class="bawah"></div>
        </div>
        <!-- background -->

    <div class="container">
            <div class="content">
             
                <div class="section-1" onclick="closePopup()">
                    <h1><span>ORION</span> COFFESHOP</h1>

                    <div class="popup" id="popup">
                        <div class="overlay" ></div>
                        <div class="card-popup">
                            <div class="detail">
                            <img id="popup-image" src="" alt="">
                                <h2 id="popup-nama"></h2>
                                <p>Harga Satuan</p>
                                <p id="popup-harga"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-2">
                    <div class="title">
                        <p>PESANAN</p>
                        <a href="javascript:history.back()" class="back"><img src="image/back.png" alt=""></a>
                    </div>

                    <div class="cart-container">
                        <?php if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            $total = 0;
                            while($row = mysqli_fetch_assoc($result)) {
                                $total += $row['subtotal'];
                        ?>
                            <?php echo "<div onclick='showPopup(".$row['id'].", \"".$row['nama_produk']."\", \"".$row['gambar_produk']."\", ".$row['harga_satuan'].")' class='cart'>";
                            echo "<img class='img' src='crud/images/".$row['gambar_produk']."' alt='".$row['nama_produk']."'>";
                            echo "<p>".$row['jumlah_produk']."</p>";
                            echo "<p class = 'nama_produk'>".$row['nama_produk']."</p>";
                            echo "<p class = 'total'>Rp. ".number_format($row['subtotal'], 0, ',', '.')."</p>";
                            echo "<a class='delete' href=''>";
                            echo "<button onclick='confirmDelete(".$row['id'].")'><img src='image/delete.png' alt=''></button>";
                            echo "</a>";
                            echo "</div>";
                            }
                        } else {
                            echo "<p>Keranjang kosong</p>";
                        } 
                        ?>
                    </div>

                    <div class="subtotal">
                        
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <p>Total : Rp. <?php echo number_format($total, 0, ',', '.'); ?></p>
                    <?php else: ?>
                        <p>Total : Rp. 0</p>
                    <?php endif; ?>                    
                        
                    </div>

                    <div class="konfirmasi">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <a href="metode.html"><button>KONFIRMASI</button></a>
                    <?php else: ?>
                        <a href="index.php"><button>PESAN</button></a>
                    <?php endif; ?>  

                </div>


            </div>
    </div>

    <script>
      feather.replace();

      function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
                window.location.href = "keranjang.php?delete_id=" + id;
            }
        }

      function toggleColor(button) {
        const span = button.querySelector('span');
        if (confirm('Apakah Anda Yakin?')) {
            if (span.classList.contains('merah')) {
                span.classList.remove('merah');
                span.classList.add('hijau');
            } else {
                span.classList.remove('hijau');
                span.classList.add('merah');
            }
        } else {
            return;
        }
      }


      function showPopup(id, nama, gambar, harga) {
        document.getElementById('popup-image').src = 'crud/images/' + gambar;
        document.getElementById('popup-nama').textContent = nama;
        document.getElementById('popup-harga').textContent = 'Rp. ' + harga.toLocaleString('id-ID');
        document.getElementById('popup').classList.add("active");
      }

      function closePopup() {
        document.getElementById('popup').classList.remove("active");
      }

    </script>
  </body>
</html>