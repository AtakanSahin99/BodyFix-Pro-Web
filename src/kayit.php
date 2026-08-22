<?php
include("Dosyalar/baglanti.php");

$mesaj = "";
$mesajTuru = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vt = new Veritabani();
    $baglanti = $vt->baglan();

    $ad_soyad = $_POST['ad_soyad'];
    $email = $_POST['email'];
    $sifre = md5($_POST['sifre']); // Şifreleme

    // e-posta daha önce alınmış mı
    $kontrol = $baglanti->prepare("SELECT id FROM users WHERE email = ?");
    $kontrol->bind_param("s", $email);
    $kontrol->execute();
    $sonuc = $kontrol->get_result();

    if ($sonuc->num_rows > 0) {
        $mesaj = "Bu e-posta adresi zaten kayıtlı!";
        $mesajTuru = "error";
    } else {
        // Kayıt
        $ekle = $baglanti->prepare("INSERT INTO users (ad_soyad, email, sifre, rol) VALUES (?, ?, ?, 'uye')");
        $ekle->bind_param("sss", $ad_soyad, $email, $sifre);

        if ($ekle->execute()) {
            $mesaj = "Kayıt başarılı! Giriş sayfasına yönlendiriliyorsunuz...";
            $mesajTuru = "success";
            header("refresh:2;url=giris.php"); // 2 saniye sonra giriş'e atar
        } else {
            $mesaj = "Bir hata oluştu: " . $baglanti->error;
            $mesajTuru = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - BodyFix PRO</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 5px solid #d62828;
        }

        .logo {
            font-family: 'Oswald', sans-serif;
            font-size: 2rem;
            color: #1a1a1a;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            text-decoration: none;
        }

        .logo span {
            color: #d62828;
            font-style: italic;
        }

        .baslik {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .btn-giris {
            width: 100%;
            background-color: #1a1a1a;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-giris:hover {
            background-color: #d62828;
        }

        .mesaj-kutusu {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #ffe6e6;
            color: #721c24;
        }

        .link-alani {
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .link-alani a {
            color: #d62828;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <a href="vucud.php" class="logo">Body<span>Fix</span> PRO</a>
        <p class="baslik">Yeni Sporcu Hesabı Oluştur</p>

        <?php if ($mesaj): ?>
            <div class="mesaj-kutusu <?php echo $mesajTuru; ?>"><?php echo $mesaj; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="ad_soyad" placeholder="Ad Soyad" required>
            <input type="email" name="email" placeholder="E-Posta Adresi" required>
            <input type="password" name="sifre" placeholder="Şifre Oluştur" required>
            <button type="submit" class="btn-giris">KAYIT OL</button>
        </form>

        <div class="link-alani">
            Zaten hesabın var mı? <a href="giris.php">Giriş Yap</a>
        </div>
    </div>
</body>

</html>