<!--
MULAI

// Bagian Header
MEMBUAT bagian header dengan ID “header”
    - TAMBAHKAN gambar logo dengan tautan ke beranda
    - BUAT bilah navigasi dengan tautan berikut:
        - “Beranda” (Beranda)
        - “Produk” (Produk)
        - “Tentang Kami” (About Us)
        - “Hubungi Kami” (Contact Us) - tautan aktif
        - “Pengguna” (Profil Pengguna)

// Bagian Header Halaman
BUAT bagian header halaman dengan ID “page-header” dan class “about-header”
    - TAMBAHKAN judul utama “Yuk, Beri Pesan!” (Ayo, Tinggalkan Pesan!)
    - TAMBAHKAN subjudul “Tinggalkan Pesan, Kami Senang Mendengarnya”

// Bagian Detail Kontak
BUAT bagian dengan ID “detail-kontak” dan kelas “bagian-p1”
    - Buat div detail dengan informasi kontak:
        - Tampilkan judul “HUBUNGI KAMI” (Hubungi Kami)
        - Tampilkan subjudul “Kunjungi salah satu Kantor Agensi Kami atau Hubungi Kami Hari Ini.” (Kunjungi salah satu kantor kami atau hubungi kami hari ini)
        - Menampilkan alamat dengan ikon peta, email dengan ikon amplop, nomor telepon dengan ikon telepon, dan jam operasional dengan ikon jam

    - Tambahkan iframe embed Google Map untuk menampilkan lokasi kantor (INDOGROSIR Batam)

// Bagian Formulir
BUAT bagian dengan ID “formulir-detail”
    - BUAT sebuah form untuk mengumpulkan data pengguna (Nama, Email, Subject, dan Pesan)
    - TAMBAHKAN tombol submit dengan class “normal” (Submit)
    - TAMBAHKAN div people untuk menampilkan detail kontak anggota tim:
        - Tampilkan foto dan detail anggota tim:
            - Nama, Peran (Full Stack, Front End, Back End)
            - Nomor telepon dan alamat email untuk setiap anggota

// Bagian Buletin
CREATE section dengan ID “newsletter” dan class “section-p1”
    - CREATE text block dengan judul “Daftar untuk Info Terbaru”
    - Tampilkan deskripsi untuk menerima update email tentang berita toko terbaru dan penawaran khusus
    - Buat form input email dengan tombol “Masuk” (Submit)

// Bagian Footer
Buat bagian footer dengan kelas “section-p1”
    - Tambahkan logo dan informasi kontak perusahaan:
        - Alamat, nomor telepon, jam kerja
    - TAMBAHKAN ikon mengikuti media sosial (Facebook, Instagram, Twitter, WhatsApp, Snapchat)
    - MEMBUAT tautan ke berbagai halaman:
        - “Tentang Kami” (Tentang Kami)
        - “Informasi Pengiriman” (Informasi Pengiriman)
        - “Kebijakan Privasi” (Privacy Policy)
        - “Syarat & Ketentuan” (Syarat & Ketentuan)
        - “Hubungi Kami” (Contact Us)
    - Tambahkan tautan akun:
        - “Masuk” (Login)
        - “Lihat Keranjang” (Lihat Keranjang)
        - “Dompet Saya” (Dompet Saya)
        - “Lacak Pesanan Saya” (Track My Order)
        - “Bantuan” (Bantuan)
    - Tambahkan pernyataan hak cipta untuk PiayuPride

AKHIR
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BagItUp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a class="active" href="contact.php">Hubungi Kami</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="login.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Page Header Section -->
    <section id="page-header" class="about-header">
        <h2>Yuk, Beri Pesan!</h2>
        <p>Tinggalkan Pesan, Kami Senang Mendengarnya</p>
    </section>

    <!-- Contact Details Section -->
    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>HUBUNGI KAMI</span>
            <h2>Kunjungi salah satu Kantor Agensi Kami atau Hubungi Kami Hari Ini.</h2>
            <h3>Kantor Pusat</h3>
            <div>
                <li><i class="fa-solid fa-map"></i><p>Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam</p></li>
                <li><i class="far fa-envelope"></i><p>bagitup1@gmail.com</p></li>
                <li><i class="fas fa-phone-alt"></i><p>+62 821 4423 2308</p></li>
                <li><i class="far fa-clock"></i><p>Senin-Sabtu: 10.00am to 18.00pm</p></li>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.123848952422!2d104.02155447319717!3d1.069041462417797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98f6ae03e99eb%3A0x385b34384333fa5a!2sINDOGROSIR%20BATAM!5e0!3m2!1sid!2sid!4v1732956953456!5m2!1sid!2sid" 
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>      
    </section>

    <!-- Form Section -->
    <section id="form-details">
        <form action="">
            <span>Yuk, Beri Pesan</span>
            <h2>Tinggalkan Pesan, Kami Senang Mendengarnya</h2>
            <input type="text" placeholder="Name">
            <input type="text" placeholder="E-mail">
            <input type="text" placeholder="Subject">
            <textarea cols="30" rows="10" placeholder="Your Message"></textarea>
            <button class="normal">Submit</button>
        </form>

        <!-- Team Section -->
        <div class="people">
            <div>
                <img src="img/1.jpg" alt="">
                <p><span>Muhammad Yuki</span> Full Stack<br>Phone: +62 852 7436 6826<br>Email: yuki@gmail.com</p>
            </div>
            <div>
                <img src="img/.jpg" alt="">
                <p><span>Muhammad Raihan Fauzan</span> Front End<br>Phone: +62 895 3279 52831<br>Email: raihan@gmail.com</p>
            </div>
            <div>
                <img src="img/.jpg" alt="">
                <p><span>Naylah Amirah Az Zikra</span> Back End<br>Phone: +62 822 8769 0013<br>Email: naylah@gmail.com</p>
            </div>
            <div>
                <img src="img/.jpg" alt="">
                <p><span>Annisa Fadilla Efendi Harahap</span> Back End<br>Phone: +62 895 2386 4950<br>Email: annisa@gmail.com</p>
            </div>
            <div>
                <img src="img/.jpg" alt="">
                <p><span>Hanifah Dwi Cahaya</span> Front End<br>Phone: +62 896 4355 3834<br>Email: hanifah@gmail.com</p>
            </div>
            <div>
                <img src="img/.jpg" alt="">
                <p><span>Masitoh Anggina</span> Front End<br>Phone: +62 821 7213 3728<br>Email: masitoh@gmail.com</p>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4>Daftar untuk Info Terbaru</h4>
            <p>Dapatkan Pembaruan Email Tentang Toko Terbaru Kami dan <span>Penawaran Spesial.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Masuk</button>
        </div>
    </section>

    <!-- Footer Section -->
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

    <script src="script.js"></script>
</body>
</html>