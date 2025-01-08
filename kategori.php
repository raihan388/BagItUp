<?php
    include 'fungsi.php';
    include 'database.php';
    $query = "SELECT * FROM kategori";
    $sql = mysqli_query($conn, $query);
    $no = 0;

    $kategori = '';
    $tgl = '';


    if(isset($_GET['ubah'])) {
        $id = $_GET['ubah'];
        
        $query = "SELECT * FROM produk WHERE id = '$id'";
        $sql = mysqli_query($conn, $query);

        $result = mysqli_fetch_assoc($sql);
        

        //die();
    }
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">BAGITUP</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Laman Admin</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Data Master -->
                <li class="nav-item active">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-database"></i>
                        <span>Manajemen Data</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="dataproduk.php">Produk</a>
                            <a class="collapse-item" href="kategori.php">Kategori</a>
                        </div>
                    </div>
                </li>

                <!-- Transaksi -->
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-desktop"></i>
                        <span>Transaksi</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler -->
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

                        <!-- Sidebar Toggle -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Brand Logo -->
                        <h5 class="d-lg-block d-none mt-2">
                            <img src="img/bagitup.png" alt="">
                        </h5>

                        <!-- Topbar Navbar -->
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
                    <!-- End of Topbar -->
                    <div class="container-fluid">
                        <h4>Kategori</h4>
                            <br />
                            <?php if(isset($_GET['success'])){?>
                            <div class="alert alert-success">
                                <p>Tambah Data Berhasil !</p>
                            </div>
                            <?php }?>
                            <?php if(isset($_GET['success-edit'])){?>
                            <div class="alert alert-success">
                                <p>Update Data Berhasil !</p>
                            </div>
                            <?php }?>
                            <?php if(isset($_GET['remove'])){?>
                            <div class="alert alert-danger">
                                <p>Hapus Data Berhasil !</p>
                            </div>
                            <?php }?>
                            <?php 
                                if(isset($_GET['ubah'])) { 
                            ?>
                            <form method="POST" action="proses.php">
                                <table>
                                    <tr>
                                        <td style="width:25pc;"><input type="text" class="form-control" value="<?php echo $kategori ?>"
                                                required name="kategori" placeholder="Ubah Kategori Barang Baru">
                                            <input type="hidden" name="id" value="<?= $edit['id_kategori'];?>">
                                        </td>
                                        <td style="padding-left:10px;"><button type="submit" name="ubah_kategori" id="tombol-simpan" class="btn btn-primary"><i class="fa fa-edit"></i>
                                                Ubah Data</button></td>
                                    </tr>
                                </table>
                            </form>
                            <?php }else{?>
                            <form method="POST" action="proses.php" >
                                <table>
                                    <tr>
                                        <td>
                                            <input style="width:25pc;" type="text" name="nama_kategori" class="form-control" placeholder="Masukkan kategori baru" required>
                                        </td>
                                        <td>
                                            <button type="submit" name="tambah_kategori" class="btn btn-primary">Tambah</button>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </form>
                            </form>
                            <?php }?>
                            <br />
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm" id="example1">
                                        <thead>
                                            <tr style="background:#DFF0D8;color:#333;">
                                                <th>No.</th>
                                                <th>Kategori</th>
                                                <th>Tanggal Input</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            while($result = mysqli_fetch_assoc($sql)){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo ++$no;?></td>
                                                <td><?php echo $result['nama_kategori'];?></td>
                                                <td><?php echo $result['tgl_input'];?></td>
                                                <td>
                                                    <a href="kategori.php?ubah=<?php echo $result['id_kategori']; ?>"><button
                                                            class="btn btn-warning">Edit</button></a>
                                                    <a href="proses.php?hapus_kategori=<?php echo $result['id_kategori']; ?>"
                                                        onclick="javascript:return confirm('Hapus Data Kategori ?');"><button
                                                            class="btn btn-danger">Hapus</button></a>
                                                </td>
                                            </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
