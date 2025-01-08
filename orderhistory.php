<?php
    include 'database.php';
    session_start();

  // Query untuk mendapatkan data order history
    $query = "SELECT 
    o.id_order, 
    o.jumlah, 
    o.status, 
    o.invoice, 
    p.nama_produk, 
    p.harga, 
    p.gambar, 
    p.stok
    FROM orders o
    JOIN produk p ON o.id = p.id
    ORDER BY o.id_order DESC";
    $result = mysqli_query($conn, $query);
    $no = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column; 
        }

        body {
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 24px;
            margin: 0;
            font-family: 'Quicksand', sans-serif;
        }

        header nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
        }

        /* Wrapper untuk konten utama */
        .main-container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
        }

        /* Profil Section */
        .profile-container {
            flex: 0 0 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-right: 20px;
            margin-bottom: 20px;
            height: auto;
        }

        .profile-container img {
            border-radius: 50%;
            width: 155px;
            height: 155px;
            margin-bottom: 0;
        }

        .profile-container p {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 50px;
            margin-top: 5px;
            font-family: 'Quicksand', sans-serif;
        }

        .profile-container a {
            color: #000;
            text-decoration: none;
            font-size: 15px;
        }

        .profile-container a:hover {
            color: #555;
        }

        .profile-container {
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }

        .profile-container:hover {
            transform: translateZ(20px);  
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);  
        }

        .profile-container .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
        }

        .profile-container .user-info i {
            margin-right: 10px;
        }

        .profile-container .order-history {
            font-size: 18px;
            color: #000; 
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .profile-container .order-history i {
            margin-right: 8px;
            color: #000;  
        }

        /* Order History Section */
        .order-history-container {
            flex: 1;
            overflow-x: auto;
            margin-bottom: 20px;
            
        }

        table {
            width: 100%;
            border-collapse: collapse;
            
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

      

    </style>
</head>
<body>

<section id="header">
        <a href="#"><img src="img/bagitup.png" class= "logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a class="active"href="index.php">Beranda</a></li>
                <li><a href="shop.php">Produk</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Hubungi Kami</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li><!--notifikasi keranjang-->
                <li><a href="user.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

<div class="main-container">
    <!-- Profil yang berada di kiri -->
    <div class="profile-container">
        <img src="img/bahan/hani.jpg" alt="Profile Picture">
        <p>hani22._.</p>
        
        <div class="user-info">
            <i class="fas fa-user"></i> 
            <a href="user.php">Akun Saya</a>
        </div>
        
        <div class="order-history">
            <i class="fas fa-clock"></i> 
            <a href="orderhistory.php">Riwayat Pesanan</a>
        </div>
    </div>

    <!-- Tabel Order History yang berada di kanan -->
    <div class="order-history-container">
        <h2>Riwayat Pesanan ________________
        </h2>
        <table >
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>SubTotal</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_order'] . "</td>";
                    echo "<td><img src='" . $row['gambar'] . "' alt='" . $row['nama_produk'] . "' style='width: 100px; height: auto;'></td>";
                    echo "<td>" . $row['nama_produk'] . "</td>";
                    echo "<td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td>Rp " . number_format($row['subtotal'], 2, ',', '.') . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['invoice'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada riwayat order.</td></tr>";
            }
            ?>                        
            </tbody>
        </table>
    </div>
</div>
<footer class="section-p1">
        <div class="col">
            <img class="logo"src="img/bagitup.png" alt="">
            <h4>Kontak</h4>
            <p><strong>Alamat:</strong>Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461</p>
            <p><strong>Telepon:</strong>+62 821 4423 2308</p>
            <p><strong>Jam operasional:</strong>10:00 - 18.00, Senin - Sabtu</p>
            <div class="follow">
                <h4>Ikuti Kami</h4>
                <div class="icon"><!--??-->
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                    <i class="fa-brands fa-snapchat"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>Tentang</h4>
            <a href="#">Tentang Kami</a><!--??-->
            <a href="#">Informasi Pengiriman</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kontak Kami</a>
        </div>
        <div class="col">
            <h4>Akun Saya</h4>
            <a href="#">Masuk</a><!--??-->
            <a href="#">Lihat Keranjang</a>
            <a href="#">Dompet Saya</a>
            <a href="#">Lacak Pesanan Saya</a>
            <a href="#">Bantuan</a>
        </div>
        <div class="copyright">
            <p>2024, PiayuPride</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
