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
    logMessage("Failed post username");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postText = $_POST['postText'];
    $postImage = $_FILES['postImage']['name'];
    $target = "uploads/" . basename($postImage);

    if (move_uploaded_file($_FILES['postImage']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO posts (postText, postImage, user_Id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $postText, $postImage, $userId);

        if ($stmt->execute()) {
            logMessage("Post successfully uploaded by user: $userId");
            header('Location: ../Forum/forum.php');
            exit();
        } else {
            logMessage("Error: " . $stmt->error);
            echo "Error: " . $stmt->error;
        }
    } else {
        logMessage("Failed to upload image.");
        echo "Failed to upload image.";
    }
}
?>
