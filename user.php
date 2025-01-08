<!--
MULAI

// Sertakan berkas koneksi basis data
INCLUDE "database.php"

// Inisialisasikan detail pengguna sebagai string kosong
SET user = ''
SET email = ''
SET no_telp = ''
SET addres = ''

// Kueri untuk mengambil data profil pengguna dari basis data
EXECUTE kueri SQL untuk SELECT * FROM profil_user WHERE id_user = 1

// Periksa apakah data ditemukan
IF data ditemukan:
// Ambil detail pengguna dari hasil kueri
SET user = nama pengguna yang diambil
SET email = email yang diambil
SET no_telp = nomor telepon yang diambil
SET addres = alamat yang diambil
END IF

// Struktur halaman HTML dimulai di sini
DISPLAY tajuk halaman dengan logo dan tautan navigasi (Beranda, Toko, Tentang Kami, Hubungi Kami, Profil Pengguna, Keluar)

// Bagian Profil Pengguna
DISPLAY foto profil pengguna (jika tersedia) dan formulir untuk mengunggah foto baru
IF foto diunggah:
// Unggah dan simpan foto baru foto menggunakan formulir (permintaan POST)
TANGANI unggahan foto di 'proses_user.php'
AKHIR JIKA

// Tampilkan formulir informasi pengguna untuk memperbarui profil
TAMPILKAN kolom untuk nama pengguna, email, nomor telepon, dan alamat
JIKA formulir dikirimkan (dengan data POST):
// Simpan detail pengguna yang diperbarui di basis data menggunakan 'proses_user.php'

// Tampilkan formulir perubahan kata sandi
TAMPILKAN formulir untuk mengubah kata sandi (input untuk kata sandi baru)
JIKA formulir dikirimkan (dengan data POST):
// Perbarui kata sandi di basis data menggunakan 'proses_user.php'

// Tangani klik tombol dengan JavaScript
PADA saat mengklik tombol "Simpan Profil":
// Tampilkan peringatan untuk mengonfirmasi pembaruan profil

PADA saat mengklik tombol "Ubah Kata Sandi":
// Periksa apakah kata sandi baru diberikan dan tampilkan peringatan berdasarkan input
JIKA kata sandi baru diberikan:
TAMPILKAN peringatan 'Kata sandi berhasil diperbarui!'
LAINNYA:
TAMPILKAN peringatan 'Silakan masukkan kata sandi baru.' AKHIR JIKA

PADA saat mengklik tombol "Ubah Foto":
// Periksa apakah foto baru dipilih dan tampilkan peringatan berdasarkan input
JIKA foto dipilih:
TAMPILKAN peringatan 'Foto berhasil diunggah!'
LAINNYA:
TAMPILKAN peringatan 'Silakan pilih foto terlebih dahulu.'
AKHIR JIKA

// Muat Bootstrap dan JavaScript eksternal
SERTAKAN Bootstrap dan JavaScript khusus

AKHIR
-->


<?php
// Menyertakan file database.php untuk koneksi ke database
include "database.php";

// Inisialisasi variabel untuk menyimpan data pengguna
$user = '';
$email = '';
$no_telp = '';
$addres = '';

// Menangani pengecualian dengan blok try-catch untuk query database
try {
    // Memeriksa apakah koneksi ke database berhasil
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Query untuk mengambil data pengguna dengan ID tertentu
    $sql = "SELECT * FROM profil_user WHERE id_user = 1"; // Ganti dengan ID pengguna yang sesuai
    $result = mysqli_query($conn, $sql);

    // Menangani jika query gagal
    if (!$result) {
        throw new Exception("Query gagal: " . mysqli_error($conn));
    }

    // Memeriksa apakah data pengguna ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Mengisi variabel dengan data dari database
        $user = $row['username'];
        $email = $row['email'];
        $no_telp = $row['no_telp'];
        $addres = $row['addres'];
    } else {
        throw new Exception("Data pengguna dengan ID 1 tidak ditemukan.");
    }
} catch (Exception $e) {
    // Menampilkan pesan kesalahan jika ada pengecualian
    echo "<p>Kesalahan: " . $e->getMessage() . "</p>";
    exit(); // Menghentikan eksekusi lebih lanjut jika terjadi kesalahan
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coba coba saja</title>
    <!-- Menyertakan stylesheet dan Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Bagian Header -->
    <section id="header">
        <a href="#"><img src="img/bagitup.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li><a class="active" href="user.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Bagian Konten Utama -->
    <div class="container mt-5">
        <h2 class="text-center">Profil Pengguna Aplikasi</h2>
        <div class="row mt-4">
            <!-- Foto Pengguna -->
            <div class="col-md-4 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Foto Pengguna</h5>
                        <form action="proses_user.php" method="POST" enctype="multipart/form-data">
                            <!-- Menampilkan foto pengguna yang ada -->
                            <img src="<?php echo 'uploads/' . $row['foto']; ?>" alt="Foto Pengguna" class="img-thumbnail">
                            <!-- Input untuk memilih foto baru -->
                            <input type="file" name="foto" class="form-control mt-3" id="uploadPhoto">
                            <!-- Tombol untuk mengunggah foto -->
                            <button type="submit" name="upload_foto" class="btn btn-primary mt-3" id="btnChangePhoto">Upload Foto</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kelola Pengguna -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Pengguna</h5>
                        <form id="userForm" method="POST" action="proses.php">
                            <!-- Input untuk username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" value="<?php echo $user ?>">
                            </div>
                            <!-- Input untuk email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>">
                            </div>
                            <!-- Input untuk no. telp -->
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Handphone</label>
                                <input type="text" name="no_telp" class="form-control" id="no_telp" value="<?php echo $no_telp ?>">
                            </div>
                            <!-- Input untuk alamat -->
                            <div class="mb-3">
                                <label for="addres" class="form-label">Alamat</label>
                                <textarea class="form-control" name="addres" id="addres" rows="2"><?php echo $addres ?></textarea>
                            </div>
                            <!-- Tombol untuk menyimpan perubahan profil -->
                            <button type="submit" name="tambah" value="add" class="btn btn-primary" id="btnSaveProfile">Ubah Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ganti Kata Sandi</h5>
                        <form id="passwordForm" method="POST" action="proses.php">
                            <!-- Input untuk username (tidak digunakan pada form ini, hanya placeholder) -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" value="admin" readonly>
                            </div>
                            <!-- Input untuk kata sandi baru -->
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="Masukkan Kata Sandi Baru Anda">
                            </div>
                            <!-- Tombol untuk mengganti password -->
                            <button type="submit" name="changepassword" value="changepassword" class="btn btn-primary" id="btnChangePassword">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menyertakan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script untuk interaksi dengan tombol -->
    <script>
        // Menangani tombol untuk menyimpan perubahan profil
        document.getElementById('btnSaveProfile').addEventListener('click', () => {
            alert('Profil berhasil diperbarui!');
        });

        // Menangani tombol untuk mengganti kata sandi
        document.getElementById('btnChangePassword').addEventListener('click', () => {
            const newPassword = document.getElementById('newPassword').value;
            if (newPassword) {
                alert('Password berhasil diperbarui!');
            } else {
                alert('Harap masukkan password baru.');
            }
        });

        // Menangani tombol untuk mengunggah foto
        document.getElementById('btnChangePhoto').addEventListener('click', () => {
            const photoInput = document.getElementById('uploadPhoto');
            if (photoInput.files.length > 0) {
                alert('Foto berhasil diunggah!');
            } else {
                alert('Harap pilih foto terlebih dahulu.');
            }
        });
    </script>
</body>
</html>