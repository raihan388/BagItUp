<!--
MULAI

1. Tentukan parameter koneksi database:
   - Host: “localhost”
   - Pengguna: “root”
   - Kata sandi: “”
   - Nama basis data: “dbpbl”

2. Membuat koneksi ke basis data MySQL:
   - Gunakan `mysqli_connect()` dengan parameter koneksi yang disediakan (host, pengguna, kata sandi, nama basis data)

3. Periksa apakah koneksi berhasil:
   - Jika koneksi berhasil, lanjutkan operasi.
   - Jika koneksi gagal, tampilkan pesan kesalahan.

4. Pilih database yang diinginkan:
   - Gunakan `mysqli_select_db()` untuk memilih basis data `dbpbl` untuk sesi saat ini.

AKHIR
-->

<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dbpbl";

// Menambahkan exception handling untuk koneksi database
try {
    // Coba untuk membuat koneksi ke database
    $conn = mysqli_connect($host, $user, $pass, $dbname);

    // Periksa jika koneksi gagal
    if (!$conn) {
        throw new Exception("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    // Pilih database jika koneksi berhasil
    if (!mysqli_select_db($conn, $dbname)) {
        throw new Exception("Gagal memilih database: " . mysqli_error($conn));
    }

    // Jika koneksi berhasil, bisa menambahkan kode lain di sini (misal: operasi database)

} catch (Exception $e) {
    // Tangkap dan tampilkan pesan kesalahan jika ada
    die("Terjadi kesalahan: " . $e->getMessage());
}

?>