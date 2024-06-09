<?php
// Veritabanı bağlantısını dahil et
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Şifreyi hashle
   
   
   
    $profileImage= 'security.png';

    // Veriyi ekle
    $sql = "INSERT INTO users (username, email, password, profileImage) VALUES ('$username', '$email', '$password', '$profileImage')";
    
    if ($conn->query($sql) === TRUE) {
        // Kayıt başarılı, giriş sayfasına yönlendir
        header("Location: ../login/login.php");
        exit();
    } else {
        // Kayıt başarısız, hata mesajıyla geri yönlendir
        header("Location: ../login/login.php");
        exit();
    }
    
    // Bağlantıyı kapat
    $conn->close();
}
?>
