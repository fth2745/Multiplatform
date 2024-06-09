<?php
session_start(); // Oturumu başlat

// Oturumu sonlandır
session_unset();
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendir
header("Location: ../Login/login.php");
exit;
?>
