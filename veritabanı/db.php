<?php
// db.php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kullanici1";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
