<?php
// Veritabanı bağlantısını dahil et
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION["email"] = $email; 
    // Kullanıcıyı sorgula
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Kullanıcı bulundu
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Giriş başarılı, anasayfaya yönlendir
            header("Location: ../Giris/Giris.php");
            exit();
        } else {
            // Yanlış şifre, hata mesajıyla geri yönlendir
            header("Location: ../Login/login.php");
            exit();
        }
    } else {
        // Kullanıcı bulunamadı, hata mesajıyla geri yönlendir
        header("Location: Location: ../Login/login.php");
        exit();
    }
    
    // Bağlantıyı kapat
    $conn->close();
}
?>
