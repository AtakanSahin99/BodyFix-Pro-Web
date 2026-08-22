<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("Dosyalar/baglanti.php");

$vt = new Veritabani();
$baglanti = $vt->baglan();

// kart Kaydetme
if (isset($_POST['sakatlik_kaydet']) && isset($_SESSION['user_id'])) {
    $sakatlik_id = $_POST['sakatlik_id'];
    $user_id = $_SESSION['user_id'];

    // Kayıt Kontrol
    $kontrol = $baglanti->prepare("SELECT id FROM potansiyel_sakatliklar WHERE user_id = ? AND sakatlik_id = ?");
    $kontrol->bind_param("ii", $user_id, $sakatlik_id);
    $kontrol->execute();

    if ($kontrol->get_result()->num_rows == 0) {
        $ekle = $baglanti->prepare("INSERT INTO potansiyel_sakatliklar (user_id, sakatlik_id) VALUES (?, ?)");
        $ekle->bind_param("ii", $user_id, $sakatlik_id);
        $ekle->execute();
        echo "<script>alert('Sakatlık profilinize eklendi!');</script>";
    } else {
        echo "<script>alert('Bu sakatlık zaten profilinizde kayıtlı.');</script>";
    }
}

// bölge kodu
$aktif_kod = isset($_GET['bolge']) ? $_GET['bolge'] : '';
$seciliBolge = null;
$sakatliklar = [];

if ($aktif_kod) {
    $sorgu = $baglanti->prepare("SELECT * FROM bolgeler WHERE kisa_kod = ?");
    $sorgu->bind_param("s", $aktif_kod);
    $sorgu->execute();
    $seciliBolge = $sorgu->get_result()->fetch_assoc();

    if ($seciliBolge) {
        $bolge_id = $seciliBolge['id'];
        $sakatlikSorgu = $baglanti->prepare("SELECT * FROM sakatliklar WHERE bolge_id = ?");
        $sakatlikSorgu->bind_param("i", $bolge_id);
        $sakatlikSorgu->execute();
        $sakatlikSonuc = $sakatlikSorgu->get_result();
        while ($satir = $sakatlikSonuc->fetch_assoc()) {
            $sakatliklar[] = $satir;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>BodyFix Analiz Raporu</title>
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

        .page-header {
            margin-bottom: 40px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 20px;
        }

        .page-title {
            font-size: 2.5rem;
            color: #2c3e50;
            font-family: 'Oswald', sans-serif;
            margin: 0;
            text-transform: uppercase;
        }

        /* KART TASARIMI */
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

        .symptom-box {
            background: #fff5f5;
            border-left: 4px solid #e74c3c;
            padding: 15px 20px;
            color: #c0392b;
            font-style: italic;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }

        .treatment-text {
            color: #27ae60;
            font-weight: 500;
            line-height: 1.8;
        }

        .forbidden-text {
            color: #e74c3c;
            font-weight: 500;
            line-height: 1.8;
        }

        .extra-info-bar {
            background: #f7fafc;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border: 1px solid #e2e8f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #718096;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-value {
            display: block;
            font-size: 1.1rem;
            font-weight: bold;
            color: #2d3748;
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

        .btn-detail:hover {
            background: #e63946;
            transform: translateY(-2px);
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

        .welcome {
            text-align: center;
            margin-top: 100px;
            color: #a0aec0;
        }
    </style>
</head>

<body>

    <?php include("menu.php"); ?>
    <?php include("sidebar.php"); ?>

    <div class="main-container">
        <?php if ($seciliBolge): ?>
            <div class="page-header">
                <h1 class="page-title"><?php echo htmlspecialchars($seciliBolge['bolge_adi']); ?></h1>
                <p>Sakatlık Analiz Raporları</p>
            </div>

            <?php if (count($sakatliklar) > 0): ?>
                <?php foreach ($sakatliklar as $sakatlik): ?>
                    <?php
                    $riskClass = 'bg-dusuk';
                    $borderClass = 'border-dusuk';
                    $iyilesme = "3-7 Gün";
                    if (strpos($sakatlik['risk_seviyesi'], 'Yüksek') !== false) {
                        $riskClass = 'bg-yuksek';
                        $borderClass = 'border-yuksek';
                        $iyilesme = "4-8 Hafta";
                    } elseif (strpos($sakatlik['risk_seviyesi'], 'Orta') !== false) {
                        $riskClass = 'bg-orta';
                        $borderClass = 'border-orta';
                        $iyilesme = "2-4 Hafta";
                    }
                    ?>
                    <div class="med-card <?php echo $borderClass; ?>">
                        <div class="med-header">
                            <div class="med-title"><?php echo htmlspecialchars($sakatlik['baslik']); ?></div>
                            <span
                                class="risk-badge <?php echo $riskClass; ?>"><?php echo htmlspecialchars($sakatlik['risk_seviyesi']); ?></span>
                        </div>
                        <div class="med-body">

                            <div class="symptom-box">
                                <strong>Belirtiler:</strong><br>
                                <?php echo nl2br(htmlspecialchars($sakatlik['belirtiler'])); ?>
                            </div>

                            <div class="info-grid">
                                <div>
                                    <h4>✅ Tedavi & Öneri</h4>
                                    <div class="treatment-text">
                                        <?php echo nl2br(htmlspecialchars($sakatlik['tedavi_yontemi'])); ?>
                                    </div>
                                </div>
                                <div>
                                    <h4>⛔ Yasak / Riskli Hareketler</h4>
                                    <div class="forbidden-text">
                                        <?php echo nl2br(htmlspecialchars($sakatlik['yasak_hareket'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="extra-info-bar">
                                <div class="stat-item"><span class="stat-label">İyileşme</span><span
                                        class="stat-value"><?php echo $iyilesme; ?></span></div>
                                <div class="stat-item"><span class="stat-label">Uzman</span><span class="stat-value"
                                        style="color:#e63946"><?php echo htmlspecialchars($sakatlik['uzman_doktor']); ?></span>
                                </div>
                            </div>
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

                            <?php if (!empty($sakatlik['faydali_link'])): ?>
                                <a href="<?php echo htmlspecialchars($sakatlik['faydali_link']); ?>" target="_blank"
                                    class="btn-detail">KAYNAĞA GİT ➜</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="welcome">
                    <h3>Kayıt Bulunamadı</h3>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="welcome">
                <h2>Hoş Geldiniz!</h2>
                <p>Bölge seçiniz.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>