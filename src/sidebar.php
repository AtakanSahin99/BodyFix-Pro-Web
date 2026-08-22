<?php
// Sidebar
if(!isset($baglanti)) {
    include("Dosyalar/baglanti.php");
    $vt = new Veritabani();
    $baglanti = $vt->baglan();
}
?>

<style>
    .sidebar {
        width: 260px;
        background-color: #ffffff;
        border-right: 1px solid #eee;
        position: fixed;
        top: 83px; /* Menünün hemen altı */
        bottom: 0;
        overflow-y: auto;
        z-index: 100;
        padding-top: 10px;
        font-family: 'Roboto', sans-serif;
    }

    /* Slogan Alanı */
    .slogan-box {
        padding: 20px;
        margin: 0 15px 20px 15px;
        background: linear-gradient(135deg, #e63946, #d62828);
        color: white;
        text-align: center;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
    }

    .slogan-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin: 0;
        font-family: 'Oswald', sans-serif;
        letter-spacing: 1px;
    }

    .slogan-text {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-top: 5px;
    }

    /* --- AKORDİYON MENÜ STİLLERİ --- */
    .accordion {
        background-color: #fff;
        color: #333;
        cursor: pointer;
        padding: 15px 25px;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.4s;
        font-weight: bold;
        font-size: 0.95rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-transform: uppercase;
    }

    .active, .accordion:hover {
        background-color: #fff5f5;
        color: #e63946;
    }

    .accordion:after {
        content: '\002B'; /* Artı işareti */
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212"; 
        color: #e63946;
    }

    .panel {
        padding: 0;
        background-color: #f9f9f9;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        border-bottom: 1px solid #eee;
    }

    .panel a {
        display: block;
        padding: 12px 35px;
        text-decoration: none;
        color: #555;
        font-size: 0.9rem;
        border-bottom: 1px solid #eee;
        transition: 0.2s;
    }

    .panel a:last-child { border-bottom: none; }

    .panel a:hover {
        background-color: #eee;
        color: #e63946;
        padding-left: 40px;
    }

    .panel a.aktif-link {
        color: #e63946;
        font-weight: bold;
        background-color: #fff0f0;
        border-left: 4px solid #e63946;
    }
</style>

<div class="sidebar">
    <div class="slogan-box">
        <div class="slogan-title">BÖLGELER</div>
        <div class="slogan-text">"Vücudunu tanı, tedavini seç."</div>
    </div>

    <?php
    // Veritabanındaki bölgeler
    $tumBolgeler = [];
    $sorgu = $baglanti->query("SELECT * FROM bolgeler");
    while ($row = $sorgu->fetch_assoc()) {
        $tumBolgeler[$row['kisa_kod']] = $row['bolge_adi'];
    }

    // Gruplama
    $gruplar = [
        'ÜST VÜCUT' => ['boyun', 'omuz', 'kol'],
        'GÖVDE' => ['gogus', 'sirt', 'bel', 'karin'],
        'ALT VÜCUT' => ['ustbacak', 'diz', 'altbacak']
    ];

    $aktifKod = isset($_GET['bolge']) ? $_GET['bolge'] : '';
    ?>

    <?php foreach ($gruplar as $grupAdi => $kodlar): ?>

        <?php
        // kontrol
        $grupAcik = false;
        foreach ($kodlar as $kod) {
            if ($kod == $aktifKod) {
                $grupAcik = true;
                break;
            }
        }
        ?>

        <button class="accordion <?php echo $grupAcik ? 'active' : ''; ?>">
            <?php echo $grupAdi; ?>
        </button>

        <div class="panel" style="<?php echo $grupAcik ? 'max-height: 500px;' : ''; ?>">
            <?php foreach ($kodlar as $kod): ?>
                <?php if (isset($tumBolgeler[$kod])): ?>
                    
                    <a href="detay.php?bolge=<?php echo $kod; ?>" class="<?php echo ($kod == $aktifKod) ? 'aktif-link' : ''; ?>">
                        • <?php echo $tumBolgeler[$kod]; ?>
                    </a>

                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    <?php endforeach; ?>

</div>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>