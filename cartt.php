<?php
    include 'koneksi.php';
    session_start();

    // Hapus produk dari keranjang jika link "Remove" diklik
    if (isset($_GET['remove_id'])) {
        $idproduk = $_GET['remove_id'];
        unset($_SESSION['produk'][$idproduk]); // Menghapus produk dari session
    }

    // Inisialisasi total ke 0 untuk keranjang
    $totalKeranjang = 0; 
    $totalCheckout = 0; // Untuk checkout, dihitung nanti berdasarkan produk yang dicentang

    // Jika ada produk dalam session, hitung total belanja
    if (isset($_SESSION['produk']) && count($_SESSION['produk']) > 0) {
        foreach ($_SESSION['produk'] as $idproduk => $quantity) {
            // Ambil data produk berdasarkan id_produk
            $query = "SELECT * FROM produk WHERE id_produk = '$idproduk'";
            $result = mysqli_query($conn, $query);
            $produk = mysqli_fetch_assoc($result);
    
            if ($produk) {
                // Hitung subtotal untuk produk di keranjang
                $subtotal = $produk['harga'] * $quantity;
                $totalKeranjang += $subtotal;  // Tambahkan subtotal ke total keranjang
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BagItUp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <li><a class="active" href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#keranjang belanja</h2>
        <p>Masukkan kode kupon & HEMAT hingga 70%!</p>
    </section>

    <section id="cart" class="section-p1">
        <form method="POST" action="cart.php">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Pilih</td>
                        <td>Hapus</td>
                        <td>Gambar</td>
                        <td>Produk</td>
                        <td>Harga</td>
                        <td>Stok</td>
                        <td>SubTotal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['produk']) && count($_SESSION['produk']) > 0) {
                        foreach ($_SESSION['produk'] as $idproduk => $quantity) {
                            // Mengambil detail produk berdasarkan id_produk
                            $query = "SELECT * FROM produk WHERE id_produk = '$idproduk'";
                            $result = mysqli_query($conn, $query);
                            $produk = mysqli_fetch_assoc($result);
                            if ($produk) {
                                $subtotal = $produk['harga'] * $quantity;
                    ?>
                    <tr id="row-<?php echo $idproduk; ?>">
                        <td><input type="checkbox" name="selected_products[]" value="<?php echo $idproduk; ?>" class="productCheckbox" data-price="<?php echo $produk['harga']; ?>" data-id="<?php echo $idproduk; ?>" data-quantity="<?php echo $quantity; ?>" onclick="updateTotal()"></td>
                        <td><a href="cart.php?remove_id=<?php echo $idproduk; ?>"><i class="far fa-times-circle"></i></a></td>
                        <td><img src="img/bahan/<?php echo $produk['gambar']; ?>"></td>
                        <td><?php echo $produk['nama_produk']; ?></td>
                        <td>Rp.<?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td id="subtotal-<?php echo $idproduk; ?>">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                            }
                        }
                    ?>
                    <tr>
                        <td colspan="6">Total Keranjang</td>
                        <td>Rp<span id="totalCart"><?php echo number_format($totalKeranjang, 0, ',', '.'); ?></span></td>
                    </tr>
                    <?php
                    } else {
                        echo "<tr><td colspan='7'>Keranjang belanja kosong</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </section>
            
    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Masukkan Kupon</h3>
            <div>
                <input type="text" placeholder="Masukkan Kupon Anda">
                <button class="normal">Terapkan</button>
            </div>
        </div>

        <!-- Tombol Checkout -->
        <div id="subtotal">
            <h3>Total Keranjang</h3>
            <table>
                <tr>
                    <td>SubTotal Keranjang</td>
                    <td><span id="checkoutTotal"><?php echo number_format(0, 0, ',', '.'); ?></span></td>
                </tr>
                <tr>
                    <td>Pengiriman</td>
                    <td>Gratis</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong id="checkoutTotalFinal">Rp<?php echo number_format(0, 0, ',', '.'); ?></strong></td>
                </tr>
            </table>
            <a href="checkout.php" class="normal">
            <button type="button">Lanjutkan ke Pembayaran</button>
            </a>
        
        </div>
    </section>
        
    <footer class="section-p1">
        <div class="col">
            <img class="logo"src="img/bagitup.png" alt="">
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

    <script>
        // Fungsi untuk memperbarui total checkout berdasarkan produk yang dicentang
        function updateTotal() {
            let totalCheckout = 0;
            
            // Menambahkan subtotal dari produk yang dicentang
            document.querySelectorAll('.productCheckbox:checked').forEach(checkbox => {
                const price = parseInt(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                totalCheckout += price * quantity;
            });

            // Update total checkout
            document.getElementById('checkoutTotal').innerText = 'Rp' + totalCheckout.toLocaleString();
            document.getElementById('checkoutTotalFinal').innerText = 'Rp' + totalCheckout.toLocaleString();
        }

        // Panggil fungsi updateTotal untuk inisialisasi
        updateTotal();

        // Event listener untuk perubahan checkbox
        document.querySelectorAll('.productCheckbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateTotal);
        });
    </script>
</body>
</html>
