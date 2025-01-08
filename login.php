<!--
MULAI

    MASUKKAN koneksi basis data (database.php)
    
    TANGANI proses pendaftaran:
        JIKA formulir “daftar” dikirimkan:
            - Ambil email, kata sandi, kontak, dan alamat dari data POST
            - Hash kata sandi menggunakan password_hash() untuk keamanan
            - Siapkan kueri SQL untuk memasukkan data ke dalam tabel 'users' dengan penampung
            - JIKA pernyataan SQL berhasil disiapkan:
                - Mengikat parameter (email, hash_password, kontak, alamat)
                - Jalankan kueri:
                    - JIKA pendaftaran berhasil:
                        - Tampilkan pesan sukses menggunakan SweetAlert
                        - Alihkan ke index.php
                    - ELSE tampilkan pesan kesalahan menggunakan SweetAlert
            - ELSE tampilkan pesan kesalahan jika pernyataan SQL tidak dapat disiapkan

    Menangani proses login:
        JIKA formulir “login” dikirimkan:
            - Ambil email dan kata sandi dari data POST
            - Siapkan kueri SQL untuk memilih pengguna berdasarkan email yang diberikan
            - Mengikat parameter (email)
            - Jalankan kueri tersebut:
                - JIKA pengguna ada di dalam database:
                    - Ambil data pengguna
                    - Memulai sesi dan menyimpan data pengguna (user_id, email, role) dalam variabel sesi
                    - JIKA peran pengguna adalah “Penjual”:
                        - Tampilkan pesan sukses menggunakan SweetAlert
                        - Alihkan ke halaman dasbor untuk penjual (dasbor.php)
                    - ELSE tampilkan pesan sukses menggunakan SweetAlert dan alihkan ke halaman beranda (index.php)
                - ELSE tampilkan pesan kesalahan menggunakan SweetAlert untuk kredensial yang salah

    Tampilkan struktur HTML untuk formulir pendaftaran dan login:
        - Tampilkan formulir pendaftaran dengan kolom untuk email, kontak, alamat, dan kata sandi
        - Tampilkan formulir login dengan kolom untuk email dan kata sandi
        - Sediakan tombol untuk beralih antara formulir pendaftaran dan login

    Akhiri struktur HTML

    Sertakan JS eksternal untuk interaksi formulir dan fungsionalitas sakelar (script2.js)

AKHIR
-->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="style6.css">
</head>

<body>
<div class="container">
<?php 
include"database.php";
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Hash password menggunakan password_hash() untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query dengan prepared statement untuk menghindari SQL Injection
    $sql = "INSERT INTO users (email, password, no_telp, address) VALUES (?, ?, ?, ?)";

    // Persiapkan statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Mengikat parameter
        mysqli_stmt_bind_param($stmt, "ssss", $email, $hashed_password, $contact, $address);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika registrasi berhasil
            echo "<script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Anda berhasil melakukan registrasi.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';  // Ganti dengan URL tujuan Anda
                        }
                    });
                  </script>";
        } else {
            // Jika gagal mengeksekusi query
            echo "<script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Registrasi gagal, coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }

        // Tutup prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika query tidak bisa dipersiapkan
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
// Jika ingin menggunakan query MySQLi untuk login, misalnya
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menghindari SQL Injection dengan MySQLi (gunakan prepared statements)
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Mengikat parameter (bind_param pada MySQLi)
    mysqli_stmt_bind_param($stmt, "s", $email); // "s" menunjukkan bahwa parameter adalah string
    
    // Eksekusi statement
    mysqli_stmt_execute($stmt);
    
    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        // Ambil data pengguna
        $data = mysqli_fetch_assoc($result);
        
        // Simpan informasi pengguna dalam sesi
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];
        
        // Redirect sesuai dengan role pengguna
        if ($data['role'] == "Penjual") {
            echo "<script>
                    Swal.fire({
                        title: 'Selamat datang!',
                        text: 'Role: " . $data['role'] . "',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'dashboard.php'; // Halaman dashboard untuk penjual
                        }
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Selamat datang!',
                        text: 'Role: " . $data['role'] . "',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php'; // Halaman home untuk pengguna lainnya
                        }
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Akun tidak ada atau password salah.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
    
    mysqli_stmt_close($stmt); // Menutup statement
}
?>

        <div class="form-box register">
            <form  method="POST">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" placeholder="Email" name="email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="number" placeholder="No. Handphone" name="contact" required>
                    <i class='bx bxs-contact'></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Address" name="address" required>
                    <i class='bx bxs-map'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn" name="register">Register</button>
            </form>
        </div>

        <div class="form-box login">
            <form  method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required> 
                    <i class='bx bxs-envelope'></i>
                </div>
                    <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn" name="login">Login</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Welcome to BagItUp</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>BagItUp!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>
        </div>
    </div>


    <script src="script2.js"></script>
</body>
</html>