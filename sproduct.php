<!--
MULAI

// Sertakan file koneksi basis data
INCLUDE 'database.php'

// Periksa apakah ID produk tersedia di URL (permintaan GET)
JIKA 'id' ditetapkan di GET:
// Ambil ID produk dari URL
GET product_id dari GET
// Query basis data untuk mengambil detail produk berdasarkan ID produk
EXECUTE query SQL untuk mengambil detail produk dengan 'id_produk'
GET data produk sebagai 'product' dari hasil query

// Periksa apakah formulir 'add_to_cart' dikirimkan
JIKA 'add_to_cart' ditetapkan di POST:
// Ambil detail produk dan kuantitas dari data POST
GET product_id, product_name, product_price, product_image, product_merk, product_deskripsi, dan kuantitas dari POST

// Periksa apakah produk sudah ada di keranjang
EXECUTE query SQL untuk memeriksa apakah produk sudah ada di keranjang (SELECT from `keranjang` where 'product_name')

// Jika produk sudah ada di keranjang:
JIKA produk ada di keranjang:
// Ambil data keranjang yang ada
DAPATKAN data keranjang dari hasil kueri
// Perbarui jumlah produk di keranjang
SET jumlah baru ke jumlah yang ada + jumlah saat ini
JALANKAN kueri SQL untuk memperbarui keranjang dengan jumlah baru
TAMBAHKAN pesan: 'Produk sudah ada di keranjang, jumlah diperbarui!'

LAINNYA:
// Jika produk tidak ada di keranjang, tambahkan ke keranjang
JALANKAN kueri SQL untuk memasukkan produk ke keranjang beserta detailnya (nama, harga, gambar, merek, jumlah, deskripsi)
TAMBAHKAN pesan: 'Produk berhasil ditambahkan ke keranjang!'

// Arahkan pengguna ke halaman keranjang setelah menambahkan produk
REDIRECT ke 'cart.php'

// Bagian HTML dimulai di sini
TAMPILKAN tajuk halaman dengan logo dan tautan navigasi (Beranda, Toko, Tentang Kami, Hubungi Kami, Keranjang, Pengguna)

// Tampilkan detail produk di bagian "detail produk"
TAMPILKAN gambar produk, nama, harga, dan merek di halaman
TAMPILKAN deskripsi produk
TAMPILKAN formulir dengan bidang input kuantitas dan tombol untuk menambahkan produk ke keranjang

// Tampilkan bagian footer dengan informasi kontak dan tautan media sosial
TAMPILKAN footer dengan detail kontak dan ikon media sosial

// JavaScript untuk menangani peralihan gambar untuk gambar produk
KETIKA gambar mini diklik:
GANTI gambar produk utama ke gambar mini yang dipilih

// Sertakan file JavaScript eksternal untuk interaktivitas tambahan
SERTAKAN 'script.js'

AKHIR
-->


<?php
    // Menyertakan file database.php untuk koneksi ke database
    include 'database.php';

    // Menangani pengecualian dengan blok try-catch
    try {
        // Memeriksa apakah parameter 'id' ada di URL
        if(isset($_GET['id'])) {
            // Mengambil ID produk dari URL
            $product_id = $_GET['id'];
            // Query untuk mengambil data produk berdasarkan ID
            $product_query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$product_id'");
            
            // Menangani jika query gagal
            if (!$product_query) {
                throw new Exception("Query produk gagal: " . mysqli_error($conn));
            }
            
            // Mengambil data produk dalam bentuk array asosiatif
            $product = mysqli_fetch_assoc($product_query);
            // Menangani jika produk tidak ditemukan
            if (!$product) {
                throw new Exception("Produk tidak ditemukan.");
            }
        }

        // Menambahkan produk ke keranjang jika tombol 'add_to_cart' ditekan
        if(isset($_POST['add_to_cart'])) {
            // Mengambil data produk dari form
            $sproduct_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_merk = $_POST['product_merk'];
            $product_deskripsi = $_POST['product_deskripsi'];
            $product_quantity = $_POST['quantity']; // Mengambil kuantitas dari form

            // Query untuk memeriksa apakah produk sudah ada di keranjang
            $check_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama_produk = '$product_name'");

            // Menangani jika query gagal
            if (!$check_cart) {
                throw new Exception("Query cek keranjang gagal: " . mysqli_error($conn));
            }

            // Menangani jika produk sudah ada di keranjang
            if(mysqli_num_rows($check_cart) > 0) {
                // Mengambil data keranjang
                $keranjang_data = mysqli_fetch_assoc($check_cart);
                // Menghitung kuantitas baru dengan menambahkan kuantitas yang ada
                $new_quantity = $keranjang_data['kuantitas'] + $product_quantity;
                // Query untuk memperbarui kuantitas produk di keranjang
                $update_quantity = mysqli_query($conn, "UPDATE `keranjang` SET kuantitas = '$new_quantity' WHERE id = '{$keranjang_data['id']}'");
                
                // Menangani jika query gagal
                if (!$update_quantity) {
                    throw new Exception("Update kuantitas keranjang gagal: " . mysqli_error($conn));
                }
                // Menampilkan pesan bahwa produk sudah ada dan kuantitas ditambahkan
                $message[] = 'Produk sudah ada di keranjang, kuantitas ditambahkan!';
            } else {
                // Jika produk belum ada di keranjang, menambahkan produk baru
                $add_to_cart = mysqli_query($conn, "INSERT INTO `keranjang`(nama_produk, harga, gambar, merk, kuantitas, deskripsi) 
                                                    VALUES('$product_name', '$product_price', '$product_image', '$product_merk', '$product_quantity', '$product_deskripsi')");
                // Menangani jika query gagal
                if (!$add_to_cart) {
                    throw new Exception("Gagal menambahkan produk ke keranjang: " . mysqli_error($conn));
                }
                // Menampilkan pesan bahwa produk berhasil ditambahkan ke keranjang
                $message[] = 'Produk berhasil ditambahkan ke keranjang!';
            }

            // Arahkan pengguna ke halaman keranjang setelah produk ditambahkan
            header("Location: cart.php");
            exit; // Menghentikan eksekusi kode selanjutnya
        }
    } catch (Exception $e) {
        // Menangani pengecualian dan menampilkan pesan kesalahan
        echo "<p>Kesalahan: " . $e->getMessage() . "</p>";
        exit(); // Menghentikan eksekusi lebih lanjut
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['nama_produk']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Beranda</a></li>
                <li><a class="active" href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <?php
                // Menghitung jumlah produk di keranjang
                $select_rows = mysqli_query($conn, "SELECT * FROM `keranjang`") or die('Gagal terhubung!');
                $row_acount = mysqli_num_rows($select_rows);
                ?>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"><span><?php echo $row_acount ?></span> </i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Halaman detail produk -->
    <section id="prodetail" class="section-p1">
        <div class="single-pro-image">
            <img src="img/bahan/<?php echo $product['gambar']; ?>" alt="<?php echo $product['nama_produk']; ?>" width="100%" id="MainImg">       
        </div>
        <div class="single-pro-details">
            <h6><?php echo $product['merk']; ?></h6>
            <h4><?php echo $product['nama_produk']; ?></h4>
            <h2>Rp <?php echo $product['harga']; ?></h2>
            <form method="post" action="sproduct.php?id=<?php echo $product['id_produk']; ?>">
                <!-- Mengirim data produk melalui hidden inputs -->
                <input type="hidden" name="product_name" value="<?php echo $product['nama_produk']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['harga']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $product['gambar']; ?>">
                <input type="hidden" name="product_merk" value="<?php echo $product['merk']; ?>">
                <input type="hidden" name="product_deskripsi" value="<?php echo $product['deskripsi']; ?>">
                <!-- Input untuk kuantitas produk -->
                <input type="number" value="1" min="1" name="quantity" required>
                <button type="submit" name="add_to_cart" class="normal">Masukkan Keranjang</button>
            </form>
            <h4>Detail Produk</h4>
            <span><?php echo $product['deskripsi']; ?></span>
        </div>
    </section>

    <!-- Footer -->
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
    </footer>

    <!-- Script untuk mengganti gambar utama produk -->
    <script>
    var MainImg = document.getElementById("MainImg");
    var smallimg = document.getElementsByClassName("small-img") 

    smallimg[0].onclick = function() {
         MainImg.src = smallimg[0].src;
    }
    smallimg[1].onclick = function() {
         MainImg.src = smallimg[1].src;
    }
    smallimg[2].onclick = function() {
         MainImg.src = smallimg[2].src;
    }
    smallimg[3].onclick = function() {
         MainImg.src = smallimg[3].src;
    }
    </script>

    <script src="script.js"></script>
</body>
</html>