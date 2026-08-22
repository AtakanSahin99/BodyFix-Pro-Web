<?php
session_start();
include("Dosyalar/baglanti.php");

$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vt = new Veritabani();
    $baglanti = $vt->baglan();

    $email = $_POST['email'];
    $sifre = md5($_POST['sifre']);

    // Kullanıcıyı sorgula
    $sorgu = $baglanti->prepare("SELECT * FROM users WHERE email = ? AND sifre = ?");
    $sorgu->bind_param("ss", $email, $sifre);
    $sorgu->execute();
    $sonuc = $sorgu->get_result();
    $kullanici = $sonuc->fetch_assoc();

    if ($kullanici) {
        $_SESSION['user_id'] = $kullanici['id'];
        $_SESSION['ad_soyad'] = $kullanici['ad_soyad'];
        $_SESSION['rol'] = $kullanici['rol'];

        header("Location: profil.php");
        exit;
    } else {
        $hata = "E-posta veya şifre hatalı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - BodyFix PRO</title>
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
            background-color: #d62828;
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
            background-color: #b01f1f;
        }

        .hata-kutusu {
            background-color: #ffe6e6;
            color: #d62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        /* Link Alanı */
        .alt-linkler {
            margin-top: 25px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 0.95rem;
        }

        .kayit-link {
            color: #1a1a1a;
            text-decoration: none;
            font-weight: 500;
        }

        .kayit-link span {
            color: #d62828;
            font-weight: bold;
            text-decoration: underline;
        }

        .kayit-link:hover span {
            color: #b01f1f;
        }

        .geri-don {
            display: block;
            margin-top: 15px;
            color: #999;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .geri-don:hover {
            color: #666;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <a href="vucud.php" class="logo">Body<span>Fix</span> PRO</a>
        <p class="baslik">Sporcu Analiz Sistemine Giriş</p>

        <?php if ($hata): ?>
            <div class="hata-kutusu"><?php echo $hata; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="E-Posta Adresi" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit" class="btn-giris">GİRİŞ YAP</button>
        </form>

        <div class="alt-linkler">
            <a href="kayit.php" class="kayit-link">Hesabın yok mu? <span>Hemen Kayıt Ol</span></a>
            <a href="vucud.php" class="geri-don">← Ana Sayfaya Dön</a>
        </div>
    </div>

</body>