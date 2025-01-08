<!--
MULAI

// Sertakan berkas koneksi basis data
INCLUDE database.php

// Periksa apakah tombol 'add_to_cart' diklik
JIKA 'add_to_cart' ditetapkan dalam POST:
// Ambil detail produk dari permintaan POST
GET 'product_name', 'product_price', 'product_image', 'product_merk' dari POST
SET jumlah produk awal ke 1

// Periksa apakah produk sudah ada di keranjang
JALANKAN kueri SQL untuk memeriksa apakah produk ada di keranjang (SELECT from `keranjang` where 'product_name')

// Jika produk sudah ada di keranjang
JIKA produk ada di keranjang:
// Perbarui jumlah produk di keranjang (tambahkan 1)
JALANKAN kueri SQL untuk memperbarui jumlah produk di keranjang
TAMBAHKAN pesan: 'Produk sudah ada di keranjang, jumlah bertambah!'

LAINNYA:
// Tambahkan produk ke keranjang (masukkan ke `keranjang`)
JALANKAN kueri SQL untuk memasukkan produk ke keranjang
TAMBAHKAN pesan: 'Produk berhasil ditambahkan ke keranjang!'
// Bagian HTML dimulai di sini
// Tampilkan pesan jika ada
JIKA pesan ditetapkan:
UNTUK setiap pesan dalam pesan:
TAMPILKAN pesan dengan opsi untuk menutup (klik untuk menghapus)

// Tampilkan bagian tajuk dengan logo dan menu navigasi
TAMPILKAN tajuk dengan tautan ke Beranda, Toko, Tentang Kami, Hubungi Kami, Keranjang, Pengguna

// Ambil produk dari basis data dan tampilkan
JALANKAN kueri SQL untuk memilih semua produk dari basis data (urutkan berdasarkan 'id_produk' DESC)
JIKA ada produk yang tersedia:
UNTUK setiap produk:
TAMPILKAN gambar produk, nama, harga, merek, dan tautan ke halaman produk
SERTAKAN tombol untuk menambahkan produk ke keranjang

LAINNYA:
TAMPILKAN pesan: 'Tidak ada produk yang tersedia'

// Tampilkan tautan paginasi untuk menelusuri halaman (untuk kesederhanaan, gunakan tautan statis)
TAMPILKAN tautan paginasi

// Tampilkan bagian buletin dengan formulir untuk berlangganan pembaruan
TAMPILKAN teks untuk berlangganan buletin
SERTAKAN kolom input untuk email dan tombol kirim

// Tampilkan footer dengan kontak informasi dan tautan ke bagian lain (Tentang, Pengiriman, Kebijakan Privasi, dll.)
TAMPILKAN footer dengan detail kontak perusahaan, tautan media sosial, dan informasi bermanfaat lainnya

// Sertakan file JavaScript eksternal untuk interaktivitas (jika diperlukan)
SERTAKAN script.js

AKHIR
-->


<?php
    include 'database.php';

    // Proses menambahkan produk ke keranjang
    try {
        // Memeriksa jika form add_to_cart dikirimkan
        if(isset($_POST['add_to_cart'])) {
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_merk = $_POST['product_merk'];
            $product_quantity = 1;  // Kuantitas awal adalah 1

            // Cek apakah produk sudah ada di keranjang
            $check_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama_produk = '$product_name'");

            // Menangani jika query gagal
            if (!$check_cart) {
                throw new Exception('Query cek keranjang gagal: ' . mysqli_error($conn));
            }

            if(mysqli_num_rows($check_cart) > 0) {
                // Jika produk sudah ada, tambahkan kuantitas
                $update_quantity = mysqli_query($conn, "UPDATE `keranjang` SET kuantitas = kuantitas + 1 WHERE nama_produk = '$product_name'");
                if (!$update_quantity) {
                    throw new Exception('Update kuantitas gagal: ' . mysqli_error($conn));
                }
                $message[] = 'Produk sudah ada di keranjang, kuantitas ditambahkan!';
            } else {
                // Jika produk belum ada, tambahkan ke keranjang
                $add_to_cart = mysqli_query($conn, "INSERT INTO `keranjang`(nama_produk, harga, gambar, merk, kuantitas) 
                                                    VALUES('$product_name', '$product_price', '$product_image', '$product_merk', '$product_quantity')");
                if (!$add_to_cart) {
                    throw new Exception('Gagal menambahkan produk ke keranjang: ' . mysqli_error($conn));
                }
                $message[] = 'Produk berhasil ditambahkan ke keranjang!';
            }
        }
    } catch (Exception $e) {
        // Menangani pengecualian dan menampilkan pesan kesalahan
        $message[] = 'Terjadi kesalahan: ' . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menampilkan pesan jika ada -->
    <?php
        if(isset($message)){
            foreach($message as $message){
                echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
            }
        }
    ?>

    <!-- Header bagian atas -->
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Beranda</a></li>
                <li><a class="active" href="shop.php">Produk</a></li>
                <li><a href="about.html">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <?php
                    // Menghitung jumlah produk di keranjang
                    $select_rows = mysqli_query($conn, "SELECT * FROM `keranjang`");
                    if (!$select_rows) {
                        throw new Exception("Query keranjang gagal: " . mysqli_error($conn));
                    }
                    $row_acount = mysqli_num_rows($select_rows);
                ?>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"><span><?php echo $row_acount ?></span> </i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="login.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Header halaman produk -->
    <section id="page-header">
        <h2>#Tetap di Rumah</h2>
        <p>Hemat lebih banyak dengan kupon & diskon hingga 70%!</p>
    </section>

    <!-- Menampilkan daftar produk -->
    <section id="product1" class="section-p1">
        <div class="pro-container">
            <?php
                try {
                    // Query untuk mengambil produk dari database
                    $products = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
                    if (!$products) {
                        throw new Exception('Query produk gagal: ' . mysqli_error($conn));
                    }

                    // Menampilkan produk jika tersedia
                    if(mysqli_num_rows($products) > 0) {
                        while($product = mysqli_fetch_assoc($products)) {
            ?>
            <div class="pro">
                <a href="sproduct.php?id=<?php echo $product['id_produk']; ?>">
                    <img src="img/bahan/<?php echo $product['gambar']; ?>" alt="">
                    <div class="des">
                        <span><?php echo $product['merk']; ?></span>
                        <h5><?php echo $product['nama_produk']; ?></h5>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></h4>
                    </div>
                    <a href="sproduct.php?id=<?php echo $product['id_produk']; ?>" class="cart"><i class="fa-solid fa-cart-plus"></i></a>
                </a>
            </div>
            <?php 
                        } 
                    } else {
                        echo "<p>Produk Tidak Tersedia</p>";
                    }
                } catch (Exception $e) {
                    echo '<p>Terjadi kesalahan saat menampilkan produk: ' . $e->getMessage() . '</p>';
                }
            ?>
        </div>
    </section>

    <!-- Pagination -->
    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
    </section>

    <!-- Newsletter -->
    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4>Daftar untuk Info Terbaru</h4>
            <p>Dapatkan Pembaruan Email Tentang Toko Terbaru Kami dan <span>Penawaran Spesial.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Alamat email Anda">
            <button class="normal">Daftar</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/bagitup.png" alt="">
            <h4>Kontak</h4>
            <p><strong>Alamat:</strong> Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461</p>
            <p><strong>Telepon:</strong> +62 821 4423 2308</p>
            <p><strong>Jam Operasional:</strong> 10:00 - 18.00, Senin - Sabtu</p>
            <div class="follow">
                <h4>Ikuti Kami</h4>
                <div class="icon">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                    <i class="fa-brands fa-snapchat"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>Tentang</h4>
            <a href="#">Tentang Kami</a>
            <a href="#">Informasi Pengiriman</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kontak Kami</a>
        </div>
        <div class="col">
            <h4>Akun Saya</h4>
            <a href="#">Masuk</a>
            <a href="#">Lihat Keranjang</a>
            <a href="#">Dompet Saya</a>
            <a href="#">Lacak Pesanan Saya</a>
            <a href="#">Bantuan</a>
        </div>
        <div class="copyright">
            <p>2024, PiayuPride</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>