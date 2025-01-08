<!--
MULAI

// Inisialisasi Struktur Halaman
1. Inisialisasi Header Halaman
   - Tambahkan Judul “BAGITUP”
   - Tambahkan Bilah Sisi dengan Tautan Navigasi
   - Tambahkan Dropdown Pengguna untuk Admin

2. Inisialisasi Pembungkus Konten
   - Tampilkan Dasbor dengan opsi Navigasi:
     a. Dasbor (Halaman Admin)
     b. Manajemen Data
        i. Manajemen Produk
     c. Manajemen Transaksi
        i. Laporan Penjualan
     d. Bagian Footer
     e. Pemberitahuan tentang Perubahan Data

3. Menentukan Menu Sidebar
   a. Menambahkan Merek Sidebar (Ikon BagItUp)
   b. Tambahkan Menu Dashboard dengan tautan ke halaman Admin
   c. Tambahkan Menu Manajemen Data (Produk)
   d. Tambahkan Menu Manajemen Transaksi (Laporan Penjualan)
   e. Tambahkan Sidebar Toggler (untuk seluler)

4. Menampilkan Konten Utama
   a. Tampilkan Widget Kartu dengan statistik terkini:
      - Total Produk: “5”
      - Stok Produk: “220”
      - Produk Terjual: “100”
      - Kategori Produk: “5”
   b. Sediakan tautan navigasi ke tampilan detail dari setiap bagian (produk, laporan, dll.)

5. Menangani Tindakan Topbar
   a. Tampilkan Topbar dengan nama Admin
   b. Menyediakan tombol Logout untuk Admin

6. Bagian Footer
   a. Tampilkan footer dengan branding situs web (BagItUp)

7. Tambahkan Interaktivitas menggunakan JavaScript
   a. Menangani inisialisasi DataTables untuk data Produk dan laporan Penjualan
   b. Menampilkan notifikasi (sukses, bahaya, peringatan) dengan efek fade-in dan fade-out berjangka waktu
   c. Menerapkan fungsionalitas Modal (menampilkan dan menyembunyikan modal)

AKHIR
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BAGITUP </title>
    <!-- Custom fonts for this template-->
    <link href="sb-admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DATATABLES BS 4-->
    <link rel="stylesheet" href="sb-admin/vendor/datatables/dataTables.bootstrap4.css" />
    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BAGITUP<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Laman Admin</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-database"></i>
            <span>Manajemen Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="dataproduk.php">Produk</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true"
        aria-controls="collapse3">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="laporan.php">Laporan Penjualan</a>
            </div>
        </div>
    </li>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <h5 class="d-lg-block d-none mt-2"><img src="img/bagitup.png" alt=""></h5>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span
                            class="mr-2 d-none d-lg-inline text-gray-600 small ml-2">Admin</span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                       
                        <a class="dropdown-item" href="login.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <h3>Laman Admin</h3>
        <br/>
        <div class="row">
    <!--STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-cubes"></i> Nama Produk</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>5</h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='dataproduk.php'>Tabel
                    Produk <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
    <!-- STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-chart-bar"></i> Stok Produk</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>220</h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='dataproduk.php'>Tabel
                    Produk <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
        <!--/grey-card -->
    </div>
    <!-- STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-upload"></i> Telah Terjual</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>100</h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=laporan'>Tabel
                    Laporan <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fa fa-bookmark"></i> Kategori Barang</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>5</h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=kategori'>Tabel
                    Kategori <i class='fa fa-angle-double-right'></i></a>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
</div>
</div>
    </div>
    <!-- End of Main Content -->
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>
                    |BagItUp|
                   
                </span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Custom scripts for all pages-->
    <script src="sb-admin/js/sb-admin-2.min.js"></script>
    <script src="sb-admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="sb-admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    //datatable
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable();
    });
   </script>
   <script type="text/javascript">
    //template
    $(document).ready(function() {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Peringatan !',
            // (string | mandatory) the text inside the notification
            text: 'stok barang ada yang tersisa kurang dari 3 silahkan pesan lagi !',
            // (string | optional) the image to display on the left
            image: 'assets/img/seru.png',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'

        });

        return false;
    });
   </script>
   <script type="application/javascript">
    //angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-danger").fadeIn('slow');
        }, 500);
    });
    //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    setTimeout(function() {
        $(".alert-danger").fadeOut('slow');
    }, 5000);

    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-success").fadeIn('slow');
        }, 500);
    });
    setTimeout(function() {
        $(".alert-success").fadeOut('slow');
    }, 5000);

    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-warning").fadeIn('slow');
        }, 500);
    });
    setTimeout(function() {
        $(".alert-success").fadeOut('slow');
    }, 5000);
   </script>
   <script>
    $(".modal-create").hide();
    $(".bg-shadow").hide();
    $(".bg-shadow").hide();

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
        