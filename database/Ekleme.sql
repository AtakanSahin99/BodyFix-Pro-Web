use bodyfix;

SET SQL_SAFE_UPDATES = 0;

UPDATE sakatliklar SET 
    uzman_doktor = 'Beyin ve Sinir Cerrahisi', 
    faydali_link = 'https://www.youtube.com/watch?v=example1' 
WHERE baslik LIKE '%Boyun Fıtığı%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Fizyoterapist', 
    faydali_link = 'https://www.youtube.com/watch?v=example2' 
WHERE baslik LIKE '%Boyun Tutulması%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Ortopedi Uzmanı', 
    faydali_link = 'https://www.youtube.com/watch?v=rotatorcuff' 
WHERE baslik LIKE '%Rotator%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Fizyoterapist', 
    faydali_link = 'https://www.youtube.com/watch?v=omuzsikisma' 
WHERE baslik LIKE '%Sıkışması%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Spor Hekimi / Cerrah', 
    faydali_link = 'https://www.webmd.com/fitness-exercise/pectoral-injury' 
WHERE baslik LIKE '%Pektoral%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Beyin Cerrahisi / Fizik Tedavi', 
    faydali_link = 'https://www.youtube.com/watch?v=belfitigi' 
WHERE baslik LIKE '%Bel Fıtığı%';

UPDATE sakatliklar SET 
    uzman_doktor = 'Ortopedi ve Travmatoloji', 
    faydali_link = 'https://www.youtube.com/watch?v=meniskus' 
WHERE baslik LIKE '%Menisküs%';

UPDATE sakatliklar SET uzman_doktor = 'Spor Hekimi' WHERE uzman_doktor IS NULL;
UPDATE sakatliklar SET faydali_link = 'https://www.youtube.com/results?search_query=spor+sakatlanmalari' WHERE faydali_link IS NULL OR faydali_link = '';

SET SQL_SAFE_UPDATES = 1;