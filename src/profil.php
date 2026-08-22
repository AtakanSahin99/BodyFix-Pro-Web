<?php
session_start();
// Giriş yapılmamışsa at
if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
}

include("Dosyalar/baglanti.php");
$vt = new Veritabani();
$baglanti = $vt->baglan();
$user_id = $_SESSION['user_id'];

// AĞRI EKLEME 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agri_ekle'])) {
    $bolge_id = $_POST['bolge_id'];
    $agri_seviyesi = $_POST['agri_seviyesi'];
    $notlar = $_POST['notlar'];

    $ekle = $baglanti->prepare("INSERT INTO agri_takip (user_id, bolge_id, agri_seviyesi, notlar) VALUES (?, ?, ?, ?)");
    $ekle->bind_param("iiis", $user_id, $bolge_id, $agri_seviyesi, $notlar);
    $ekle->execute();

    // grafiği gitmek için yönlendirme
    header("Location: profil.php?filter_bolge=" . $bolge_id);
    exit;
}

// SİLME
if (isset($_GET['sil_agri'])) {
    $baglanti->query("DELETE FROM agri_takip WHERE id=" . $_GET['sil_agri'] . " AND user_id=$user_id");
    // Silince mevcut filtrede kalsın
    $redirect = isset($_GET['filter_bolge']) ? "?filter_bolge=" . $_GET['filter_bolge'] : "";
    header("Location: profil.php" . $redirect);
    exit;
}
if (isset($_GET['sil_potansiyel'])) {
    $baglanti->query("DELETE FROM potansiyel_sakatliklar WHERE id=" . $_GET['sil_potansiyel'] . " AND user_id=$user_id");
    header("Location: profil.php");
    exit;
}

// VERİ ÇEKME
$bolgeler = $baglanti->query("SELECT * FROM bolgeler"); 
$bolgeler_filtre = $baglanti->query("SELECT * FROM bolgeler"); 

// Geçmiş Listesi
$gecmis = $baglanti->query("SELECT a.*, b.bolge_adi FROM agri_takip a JOIN bolgeler b ON a.bolge_id = b.id WHERE a.user_id = $user_id ORDER BY a.tarih DESC");

// Potansiyel Sakatlık
$potansiyel = $baglanti->query("SELECT p.id as kayit_id, s.baslik, s.risk_seviyesi, b.bolge_adi FROM potansiyel_sakatliklar p JOIN sakatliklar s ON p.sakatlik_id = s.id JOIN bolgeler b ON s.bolge_id = b.id WHERE p.user_id = $user_id ORDER BY p.kayit_tarihi DESC");

// GRAFİK FİLTRELEME
$filter_bolge = isset($_GET['filter_bolge']) ? $_GET['filter_bolge'] : 'all';
$grafikBaslik = "Genel Ağrı Ortalaması";

$sqlGrafik = "SELECT agri_takip.tarih, agri_takip.agri_seviyesi, bolgeler.bolge_adi 
              FROM agri_takip 
              JOIN bolgeler ON agri_takip.bolge_id = bolgeler.id
              WHERE user_id = $user_id ";

if ($filter_bolge != 'all' && is_numeric($filter_bolge)) {
    $sqlGrafik .= " AND bolge_id = $filter_bolge ";

    // bölge adını bul
    $bolgeAdoSorgu = $baglanti->query("SELECT bolge_adi FROM bolgeler WHERE id = $filter_bolge");
    $bAd = $bolgeAdoSorgu->fetch_assoc();
    $grafikBaslik = $bAd['bolge_adi'] . " Bölgesi Ağrı Grafiği";
}

$sqlGrafik .= " ORDER BY tarih DESC LIMIT 15"; 

$grafikSorgu = $baglanti->query($sqlGrafik);

$grafikTarih = [];
$grafikPuan = [];

while ($g = $grafikSorgu->fetch_assoc()) {
    $grafikTarih[] = date("d.m", strtotime($g['tarih']));
    $grafikPuan[] = $g['agri_seviyesi'];
}
// eskiden yeniye sırala
$grafikTarih = array_reverse($grafikTarih);
$grafikPuan = array_reverse($grafikPuan);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Profil - BodyFix</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2964/2964514.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        .user-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            height: fit-content;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .avatar {
            width: 80px;
            height: 80px;
            background: #eee;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        /*çıkış butonu*/

        .btn-logout {
            display: block;
            width: 80%;
            margin: 15px auto 0 auto;
            background: #333;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            box-sizing: border-box;
        }

        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        h2 {
            margin-top: 0;
            color: #d62828;
            font-family: 'Oswald', sans-serif;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            font-size: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            margin-top: 20px;
        }

        /* Form Elemanları */
        .agri-form {
            display: grid;
            grid-template-columns: 1fr 1fr 2fr auto;
            gap: 15px;
            align-items: end;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-ekle {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            height: 40px;
            font-weight: bold;
        }

        /* FİLTRE DROPDOWN STİLİ */
        .filter-select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #d62828;
            color: #d62828;
            font-weight: bold;
            cursor: pointer;
            background: white;
        }

        /* Tablo */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8f8f8;
            color: #555;
            font-size: 0.85rem;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .low {
            background: #27ae60;
        }

        .medium {
            background: #f39c12;
        }

        .high {
            background: #c0392b;
        }

        .potansiyel-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .p-item {
            background: #fff5f5;
            border: 1px solid #ffcccc;
            padding: 15px;
            border-radius: 8px;
            position: relative;
        }

        .p-title {
            font-weight: bold;
            color: #c0392b;
            display: block;
            margin-bottom: 5px;
        }

        .p-sub {
            font-size: 0.85rem;
            color: #666;
        }

        .btn-x {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #999;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-x:hover {
            color: red;
        }

        @media (max-width: 768px) {
            .agri-form {
                grid-template-columns: 1fr;
            }

            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include("menu.php"); ?>

    <div class="container">
        <div class="user-card">
            <div class="avatar">📊</div>
            <h3><?php echo htmlspecialchars($_SESSION['ad_soyad']); ?></h3>
            <p style="color:#777; font-size:0.9rem;">BodyFix Üyesi</p>
            <a href="cikis.php" class="btn-logout">ÇIKIŞ</a>
        </div>

        <div style="width: 100%;">

            <div class="content-card">
                <h2>
                    📈 <?php echo $grafikBaslik; ?>

                    <form method="GET" style="margin:0;">
                        <select name="filter_bolge" class="filter-select" onchange="this.form.submit()">
                            <option value="all">Tüm Bölgeler</option>
                            <?php while ($b = $bolgeler_filtre->fetch_assoc()): ?>
                                <option value="<?php echo $b['id']; ?>" <?php echo ($filter_bolge == $b['id']) ? 'selected' : ''; ?>>
                                    <?php echo $b['bolge_adi']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </form>
                </h2>

                <?php if (count($grafikPuan) > 0): ?>
                    <div class="chart-container">
                        <canvas id="agriGrafigi"></canvas>
                    </div>
                <?php else: ?>
                    <div style="text-align:center; padding:50px; color:#999;">
                        Bu bölge için henüz veri girişi yok.
                    </div>
                <?php endif; ?>
            </div>

            <div class="content-card">
                <h2>⚠️ Potansiyel Sakatlıklarım (Favoriler)</h2>
                <?php if ($potansiyel->num_rows > 0): ?>
                    <div class="potansiyel-list">
                        <?php while ($p = $potansiyel->fetch_assoc()): ?>
                            <div class="p-item">
                                <a href="?sil_potansiyel=<?php echo $p['kayit_id']; ?>" class="btn-x"
                                    onclick="return confirm('Silinsin mi?')">×</a>
                                <span class="p-title"><?php echo $p['baslik']; ?></span>
                                <div class="p-sub">Bölge: <?php echo $p['bolge_adi']; ?></div>
                                <div class="p-sub">Risk: <?php echo $p['risk_seviyesi']; ?></div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p style="color:#999; font-style:italic;">Henüz bir sakatlık kaydetmediniz.</p>
                <?php endif; ?>
            </div>

            <div class="content-card">
                <h2>📝 Günlük Ağrı Girişi</h2>
                <form method="POST" class="agri-form">
                    <input type="hidden" name="agri_ekle" value="1">
                    <select name="bolge_id" class="form-control" required>
                        <option value="">Bölge Seç...</option>
                        <?php while ($b = $bolgeler->fetch_assoc()): ?>
                            <option value="<?php echo $b['id']; ?>"><?php echo $b['bolge_adi']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <select name="agri_seviyesi" class="form-control">
                        <?php for ($i = 1; $i <= 10; $i++):
                            echo "<option value='$i'>$i. Seviye</option>";
                        endfor; ?>
                    </select>
                    <input type="text" name="notlar" class="form-control" placeholder="Not ekle...">
                    <button type="submit" class="btn-ekle">KAYDET</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Tarih</th>
                            <th>Bölge</th>
                            <th>Seviye</th>
                            <th>Not</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $gecmis->fetch_assoc()):
                            $renk = ($row['agri_seviyesi'] <= 3) ? 'low' : (($row['agri_seviyesi'] <= 7) ? 'medium' : 'high');
                            ?>
                            <tr>
                                <td><?php echo date("d.m.Y", strtotime($row['tarih'])); ?></td>
                                <td><?php echo $row['bolge_adi']; ?></td>
                                <td><span class="badge <?php echo $renk; ?>"><?php echo $row['agri_seviyesi']; ?>/10</span>
                                </td>
                                <td><?php echo $row['notlar']; ?></td>
                                <td>
                                    <a href="?sil_agri=<?php echo $row['id']; ?>&filter_bolge=<?php echo $filter_bolge; ?>"
                                        style="color:#ccc; text-decoration:none;">×</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('agriGrafigi');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($grafikTarih); ?>,
                    datasets: [{
                        label: 'Ağrı Seviyesi',
                        data: <?php echo json_encode($grafikPuan); ?>,
                        borderColor: '#d62828',
                        backgroundColor: 'rgba(214, 40, 40, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#d62828'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, max: 10, title: { display: true, text: 'Ağrı Puanı' } },
                        x: { title: { display: true, text: 'Tarih' } }
                    }
                }
            });
        }
    </script>
</body>

</html>