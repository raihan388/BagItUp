<!--
MULAI

FUNGSI tambah_produk(data, file):
    - Mengekstrak data dari input (`id_produk`, `kategori`, `nama_produk`, `merk`, `stok`, `satuan`, `harga`, `deskripsi`).
    - Ekstrak data file (`gambar`).
    - Atur direktori unggahan ke “unggahan/”.
    
    - Dapatkan ekstensi file dari gambar yang diunggah.
    - Tentukan ekstensi yang diizinkan sebagai PNG, JPG, dan JPEG.
    - Jika ekstensi file tidak diizinkan:
        - Kembalikan pesan kesalahan: “Format file tidak valid. Hanya diperbolehkan PNG, JPG, dan JPEG.”
    - Lain-lain:
        - Pindahkan gambar yang diunggah ke direktori “uploads/”.
        - Membuat kueri SQL untuk memasukkan detail produk ke dalam basis data.
        - Jika kueri berhasil:
            - Kembalikan nilai true.
        - Lain:
            - Menghapus gambar yang diunggah (jika kueri gagal).
            - Mengembalikan pesan kesalahan: “Gagal menyimpan data ke database.”
        END IF
    AKHIR JIKA
AKHIR FUNGSI

FUNGSI ubah_produk(data, files):
    - Mengekstrak data dari input (`id`, `id_produk`, `kategori`, `nama_produk`, `merk`, `stok`, `satuan`, `harga`, `deskripsi`).
    
    - Ambil detail produk saat ini dari basis data menggunakan `id` produk.
    - Jika tidak ada gambar baru yang diunggah:
        - Mengatur gambar saat ini dari database.
    - Lain:
        - Menghapus gambar lama dari server.
        - Unggah gambar baru ke direktori “uploads/”.
    
    - Membuat kueri SQL untuk memperbarui informasi produk dalam database.
    - Jalankan kueri SQL.
    - Kembalikan nilai true (menunjukkan pembaruan berhasil).

AKHIRI FUNGSI

FUNGSI hapus_produk(data):
    - Ekstrak `hapus` (ID produk) dari input.
    
    - Ambil detail produk dari basis data menggunakan `id`.
    - Menghapus gambar produk dari direktori “uploads/”.
    
    - Buat kueri SQL untuk menghapus produk dari database.
    - Jalankan kueri SQL.
    - Kembalikan nilai true (menunjukkan penghapusan berhasil).
    
AKHIRI FUNGSI

AKHIR
-->


<?php
// Memasukkan file koneksi database
include "database.php";

// Fungsi untuk menambahkan produk
function tambah_produk($data, $files) {
    try {
        // Mengambil data dari parameter
        $id = $data['id_produk'];
        $kategori = $data['kategori'];
        $nama = $data['nama_produk'];
        $merk = $data['merk'];
        $stok = $data['stok'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $deskripsi = $data['deskripsi'];
        
        // Mengolah file gambar yang diunggah
        $gambar = $files['gambar']['name'];
        $tmpFile = $files['gambar']['tmp_name'];
        $dir = "uploads/";

        // Validasi ekstensi file gambar
        $ekstensiValid = ['png', 'jpg', 'jpeg'];
        $ekstensiFile = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

        if (!in_array($ekstensiFile, $ekstensiValid)) {
            throw new Exception("Format file tidak valid. Hanya diperbolehkan PNG, JPG, dan JPEG.");
        }

        // Memindahkan file ke folder tujuan
        $pathUpload = $dir . $gambar;
        if (!move_uploaded_file($tmpFile, $pathUpload)) {
            throw new Exception("Gagal mengunggah file.");
        }

        // Menyimpan data produk ke database
        $query = "INSERT INTO produk VALUES (null, '$id', '$kategori', '$nama', '$merk', '$stok', '$satuan', '$harga', '$deskripsi', '$gambar')";
        $sql = mysqli_query($GLOBALS['conn'], $query);
        
        if (!$sql) {
            // Hapus file jika query gagal
            unlink($pathUpload);
            throw new Exception("Gagal menyimpan data ke database: " . mysqli_error($GLOBALS['conn']));
        }

        return true;
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fungsi untuk mengubah data produk
function ubah_produk($data, $files) {
    try {
        // Mengambil data dari parameter
        $id = $data['id'];
        $idproduk = $data['id_produk'];
        $kategori = $data['kategori'];
        $nama = $data['nama_produk'];
        $merk = $data['merk'];
        $stok = $data['stok'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $deskripsi = $data['deskripsi'];

        // Mengambil data produk berdasarkan ID
        $queryshow = "SELECT * FROM produk WHERE id = '$id'";
        $sqlshow = mysqli_query($GLOBALS['conn'], $queryshow);
        if (!$sqlshow) {
            throw new Exception("Gagal mengambil data produk: " . mysqli_error($GLOBALS['conn']));
        }
        $result = mysqli_fetch_assoc($sqlshow);

        // Jika tidak ada gambar baru, gunakan gambar lama
        if ($files['gambar']['name'] == "") {
            $gambar = $result['gambar'];
        } else {
            // Hapus gambar lama dan unggah gambar baru
            unlink("uploads/" . $result['gambar']);
            $gambar = $files['gambar']['name'];
            if (!move_uploaded_file($files['gambar']['tmp_name'], 'uploads/' . $gambar)) {
                throw new Exception("Gagal mengunggah gambar baru.");
            }
        }

        // Mengupdate data produk di database
        $query = "UPDATE produk SET id_produk = '$idproduk', kategori = '$kategori', nama_produk = '$nama', merk = '$merk', stok = '$stok', satuan_produk = '$satuan', harga = '$harga', deskripsi = '$deskripsi', gambar = '$gambar' WHERE id = '$id';";
        $sql = mysqli_query($GLOBALS['conn'], $query);
        
        if (!$sql) {
            throw new Exception("Gagal memperbarui data produk: " . mysqli_error($GLOBALS['conn']));
        }

        return true;
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fungsi untuk menghapus produk
function hapus_produk($data) {
    try {
        // Mengambil ID produk yang akan dihapus
        $id = $data['hapus'];

        // Mengambil data produk berdasarkan ID
        $queryshow = "SELECT * FROM produk WHERE id = '$id'";
        $sqlshow = mysqli_query($GLOBALS['conn'], $queryshow);
        if (!$sqlshow) {
            throw new Exception("Gagal mengambil data produk: " . mysqli_error($GLOBALS['conn']));
        }
        $result = mysqli_fetch_assoc($sqlshow);

        // Menghapus gambar dari folder
        $pathGambar = "uploads/" . $result['gambar'];
        if (file_exists($pathGambar)) {
            unlink($pathGambar);
        }

        // Menghapus data produk dari database
        $query = "DELETE FROM produk WHERE id = '$id'";
        $sql = mysqli_query($GLOBALS['conn'], $query);
        
        if (!$sql) {
            throw new Exception("Gagal menghapus produk: " . mysqli_error($GLOBALS['conn']));
        }

        return true;
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}
?>