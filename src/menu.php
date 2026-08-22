<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

<style>
    /* KRİTİK DÜZELTME: Bu satır sayfanın taşmasını engeller */
    * {
        box-sizing: border-box;
    }

    nav {
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%; /* box-sizing sayesinde artık taşma yapmaz */
        height: 80px;
        border-bottom: 3px solid #d62828;
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .logo {
        font-family: 'Oswald', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: 1px;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap; /* Logo mobilde kırılmasın */
    }

    .logo span {
        color: #d62828;
        font-style: italic;
    }

    .search-box {
        flex: 1;
        max-width: 400px;
        margin: 0 20px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px;
        border-radius: 50px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        font-family: 'Roboto', sans-serif;
        padding-right: 40px;
        outline: none;
        transition: 0.3s;
    }

    .search-input:focus {
        border-color: #d62828;
        background: #fff;
        box-shadow: 0 0 5px rgba(214, 40, 40, 0.2);
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: #666;
    }

    .menu-links {
        display: flex;
        gap: 20px;
        align-items: center;
        white-space: nowrap;
    }

    .menu-links a {
        text-decoration: none;
        color: #1a1a1a;
        font-family: 'Oswald', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        text-transform: uppercase;
        transition: color 0.3s;
    }

    .menu-links a:hover {
        color: #d62828;
    }

    .btn-profil {
        background-color: #1a1a1a;
        color: white !important;
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 0.9rem;
    }

    .btn-profil:hover {
        background-color: #d62828 !important;
    }

    /* Mobil Düzenleme */
    @media (max-width: 900px) {
        nav {
            flex-direction: column;
            height: auto;
            padding: 15px;
            gap: 15px;
        }

        .search-box {
            width: 100%;
            margin: 0;
            order: 2;
        }

        .menu-links {
            order: 3;
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }
    }
</style>

<nav>
    <a href="vucud.php" class="logo">Body<span>Fix</span> PRO</a>

    <form action="arama.php" method="GET" class="search-box">
        <input type="text" name="q" class="search-input" placeholder="Ara... (Örn: Omuz)">
        <button type="submit" class="search-btn">🔍</button>
    </form>

    <div class="menu-links">
        <a href="vucud.php">Ana Sayfa</a>
        <a href="detay.php">Rehber</a>
        <a href="hakkimizda.php">Hakkımızda</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profil.php" class="btn-profil">👤 Profil</a>
        <?php else: ?>
            <a href="giris.php">Giriş Yap</a>
            <a href="kayit.php" style="color:#d62828;">Kayıt Ol</a>
        <?php endif; ?>
    </div>
</nav>