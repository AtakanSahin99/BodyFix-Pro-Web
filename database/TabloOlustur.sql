CREATE DATABASE IF NOT EXISTS bodyfix CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;
USE bodyfix;

-- KULLANICILAR
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_soyad VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    sifre VARCHAR(255) NOT NULL, 
    rol ENUM('admin', 'uye') DEFAULT 'uye',
    kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- VÜCUT BÖLGELERİ
CREATE TABLE bolgeler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bolge_adi VARCHAR(50) NOT NULL,
    kisa_kod VARCHAR(50) NOT NULL  
);

-- SAKATLIK BİLGİ
CREATE TABLE sakatliklar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bolge_id INT,
    baslik VARCHAR(150) NOT NULL,
    belirtiler TEXT,
    risk_seviyesi VARCHAR(50),  
    tedavi_yontemi TEXT,     
    yasak_hareket TEXT,     
    faydali_link VARCHAR(255),  
    FOREIGN KEY (bolge_id) REFERENCES bolgeler(id) ON DELETE CASCADE
);

-- AĞRI TAKİP GÜNLÜĞÜ
CREATE TABLE agri_takip (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    bolge_id INT, 
    agri_seviyesi INT, -- 1-10 arası puan
    notlar VARCHAR(255),
    tarih DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bolge_id) REFERENCES bolgeler(id) ON DELETE CASCADE
);

-- GEÇMİŞ ARAMA
CREATE TABLE arama_gecmisi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    sakatlik_id INT,
    bakilan_tarih TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (sakatlik_id) REFERENCES sakatliklar(id) ON DELETE CASCADE
);

-- TEST VERİ

-- Bölgeler
INSERT INTO bolgeler (bolge_adi, kisa_kod) VALUES 

('Boyun', 'boyun'),        -- Boyun fıtığı, tutulma
('Omuz', 'omuz'),          -- Rotator cuff, sıkışma (Kırmızı Alanlar)
('Göğüs', 'gogus'),        -- Pektoral yırtıklar (Turuncu Alan)
('Sırt', 'sirt'),          -- Kürek kemiği ve kanat kasları
('Bel', 'bel'),            -- Bel fıtığı, kanal daralması (Sarı/Turuncu alt arka)
('Kol', 'kol'),            -- Pazı (Biceps) ve Arka Kol (Triceps) tek parça
('Karın', 'karin'),        -- Mide kasları
('Üst Bacak', 'ustbacak'), -- Quadriceps ve Hamstring
('Diz', 'diz'),            -- Menisküs, Ön çapraz bağ
('Alt Bacak', 'altbacak'); -- Kalf ve Aşil tendonu

-- İçerik

-- 1. BOYUN BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='boyun'), 'Boyun Fıtığı', 'Kola vuran uyuşma, boyun hareketlerinde kısıtlılık.', 'Ciddi Risk', 'Fizik Tedavi ve Boyunluk', 'Ağır Overhead Press'),
((SELECT id FROM bolgeler WHERE kisa_kod='boyun'), 'Boyun Tutulması', 'Sabah kalkınca boynu çevirememe.', 'Düşük Risk', 'Sıcak Uygulama ve Masaj', 'Ani Boyun Çevirme');

-- 2. OMUZ BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='omuz'), 'Rotator Manşet Yırtığı', 'Kolu yana açarken şiddetli ağrı.', 'Yüksek Risk', 'Dinlenme ve Egzersiz', 'Lateral Raise (Yana Açış)'),
((SELECT id FROM bolgeler WHERE kisa_kod='omuz'), 'Omuz Sıkışması', 'Kolu baş üstüne kaldırırken batma hissi.', 'Orta Seviye', 'Buz ve Manuel Terapi', 'Upright Row');

-- 3. GÖĞÜS BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='gogus'), 'Pektoral Kas Yırtığı', 'Göğüs ön kısmında morarma ve çukur oluşumu.', 'Ciddi Risk', 'Cerrahi Müdahale Gerekebilir', 'Ağır Bench Press');

-- 4. SIRT BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='sirt'), 'Kulunç (Miyofasiyal Ağrı)', 'Kürek kemiği altında nokta şeklinde ağrı.', 'Düşük Risk', 'Masaj ve Tetik Nokta Terapisi', 'Kambur Durmak'),
((SELECT id FROM bolgeler WHERE kisa_kod='sirt'), 'Rhomboid Zorlanması', 'Nefes alırken sırta batan ağrı.', 'Orta Seviye', 'Köpük Rulo (Foam Roller)', 'Ağır Row Hareketleri');

-- 5. BEL BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='bel'), 'Bel Fıtığı (L4-L5)', 'Bacağa ve kalçaya vuran elektriklenme.', 'Yüksek Risk', 'Kor Egzersizleri ve Yüzme', 'Deadlift ve Squat'),
((SELECT id FROM bolgeler WHERE kisa_kod='bel'), 'Mekanik Bel Ağrısı', 'Uzun süre ayakta durunca artan ağrı.', 'Orta Seviye', 'Esneme Hareketleri', 'Yüksek Topuklu Ayakkabı');

-- 6. KOL BÖLGESİ (Pazı ve Dirsek)
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='kol'), 'Tenisçi Dirseği', 'Dirseğin dış kısmında yanma.', 'Orta Seviye', 'Dirseklik ve Dinlenme', 'Ağır Hammer Curl'),
((SELECT id FROM bolgeler WHERE kisa_kod='kol'), 'Biceps Tendiniti', 'Omuz önünde ve pazıda sızlama.', 'Düşük Risk', 'Buz Kompresi', 'Barbell Curl');

-- 7. KARIN BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='karin'), 'Karın Kası Çekmesi', 'Mekik çekerken ani batma.', 'Düşük Risk', 'Dinlenme', 'Mekik (Sit-up)');

-- 8. ÜST BACAK
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='ustbacak'), 'Hamstring Çekmesi', 'Arka bacakta ani kopma hissi.', 'Orta Seviye', 'Soğuk Uygulama ve Bandaj', 'Sprint Koşu'),
((SELECT id FROM bolgeler WHERE kisa_kod='ustbacak'), 'Quadriceps Ezilmesi', 'Darbe sonucu ön bacakta şişlik.', 'Düşük Risk', 'Kompresyon ve İstirahat', 'Leg Extension');

-- 9. DİZ BÖLGESİ
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='diz'), 'Menisküs Yırtığı', 'Dizde kilitlenme ve merdiven inememe.', 'Yüksek Risk', 'Artroskopi veya Fizik Tedavi', 'Tam Çökme (Deep Squat)'),
((SELECT id FROM bolgeler WHERE kisa_kod='diz'), 'Ön Çapraz Bağ (ACL)', 'Dizde boşluk hissi ve güvensizlik.', 'Ciddi Risk', 'Cerrahi ve Rehabilitasyon', 'Ani Dönüşler (Futbol)');

-- 10. ALT BACAK
INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket) VALUES 
((SELECT id FROM bolgeler WHERE kisa_kod='altbacak'), 'Shin Splints (Kaval Ağrısı)', 'Koşarken kaval kemiğinde sızı.', 'Orta Seviye', 'Tabanlık ve Buz', 'Sert Zeminde Koşu'),
((SELECT id FROM bolgeler WHERE kisa_kod='altbacak'), 'Aşil Tendiniti', 'Topuk arkasında sabahları sertlik.', 'Yüksek Risk', 'Germe Egzersizleri', 'İp Atlama');

-- Kullanıcı
INSERT INTO users (ad_soyad, email, sifre, rol) VALUES 
('Atakan Admin', 'admin@bodyfix.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
('Sporcu Üye', 'uye@bodyfix.com', 'e10adc3949ba59abbe56e057f20f883e', 'uye');