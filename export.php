<!--
MULAI

1. Sertakan pustaka FPDF dan file koneksi database.
2. Mulai sesi untuk mengelola variabel sesi.
3. Inisialisasi penghitung `$no` untuk melacak nomor item.

4. Buat dokumen PDF baru menggunakan kelas FPDF.
    - Atur orientasi halaman ke potret (P), ukuran kertas ke A4.
    - Tambahkan halaman ke PDF.

5. Atur font untuk judul dan tambahkan “INVOICE” di bagian tengah halaman.

6. Atur font untuk detail perusahaan dan tambahkan informasi perusahaan (nama, alamat, email) di sebelah kiri.

7. Tambahkan tanggal saat ini (menggunakan `tanggal()`) dan penerima (misalnya, “CONTOH, PT.”) di sisi kanan.

8. Buat header tabel dengan kolom-kolom berikut:
    - “No” (Nomor)
    - “Gambar” (Gambar)
    - “Nama Barang” (Product Name)
    - “Merk” (Merk)
    - “Jumlah” (Quantity)
    - “Subtotal” (Subtotal)

9. Query database untuk memilih semua barang dari keranjang belanja (tabel `keranjang`).
    - Inisialisasi variabel `$grand_total` untuk mengakumulasikan harga total.

10. Jika ada item di dalam keranjang:
    - Untuk setiap item:
        - Hitung subtotal dengan mengalikan harga barang (`harga`) dengan kuantitasnya (`kuantitas`).
        - Tambahkan subtotal ke `$grand_total`.
        - Tampilkan rincian item dalam tabel:
            - Nomor barang
            - Gambar (disesuaikan agar sesuai dengan sel)
            - Nama produk
            - Merek
            - Kuantitas
            - Subtotal dengan mata uang yang telah diformat (contoh: Rp 1.000.000)

11. Setelah semua item ditampilkan, tambahkan satu baris untuk jumlah totalnya:
    - Beri label “Total”
    - Menampilkan total keseluruhan dengan mata uang yang diformat.

12. Keluarkan PDF yang dihasilkan ke browser.

AKHIR
-->


<?php
require('fpdf/fpdf.php');
include 'database.php';
session_start();

$no = 0;

// Inisialisasi FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul Invoice
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'INVOICE', 0, 1, 'C');

// Informasi Perusahaan
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'BagItup', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Jl. S. Parman', 0, 1, 'L');
$pdf->Cell(0, 5, 'Piayu, Batam', 0, 1, 'L');
$pdf->Cell(0, 5, 'Email: bagitup@gmail.com', 0, 1, 'L');

// Tanggal dan Penerima
$pdf->SetY(20);
$pdf->SetX(150);
$pdf->Cell(0, 5, 'Batam, ' . date('d-m-Y'), 0, 1, 'L');
$pdf->SetX(150);
$pdf->Cell(0, 5, 'EXAMPLE, PT.', 0, 1, 'L');

// Tabel Header
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 10, 'No', 1, 0, 'C');
$pdf->Cell(30, 10, 'Gambar', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(30, 10, 'Merk', 1, 0, 'C');
$pdf->Cell(25, 10, 'Jumlah', 1, 0, 'C');
$pdf->Cell(25, 10, 'Subtotal', 1, 1, 'C');

// Isi Tabel
$select_cart = mysqli_query($conn, "SELECT * FROM `keranjang`");
$grand_total = 0;

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $sub_total = floatval($fetch_cart['harga']) * floatval($fetch_cart['kuantitas']);
        $grand_total += $sub_total;

        // Nomor
        $pdf->Cell(20, 30, ++$no, 1, 0, 'C');

        // Gambar
        $x = $pdf->GetX(); // Simpan posisi X sebelum gambar
        $y = $pdf->GetY(); // Simpan posisi Y sebelum gambar
        $pdf->Cell(30, 30, '', 1, 0, 'C'); // Buat cell untuk gambar
        $pdf->Image('uploads/' . $fetch_cart['gambar'], $x + 2, $y + 2, 26, 26); // Sesuaikan ukuran gambar

        // Nama Barang
        $pdf->Cell(60, 30, $fetch_cart['nama_produk'], 1, 0, 'C');

        // Merk
        $pdf->Cell(30, 30, $fetch_cart['merk'], 1, 0, 'C');

        // Jumlah
        $pdf->Cell(25, 30, $fetch_cart['kuantitas'], 1, 0, 'C');

        // Subtotal
        $pdf->Cell(25, 30, 'Rp ' . number_format($sub_total, 0, ',', '.'), 1, 1, 'C');
    }
}

// Total Keseluruhan
$pdf->Cell(165, 10, 'Total', 1, 0, 'C');
$pdf->Cell(25, 10, 'Rp ' . number_format($grand_total, 0, ',', '.'), 1, 1, 'C');

// Output PDF
$pdf->Output();
?>