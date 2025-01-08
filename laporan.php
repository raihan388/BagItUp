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
    < id="content">

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
        <div class="row">
	<div class="col-md-12">
		<h4>
			<?php if(!empty($_GET['cari'])){ ?>
			Data Laporan Penjualan <?= $bulan_tes[$_POST['bln']];?> <?= $_POST['thn'];?>
			<?php }elseif(!empty($_GET['hari'])){?>
			Data Laporan Penjualan <?= $_POST['hari'];?>
			<?php }else{?>
			Data Laporan Penjualan <?= $bulan_tes[date('m')];?> <?= date('Y');?>
			<?php }?>
		</h4>
		<br />
		<div class="card">
			<div class="card-header">
				<h5 class="card-title mt-2">Cari Laporan Per Bulan</h5>
			</div>
			<div class="card-body p-0">
				<form method="post" action="index.php?page=laporan&cari=ok">
					<table class="table table-striped">
						<tr>
							<th>
								Pilih Bulan
							</th>
							<th>
								Pilih Tahun
							</th>
							<th>
								Aksi
							</th>
						</tr>
						<tr>
							<td>
								<select name="bln" class="form-control">
									<option selected="selected">Bulan</option>
									<?php
								$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
								$jlh_bln=count($bulan);
								$bln1 = array('01','02','03','04','05','06','07','08','09','10','11','12');
								$no=1;
								for($c=0; $c<$jlh_bln; $c+=1){
									echo"<option value='$bln1[$c]'> $bulan[$c] </option>";
								$no++;}
							?>
								</select>
							</td>
							<td>
							<?php
								$now=date('Y');
								echo "<select name='thn' class='form-control'>";
								echo '
								<option selected="selected">Tahun</option>';
								for ($a=2017;$a<=$now;$a++)
								{
									echo "<option value='$a'>$a</option>";
								}
								echo "</select>";
							?>
							</td>
							<td>
								<input type="hidden" name="periode" value="ya">
								<button class="btn btn-primary">
									<i class="fa fa-search"></i> Cari
								</button>
								<a href="index.php?page=laporan" class="btn btn-success">
									<i class="fa fa-refresh"></i> Refresh</a>

								<?php if(!empty($_GET['cari'])){?>
								<a href="excel.php?cari=yes&bln=<?=$_POST['bln'];?>&thn=<?=$_POST['thn'];?>"
									class="btn btn-info"><i class="fa fa-download"></i>
									Excel</a>
								<?php }else{?>
								<a href="excel.php" class="btn btn-info"><i class="fa fa-download"></i>
									Excel</a>
								<?php }?>
							</td>
						</tr>
					</table>
				</form>
				<form method="post" action="index.php?page=laporan&hari=cek">
					<table class="table table-striped">
						<tr>
							<th>
								Pilih Hari
							</th>
							<th>
								Aksi
							</th>
						</tr>
						<tr>
							<td>
								<input type="date" value="<?= date('Y-m-d');?>" class="form-control" name="hari">
							</td>
							<td>
								<input type="hidden" name="periode" value="ya">
								<button class="btn btn-primary">
									<i class="fa fa-search"></i> Cari
								</button>
								<a href="index.php?page=laporan" class="btn btn-success">
									<i class="fa fa-refresh"></i> Refresh</a>

								<?php if(!empty($_GET['hari'])){?>
								<a href="excel.php?hari=cek&tgl=<?= $_POST['hari'];?>" class="btn btn-info"><i
										class="fa fa-download"></i>
									Excel</a>
								<?php }else{?>
								<a href="excel.php" class="btn btn-info"><i class="fa fa-download"></i>
									Excel</a>
								<?php }?>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
         <br />
         <br />
         <!-- view barang -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered w-100 table-sm" id="example1">
						<thead>
							<tr style="background:#DFF0D8;color:#333;">
								<th> No</th>
								<th> ID Barang</th>
								<th> Nama Barang</th>
								<th style="width:10%;"> Jumlah</th>
								<th style="width:10%;"> Modal</th>
								<th style="width:10%;"> Total</th>
								<th> Kasir</th>
								<th> Tanggal Input</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no=1; 
								if(!empty($_GET['cari'])){
									$periode = $_POST['bln'].'-'.$_POST['thn'];
									$no=1; 
									$jumlah = 0;
									$bayar = 0;
									$hasil = $lihat -> periode_jual($periode);
								}elseif(!empty($_GET['hari'])){
									$hari = $_POST['hari'];
									$no=1; 
									$jumlah = 0;
									$bayar = 0;
									$hasil = $lihat -> hari_jual($hari);
								}else{
									$hasil = $lihat -> jual();
								}
							?>
							<?php 
								$bayar = 0;
								$jumlah = 0;
								$modal = 0;
								foreach($hasil as $isi){ 
									$bayar += $isi['total'];
									$modal += $isi['harga_beli']* $isi['jumlah'];
									$jumlah += $isi['jumlah'];
							?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $isi['id_barang'];?></td>
								<td><?php echo $isi['nama_barang'];?></td>
								<td><?php echo $isi['jumlah'];?> </td>
								<td>Rp.<?php echo number_format($isi['harga_beli']* $isi['jumlah']);?>,-</td>
								<td>Rp.<?php echo number_format($isi['total']);?>,-</td>
								<td><?php echo $isi['nm_member'];?></td>
								<td><?php echo $isi['tanggal_input'];?></td>
							</tr>
							<?php $no++; }?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="3">Total Terjual</td>
								<th><?php echo $jumlah;?></td>
								<th>Rp.<?php echo number_format($modal);?>,-</th>
								<th>Rp.<?php echo number_format($bayar);?>,-</th>
								<th style="background:#0bb365;color:#fff;">Keuntungan</th>
								<th style="background:#0bb365;color:#fff;">
									Rp.<?php echo number_format($bayar-$modal);?>,-</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
     </div>
 </div>
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