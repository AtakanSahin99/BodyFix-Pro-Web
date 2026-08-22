<?php
session_start();
if (file_exists('Dosyalar/baglanti.php')) { include 'Dosyalar/baglanti.php'; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - BodyFix PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <style>
        /* Kaydırma sorununu burada da çözelim */
        * { box-sizing: border-box; }
        body { background: #f0f2f5; font-family: 'Roboto', sans-serif; display:flex; flex-direction:column; min-height:100vh; margin:0; }
        
        /* Düzen */
        .page-wrapper { display: flex; max-width: 1400px; margin: 0 auto; width: 100%; flex-grow: 1; }
        .main-content { flex: 1; padding: 40px; }
        .sidebar-area { width: 260px; flex-shrink: 0; } /* Sol menü alanı */
        
        .about-card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #d62828; }
        
        h1, h3 { font-family: 'Oswald', sans-serif; color: #1a1a1a; text-transform: uppercase; }
        p { color: #555; line-height: 1.7; }
        
        footer { margin-top: auto; padding: 20px; text-align: center; color: #888; background: #e9ecef; width: 100%; }
        
        @media (max-width: 900px) { 
            .page-wrapper { flex-direction: column; }
            .sidebar-area { width: 100%; }
            .main-content { padding: 20px; }
        }
    </style>
</head>
<body>

    <?php include("menu.php"); ?>

    <div class="page-wrapper">
        <div class="sidebar-area">
            <?php include("sidebar.php"); ?>
        </div>

        <div class="main-content">
            <h1 class="mb-4">Hakkımızda</h1>
            
            <div class="row">
                <div class="col-md-7">
                    <div class="about-card">
                        <h3>BodyFix PRO Nedir?</h3>
                        <p>Sporcuların sakatlıklarını takip etmesi için geliştirilmiş profesyonel bir sistemdir.</p>
                        <p>Güvenilir tıbbi kaynaklara dayalı verilerle rehberlik ediyoruz.</p>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="about-card text-center">
                        <h4>Proje Geliştiricisi</h4>
                        <p><b>Atakan</b></p>
                        <span class="badge bg-danger">Web Tasarım Dersi</span>
                    </div>

                    <div class="about-card">
                        <h3>İletişim</h3>
                        <form action="" method="POST">
                            <input type="text" class="form-control mb-2" placeholder="Adınız" required>
                            <input type="email" class="form-control mb-2" placeholder="E-posta" required>
                            <textarea class="form-control mb-2" rows="3" placeholder="Mesajınız..."></textarea>
                            <button class="btn btn-dark w-100">GÖNDER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>© 2025 BODYFIX PRO</footer>
</body>
</html>