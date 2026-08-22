SET SQL_SAFE_UPDATES = 0;

INSERT INTO sakatliklar (bolge_id, baslik, belirtiler, risk_seviyesi, tedavi_yontemi, yasak_hareket, uzman_doktor, faydali_link) VALUES 

((SELECT id FROM bolgeler WHERE kisa_kod='boyun'), 
'Akut Tortikolis (Boyun Tutulması)', 
'• Sabah uyanınca başın tek tarafa eğik durması ve düzeltilememesi.
• Sternokleidomastoid (SCM) kasında şiddetli spazm ve sertlik.
• Boynu aksi yöne çevirmeye çalışınca bıçak saplanır tarzda ağrı.', 
'Düşük Risk', 
'Sıcak kompres, Kas gevşetici krem, Hafif masaj.', 
'• Ani baş hareketleri
• Soğuk rüzgara maruz kalmak', 
'Aile Hekimi / Fizyoterapist', 
'https://my.clevelandclinic.org/health/diseases/22430-torticollis'),

((SELECT id FROM bolgeler WHERE kisa_kod='boyun'), 
'Servikal Radikülopati (Sinir Sıkışması)', 
'• Boyundan kürek kemiğine ve kola yayılan yanıcı ağrı.
• Başın tepesinden aşağıya bastırınca (kompresyon) ağrının artması.
• Reflekslerde azalma ve kolda hissizlik.', 
'Yüksek Risk', 
'Servikal traksiyon, Gabapentin türevi ilaçlar, Fizik tedavi.', 
'• Başın üzerinde yük taşıma
• Barbell Overhead Press', 
'Nöroloji / Beyin Cerrahisi', 
'https://www.hopkinsmedicine.org/health/conditions-and-diseases/cervical-radiculopathy'),

((SELECT id FROM bolgeler WHERE kisa_kod='omuz'), 
'Biceps Tendiniti (Uzun Baş)', 
'• Omuzun ön kısmında, bicipital olukta derin sızlama.
• Kolu öne doğru kaldırırken veya direksiyon çevirirken ağrı.
• Speed testi pozitif (Avuç içi yukarı bakarken kolu dirence karşı kaldırma).', 
'Orta Seviye', 
'Buz masajı, Ultrason tedavisi, Aktivite modifikasyonu.', 
'• Barbell Curl (Dirsekler geride)
• Dips (Omuzlar öne yuvarlanmışsa)', 
'Spor Hekimi', 
'https://orthoinfo.aaos.org/en/diseases--conditions/biceps-tendinitis/'),

((SELECT id FROM bolgeler WHERE kisa_kod='omuz'), 
'Akromioklaviküler (AC) Eklem Yaralanması', 
'• Omuzun üzerine düşme sonrası köprücük kemiği ucunda şişlik (Step deformitesi).
• Kolu göğsün üzerinden diğer omza doğru götürürken (Cross-body) ağrı.
• Gece o tarafa yatınca ağrı.', 
'Orta Seviye', 
'Kol askısı, Bandajlama, İleri derecelerde cerrahi.', 
'• Bench Press (Tam indirme)
• Şınav', 
'Ortopedi Uzmanı', 
'https://www.mayoclinic.org/diseases-conditions/separated-shoulder/symptoms-causes/syc-20354049'),

((SELECT id FROM bolgeler WHERE kisa_kod='gogus'), 
'Sternal Kontüzyon (Göğüs Kemiği Ezilmesi)', 
'• Göğüs kafesine alınan darbe sonrası (trafik kazası veya spor travması) morarma.
• Derin nefes alırken veya gülerken göğüs ortasında batma.
• Dokunmakla aşırı hassasiyet.', 
'Orta Seviye', 
'Solunum egzersizleri (akciğer kapasitesini korumak için), Ağrı kesici.', 
'• Bench Press
• Göğüs kafesine baskı yapan hareketler', 
'Göğüs Cerrahisi', 
'https://www.ncbi.nlm.nih.gov/books/NBK534780/'),

((SELECT id FROM bolgeler WHERE kisa_kod='sirt'), 
'Rhomboid Major Zorlanması', 
'• Kürek kemiği ile omurga arasında, derin nefes alırken batan ağrı.
• Kürek çekme (Rowing) hareketi sırasında sırtta spazm.
• Kolları baş üstünde birleştirirken zorlanma.', 
'Düşük Risk', 
'Tenis topu ile masaj, Kinesio bantlama.', 
'• Ağır Bent-over Row
• Kötü formda barfiks', 
'Fizyoterapist', 
'https://www.physio-pedia.com/Rhomboid_Strain'),

((SELECT id FROM bolgeler WHERE kisa_kod='bel'), 
'Sakroiliak (SI) Eklem Disfonksiyonu', 
'• Belin en alt kısmında, gamzelerin olduğu yerde tek taraflı ağrı.
• Ağrının kalçaya ve kasığa yayılması (ancak dize kadar inmez).
• Merdiven çıkarken veya arabadan inerken keskin batma.', 
'Orta Seviye', 
'Manuel terapi (Kayropraktik), SI eklem kuşağı, Proloterapi.', 
'• Tek ayak üzerinde yapılan egzersizler (Lunge)
• Geniş adım atma', 
'Fizik Tedavi / Kayropraktik', 
'https://www.spine-health.com/conditions/sacroiliac-joint-dysfunction/sacroiliac-joint-dysfunction-symptoms-and-causes'),

((SELECT id FROM bolgeler WHERE kisa_kod='bel'), 
'Quadratus Lumborum (QL) Sendromu', 
'• Belin yan tarafında, kaburga ile leğen kemiği arasında derin, sızlayıcı ağrı.
• Yatarken dönmekte veya otururken pozisyon değiştirmekte zorluk.
• Bir bacağın diğerinden kısa olduğu hissi.', 
'Orta Seviye', 
'Yan germe (Side stretch), Sıcak uygulama, Derin doku masajı.', 
'• Side Bend (Ağır dambılla yana eğilme)
• Asimetrik taşıma', 
'Fizyoterapist', 
'https://radiopaedia.org/articles/quadratus-lumborum-syndrome'),

((SELECT id FROM bolgeler WHERE kisa_kod='kol'), 
'Medial Epikondilit (Golfçü Dirseği)', 
'• Dirseğin iç tarafındaki kemik çıkıntıda ağrı.
• Bileği içeri bükerken (fleksiyon) veya bavul taşırken dirsekte sızlama.
• Serçe ve yüzük parmağına yayılan hafif uyuşma.', 
'Orta Seviye', 
'Bilek fleksör germe, Buz, Ortez kullanımı.', 
'• Barfiks (Avuç içi yüze bakan - Chin up)
• Barbell Curl', 
'El Cerrahisi / Ortopedi', 
'https://www.mayoclinic.org/diseases-conditions/golfers-elbow/symptoms-causes/syc-20372868'),

((SELECT id FROM bolgeler WHERE kisa_kod='kol'), 
'Kubital Tünel Sendromu', 
'• Dirseği masaya dayayınca serçe ve yüzük parmağında elektrik çarpması hissi.
• Dirsek içinden geçen ulnar sinirin sıkışması.
• İleri evrede elde "Pençe El" deformitesi gelişimi.', 
'Orta Seviye', 
'Dirsek ateli (gece), Dirseği bükülü tutmaktan kaçınma.', 
'• Skullcrusher (Triceps hareketi)
• Dirseği sert zemine dayamak', 
'Beyin ve Sinir Cerrahisi', 
'https://www.assh.org/handcare/condition/cubital-tunnel-syndrome'),

((SELECT id FROM bolgeler WHERE kisa_kod='karin'), 
'Sporcu Fıtığı (Athletic Pubalgia)', 
'• Kasık bölgesinde kronik, sinsi ağrı (görünürde şişlik/fıtık yoktur).
• Mekik çekerken veya ani dönüşlerde kasıkta yırtılma hissi.
• Genellikle futbolcu ve hokeycilerde görülür.', 
'Yüksek Risk', 
'Fizik tedavi, Kortizon enjeksiyonu, İnatçı vakalarda cerrahi.', 
'• Sit-up (Tam mekik)
• Ani sprintler', 
'Spor Cerrahisi', 
'https://orthoinfo.aaos.org/en/diseases--conditions/sports-hernia-athletic-pubalgia/'),

((SELECT id FROM bolgeler WHERE kisa_kod='karin'), 
'İliopsoas (Kalça Fleksörü) Tendiniti', 
'• Kasık ön yüzünde, bacağı yukarı kaldırırken "klik" sesi (Snapping Hip).
• Derin kasık ağrısı, merdiven çıkarken artar.
• Bel çukurunda artış (Lordoz) ile ilişkilidir.', 
'Orta Seviye', 
'Psoas germe egzersizleri, Buz, Dinlenme.', 
'• Leg Raise (Bacak kaldırma)
• Yokuş yukarı koşu', 
'Fizyoterapist', 
'https://www.hss.edu/condition-list_iliopsoas-tendonitis.asp'),

((SELECT id FROM bolgeler WHERE kisa_kod='ustbacak'), 
'Quadriceps Kontüzyonu (Charley Horse)', 
'• Uyluk ön yüzüne alınan sert darbe (dizliksiz çarpışma) sonucu derin ezilme.
• Ciddi hematom (kan toplanması) ve kireçlenme (Miyozit ossifikans) riski.
• Dizi bükmekte aşırı zorlanma.', 
'Orta Seviye', 
'Dizi bükülü pozisyonda buz uygulama (Fleksiyonda immobilizasyon).', 
'• Sıcak uygulama (İlk 48 saat yasak)
• Masaj (İlk hafta yasak)', 
'Spor Hekimi', 
'https://www.urmc.rochester.edu/encyclopedia/content.aspx?contenttypeid=1&contentid=4461'),

((SELECT id FROM bolgeler WHERE kisa_kod='ustbacak'), 
'Meralgia Paresthetica', 
'• Uyluğun dış-yan yüzünde yanma, karıncalanma ve hissizlik.
• Dar pantolon, sıkı kemer veya ağırlık kemeri kullanımıyla artan şikayetler.
• Lateral femoral kutanöz sinirin sıkışması.', 
'Düşük Risk', 
'Bol kıyafet giymek, Kilo vermek, Sinir blokajı.', 
'• Sıkı ağırlık kemeri takmak
• Kalçayı aşırı sıkan egzersizler', 
'Nöroloji', 
'https://www.mayoclinic.org/diseases-conditions/meralgia-paresthetica/symptoms-causes/syc-20355635'),

((SELECT id FROM bolgeler WHERE kisa_kod='diz'), 
'İç Yan Bağ (MCL) Yaralanması', 
'• Dizin dışından gelen darbe sonucu dizin iç kısmında açılma hissi ve ağrı.
• Dizin iç tarafında hassasiyet ve morarma.
• Valgus stres testinde (dizi içe zorlama) boşluk hissi.', 
'Orta Seviye', 
'Menteşeli dizlik, Fizik tedavi (Genellikle ameliyatsız iyileşir).', 
'• Kurbağalama yüzme
• Yan lunge hareketleri', 
'Ortopedi Uzmanı', 
'https://www.ucsfhealth.org/conditions/mcl-tear'),

((SELECT id FROM bolgeler WHERE kisa_kod='diz'), 
'İliotibial Bant (ITB) Sendromu', 
'• Dizin dış yan kısmında, koşarken veya bisiklet sürerken bıçak batması.
• Dizi 30 derece büktüğünde ağrının en şiddetli halini alması.
• Kalça yan kaslarında zayıflık ile ilişkilidir.', 
'Orta Seviye', 
'Foam roller (bant üzerine), Kalça abduktor güçlendirme.', 
'• Eğimli yolda koşu (Hep aynı yöne)
• Sert zemin koşusu', 
'Spor Hekimi', 
'https://www.hss.edu/condition-list_iliotibial-band-syndrome.asp'),

((SELECT id FROM bolgeler WHERE kisa_kod='altbacak'), 
'Plantar Fasilis (Topuk Dikeni)', 
'• Sabah ilk adımda topuk altında cam kırığına basmış gibi acı.
• Ayak tabanında gerginlik.
• Gün içinde ağrı azalır, akşam yorgunlukla tekrar artar.', 
'Orta Seviye', 
'Silikon topukluk, Ayak tabanına donmuş su şişesi ile masaj.', 
'• Çıplak ayakla sert zeminde yürümek
• Babet/Düz taban ayakkabı giymek', 
'Ortopedi / Podiatri', 
'https://www.mayoclinic.org/diseases-conditions/plantar-fasciitis/symptoms-causes/syc-20354846'),

((SELECT id FROM bolgeler WHERE kisa_kod='altbacak'), 
'Stres Kırığı (Tibia/Metatars)', 
'• Kaval kemiği veya ayak tarak kemiğinde, aktiviteyle başlayan ve dinlenince GEÇMEYEN sızı.
• Kemik üzerinde tek bir noktada aşırı hassasiyet ve ödem.
• Shin Splints ile karışır ancak ağrı daha lokalizedir.', 
'Ciddi Risk', 
'Kesin istirahat (6-8 hafta), Alçı veya bot kullanımı, D vitamini takviyesi.', 
'• Koşu ve zıplama (Kesinlikle yasak)
• Yorgun kemik üzerine yüklenme', 
'Ortopedi Uzmanı', 
'https://orthoinfo.aaos.org/en/diseases--conditions/stress-fractures-of-the-foot-and-ankle/');

SET SQL_SAFE_UPDATES = 1;