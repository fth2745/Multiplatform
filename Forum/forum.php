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
if(!isset($_SESSION['email'])){
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
$pQuery = $conn->prepare("SELECT profileimage FROM users WHERE id = ?");
$pQuery->bind_param("i", $userId); 
$pQuery->execute();
$pResult = $pQuery->get_result();
$pInfo = $pResult->fetch_assoc();

// Gönderileri al
$fArray = [];
$fQuery = $conn->prepare("SELECT posts.postText, posts.postImage, users.username AS username, users.profileImage AS profileImage FROM posts LEFT JOIN users ON posts.user_id = users.id");
$fQuery->execute();
$fResult = $fQuery->get_result();

while($row = $fResult->fetch_assoc()) {
    $fArray[] = $row;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
<section class="main">
    <div class="navigate">
        <ul>
            <img src="../veritabanı/uploads/<?= $pInfo["profileimage"]?>" alt="" id="profile-pic" class="yuvarlak">
            <a href="../Giris/giris.php"><li>Ana Sayfa</li> <br></a>
            <a href="../blog/blog.php" ><li>Profil</li> <br></a>
            <br>
            <br>
            <button id="buton">Gönderi paylaş <img src="icons/post.png" alt=""></button>
            <br>
            <br>
            <br>
            <br>
            <br>
            <a href="../veritabanı/logout.php" ><li>Çıkış Yap</li></a>
        </ul>
    </div>
    <div class="Hepsi">
        <div class="Time">
            <div id="a" class="Time">
                <h3>Size Özel Akış</h3>
            </div>

        </div>
        <div class="container">
            <?php foreach($fArray as $post) { ?>
                <div>
                    <div id="ppost-info">
                        <img src="../veritabanı/uploads/<?= $post["profileImage"]?>" alt="" class="yuvarlak" id="post-profile-pic">
                        <p id="pp-name">@<?= $post["username"]?></p>
                    </div>
                    <div id="post-inside">
                        <p><?= $post["postText"]?></p>
                        <img src="../veritabanı/uploads/<?= $post["postImage"]?>" alt="">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<!-- Modal -->
  <div id="myModal" class="modal">
          <div class="modal-content">
              <span class="close">&times;</span>
              <form id="post-form" method="POST" enctype="multipart/form-data" action="../veritabanı/post_process.php">
                  <label for="postText">Gönderi Metni:</label>
                  <textarea id="postText" name="postText" required></textarea>
                  <label for="postImage">Gönderi Resmi:</label>
                  <input type="file" id="postImage" name="postImage" accept="image/*" required>
                  <button type="submit">Gönder</button>
              </form>
          </div>
      </div>

      <script>
          // Modal kontrol
          var modal = document.getElementById("myModal");
          var btn = document.getElementById("buton");
          var span = document.getElementsByClassName("close")[0];

          btn.onclick = function() {
              modal.style.display = "block";
          }

          span.onclick = function() {
              modal.style.display = "none";
          }

          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          }
      </script>
</section>

</body>
</html>
