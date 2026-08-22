<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantısı varsa dahil et
if (file_exists('dosyalar/baglanti.php')) {
    include 'dosyalar/baglanti.php';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BodyFix PRO - Sporcu Analizi</title>

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2964/2964514.png" type="image/x-icon">

    <style>
        body {
            background-color: #f0f2f5;
            color: #333;
            font-family: 'Roboto', sans-serif;
            margin: 0; padding: 0;
            display: flex; flex-direction: column;
            min-height: 100vh;
        }

        /* ANA KAPLAYICI */
        .main-wrapper {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            flex-grow: 1; 
        }

        /* SOL TARAF (Harita Alanı - Geniş) */
        .left-content {
            flex: 1; /* Kalan tüm boşluğu kapla */
            padding: 20px;
            display: flex; flex-direction: column; align-items: center;
        }

        /* SAĞ TARAF (Panel - Daraltıldı) */
        .right-sidebar {
            width: 200px; /* Genişlik azaltıldı */
            min-width: 200px; /* Küçülmesini engelle */
            background: #fff;
            border-left: 2px solid #ddd;
            padding: 15px;
            display: flex; flex-direction: column; gap: 15px;
            box-shadow: -5px 0 15px rgba(0,0,0,0.05);
        }

        .header-area { text-align: center; margin-bottom: 20px; margin-top: 20px; }
        .status-badge { background-color: #1a1a1a; color: #fff; padding: 8px 20px; border-radius: 50px; font-size: 0.9rem; font-weight: bold; display: inline-flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .dot { height: 10px; width: 10px; background-color: #00ff88; border-radius: 50%; box-shadow: 0 0 10px #00ff88; }
        h2 { font-family: 'Oswald', sans-serif; font-size: 2.5rem; color: #1a1a1a; margin: 15px 0; text-transform: uppercase; }
        p.aciklama { color: #666; font-size: 1rem; max-width: 600px; margin: 0 auto; }

        .harita-container {
            width: 100%; max-width: 800px;
            border: 4px solid #d62828; border-radius: 15px; padding: 5px;
            background-color: #fff; box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
        }
        img { width: 100%; height: auto; display: block; border-radius: 10px; }

        /* REKLAM KUTULARI */
        .ad-box {
            border: 1px solid #eee; padding: 10px; border-radius: 8px; background: #fafafa;
            text-align: center;
        }
        .ad-title { color: #d62828; font-family: 'Oswald'; margin-bottom: 5px; border-bottom: 2px solid #d62828; display: inline-block; font-size: 0.9rem; }

        footer { margin-top: auto; padding: 20px; color: #888; font-size: 0.9rem; text-align: center; width: 100%; background: #e9ecef; }

        /* Mobil Uyum */
        @media (max-width: 900px) {
            .main-wrapper { flex-direction: column; }
            .right-sidebar { width: 100%; border-left: none; border-top: 2px solid #ddd; }
        }
    </style>
</head>

<body>

    <?php include("menu.php"); ?>

    <div class="main-wrapper">
        
        <div class="left-content">
            <div class="header-area">
                <div class="status-badge">
                    <div class="dot"></div>
                    SPORCULAR İÇİN AĞRI TESPİT SİSTEMİ
                </div>
                <h2>SAKATLIK ANALİZİ</h2>
                <p class="aciklama">Ağrı hissettiğin veya sakatlık riski taşıyan kas grubunu aşağıdan seç.</p>
            </div>

            <div class="harita-container">
                <img src="resimler/kaslar.jpg" alt="Vücut Kas Haritası" usemap="#image-map">
                <map name="image-map">
                    <area target="" alt="Göğüs" title="Göğüs" href="detay.php?bolge=gogus" coords="4039,1858,4139,1585,4313,1324,4649,1361,4786,1411,4860,1485,4947,1423,5072,1361,5432,1324,5619,1610,5694,1846,5532,2082,5432,2156,5258,2169,4972,2107,4860,1995,4761,2107,4487,2169,4276,2132,4189,2069" shape="poly">
                    <area target="" alt="Boyun" title="Boyun" href="detay.php?bolge=boyun" coords="4504,1090,4375,1175,4233,1251,4353,1327,4655,1357,4761,1387,4866,1463,4942,1402,5078,1357,5213,1342,5440,1327,5545,1251,5274,1131,5138,1025,5138,859,5022,976,4860,1026,4699,963,4595,859,4580,1045" shape="poly">
                    <area target="" alt="Sağ Omuz" title="Sağ Omuz" href="detay.php?bolge=omuz" coords="4021,1845,3885,1950,3719,2041,3689,1815,3735,1573,3870,1392,4021,1287,4187,1256,4308,1332,4187,1513,4097,1669" shape="poly">
                    <area target="" alt="Sol Omuz" title="Sol Omuz" href="detay.php?bolge=omuz" coords="5440,1322,5530,1261,5696,1276,5817,1322,5923,1427,5998,1563,6043,1729,6043,2046,5908,1986,5787,1895,5711,1880,5651,1639,5557,1496" shape="poly">
                    <area target="" alt="Sağ Kol" title="Sağ Kol" href="detay.php?bolge=kol" coords="3719,2046,3659,2212,3644,2348,3614,2514,3568,2619,3433,2926,3402,3238,3357,3479,3297,3645,3418,3676,3553,3756,3659,3515,3780,3344,3855,3178,3946,2981,3976,2785,4006,2604,4066,2453,4112,2302,4082,2152,4097,1940,4021,1850" shape="poly">
                    <area target="" alt="Sol Kol" title="Sol Kol" href="detay.php?bolge=kol" coords="5696,1865,5621,1971,5651,2121,5636,2257,5651,2363,5711,2529,5757,2665,5802,2906,5847,3057,5923,3223,6043,3419,6225,3736,6353,3660,6490,3660,6345,3238,6315,2997,6270,2770,6134,2559,6119,2272,6043,2046,5877,1955" shape="poly">
                    <area target="" alt="Sağ Üst Bacak" title="Sağ Üst Bacak" href="detay.php?bolge=ustbacak" coords="4172,3258,4112,3585,4067,3842,4036,4073,4097,4737,4187,5054,4202,5129,4233,5220,4293,5174,4338,5099,4489,5114,4610,5295,4746,5265,4761,4857,4836,4375,4821,4073,4670,3862,4399,3454" shape="poly">
                    <area target="" alt="Sol Üst Bacak" title="Sol Üst Bacak" href="detay.php?bolge=ustbacak" coords="5013,5257,5104,5302,5179,5257,5255,5121,5390,5121,5466,5196,5526,5242,5572,5091,5647,4819,5692,4412,5722,4110,5617,3371,5572,3265,5406,3401,5255,3597,5043,3959,4983,4050,4923,4095,4923,4367,4998,4819,5013,5066" shape="poly">
                    <area target="" alt="Sol Diz" title="Sol Diz" href="detay.php?bolge=diz" coords="5063,5567,5259,5687,5379,5707,5425,5582,5440,5431,5455,5210,5379,5114,5259,5119,5198,5255,5123,5300,5002,5240" shape="poly">
                    <area target="" alt="Sağ Diz" title="Sağ Diz" href="detay.php?bolge=diz" coords="4474,5114,4353,5114,4293,5204,4323,5446,4353,5642,4414,5702,4504,5687,4670,5582,4715,5355,4731,5265,4610,5280" shape="poly">
                    <area target="" alt="Sağ Alt Bacak" title="Sağ Alt Bacak" href="detay.php?bolge=altbacak" coords="4281,5212,4206,5249,4219,5560,4169,5796,4169,5983,4194,6231,4256,6529,4306,6765,4330,6915,4318,6952,4330,7026,4430,6977,4530,7014,4579,7064,4592,6927,4579,6666,4629,6393,4679,6157,4704,5970,4641,5722,4666,5585,4530,5697,4418,5697,4355,5647,4330,5473,4306,5336,4293,5287" shape="poly">
                    <area target="" alt="Sağ Alt Bacak" title="Sağ Alt Bacak" href="detay.php?bolge=altbacak" coords="5457,5204,5520,5241,5525,5597,5562,5846,5587,6020,5549,6219,5500,6455,5475,6654,5437,6815,5437,6952,5462,7051,5308,6968,5164,7051,5214,7014,5164,7051,5189,6877,5134,6446,5047,6111,5072,5862,5072,5576,5271,5713,5370,5701,5408,5601,5432,5465,5445,5365" shape="poly">
                    <area target="" alt="Karın" title="Karın" href="detay.php?bolge=karin" coords="4276,2144,4189,2293,4151,2504,4189,2691,4214,2840,4189,2977,4176,3138,4164,3250,4363,3387,4537,3635,4761,4008,4835,4058,4923,4058,4985,3996,5047,3896,5209,3635,5358,3412,5544,3250,5557,3064,5520,2915,5507,2728,5569,2492,5532,2318,5445,2156,5258,2169,4985,2119,4898,2045,4860,1995,4798,2094,4699,2119,4562,2156,4437,2181" shape="poly">
                    <area target="" alt="Sırt" title="Sırt" href="detay.php?bolge=sirt" coords="8418,1722,8368,1821,8393,2107,8443,2442,8505,2641,8530,2728,8604,2753,8741,2716,8878,2678,9002,2579,9127,2467,9189,2504,9226,2467,9313,2554,9425,2629,9525,2678,9612,2716,9724,2753,9836,2741,9935,2318,9960,2119,9997,1821,9910,1672,9736,1498,9699,1374,9537,1274,9338,1299,9189,1361,9002,1311,8828,1274,8704,1336,8642,1374,8654,1448,8567,1535,8480,1635" shape="poly">
                    <area target="" alt="Bel" title="Bel" href="detay.php?bolge=bel" coords="8519,2728,8532,2877,8482,3089,8482,3213,8644,3200,8805,3176,8979,3238,9054,3337,9141,3399,9191,3449,9315,3312,9452,3238,9539,3176,9701,3176,9887,3238,9875,3113,9838,2902,9813,2753,9639,2741,9415,2641,9228,2467,9191,2517,9129,2467,8967,2629,8830,2703,8619,2765" shape="poly">
                    <area target="" alt="Arka Boyun" title="Arka Boyun" href="detay.php?bolge=boyun" coords="8691,1174,8753,1200,8803,1287,8877,1262,8989,1274,9101,1324,9201,1349,9400,1287,9512,1274,9574,1287,9636,1212,9698,1175,9599,1113,9487,1050,9450,963,9462,827,9363,765,9251,740,9114,740,8977,765,8902,814,8903,901,8890,1026,8778,1112,8691,1174" shape="poly">
                </map>
            </div>
        </div>

        <div class="right-sidebar">
            
            <div class="ad-box">
                <h4 class="ad-title">SON DAKİKA</h4>
                <marquee direction="left" scrollamount="5" style="color:red; font-weight:bold; font-size:12px;">
                    Yeni sakatlıklar veritabanına eklendi!
                </marquee>
            </div>

            <div class="ad-box" style="flex-grow: 1; display:flex; flex-direction:column; justify-content:center;">
                <b style="color:#d62828; margin-bottom:10px;">FIRSATLAR</b>
                <marquee direction="up" scrollamount="3" height="200" style="text-align:center;">
                    <img src="https://cdn-icons-png.flaticon.com/512/2964/2964514.png" style="width:50px; margin:0 auto;"><br>
                    <small>İndirimli Ürünler</small>
                </marquee>
                <small style="color:#ccc; font-size:10px; margin-top:10px;">Reklam Alanı</small>
            </div>

        </div>

    </div>

    <footer>
        © 2025 BODYFIX PERFORMANCE SYSTEMS
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.2/jquery.maphilight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('map').imageMapResize();
            $('img[usemap]').maphilight({
                fill: true, fillColor: 'ff0000', fillOpacity: 0.4,
                stroke: true, strokeColor: 'ffffff', strokeWidth: 5, strokeOpacity: 1,
                shadow: true, shadowColor: '000000', shadowRadius: 10, shadowOpacity: 0.8, shadowPosition: 'outside',
                fade: true, alwaysOn: false
            });
        });
    </script>
</body>
</html>