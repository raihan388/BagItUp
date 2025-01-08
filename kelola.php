<!--
MULAI

    MASUKKAN file koneksi basis data (database.php)
    
    Tetapkan nilai default untuk variabel-variabel berikut ini:
        idproduk = ''
        kategori = ''
        nama = ''
        merk = ''
        stok = ''
        satuan = ''
        harga = ''
        deskripsi = ''
    
    JIKA URL berisi 'ubah' (bendera pembaruan):
        MENGAMBIL kembali ID produk dari URL ('ubah')
        LAKUKAN kueri untuk mengambil detail produk dari basis data menggunakan ID
        TANGKAP hasilnya dan simpan dalam variabel:
            idproduk = id_produk yang diambil
            kategori = kategori yang diambil
            nama = mengambil nama_produk
            merk = mengambil merk
            stok = mengambil stok
            satuan = diambil satuan_produk
            harga = harga yang diambil
            deskripsi = diambil deskripsi

    Struktur HTML dimulai:
        Merender tajuk halaman dan metadata.
        
        Menampilkan formulir untuk menambahkan atau mengedit produk:
            JIKA 'ubah' (bendera pembaruan) ada di URL:
                - Menampilkan nilai saat ini untuk bidang (info produk).
            LAINNYA:
                - Menampilkan bidang formulir yang kosong.
            
            Menampilkan bidang masukan:
                - ID Produk (dapat diedit untuk pembaruan)
                - Gambar (input file, wajib diisi jika tidak memperbarui)
                - Kategori (input teks, wajib diisi)
                - Nama Produk (input teks, wajib diisi)
                - Merk (input teks, wajib diisi)
                - Stok (input teks, wajib diisi)
                - Satuan (menu tarik-turun, default untuk PCS)
                - Harga (input teks, wajib diisi)
                - Deskripsi (area teks, wajib diisi)
                
            Tombol-tombol tampilan:
                - Jika 'ubah' ada di URL, tampilkan tombol 'Edit' untuk mengirimkan formulir.
                - Jika tidak ada 'ubah', tampilkan tombol 'Tambah' untuk menambahkan produk baru.
                
            Tampilkan tombol batal yang menghubungkan kembali ke daftar produk.

    AKHIRI struktur HTML

    Tampilkan footer halaman dan skrip.
    
AKHIR
-->


<!DOCTYPE html>
<?php 
// Menghubungkan ke file database
    include "database.php";
    
    // Variabel untuk form
    $idproduk = '';
    $kategori = '';
    $nama = '';
    $merk = '';
    $stok = '';
    $satuan = '';
    $harga = '';
    $deskripsi = '';

    try {
        // Jika ada parameter 'ubah' pada URL, kita ingin mengambil data produk untuk edit
        if (isset($_GET['ubah'])) {
            $id = $_GET['ubah'];

            // Sanitasi input untuk menghindari SQL Injection
            $id = mysqli_real_escape_string($conn, $id);

            // Query untuk mengambil data produk berdasarkan ID
            $query = "SELECT * FROM produk WHERE id = '$id'";
            $sql = mysqli_query($conn, $query);

            // Cek apakah query berhasil dijalankan
            if (!$sql) {
                throw new Exception("Query gagal dijalankan: " . mysqli_error($conn));
            }

            // Cek apakah data produk ditemukan
            if ($result = mysqli_fetch_assoc($sql)) {
                $idproduk = $result['id_produk'];
                $kategori = $result['kategori'];
                $nama = $result['nama_produk'];
                $merk = $result['merk'];
                $stok = $result['stok'];
                $satuan = $result['satuan_produk'];
                $harga = $result['harga'];
                $deskripsi = $result['deskripsi'];
            } else {
                throw new Exception("Data produk dengan ID $id tidak ditemukan.");
            }
        }
    } catch (Exception $e) {
        // Tangani error dan tampilkan pesan kesalahan
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
    }
?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/5.15.4/css/all.min.css">
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
                        <a class="collapse-item" href="data_produk.php">Produk</a>
                        <a class="collapse-item" href="kategori.php">Kategori</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
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
                
                <div class="container">
                    <form method="POST" action="proses.php" enctype="multipart/form-data">
                        <h3><i class="fa-regular fa-database p-2"></i> Tambahkan Data</h3>
                        <input type="hidden" value="<?php echo $id;?>" name="id">
                        <div class="mb-3 row">
                            <label for="id_produk" class="col-sm-2 col-form-label">ID Produk</label>
                            <div class="col-sm-10">
                                <input type="text" name="id_produk" class="form-control" id="id_produk" value="<?php echo $idproduk ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <input <?php if(!isset($_GET['ubah'])){echo "required";} ?> type="file" name="gambar" class="form-control" id="gambar" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" name="kategori" class="form-control" id="kategori" required value="<?php echo $kategori; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_produk" class="form-control" id="nama_produk" required value="<?php echo $nama; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="merk" class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-10">
                                <input type="text" name="merk" class="form-control" id="merk" required value="<?php echo $merk ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="text" name="stok" class="form-control" id="stok" required value="<?php echo $stok ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-10">
                                <select id="satuan" name="satuan" class="form-select">
                                    <option>Buka Menu Pilihan Ini</option>
                                    <option selected value="PCS">PCS</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <input type="text" name="harga" class="form-control" id="harga" required value="<?php echo $harga ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required ><?php echo $deskripsi; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3 row mt-4">
                            <div class="col">
                                <?php 
                                    if(isset($_GET['ubah'])) {
                                ?>
                                    <button type="submit" name="aksi" value="edit" class="btn btn-primary">Edit</button>
                                <?php
                                    } else {
                                ?>
                                    <button type="submit" name="aksi" value="add" class="btn btn-primary">Tambah</button>
                                <?php
                                    }
                                ?>
                                <a href="dataproduk.php" type="button" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>