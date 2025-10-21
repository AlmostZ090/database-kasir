<?php
include('config.php');
// Ambil data ringkasan untuk dashboard
$detail_penjualan = 0;
$query = "SELECT SUM(total_harga) AS total FROM penjualan WHERE tgl_penjualan = CURDATE()";
$result = mysqli_query($koneksi,$query);
if ($result && $row = $result->fetch_assoc()) {
    $detail_penjualan = $row['total'] ?? 0;
}

$stok_habis = 0;
$query_stok = "SELECT COUNT(*) AS count FROM produk WHERE stok <= 5"; // Produk dengan stok kritis
$result_stok = mysqli_query($koneksi,$query_stok);
if ($result_stok && $row_stok = $result_stok->fetch_assoc()) {
    $stok_habis = $row_stok['count'];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .sidebar { width: 200px; background-color: #343a40; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { padding: 10px 15px; text-decoration: none; font-size: 18px; color: white; display: block; }
        .sidebar a:hover { background-color: #495057; }
        .content { margin-left: 200px; padding: 20px; }
        .header { background-color: #007bff; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center;}
        .card { background-color: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 30%; display: inline-block; margin-right: 2%; box-sizing: border-box;}
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 style="text-align: center; margin-bottom: 30px;">APP KASIR</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="kasir.php">Transaksi Kasir</a>
        <a href="#">Manajemen Produk (Admin Only)</a>
        <a href="#">Laporan Penjualan</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Selamat Datang, <?php echo htmlspecialchars ($_SESSION['username']); ?> <?php echo ($_SESSION['role']); ?></h1>
            <p><a href="logout.php" style="color: white; text-decoration: underline;">Logout</a></p>
        </div>

        <h2>Ringkasan Hari Ini</h2>
        <div class="card">
            <h3>Penjualan Hari Ini</h3>
            <p style="font-size: 2em; color: green;">Rp <?php echo number_format($detail_penjualan, 0, ',', '.'); ?></p>
        </div>
        <div class="card">
            <h3>Stok Kritis</h3>
            <p style="font-size: 2em; color: red;"><?php echo $stok_habis; ?> Produk</p>
        </div>
        <h2>Menu Cepat</h2>
        <p>Silakan gunakan menu di samping atau tombol di bawah untuk memulai transaksi.</p>
        <p><a href="kasir.php" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">Mulai Transaksi Baru</a></p>
    </div>
</body>
</html>
