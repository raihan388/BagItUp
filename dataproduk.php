<!--
MULAI

1. Sertakan file koneksi database (database.php).
2. Buat query SQL untuk memilih semua produk dari tabel 'produk'.
3. Jalankan kueri menggunakan `mysqli_query()` dan simpan hasilnya dalam sebuah variabel.

Struktur HTML:
- Tentukan jenis dan struktur dokumen.
- Siapkan header dengan meta tag dan lembar gaya eksternal (Bootstrap, CSS khusus, Font Awesome).
- Mengatur penyertaan JavaScript untuk fungsi-fungsi seperti jQuery, Bootstrap, dan pustaka lainnya.

TUBUH
1. Buat pembungkus halaman (`#wrapper`) yang berisi bilah sisi, bilah atas, dan area konten utama.

SIDEBAR:
- Tampilkan bilah sisi dengan item navigasi (Dasbor, Manajemen Data, Transaksi).
- Di dalam sidebar, sediakan tautan untuk mengelola data produk dan melihat laporan penjualan.

BIDANG ATAS (TOPBAR):
- Menampilkan bar bagian atas dengan logo dan dropdown admin untuk opsi logout.

KONTEN UTAMA (Data Produk):
1. Menampilkan bagian dengan judul “Daftar Produk”.
2. Menampilkan tombol untuk menambahkan data produk baru (link ke `kelola.php`).
3. Periksa apakah ada produk yang memiliki stok lebih rendah dari 3. Jika ada, tampilkan peringatan untuk setiap produk tersebut.
4. Buat sebuah tabel untuk menampilkan detail produk:
    - Kolom: No., ID Produk, Gambar, Kategori, Nama Produk, Merek, Stok, Unit, Harga, Deskripsi, Tindakan.
    - Ulangi hasil dari kueri SQL (`mysqli_fetch_assoc`) untuk menampilkan data produk di setiap baris tabel.
    - Sediakan tindakan Edit dan Hapus dengan tombol masing-masing.

FOOTER:
- Tampilkan footer dengan branding “BagItUp”.

AKHIR PEMBUNGKUS HALAMAN

Tombol Gulir ke Atas:
- Menampilkan tombol untuk menggulir ke bagian atas halaman.

Fungsi JavaScript:
1. Menginisialisasi plugin DataTables untuk tabel.
2. Membuat templat untuk notifikasi menggunakan pustaka `gritter` untuk menampilkan pesan peringatan stok.
3. Atur batas waktu untuk memudarkan peringatan keberhasilan, kesalahan, dan peringatan setelah interval tertentu.
4. Menyembunyikan dan menampilkan tampilan modal untuk membuat/mengedit produk.

AKHIR
-->

<?php
    include "database.php";

    $query = "SELECT * FROM produk";
    $sql = mysqli_query($conn, $query);
    $no = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BAGITUP</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="sb-admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sb-admin/vendor/datatables/dataTables.bootstrap4.css">

    <!-- Scripts -->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-cash-register"></i>
                </div>
                <div class="sidebar-brand-text mx-3">BAGITUP</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Laman Admin</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Manajemen Data</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="dataproduk.php">Produk</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="laporan.php">Laporan Penjualan</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h5 class="d-lg-block d-none mt-2">
                        <img src="img/bagitup.png" alt="">
                    </h5>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small ml-2">Admin</span>
                                <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="col-md-20 p-3 pt-3">
                        <h3><i class="fas fa-box p-2"></i>Daftar Produk</h3>
                        <a href="kelola.php" type="button" class="btn btn-primary mb-3">Tambahkan Data</a>

                        <?php
                            $datastock = mysqli_query($conn, "SELECT * FROM produk WHERE stok < 3");
                            while ($data = mysqli_fetch_assoc($datastock)) {
                        ?>
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <div>
                                    <strong>Peringatan!</strong> stok <?php echo $data['nama_produk']; ?> Telah habis
                                </div>
                            </div>
                        <?php
                            }
                        ?>

                        <div class="table-responsive">
                            <table class="table align-middle table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><center>No.</center></th>
                                        <th>ID produk</th>
                                        <th>Gambar</th>
                                        <th>Kategori</th>
                                        <th>Nama Produk</th>
                                        <th>Merk</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($result = mysqli_fetch_assoc($sql)) {
                                    ?>
                                    <tr>
                                        <td><center><?php echo ++$no; ?></center></td>
                                        <td><?php echo $result['id_produk']; ?></td>
                                        <td><img src="img/bahan/<?php echo $result['gambar']; ?>" alt="" style="width:100px;"></td>
                                        <td><?php echo $result['kategori']; ?></td>
                                        <td><?php echo $result['nama_produk']; ?></td>
                                        <td><?php echo $result['merk']; ?></td>
                                        <td><?php echo $result['stok']; ?></td>
                                        <td><?php echo $result['satuan_produk']; ?></td>
                                        <td><?php echo $result['harga']; ?></td>
                                        <td><?php echo $result['deskripsi']; ?></td>
                                        <td>
                                            <a href="kelola.php?ubah=<?php echo $result['id']; ?>" class="btn btn-success">Edit</a>
                                            <a href="proses.php?hapus=<?php echo $result['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data tersebut?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>|BagItUp|</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="sb-admin/js/sb-admin-2.min.js"></script>
    <script src="sb-admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="sb-admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable();
        });

        $(document).ready(function() {
            setTimeout(function() {
                $(".alert-danger").fadeIn('slow');
            }, 500);
            setTimeout(function() {
                $(".alert-danger").fadeOut('slow');
            }, 5000);

            setTimeout(function() {
                $(".alert-success").fadeIn('slow');
            }, 500);
            setTimeout(function() {
                $(".alert-success").fadeOut('slow');
            }, 5000);

            setTimeout(function() {
                $(".alert-warning").fadeIn('slow');
            }, 500);
            setTimeout(function() {
                $(".alert-warning").fadeOut('slow');
            }, 5000);
        });

        function clickModals() {
            $(".bg-shadow").fadeIn();
            $(".modal-create").fadeIn();
        }

        function cancelModals() {
            $('.modal-view').fadeIn();
            $(".modal-create").hide();
            $(".bg-shadow").hide();
        }
    </script>
</body>
</html>
