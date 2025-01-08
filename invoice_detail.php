<?php
// Koneksi ke database
$host = 'localhost';
$pengguna = 'root';
$kata_sandi = '';
$database = 'dbpbl';

$conn = new mysqli($host, $pengguna, $kata_sandi, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan ID pesanan diteruskan melalui URL dan valid
$id_pesanan = isset($_GET['id_pesanan']) && is_numeric($_GET['id_pesanan']) ? $_GET['id_pesanan'] : null;

// Jika ID pesanan tidak ada atau tidak valid
if ($id_pesanan === null) {
    die("ID pesanan tidak ditemukan.");
}

$sql = "SELECT o.tanggal_pesanan, o.jumlah_total, o.status
        FROM orders o
        WHERE o.id_pesanan = $id_pesanan";

$result = $conn->query($sql);

if ($result === false) {
    die("Query Error: " . $conn->error); 
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Invoice</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Detail Pesanan</th>
                        <th>Informasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = $result->fetch_assoc();
                    echo "<tr><td><strong>Tanggal Pesanan:</strong></td><td>" . $row['tanggal_pesanan'] . "</td></tr>";
                    echo "<tr><td><strong>Status:</strong></td><td>" . $row['status'] . "</td></tr>";
                    echo "<tr><td><strong>Jumlah Total:</strong></td><td>Rp " . number_format($row['jumlah_total'], 0, ',', '.') . "</td></tr>";
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Data tidak Ditemukan Untuk ID pesanan: <?php echo $id_pesanan; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
