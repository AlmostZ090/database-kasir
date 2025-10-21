<?php
// config.php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "db_kasir"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()){
    die("Koneksi database GAGAL: " . mysqli_connect_error());
}

?>