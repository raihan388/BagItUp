<!--
MULAI

// Periksa apakah tombol 'tambah_keranjang' ditekan (pengguna ingin menambahkan produk ke troli)
IF 'tambah_keranjang' sudah diset:
    - Ambil detail produk (nama, harga, gambar, merek) dari permintaan POST.
    - Tetapkan jumlah produk awal ke 1.

    // Query database untuk memeriksa apakah produk sudah ada di keranjang
    Query database untuk memeriksa apakah produk sudah ada di troli (berdasarkan nama produk).
    JIKA produk sudah ada di troli:
        - Ambil jumlah produk saat ini dari troli.
        - Tambah kuantitas dengan 1.
        - Perbarui troli dengan jumlah yang baru.
        - Atur pesan peringatan: “Produk telah ditambahkan ke keranjang” (Produk telah ditambahkan ke keranjang).
    LAINNYA:
        - Tambahkan produk baru ke keranjang dengan kuantitas 1.
        - Mengatur pesan peringatan: “Produk berhasil ditambahkan ke keranjang!” (Produk berhasil ditambahkan ke keranjang).
    END IF
AKHIR JIKA

// Struktur HTML
MULAI HTML
    // Bagian header dengan tautan navigasi dan ikon keranjang yang menampilkan jumlah item
    Tampilkan logo dan navbar dengan tautan ke beranda, toko, tentang, kontak, dan profil pengguna.
    Meminta basis data untuk menghitung jumlah produk di keranjang dan menampilkannya di sebelah ikon keranjang.
    
    // Bagian pahlawan yang mempromosikan penawaran
    Menampilkan teks promosi (diskon, penawaran khusus, dll.) dan tombol “Belanja Sekarang”.

    // Bagian fitur yang menampilkan nilai jual utama
    Tampilkan kotak fitur untuk pengiriman gratis, pesanan online, penghematan, promosi, penjualan yang menyenangkan, dan dukungan 24/7.

    // Bagian produk yang menampilkan produk unggulan
    Kueri database untuk mengambil produk terbaru (batas hingga 8 produk).
    JIKA ada produk:
        Untuk setiap produk:
            - Tampilkan detail produk: gambar, merek, nama, harga.
            - Sediakan tombol untuk menambahkan produk ke keranjang (melalui formulir).
        AKHIR UNTUK
    LAINNYA:
        - Menampilkan pesan: “Produk Tidak Ada” (Tidak ada produk yang tersedia).
    AKHIR JIKA

    // Bagian spanduk dengan ajakan bertindak untuk opsi lainnya
    Tampilkan banner promosi dengan tombol untuk menjelajahi lebih banyak pilihan.

    // Bagian footer
    - Tampilkan detail kontak (alamat, nomor telepon, jam kerja).
    - Menampilkan opsi mengikuti media sosial (Facebook, Instagram, Twitter, WhatsApp, Snapchat).
    - Menampilkan tautan informasi tambahan (Tentang Kami, Info Pengiriman, Kebijakan Privasi, Syarat & Ketentuan, Hubungi Kami).
    - Menampilkan tautan terkait akun (Login, Lihat Keranjang, Dompet Saya, Lacak Pesanan, Bantuan).
    - Tampilkan pemberitahuan hak cipta (misalnya, “2024, PiayuPride”).

AKHIRI HTML

// JavaScript untuk menampilkan pesan peringatan
MULAI JAVASCRIPT
    Saat memuat halaman:
        JIKA ada pesan peringatan:
            - Tampilkan pesan peringatan menggunakan JavaScript (alert()).

AKHIR

AKHIR
-->


<?php
    // Menghubungkan ke file database
    include 'database.php';

    // Mengaktifkan laporan kesalahan untuk menangani exception
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        // Memeriksa apakah tombol 'tambah_keranjang' ditekan
        if (isset($_POST['tambah_keranjang'])) {
            // Mengambil data produk dari formulir
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_merk = $_POST['product_merk'];
            $product_quantity = 1;

            // Memeriksa apakah produk sudah ada di keranjang
            $pilih_keranjang = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama_produk = '$product_name'");
            if ($pilih_keranjang === false) {
                throw new Exception("Gagal mengambil data keranjang.");
            }

            if (mysqli_num_rows($pilih_keranjang) > 0) {
                // Jika produk sudah ada, tambahkan jumlahnya
                $keranjang_data = mysqli_fetch_assoc($pilih_keranjang);
                $new_quantity = $keranjang_data['kuantitas'] + 1;

                $update_quantity = mysqli_query($conn, "UPDATE `keranjang` SET kuantitas = '$new_quantity' WHERE nama_produk = '$product_name'");
                if ($update_quantity === false) {
                    throw new Exception("Gagal memperbarui jumlah keranjang.");
                }

                $alert_message = 'Produk telah ditambahkan ke keranjang';
            } else {
                // Jika produk belum ada, tambahkan ke keranjang
                $tambah_produk = mysqli_query($conn, "INSERT INTO `keranjang`(nama_produk, harga, gambar, merk, kuantitas) VALUES('$product_name', '$product_price', '$product_image', '$product_merk', '$product_quantity')");
                if ($tambah_produk === false) {
                    throw new Exception("Gagal menambahkan produk ke keranjang.");
                }

                $alert_message = 'Produk berhasil ditambahkan ke keranjang!';
            }
        }
    } catch (Exception $e) {
        // Menangani kesalahan dengan pesan peringatan
        $alert_message = 'Terjadi kesalahan: ' . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BagItUp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        // Menampilkan pesan peringatan jika ada
        window.onload = function() {
            <?php if (isset($alert_message)) { ?>
                alert("<?php echo $alert_message; ?>");
            <?php } ?>
        };
    </script>
</head>
<body>
    <!-- Header dan Navbar -->
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a class="active"href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.html">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <?php 
                try {
                    // Menghitung jumlah item di keranjang
                    $select_rows = mysqli_query($conn, "SELECT * FROM `keranjang`");
                    if ($select_rows === false) {
                        throw new Exception("Gagal mengambil data keranjang.");
                    }
                    $row_acount = mysqli_num_rows($select_rows);
                } catch (Exception $e) {
                    $row_acount = 0; // Set jumlah item menjadi 0 jika gagal
                }
                ?>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"><span><?php echo $row_acount; ?></span></i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="login.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Hero Section -->
    <section id="hero">
        <h4>Tawaran Tukar Tambah</h4>
        <h2>Diskon Super Besar</h2>
        <h1>Untuk Semua Produk</h1>
        <p>Hemat Lebih Banyak dengan Kupon & Diskon Hingga 70%!</p>
        <button>Belanja Sekarang!</button>
    </section>

    <!-- Bagian Fitur -->
    <section id="feature" class="section-p1">
        <div class="fa-box">
            <img src="img/feature/f1.png" alt="">
            <h6>Pengiriman Gratis</h6>
        </div>
        <div class="fa-box">
            <img src="img/feature/f2.png" alt="">
            <h6>Pesanan Online</h6>
        </div>
        <div class="fa-box">
            <img src="img/feature/f3.png" alt="">
            <h6>Hemat Biaya</h6>
        </div>
        <div class="fa-box">
            <img src="img/feature/f4.png" alt="">
            <h6>Promosi</h6>
        </div>
        <div class="fa-box">
            <img src="img/feature/f5.png" alt="">
            <h6>Penjualan Menyenangkan</h6>
        </div>
        <div class="fa-box">
            <img src="img/feature/f6.png" alt="">
            <h6>Dukungan 24/7</h6>
        </div>
    </section>

    <!-- Produk Unggulan -->
    <section id="product1" class="section-p1">
        <h2>Produk Unggulan</h2>
        <p>Koleksi Desain Modern Terbaru</p>
        <div class="pro-container">
            <?php 
            try {
                // Mengambil data produk dari database
                $produks = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 8");
                if ($produks === false) {
                    throw new Exception("Gagal mengambil data produk.");
                }

                if (mysqli_num_rows($produks) > 0) {
                    while ($p = mysqli_fetch_array($produks)) {
            ?>
                        <div class="pro">
                            <a href="sproduct.php?id=<?php echo $p['id_produk']; ?>">
                                <img src="img/bahan/<?php echo $p['gambar']; ?>">
                                <div class="des">
                                    <span><?php echo $p['merk']; ?></span>
                                    <h5><?php echo $p['nama_produk']; ?></h5>
                                    <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4>Rp.<?php echo $p['harga']; ?></h4>
                                </div>
                            </a>
                            <form action="" method="post">
                                <input type="hidden" name="product_name" value="<?php echo $p['nama_produk']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $p['harga']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $p['gambar']; ?>">
                                <input type="hidden" name="product_merk" value="<?php echo $p['merk']; ?>">
                                <button type="submit" class="cart" name="tambah_keranjang"><i class="fa-solid fa-cart-plus"></i></button>
                            </form>
                        </div>
            <?php 
                    }
                } else { 
            ?>
                    <p>Produk Tidak Ada</p>
            <?php } } catch (Exception $e) { ?>
                <p>Error: <?php echo $e->getMessage(); ?></p>
            <?php } ?>   
        
        </div>
    </section>

    <section id="banner" class="section-p1">
        <h4>Layanan Perbaikan</h4>
        <h2>Berbagai Pilihan Tas Ada Di Sini</h2>  
        <button class="normal">Temukan Lebih Banyak!</button> 
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/bagitup.png" alt="">
            <h4>Kontak</h4>
            <p><strong>Alamat:</strong>Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461</p>
            <p><strong>Telepon:</strong>+62 821 4423 2308</p>
            <p><strong>Jam Operasional:</strong>10:00 - 18.00, Senin - Sabtu</p>
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
            <a href="#">Hubungi Kami</a>
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