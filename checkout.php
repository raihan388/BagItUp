<!--
MULAI

// Logika Backend (PHP)

// Menyertakan koneksi basis data
MASUKKAN 'database.php'

// Inisialisasi variabel
SET grand_total = 0

// Mengambil data keranjang dari database
RUN kueri SQL untuk SELECT semua baris dari 'keranjang'

// Logika Frontend (HTML)

// Mengatur struktur HTML
DEKLARASI DOCTYPE sebagai HTML5
SET metadata (charset, viewport, judul, tautan stylesheet)

// BAGIAN HEADER
BUAT bagian header dengan ID “header”
    TAMBAHKAN gambar logo dengan tautan ke beranda
    BUAT menu navigasi (daftar tidak berurutan)
        TAMBAHKAN item menu yang terhubung ke “Beranda”, “Produk”, “Tentang Kami”, “Hubungi Kami”, “Keranjang”, “Pengguna”, dan “Login”

// BAGIAN KONTEN UTAMA
BUAT kontainer dengan kelas “kontainer my-5”

// ROW: Item Keranjang
MEMBUAT baris dengan kelas “baris”

// KOLOM KIRI: Item Keranjang
MEMBUAT kolom dengan kelas “col-lg-8”
    TAMBAHKAN judul “Tas”
    IF data keranjang ada THEN
        FOR setiap baris dalam data keranjang
            HITUNG sub_total = harga * kuantitas
            TAMBAHKAN sub_total ke grand_total
            TAMPILKAN kartu dengan detail produk:
                - Gambar
                - Nama
                - Merek (Merk)
                - Description (Deskripsi)
                - Quantity (Jumlah Barang)
                - SubTotal (diformat sebagai mata uang)
        ENDFOR
    LAINNYA
        TAMPILKAN pesan “Keranjang belanja kosong”
    ENDIF

// KOLOM KANAN: Ringkasan Total
BUAT kolom dengan kelas “col-lg-4”
    TAMBAHKAN judul “Rekapitulasi”
    BUAT grup daftar untuk ditampilkan:
        - SubTotal: grand_total (diformat sebagai mata uang)
        - Total: grand_total (diformat sebagai mata uang, dicetak tebal)
    MEMBUAT tombol:
        - Tombol “CheckOut”
        - Tombol “Cetak Faktur” yang terhubung ke 'export.php'

// BAGIAN FOOTER
GUNAKAN Bootstrap JS untuk fungsionalitas

AKHIR
-->

<?php
    include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="login.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <!-- Bagian Keranjang -->
            <div class="col-lg-8">
                <h3>Tas</h3>
                <?php
                    $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang`");
                    $grand_total = 0;
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            $sub_total = floatval($fetch_cart['harga']) * floatval($fetch_cart['kuantitas']); // Hitung subtotal
                            $grand_total += $sub_total; // Tambahkan ke total keseluruhan
                ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="img/bahan/<?php echo $fetch_cart['gambar']; ?>" class="img-fluid rounded-start" alt="Product Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $fetch_cart['nama_produk']; ?></h5>
                                <p class="card-text text-muted">Merk: <?php echo $fetch_cart['merk']; ?><br>Deskripsi: <?php echo $fetch_cart['deskripsi']; ?></p>
                                <p class="card-text"><small>Jumlah Barang: <?php echo $fetch_cart['kuantitas']; ?></small></p>
                                <p class="card-text text-end fw-bold">Rp. <?php echo number_format($sub_total, 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>

            <!-- Ringkasan Total -->
            <div class="col-lg-4">
                <h3>Rekapitulasi</h3>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>SubTotal</span>
                        <span>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></span>
                    </li>
                </ul>
                <div class="d-grid gap-2">
                    <button class="btn btn-dark">CheckOut</button>
                    <a href="export_excel.php" class="btn btn-success">Cetak Invoice</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>