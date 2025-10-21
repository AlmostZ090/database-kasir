<?php
include('config.php');

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan ke halaman login
header("location: login.php");
exit;
?>