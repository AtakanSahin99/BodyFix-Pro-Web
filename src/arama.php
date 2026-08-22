<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("Dosyalar/baglanti.php");
$vt = new Veritabani();
$baglanti = $vt->baglan();

// PROFİLE KAYDETME
if (isset($_POST['sakatlik_kaydet']) && isset($_SESSION['user_id'])) {
    $sakatlik_id = $_POST['sakatlik_id'];
    $user_id = $_SESSION['user_id'];

    $kontrol = $baglanti->prepare("SELECT id FROM potansiyel_sakatliklar WHERE user_id = ? AND sakatlik_id = ?");
    $kontrol->bind_param("ii", $user_id, $sakatlik_id);
    $kontrol->execute();

    if ($kontrol->get_result()->num_rows == 0) {
        $ekle = $baglanti->prepare("INSERT INTO potansiyel_sakatliklar (user_id, sakatlik_id) VALUES (?, ?)");
        $ekle->bind_param("ii", $user_id, $sakatlik_id);
        $ekle->execute();
        echo "<script>alert('Sakatlık profilinize eklendi!');</script>";
    } else {
        echo "<script>alert('Zaten listenizde ekli.');</script>";
    }
}

// Arama
$aranan = isset($_GET['q']) ? $_GET['q'] : '';
$sonuclar = [];

if ($aranan != "") {
    $sql = "SELECT s.*, b.bolge_adi, b.kisa_kod 
            FROM sakatliklar s 
            JOIN bolgeler b ON s.bolge_id = b.id 
            WHERE s.baslik LIKE ? 
               OR s.belirtiler LIKE ? 
               OR s.tedavi_yontemi LIKE ?";

    $param = "%" . $aranan . "%";
    $sorgu = $baglanti->prepare($sql);
    $sorgu->bind_param("sss", $param, $param, $param);
    $sorgu->execute();
    $res = $sorgu->get_result();

    while ($row = $res->fetch_assoc()) {
        $sonuclar[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Arama Sonuçları - BodyFix</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2964/2964514.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            width: 260px;
            background-color: #fff;
            border-right: 1px solid #eee;
            position: fixed;
            top: 83px;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
        }

        .main-container {
            margin-left: 260px;
            margin-top: 20px;
            padding: 40px;
            min-height: 100vh;
        }

        .search-header {
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }

        .search-title {
            font-family: 'Oswald', sans-serif;
            font-size: 2rem;
            color: #333;
        }

        .search-term {
            color: #d62828;
            font-style: italic;
        }

        /* KART TASARIM */
        .med-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 40px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            position: relative;
        }

        .med-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 6px;
            background: #ccc;
        }

        .border-yuksek::before {
            background: #e74c3c;
        }

        .border-orta::before {
            background: #f39c12;
        }

        .border-dusuk::before {
            background: #27ae60;
        }

        .med-header {
            padding: 25px 30px;
            background: #fdfdfd;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .med-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            font-family: 'Oswald', sans-serif;
        }

        .risk-badge {
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #fff;
        }

        .bg-yuksek {
            background: #e74c3c;
        }

        .bg-orta {
            background: #f39c12;
        }

        .bg-dusuk {
            background: #27ae60;
        }

        .med-body {
            padding: 30px;
        }

        /* Satır aralıkları */
        .symptom-box {
            background: #fff5f5;
            border-left: 4px solid #e74c3c;
            padding: 15px 20px;
            color: #c0392b;
            font-style: italic;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .bolge-tag {
            background: #eee;
            color: #555;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 10px;
        }

        .med-footer {
            padding: 20px 30px;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-detail {
            background: #2d3748;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-save {
            background: transparent;
            border: 2px solid #2d3748;
            color: #2d3748;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover {
            background: #2d3748;
            color: white;
        }
    </style>
</head>

<body>

    <?php include("menu.php"); ?>
    <?php include("sidebar.php"); ?>

    <div class="main-container">

        <div class="search-header">
            <?php if ($aranan): ?>
                <h1 class="search-title">Arama Sonuçları: <span
                        class="search-term">"<?php echo htmlspecialchars($aranan); ?>"</span></h1>
                <p><?php echo count($sonuclar); ?> sonuç bulundu.</p>
            <?php else: ?>
                <h1 class="search-title">Arama Yapın</h1>
                <p>Lütfen yukarıdaki arama çubuğunu kullanın.</p>
            <?php endif; ?>
        </div>

        <?php if (count($sonuclar) > 0): ?>
            <?php foreach ($sonuclar as $sakatlik): ?>
                <?php
                $riskClass = 'bg-dusuk';
                $borderClass = 'border-dusuk';
                if (strpos($sakatlik['risk_seviyesi'], 'Yüksek') !== false) {
                    $riskClass = 'bg-yuksek';
                    $borderClass = 'border-yuksek';
                } elseif (strpos($sakatlik['risk_seviyesi'], 'Orta') !== false) {
                    $riskClass = 'bg-orta';
                    $borderClass = 'border-orta';
                }
                ?>

                <div class="med-card <?php echo $borderClass; ?>">
                    <div class="med-header">
                        <div style="display:flex; align-items:center;">
                            <span class="bolge-tag"><?php echo $sakatlik['bolge_adi']; ?></span>
                            <div class="med-title"><?php echo htmlspecialchars($sakatlik['baslik']); ?></div>
                        </div>
                        <span
                            class="risk-badge <?php echo $riskClass; ?>"><?php echo htmlspecialchars($sakatlik['risk_seviyesi']); ?></span>
                    </div>

                    <div class="med-body">
                        <div class="symptom-box">
                            <strong>Belirtiler:</strong><br>
                            <?php echo nl2br(htmlspecialchars($sakatlik['belirtiler'])); ?>
                        </div>

                        <p style="color:#666; line-height: 1.6;">
                            <strong>Tedavi (Özet):</strong><br>
                            <?php echo nl2br(mb_substr($sakatlik['tedavi_yontemi'], 0, 150)) . '...'; ?>
                        </p>
                    </div>

                    <div class="med-footer">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST">
                                <input type="hidden" name="sakatlik_id" value="<?php echo $sakatlik['id']; ?>">
                                <button type="submit" name="sakatlik_kaydet" class="btn-save">☆ PROFİLE EKLE</button>
                            </form>
                        <?php else: ?>
                            <span style="font-size:0.8rem; color:#999;">Kaydetmek için giriş yapın</span>
                        <?php endif; ?>

                        <a href="detay.php?bolge=<?php echo $sakatlik['kisa_kod']; ?>" class="btn-detail">
                            TAMAMINI OKU ➜
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php elseif ($aranan != ""): ?>
            <div style="text-align:center; margin-top:50px;">
                <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="100" style="opacity:0.5">
                <h3>Sonuç Bulunamadı</h3>
                <p>Farklı anahtar kelimelerle tekrar deneyin.</p>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>