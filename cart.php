<!--
TART

// Logika Backend (PHP)

// Menyertakan koneksi basis data
INCLUDE 'database.php'

// Menangani pembaruan kuantitas
IF 'edit_kuantitas' permintaan POST disetel MAKA
    GET 'update_kuantitas' dan 'update_kuantitas_id' dari POST
    RUN kueri SQL untuk MENGUPDATE 'keranjang' SET kuantitas = 'update_kuantitas' WHERE id = 'update_kuantitas_id'
    JIKA kueri berhasil THEN
        ALIHKAN ke 'keranjang.php'
    ENDIF
ENDIF

// Menangani penghapusan produk
IF 'remove_id' GET permintaan disetel THEN
    Dapatkan 'hapus_id' dari GET
    RUN kueri SQL untuk DELETE FROM 'keranjang' WHERE id = 'hapus_id'
    ALIHKAN ke 'keranjang.php'
ENDIF

// Logika Frontend (HTML)

// Mengatur struktur HTML
DEKLARASI DOCTYPE sebagai HTML5
SET metadata (charset, viewport, judul, tautan stylesheet)

// BAGIAN HEADER
BUAT bagian header dengan ID “header”
    TAMBAHKAN gambar logo dengan tautan ke beranda
    BUAT menu navigasi (daftar tidak berurutan)
        TAMBAHKAN item menu yang terhubung ke “Beranda”, “Produk”, “Tentang Kami”, “Hubungi Kami”, “Keranjang”, “Pengguna”, dan “Login”
        FETCH jumlah baris dari tabel 'keranjang' untuk menampilkan total item di keranjang

// BAGIAN HEADER HALAMAN
CREATE bagian dengan ID “header-halaman”
    TAMBAHKAN judul dengan teks “#keranjang belanja”
    TAMBAHKAN paragraf dengan pesan promosi

// BAGIAN KERANJANG
CREATE section dengan ID “keranjang” dan class “section-p1”
    MULAI form dengan method POST dan action 'cart.php'
        BUAT tabel dengan kolom-kolom: Pilih, Hapus, Gambar, Produk, Harga, Kuantitas, SubTotal

        FETCH semua baris dari tabel 'keranjang'
        SET total_barang menjadi 0
        JIKA baris ada MAKA
            FOR setiap baris dalam tabel 'keranjang'
                TAMBAH data baris (kotak centang, tautan hapus, gambar, nama produk, harga, input kuantitas, subtotal)
                UPDATE grand_total dengan subtotal baris
            ENDFOR
            MENAMBAH baris yang menampilkan grand_total
        ELSE
            TAMPILKAN pesan “Keranjang belanja kosong”
        ENDIF

    AKHIRI formulir

// BAGIAN TAMBAHAN KERANJANG
BUAT bagian dengan ID “keranjang-tambah” dan kelas “bagian-p1”
    TAMBAHKAN kolom input kupon dan tombol
    TAMPILKAN jumlah total pembayaran, detail pengiriman, dan subtotal akhir
    Tombol TAMBAH untuk melanjutkan ke pembayaran

// BAGIAN FOOTER
BUAT bagian footer dengan kelas “section-p1”
    TAMBAHKAN kolom untuk informasi kontak, tautan tentang, dan tautan terkait akun
    TAMBAHKAN informasi hak cipta

// Logika JavaScript

// Fungsi untuk memperbarui total pembayaran berdasarkan produk yang dipilih
DEKLARIFIKASI FUNGSI updateTotal()
    SET totalPembayaran ke 0
    UNTUK setiap kotak centang produk yang dicentang
        TAMBAHKAN (harga * kuantitas) ke totalCheckout
    ENDFOR
    PERBARUI nilai total pembayaran di DOM
AKHIR FUNGSI

// Inisialisasi perhitungan total
PANGGILAN updateTotal()

// Menambahkan pendengar peristiwa untuk memperbarui total ketika kotak centang berubah
UNTUK setiap kotak centang produk
    TAMBAHKAN pendengar peristiwa untuk peristiwa 'perubahan' ke CALL updateTotal()
ENDFOR

END
-->

<?php
include 'database.php';

// Fungsi untuk menangani kesalahan
function handleException($message) {
    echo "<script>alert('Error: $message');</script>";
}

// Mengupdate kuantitas produk
if (isset($_POST['edit_quantity'])) {
    try {
        $updateValue = $_POST['update_quantity'];
        $updateId = $_POST['update_quantity_id'];

        if (!is_numeric($updateValue) || $updateValue <= 0) {
            throw new Exception('Kuantitas harus berupa angka positif.');
        }

        $updateQuery = mysqli_query($conn, "UPDATE `keranjang` SET kuantitas = '$updateValue' WHERE id = '$updateId'");

        if (!$updateQuery) {
            throw new Exception('Gagal memperbarui kuantitas produk. ' . mysqli_error($conn));
        }

        header('location: cart.php');
    } catch (Exception $e) {
        handleException($e->getMessage());
    }
}

// Menghapus produk dari keranjang
if (isset($_GET['remove_id'])) {
    try {
        $removeId = $_GET['remove_id'];
        $deleteQuery = mysqli_query($conn, "DELETE FROM `keranjang` WHERE id = '$removeId'");

        if (!$deleteQuery) {
            throw new Exception('Gagal menghapus produk dari keranjang. ' . mysqli_error($conn));
        }

        header('location: cart.php');
    } catch (Exception $e) {
        handleException($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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
            <?php
            $selectRows = mysqli_query($conn, "SELECT * FROM `keranjang`") or die('Gagal terhubung!');
            $rowCount = mysqli_num_rows($selectRows);
            ?>
            <li><a class="active" href="cart.php"><i class="fa-solid fa-bag-shopping"><span><?php echo $rowCount; ?></span></i></a></li>
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
                    <td>Kuantitas</td>
                    <td>SubTotal</td>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $selectCart = mysqli_query($conn, "SELECT * FROM `keranjang`");

                    if (!$selectCart) {
                        throw new Exception('Gagal mengambil data keranjang. ' . mysqli_error($conn));
                    }

                    $grandTotal = 0;

                    if (mysqli_num_rows($selectCart) > 0) {
                        while ($cart = mysqli_fetch_assoc($selectCart)) {
                            $subTotal = floatval($cart['harga']) * floatval($cart['kuantitas']);
                            $grandTotal += $subTotal;
                ?>
                <tr>
                    <td><input type="checkbox" name="selected_products[]" value="<?php echo $cart['id']; ?>" class="productCheckbox" data-price="<?php echo $cart['harga']; ?>" data-quantity="<?php echo $cart['kuantitas']; ?>" onclick="updateTotal()"></td>
                    <td><a href="cart.php?remove_id=<?php echo $cart['id']; ?>"><i class="far fa-times-circle"></i></a></td>
                    <td><img src="img/bahan/<?php echo $cart['gambar']; ?>"></td>
                    <td><?php echo $cart['nama_produk']; ?></td>
                    <td>Rp<?php echo $cart['harga']; ?></td>
                    <td>
                        <input type="hidden" name="update_quantity_id" value="<?php echo $cart['id']; ?>"/>
                        <input type="number" name="update_quantity" min="1" class="quantityInput" value="<?php echo $cart['kuantitas']; ?>" data-price="<?php echo $cart['harga']; ?>" data-id="<?php echo $cart['id']; ?>">
                        <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>
                    </td>
                    <td>Rp<?php echo $subTotal; ?></td>
                </tr>
                <?php
                        }
                ?>
                <tr>
                    <td colspan="6">Total Seluruh Keranjang</td>
                    <td><span id="totalCart">Rp<?php echo $grandTotal; ?></span></td>
                </tr>
                <?php
                    } else {
                        echo "<tr><td colspan='7'>Keranjang belanja kosong</td></tr>";
                    }
                } catch (Exception $e) {
                    handleException($e->getMessage());
                }
                ?>
            </tbody>
        </table>
        
        <section id="cart-add" class="section-p1">
            <div id="coupon">
                <h3>Masukkan Kupon</h3>
                <div>
                    <input type="text" placeholder="Masukkan Kupon Anda">
                    <button class="normal">Terapkan</button>
                </div>
            </div>

            <div id="subtotal">
                <h3>Total CheckOut</h3>
                <table>
                    <tr>
                        <td>Total</td>
                        <td><span id="checkoutTotal">Rp0</span></td>
                    </tr>
                    <tr>
                        <td>Pengiriman</td>
                        <td>Gratis</td>
                    </tr>
                    <tr>
                        <td><strong>SubTotal</strong></td>
                        <td><strong id="checkoutTotalFinal">Rp0</strong></td>
                    </tr>
                </table>
                <a href="checkout.php" class="normal">
                    <button type="button">Lanjutkan ke Pembayaran</button>
                </a>
            </div>
        </section>
    </form>
</section>

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
function updateTotal() {
    let totalCheckout = 0;
    document.querySelectorAll('.productCheckbox:checked').forEach(checkbox => {
        const price = parseInt(checkbox.dataset.price);
        const quantity = parseInt(checkbox.dataset.quantity);
        totalCheckout += price * quantity;
    });
    document.getElementById('checkoutTotal').innerText = 'Rp' + totalCheckout.toLocaleString();
    document.getElementById('checkoutTotalFinal').innerText = 'Rp' + totalCheckout.toLocaleString();
}
updateTotal();
document.querySelectorAll('.productCheckbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateTotal);
});
</script>
<script src="script.js"></script>

</body>
</html>

