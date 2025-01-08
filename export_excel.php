<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan.xls");
include 'database.php';
echo "<table border='1'>";
echo "<thead>
<tr>
<th>No</th>
<th>Nama Produk</th>
<th>Merk</th>
<th>Stok</th>
<th>Total</th>
</tr>
</thead>";
// Isi Tabel
$select_cart = mysqli_query($conn, "SELECT * FROM `keranjang`");
$grand_total = 0;
$no = 1;

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $sub_total = floatval($fetch_cart['harga']) * floatval($fetch_cart['kuantitas']);
        $grand_total += $sub_total;
echo "<tr>
<td>{$no}</td>
<td>{$fetch_cart['nama_produk']}</td>
<td>{$fetch_cart['merk']}</td>
<td>{$fetch_cart['kuantitas']}</td>
<td>$sub_total</td>
</tr>";
}
}
echo "</table>";
?>