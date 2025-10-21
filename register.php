<?php
// FILE: register.php
include 'config.php'; // Hubungkan ke database

$pesan = ""; // Variabel untuk menampung pesan status

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);

    // Validasi Sederhana: Pastikan semua kolom terisi
    if (empty($username) || empty($password) || empty($level)) {
        $pesan = "kosong";
    } else {
        // 1. Enkripsi Password (WAJIB untuk keamanan)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 2. Query INSERT
        $query = "INSERT INTO login (username, password, role) VALUES ('$username', '$hashed_password', '$level')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "sukses";
        } else {
            // Error, mungkin username sudah ada (UNIQUE)
            $pesan = "error"; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register Akun Baru</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .register-box { 
            width: 350px; 
            padding: 40px; 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
        }
        h2 { 
            text-align: center; 
            color: #28a745; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }
        input[type="text"], input[type="password"], select { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            background-color: #007bff; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .alert-sukses { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
            padding: 10px; 
            margin-bottom: 15px; 
            text-align: center; 
            border-radius: 4px;
        }
        .alert-error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
            padding: 10px; 
            margin-bottom: 15px; 
            text-align: center; 
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>REGISTRASI AKUN BARU</h2>
        
        <?php if ($pesan == "sukses"): ?>
            <div class="alert-sukses">
                Registrasi berhasil! Akun telah dibuat. Silakan <a href="login.php">Login</a>.
            </div>
        <?php elseif ($pesan == "error"): ?>
            <div class="alert-error">
                Registrasi gagal. Username mungkin sudah digunakan atau terjadi kesalahan database.
            </div>
        <?php elseif ($pesan == "kosong"): ?>
            <div class="alert-error">
                Semua kolom wajib diisi.
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="level" required>
                <option value="">Pilih Level Akses</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
            <button type="submit" name="register">DAFTAR AKUN</button>
        </form>
        
        <p style="text-align:center; margin-top:15px;"><a href="login.php">Sudah punya akun? Login di sini.</a></p>
    </div>
</body>
</html>