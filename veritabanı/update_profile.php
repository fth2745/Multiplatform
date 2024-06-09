<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location:../Login/login.php');
    exit();
}

$email = $_SESSION["email"];
$conn = mysqli_connect("localhost", "root", "", "kullanici1");
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 

// Kullanıcı bilgilerini güncelleme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profileImage = $_FILES["profileImage"]["name"];
    $about = $_POST["about"];
    $experience1 = $_POST["experience1"];
    $experience2 = $_POST["experience2"];
    $education1 = $_POST["education1"];
    $education2 = $_POST["education2"];
    $skill1 = $_POST["skill1"];
    $skill2 = $_POST["skill2"];
    $project1 = $_POST["project1"];
    $project2 = $_POST["project2"];
    $community = $_POST["community"];

    // Profil resmini yükleme
    if ($profileImage) {
        $targetDir = "../veritabanı/uploads/";
        $targetFile = $targetDir . basename($profileImage);
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile);
    } else {
        $profileImage = $userInfo["profileImage"];
    }

    $uQuery = $conn->prepare("UPDATE users SET profileImage=?, about=?, experience1=?, experience2=?, education1=?, education2=?, skill1=?, skill2=?, project1=?, project2=?, community=? WHERE email=?");
    $uQuery->bind_param("ssssssssssss", $profileImage, $about, $experience1, $experience2, $education1, $education2, $skill1, $skill2, $project1, $project2, $community, $email);

    if ($uQuery->execute()) {
        header("Location: ../blog/blog.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
