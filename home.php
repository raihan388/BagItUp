<?php
    include 'koneksi.php';

    if(isset($_POST['tambah_keranjang'])){
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_merk = $_POST['product_merk'];
        $product_quantity = 1;

        $pilih_keranjang  = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama_produk = '$product_name'");

        if(mysqli_num_rows($pilih_keranjang) > 0){
            // Update jumlah produk jika produk sudah ada di keranjang
            $keranjang_data = mysqli_fetch_assoc($pilih_keranjang);
            $new_quantity = $keranjang_data['kuantitas'] + 1;
            $update_quantity = mysqli_query($conn, "UPDATE `keranjang` SET kuantitas = '$new_quantity' WHERE nama_produk = '$product_name'");
            $message[] = 'Produk telah ditambahkan ke keranjang.';
        } else {
            // Menambahkan produk baru ke keranjang
            $tambah_produk = mysqli_query($conn, "INSERT INTO `keranjang`(nama_produk, harga, gambar, merk, kuantitas)
            VALUES('$product_name', '$product_price', '$product_image', '$product_merk', '$product_quantity')");
            $message[] = 'Produk berhasil ditambahkan ke keranjang!';
        }
    }
?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php //
if(isset($message)){
    foreach($message as $message){
        echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" 
        onclick="this.parentElement.style.display = `none`;"></i> </div>';
    };
};
?>
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <li><a href="glasses.php"><i class="fa-solid fa-magnifying-glass"></i> </a></li>
                <?php
                $select_rows = mysqli_query($conn, "SELECT *FROM `keranjang`") or die('Gagal terhubung!');
                $row_acount = mysqli_num_rows($select_rows);
                ?>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"><span><?php echo $row_acount ?></span> </i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

<section id="hero">
    <h4>Tawaran Tukar Tambah</h4>
    <h2>Diskon Super Besar</h2>
    <h1>Untuk Semua Produk</h1>
    <p>Hemat Lebih Banyak dengan Kupon & Diskon Hingga 70%!</p>
    <button>Belanja Sekarang</button>
</section>

<section id="feature" class="section-p1">
    <div class="fa-box">
        <img src="img/feature/f1.png" alt="" >
        <h6>Pengiriman Gratis</h6>
    </div>
    <div class="fa-box">
        <img src="img/feature/f2.png" alt="" >
        <h6>Pesanan Online</h6>
    </div>
    <div class="fa-box">
        <img src="img/feature/f3.png" alt="" >
        <h6>Hemat Biaya</h6>
    </div>
    <div class="fa-box">
        <img src="img/feature/f4.png" alt="" >
        <h6>Promosi</h6>
    </div>
    <div class="fa-box">
        <img src="img/feature/f5.png" alt="" >
        <h6>Penjualan Menyenangkan</h6>
    </div>
    <div class="fa-box">
        <img src="img/feature/f6.png" alt="" >
        <h6>Dukungan 24/7</h6>
    </div>
</section>  

<section id="product1" class="section-p1">
    <h2>Produk Unggulan</h2>
    <p>Koleksi Desain Modern Terbaru</p>
    <div class="pro-container">
        <?php
        // Menampilkan produk unggulan
        $produks  = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 8");
        if(mysqli_num_rows($produks) > 0){
            while($p = mysqli_fetch_array($produks)){
        ?>
            <div class="pro">
                <a href="sproduct.php?id=<?php echo $p['id_produk'] ?>">
                    <img src="img/bahan/<?php echo $p['gambar'] ?>" alt="<?php echo $p['nama_produk'] ?>">
                    <div class="des">
                        <span><?php echo $p['merk'] ?></span>
                        <h5><?php echo $p['nama_produk'] ?></h5>
                        <div class="star">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h4>Rp.<?php echo number_format($p['harga'], 0, ',', '.') ?></h4>
                    </div>
                </a>
                <form action="" method="post">
                    <input type="hidden" name="product_name" value="<?php echo $p['nama_produk']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $p['harga']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $p['gambar']; ?>">
                    <input type="hidden" name="product_merk" value="<?php echo $p['merk']; ?>">
                    <button type="submit" class="cart" name="tambah_keranjang">
                        <i class="fa-solid fa-cart-plus"></i> 
                    </button>
                </form>   
            </div>     
        <?php }} else { ?>
            <p>Produk Tidak Tersedia</p>
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
        <img class="logo" src="img/bagitup.png" alt="Logo">
        <h4>Kontak</h4>
        <p><strong>Alamat:</strong> Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461</p>
        <p><strong>Telepon:</strong> +62 821 4423 2308</p>
        <p><strong>Jam Operasional:</strong> 10:00 - 18:00, Senin - Sabtu</p>
        <div class="follow">
            <h4>Ikuti Kami</h4>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </div>

    <div class="col">
        <h4>Informasi</h4>
        <ul>
            <li><a href="#">Tentang Kami</a></li>
            <li><a href="#">Kebijakan Pengembalian</a></li>
            <li><a href="#">Layanan Pelanggan</a></li>
            <li><a href="#">Syarat & Ketentuan</a></li>
        </ul>
    </div>
</footer>

<script src="script.js"></script>
</body>
</html>
