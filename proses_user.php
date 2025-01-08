<!--
MULAI

    MASUKKAN koneksi basis data (database.php)

    IF pengiriman formulir untuk memperbarui profil pengguna TIDAK kosong:
        - Ambil data dari POST:
            - Dapatkan ID pengguna
            - Dapatkan nama pengguna, email, nomor telepon, dan alamat dari data POST
        
        - Buat kueri SQL untuk memperbarui profil pengguna di database:
            - Perbarui tabel 'profil_user' dengan nama pengguna, email, nomor telepon, dan alamat yang baru
            - Jalankan kueri menggunakan mysqli_query()

        - JIKA kueri SQL berhasil dieksekusi:
            - Alihkan ke halaman 'user.php'
        - LAINNYA:
            - Tampilkan pesan kesalahan (misal, kueri gagal)

    IF kiriman formulir untuk memperbarui profil pengguna (dengan tombol 'tambah') diterima:
        - Ambil data dari POST:
            - Dapatkan nama pengguna, email, nomor telepon, dan alamat menggunakan mysqli_real_escape_string() untuk mencegah injeksi SQL
        
        - Tetapkan ID pengguna (ini dapat bersifat dinamis, bergantung pada pengguna yang masuk)
        
        - Buat kueri SQL untuk memperbarui profil pengguna:
            - Perbarui tabel 'profil_user' dengan data baru untuk pengguna
        - Jalankan kueri tersebut:
            - JIKA kueri berhasil dieksekusi:
                - Alihkan ke 'user.php' dengan status sukses
            - LAINNYA:
                - Menampilkan detail kesalahan dari kueri (misalnya, kesalahan SQL)

    JIKA pengiriman formulir untuk mengunggah foto pengguna diterima:
        - Tetapkan ID pengguna (ini bisa bersifat dinamis, bergantung pada pengguna yang login)
        - Tentukan direktori target untuk mengunggah foto
        
        - JIKA foto tidak kosong:
            - Dapatkan nama file foto dan buat jalur target
            - Periksa jenis file (pastikan jenisnya adalah gambar, seperti JPG, JPEG, PNG, GIF)
            
            - JIKA jenis file valid:
                - Pindahkan file ke direktori target
                - Buat kueri SQL untuk memperbarui foto pengguna dalam database
                - Mengikat parameter (nama file foto dan ID pengguna) ke kueri
                - Jalankan kueri:
                    - JIKA kueri berhasil dijalankan:
                        - Tampilkan pesan sukses dengan pengalihan ke 'user.php'
                    - LAINNYA:
                        - Tampilkan pesan kesalahan jika pembaruan basis data gagal
            - LAINNYA:
                - Tampilkan pesan kesalahan untuk format file yang tidak valid (tidak diizinkan)
        
        - ELSE JIKA tidak ada foto yang dipilih:
            - Tampilkan permintaan agar pengguna memilih foto

    JIKA foto yang diunggah melebihi batas ukuran (2MB):
        - Menampilkan pesan kesalahan (file terlalu besar)

AKHIR
-->


<?php
try {
    // Update data profil jika tombol tambah tidak ada
    if(!isset($_POST['tambah'])) {
        
        $id = $_POST['id_user'];
        $user = $_POST['username'];
        $email = $_POST['email'];
        $telp = $_POST['no_telp'];
        $addres = $_POST['address'];    

        $query = "UPDATE profil_user SET username = '$user', email = '$email', no_telp = '$telp', addres = '$addres' WHERE id_user = '$id'";
        $sql = mysqli_query($conn, $query);

        if(!$sql) {
            throw new Exception("Gagal melakukan update profil. Error: " . mysqli_error($conn));
        }

        // Redirect jika berhasil
        header("location: user.php");

    }

    // Update data profil ketika tombol tambah ditekan
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
        // Ambil data dari form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
        $addres = mysqli_real_escape_string($conn, $_POST['addres']);
    
        // ID pengguna yang akan diperbarui
        $id = 1; // Ganti sesuai kebutuhan Anda
    
        // Query untuk update data
        $sql = "UPDATE profil_user SET 
                    username = '$username', 
                    email = '$email', 
                    no_telp = '$no_telp', 
                    addres = '$addres'
                WHERE id_user = $id";
    
        // Eksekusi query
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error: " . mysqli_error($conn) . " Query: " . $sql);
        }
    
        // Redirect jika berhasil
        header("Location: user.php?status=success");
        exit();
    }

    // Update foto pengguna
    if (isset($_POST['upload_foto'])) {
        $id = 1; // Sesuaikan dengan ID pengguna yang akan diperbarui
        $targetDir = "uploads/";
        $foto = "";
    
        // Periksa apakah file diunggah
        if (!empty($_FILES['foto']['name'])) {
            $foto = basename($_FILES['foto']['name']);
            $targetFile = $targetDir . $foto;
    
            // Validasi format file (hanya gambar)
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
            if (!in_array($imageFileType, $allowedTypes)) {
                throw new Exception("Format file tidak valid. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
            }
    
            // Pindahkan file ke folder tujuan
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                throw new Exception("Gagal mengunggah foto.");
            }
    
            // Update database dengan foto baru
            $query = "UPDATE profil_user SET foto = ? WHERE id_user = ?";
            $stmt = mysqli_prepare($conn, $query);
            if (!$stmt) {
                throw new Exception("Error dalam persiapan query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "si", $foto, $id);
    
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Gagal memperbarui foto: " . mysqli_error($conn));
            }
    
            // Berhasil
            echo "<script>alert('Foto berhasil diperbarui!'); window.location.href='user.php';</script>";
        } else {
            throw new Exception("Harap pilih foto terlebih dahulu.");
        }
    }

    // Validasi ukuran file upload
    if ($_FILES['foto']['size'] > 2000000) { // 2MB
        throw new Exception("Ukuran file terlalu besar. Maksimum 2MB.");
    }

} catch (Exception $e) {
    // Menangkap pengecualian dan menampilkan pesan error
    echo '<div style="color: red;">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
    // Anda bisa juga log pesan kesalahan atau kirim email kepada admin di sini
}
?>
