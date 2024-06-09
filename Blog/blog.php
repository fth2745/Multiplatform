<?php
session_start();

// Log file path
$logFile = 'debug.log';

// Function to log messages to the file
function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

if (!isset($_SESSION['email'])) {
    logMessage("Failed forum email");
    header('Location: ../Login/login.php');
    exit();
}

$email = $_SESSION["email"];
$conn = mysqli_connect("localhost", "root", "", "kullanici1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
$uQuery->bind_param("s", $email);
$uQuery->execute();
$uResult = $uQuery->get_result();
$userInfo = $uResult->fetch_assoc();

// Kullanıcının profil resmi ve diğer bilgileri
$profileImage = $userInfo["profileImage"];
$about = $userInfo["about"];
$experience1 = $userInfo["experience1"];
$experience2 = $userInfo["experience2"];
$education1 = $userInfo["education1"];
$education2 = $userInfo["education2"];
$skill1 = $userInfo["skill1"];
$skill2 = $userInfo["skill2"];
$project1 = $userInfo["project1"];
$project2 = $userInfo["project2"];
$community = $userInfo["community"];
$linkedin = $userInfo["linkedin"];
$twitter = $userInfo["twitter"];
$facebook = $userInfo["facebook"];
$instagram = $userInfo["instagram"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="stylesheet" href="blog.css">
</head>
<body>

<header>
    <h2><?= $userInfo['username'] ?></h2>
</header>

<div class="container">

    <div class="profile">
        <div id="1" class="profile">  
            <img src="../veritabanı/uploads/<?= $userInfo["profileImage"] ?>" alt="Profil Fotoğrafı">
        </div>
        
        <div>
            <h2><?= $userInfo['username'] ?></h2>
            <p><?= $userInfo['email'] ?></p>
        </div>
    </div>

    <div class="section">
        <h2>Hakkımda</h2>
        <p><?= $userInfo['about'] ?></p>
    </div>

    <div class="section">
        <h2>Deneyim</h2>
        <p><?= $userInfo['experience1'] ?></p>
        <p><?= $userInfo['experience2'] ?></p>
    </div>

    <div class="section">
        <h2>Eğitim</h2>
        <p><?= $userInfo['education1'] ?></p>
        <p><?= $userInfo['education2'] ?></p>
    </div>

    <div class="section">
        <h2>Yetenekler</h2>
        <p><?= $userInfo['skill1'] ?></p>
        <p><?= $userInfo['skill2'] ?></p>
    </div>

    <div class="section">
        <h2>Projeler</h2>
        <p><?= $userInfo['project1'] ?></p>
        <p><?= $userInfo['project2'] ?></p>
    </div>

    <div class="section">
        <h2>Topluluklar</h2>
        <p><?= $userInfo['community'] ?></p>
    </div>
    
    <div class="section" id="social-media">
        <h2>Sosyal Medya</h2>
        <p><a href="<?= $userInfo['linkedin'] ?>" target="_blank"><img src="../icons/linkedin.png" alt="LinkedIn"></a></p>
        <p><a href="<?= $userInfo['twitter'] ?>" target="_blank"><img src="../icons/twitter.png" alt="Twitter"></a></p>
        <p><a href="<?= $userInfo['facebook'] ?>" target="_blank"><img src="../icons/facebook.png" alt="Facebook"></a></p>
        <p><a href="<?= $userInfo['instagram'] ?>" target="_blank"><img src="../icons/instagram.png" alt="Instagram"></a></p>
        <p><a href="<?= $userInfo['github'] ?>" target="_blank"><img src="../icons/github.png" alt="github"></a></p>

    </div>

    <!-- Profil Güncelleme Düğmesi -->
    <button id="openModalBtn" class="btn">Profili Güncelle</button>
<br>
<br>
<br>
    <button onclick="window.location.href = '../Giris/giris.php';" class="btn">Ana Ekrana Dön</button>
</div>

</div>

<!-- Modal -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="../veritabanı/update_profile.php" method="post" enctype="multipart/form-data">
            <label for="profileImage">Profil Fotoğrafı:</label>
            <input type="file" name="profileImage" id="profileImage"><br>

            <label for="about">Hakkımda:</label>
            <textarea name="about" id="about"><?= $userInfo['about'] ?></textarea><br>

            <label for="experience1">Deneyim 1:</label>
            <input type="text" name="experience1" id="experience1" value="<?= $userInfo['experience1'] ?>"><br>

            <label for="experience2">Deneyim 2:</label>
            <input type="text" name="experience2" id="experience2" value="<?= $userInfo['experience2'] ?>"><br>

            <label for="education1">Eğitim 1:</label>
            <input type="text" name="education1" id="education1" value="<?= $userInfo['education1'] ?>"><br>

            <label for="education2">Eğitim 2:</label>
            <input type="text" name="education2" id="education2" value="<?= $userInfo['education2'] ?>"><br>

            <label for="skill1">Yetenek 1:</label>
            <input type="text" name="skill1" id="skill1" value="<?= $userInfo['skill1'] ?>"><br>

            <label for="skill2">Yetenek 2:</label>
            <input type="text" name="skill2" id="skill2" value="<?= $userInfo['skill2'] ?>"><br>

            <label for="project1">Proje 1:</label>
            <input type="text" name="project1" id="project1" value="<?= $userInfo['project1'] ?>"><br>

            <label for="project2">Proje 2:</label>
            <input type="text" name="project2" id="project2" value="<?= $userInfo['project2'] ?>"><br>

            <label for="community">Topluluklar:</label>
            <input type="text" name="community" id="community" value="<?= $userInfo['community'] ?>"><br>

            <label for="linkedin">LinkedIn</label>
            <input type="text" name="linkedin" id="linkedin" value="<?= $userInfo['linkedin'] ?>"><br>

            <label for="twitter">Twitter:</label>
            <input type="text" name="twitter" id="twitter" value="<?= $userInfo['twitter'] ?>"><br>

            <label for="facebook">Facebook:</label>
            <input type="text" name="facebook" id="facebook" value="<?= $userInfo['facebook'] ?>"><br>

            <label for="instagram">Instagram:</label>
            <input type="text" name="instagram" id="instagram" value="<?= $userInfo['instagram'] ?>"><br>
            
            <label for="Github">github:</label>
            <input type="text" name="github" id="github" value="<?= $userInfo['github'] ?>"><br>

            <button type="submit" class="btn">Güncelle</button>
        </form>
    </div>
</div>

<script>
document.getElementById('openModalBtn').onclick = function() {
    document.getElementById('profileModal').style.display = 'block';
}

document.getElementsByClassName('close')[0].onclick = function() {
    document.getElementById('profileModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('profileModal')) {
        document.getElementById('profileModal').style.display = 'none';
    }
}
</script>

</body>
</html>
