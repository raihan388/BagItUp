<!--
MULAI

Fungsi INCLUDE (fungsi.php)

JIKA formulir dikirimkan dengan tindakan 'aksi':

- JIKA 'aksi' adalah "add" (tambah produk):

- Panggil fungsi `tambah_produk()` dengan data POST dan data FILES
- JIKA produk berhasil ditambahkan:

- Redirect ke 'dataproduk.php' (tampilkan pesan sukses atau lanjutkan)

- ELSE JIKA 'aksi' adalah "edit" (edit produk):

- Panggil fungsi `ubah_produk()` dengan data POST dan data FILES
- JIKA produk berhasil diperbarui:

- Redirect ke 'dataproduk.php' (tampilkan pesan sukses atau lanjutkan)

JIKA permintaan GET berisi 'hapus' (hapus produk):

- Panggil fungsi `hapus_produk()` dengan data GET (untuk mengidentifikasi produk mana yang akan dihapus)
- JIKA produk berhasil dihapus:

- Redirect ke 'dataproduk.php' (tampilkan pesan sukses atau lanjutkan)

AKHIR
-->


<?php
    include "fungsi.php"; // Menghubungkan ke file fungsi.php

    try {
        // Memeriksa apakah ada aksi yang dikirim melalui POST
        if (isset($_POST['aksi'])) {
            // Jika aksi adalah "add", coba untuk menambahkan produk
            if ($_POST['aksi'] == "add") {
                $berhasil = tambah_produk($_POST, $_FILES); // Memanggil fungsi untuk menambahkan produk
                if ($berhasil) {
                    header("location: dataproduk.php"); // Redirect ke halaman dataproduk
                    exit; // Menghentikan eksekusi script
                } else {
                    throw new Exception("Gagal menambahkan produk."); // Menangkap kesalahan jika gagal
                }

            // Jika aksi adalah "edit", coba untuk mengubah produk
            } else if ($_POST['aksi'] == "edit") {
                $berhasil = ubah_produk($_POST, $_FILES); // Memanggil fungsi untuk mengubah produk
                if ($berhasil) {
                    header("location: dataproduk.php"); // Redirect ke halaman dataproduk
                    exit; // Menghentikan eksekusi script
                } else {
                    throw new Exception("Gagal mengubah produk."); // Menangkap kesalahan jika gagal
                }
            }
        }

        // Memeriksa apakah ada permintaan untuk menghapus produk
        if (isset($_GET['hapus'])) {
            $berhasil = hapus_produk($_GET); // Memanggil fungsi untuk menghapus produk
            if ($berhasil) {
                header("location: dataproduk.php"); // Redirect ke halaman dataproduk
                exit; // Menghentikan eksekusi script
            } else {
                throw new Exception("Gagal menghapus produk."); // Menangkap kesalahan jika gagal
            }
        }

    } catch (Exception $e) {
        // Menangani pengecualian dan menampilkan pesan kesalahan
        $error_message = $e->getMessage();
        echo '<div style="color: red;">Terjadi kesalahan: ' . $error_message . '</div>';
        // Anda bisa menambahkan log error atau kirim email kepada admin jika diperlukan.
    }
?>
