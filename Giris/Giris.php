<?php
session_start();

// Log file path
$logFile = 'debug.log';

// Function to log messages to the file
function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['email'])) {
    logMessage("Failed forum username");
    header('Location: ../Login/Login.php');
    exit();
}

// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "root", "", "kullanici1");
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 

// Kullanıcı bilgilerini al
$username = $_SESSION["email"];

// Kullanıcı ID'sini al
$uQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
$uQuery->bind_param("s", $username);
$uQuery->execute();
$uResult = $uQuery->get_result();
$uInfo = $uResult->fetch_assoc();
$userId = $uInfo["id"];

// Kullanıcının profil resmini al
$pQuery = $conn->prepare("SELECT profileImage FROM users WHERE id = ?");
$pQuery->bind_param("i", $userId);
$pQuery->execute();
$pResult = $pQuery->get_result();
$pInfo = $pResult->fetch_assoc();

// Gönderileri al
$posts = [];
$postQuery = $conn->prepare("SELECT posts.postText, posts.postImage, users.username AS username FROM posts LEFT JOIN users ON posts.user_Id = users.id");
$postQuery->execute();
$postResult = $postQuery->get_result();

while($row = $postResult->fetch_assoc()) {
    $posts[] = $row;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>anasayfa</title>
    <link rel="stylesheet" href="../Giris/Giris.css">
    <script src="script.js" defer></script>

</head>
<body>
    <div id="wrapper">
        <header>
            <h1>Blog</h1>
            <nav>
                <ul>
                    <li><a href="<?= $userInfo['github'] ?>" target="_blank"><img src="../icons/github.png" alt="github">Repos</li>
                    <li><a href="../Forum/forum.php"><img src="../icons/users.png" alt="">Forum</a></li>
                    <li><a href="../Blog/blog.php"><img src="../icons/heart.png" alt="">Blog</a></li>
                    <li><a href="../veritabanı/logout.php">Çıkış yap</a></li>
                </ul>
            </nav>
        </header>
    </div>
    <div class="twitter-search">
        <div class="search-container">
            <input type="text" id="search-box" placeholder="Ara">
            <button type="submit" id="search-button">
                <img src="../icons/search.png" alt="Ara">
            </button>
        </div>
    </div>
    <div class="container">
        <?php foreach($posts as $post) { ?>
            <div class="box">
                <h2><?= htmlspecialchars($post['username']) ?></h2>
                <p><?= htmlspecialchars($post['postText']) ?></p>
                <?php if (!empty($post['postImage'])) { ?>
                    <img src="../veritabanı/uploads/<?= htmlspecialchars($post['postImage']) ?>" alt="Post Image" style="max-width: 90%; border-radius: 5%;">
                <?php } ?>
                <footer><?= htmlspecialchars($post['username']) ?></footer>
            </div>
        <?php } ?>
    </div>
</body>
</html>
