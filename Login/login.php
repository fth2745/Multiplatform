<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Modern Giriş Sayfası</title>
</head>
<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="../veritabanı/register_process.php" method="post">
                <h1>Hesap Oluştur</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>veya kayıt için e-postanızı kullanın</span>
                <input type="text" name="username" placeholder="Ad" required>
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Kayıt Ol</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="../veritabanı/login_process.php" method="post">
                <h1>Giriş Yap</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>veya giriş için e-postanızı kullanın</span>
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <a href="#">Şifrenizi mi unuttunuz?</a>
                <button type="submit">Giriş Yap</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Hoş Geldiniz!</h1>
                    <p>Tüm site özelliklerini kullanabilmek için kişisel bilgilerinizi girin</p>
                    <button class="hidden" id="login">Giriş Yap</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Merhaba, aramıza katılmaya ne dersin</h1>
                    <p>Tüm site özelliklerinden yararlanmak için kişisel bilgilerinizle kaydolun</p>
                    <button class="hidden" id="register">Kayıt Ol</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
