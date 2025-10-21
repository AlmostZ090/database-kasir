<?php
// FILE: login.php
// Pastikan config.php sudah ada dan mengandung session_start() jika belum ada, 
// atau tambahkan session_start() di baris pertama file ini.
include 'config.php'; // Hubungkan ke database

// Jika user sudah login, langsung tendang ke dashboard.
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $_SESSION['akbar'] = $akbar;
    
    header("Location: dashboard.php");
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // 1. Ambil data user dari database berdasarkan username
    $query = "SELECT * FROM login WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($data = mysqli_fetch_assoc($result)) {
        // 2. Verifikasi Password: Menggunakan password_verify untuk password terenkripsi
        if (password_verify($password, $data['password'])) {
            
            // 3. Password BENAR, buat SESSION
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['level']    = $data['level'];
            $_SESSION['id_user']  = $data['id_user'];
            
            // 4. Redirect ke Dashboard
            header("Location: dashboard.php");
        } else {
            $pesan = "password_salah"; // Password tidak cocok
        }
    } else {
        $pesan = "user_tidak_ditemukan"; // Username tidak ditemukan
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Sistem Kasir</title>
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
        .login-box { 
            width: 350px; 
            padding: 40px; 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
        }
        h2 { 
            text-align: center; 
            color: #007bff; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            background-color: #28a745; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #1e7e34;
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
    <div class="login-box">
        <h2>LOGIN SISTEM KASIR</h2>
        
        <?php if ($pesan == "password_salah" || $pesan == "user_tidak_ditemukan"): ?>
            <div class="alert-error">Username atau Password salah!</div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">LOGIN</button>
        </form>
        
        <p style="text-align:center; margin-top:15px;"><a href="register.php">Belum punya akun? Daftar di sini.</a></p>
    </div>
</body>
</html>