<?php
include('config.php');

// Ambil data produk
$products = [];
$query_prod = "SELECT ID, Nama, harga, stok FROM produk ORDER BY Nama";
$result_prod = mysqli_query($koneksi,$query_prod);
while ($row = $result_prod->fetch_assoc()) {
    $products[] = $row;
}

// Ambil data pelanggan
$customers = [];
$query_cust = "SELECT id_pelanggan, nama_pelanggan FROM pelanggan ORDER BY nama_pelanggan";
$result_cust = mysqli_query($koneksi,$query_cust);
while ($row = $result_cust->fetch_assoc()) {
    $customers[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .sidebar { width: 200px; background-color: #343a40; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { padding: 10px 15px; text-decoration: none; font-size: 18px; color: white; display: block; }
        .sidebar a:hover { background-color: #495057; }
        .content { margin-left: 200px; padding: 20px; }
        h1 { color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: white;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 style="text-align: center; margin-bottom: 30px;">APP KASIR</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="kasir.php">Transaksi Kasir</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h1>Halaman Transaksi Kasir</h1>

        <div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h2>Data Pelanggan</h2>
            <select style="padding: 10px; width: 300px;">
                <option value="">Pilih Pelanggan (Opsional)</option>
                <?php foreach ($customers as $cust): ?>
                    <option value="<?php echo $cust['id_pelanggan']; ?>"><?php echo htmlspecialchars($cust['nama_pelanggan']); ?></option>
                <?php endforeach; ?>
            </select>
            <button onclick="alert('Ini akan membuka form tambah pelanggan baru')">Tambah Pelanggan Baru</button>
        </div>

        <div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h2>Daftar Produk / Tambahkan ke Keranjang</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $prod): ?>
                    <tr>
                        <td><?php echo $prod['ID']; ?></td>
                        <td><?php echo htmlspecialchars($prod['Nama']); ?></td>
                        <td>Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $prod['stok']; ?></td>
                        <td><button onclick=>Tambah</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="background-color: #ccffcc; padding: 20px; border-radius: 8px; text-align: right;">
            <h2 style="margin: 0;">TOTAL: <span style="color: red;">Rp 0</span></h2>
            <button style="padding: 15px 30px; background-color: #f7931e; color: white; border: none; font-size: 1.2em; margin-top: 10px;" onclick="alert('Logika PHP/SQL untuk menyimpan transaksi ke database penjualan dan detail_penjualan')">BAYAR & SELESAIKAN</button>
        </div>
    </div>
</body>
</html>
