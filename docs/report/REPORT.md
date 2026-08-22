# BodyFix Pro Web Technical Report

### Page 1

 
 
 
WEB TASARIMI VE 
PROGRAMLAMA DERSİ DÖNEM 
SONU PROJE RAPORU 
 
   
 
 
 
 
         HAZIRLAYAN:  
      Ad: Atakan Şahin 
 Numara: 23040101062 
 
 
 
T.C. Topkapı Üniversitesi 
Mühendislik Fakültesi 
Bilgisayar Mühendisliği  
Bölümü 
 
Öğretmen:Zafer Güney 
  

### Page 2

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 2  
 
   
 
 
 
 
 
 
     
 
Proje Amacı 
 
     
     
   BodyFix PRO, sporcuların ve aktif 
yaşam süren bireylerin 
vücutlarında hissettikleri ağrıları 
ve olası sakatlıkları takip 
edebilmeleri amacıyla geliştirilmiş 
dinamik bir web uygulamasıdır. 
Proje, internet üzerindeki bilgi 
kirliliğini önleyerek kullanıcılara 
güvenilir, tıbbi kaynaklara dayalı 
bir rehber sunmayı hedefler. 
Kullanıcılar interaktif vücut 
haritası üzerinden ağrıyan 
bölgelerini seçebilir, sakatlık 
detaylarını öğrenebilir ve kişisel 
profillerinde ağrı gelişimlerini 
grafiksel olarak takip edebilirler. 
 
   
 
    
  


### Page 3

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 3  
 
 
 
 
 
 
 
     
 
Kullanılan Teknolojiler 
 
     
 
Projenin geliştirilmesinde aşağıdaki teknolojiler 
kullanılmıştır: 
 
 
   PHP (Backend): Sunucu taraflı işlemler, oturum yönetimi 
(Session) ve veritabanı iletişimi için kullanıldı. Kodun 
sürdürülebilirliği açısından Nesne Yönelimli Programlama (OOP) 
mimarisi uygulandı. 
 
   MySQL (Veritabanı): Projenin tüm verilerini (kullanıcı 
bilgileri, sakatlık detayları, ağrı geçmişi) güvenli ve düzenli bir şekilde 
saklamak için ilişkisel veritabanı yapısı kullanıldı. 
 
   HTML5 & CSS3 (Frontend): Web sayfalarının iskeletini 
oluşturmak ve görsel tasarımı sağlamak için kullanıldı. Bootstrap 
kütüphanesi ve Flexbox yapısı sayesinde mobil uyumlu (responsive) 
bir arayüz elde edildi. 
 
   JavaScript & Chart.js: Kullanıcı tarafındaki etkileşimler (menü 
aç/kapa, harita tıklamaları) ve özellikle profil sayfasındaki "Ağrı 
Grafiği"nin görselleştirilmesi için kullanıldı. 
 
   XAMPP (Apache Sunucusu): Projenin geliştirilmesi ve test 
edilmesi aşamasında yerel sunucu ortamı olarak kullanıldı. 
 
 
 
  

### Page 4

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 4  
 
 
VERİTABANI YAPISI 
 
Projede veri tutarlılığını sağlamak amacıyla bodyfix isimli ilişkisel bir veritabanı 
tasarlanmıştır. Veritabanı şeması aşağıdaki tablolardan oluşmaktadır: 
 
   users: Sisteme kayıt olan kullanıcıların kimlik doğrulama bilgilerini (Ad, Soyad, E-
posta, Şifre) saklar. 
 
   bolgeler: Vücut haritasında yer alan ana kas gruplarını (Örn: Omuz, Diz, Bel) ve 
bunların kısa kodlarını tanımlar. 
 
   sakatliklar: Her bölgeye özgü tıbbi sakatlıkların başlıklarını, belirtilerini ve tedavi 
yöntemlerini içerir. 
 
   agri_takip: Kullanıcıların profillerinde oluşturdukları ağrı grafiklerini çizdirmek 
için, girilen ağrı seviyelerini tarih bilgisiyle birlikte kaydeder. 
 
   potansiyel_sakatliklar: Kullanıcının "Takip Listem"e eklediği, kendisinde 
şüphelendiği sakatlıkları kullanıcı ID'si ile eşleştirerek saklar. 
 
   arama_gecmisi: Kullanıcıların site içinde yaptığı semptom aramalarını (Örn: 
"batma", "uyuşma") analiz amaçlı kayıt altına alır. 
 
 
 


### Page 5

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 5  
 
   
     
   
ANA SAYFA VE ARAYÜZ (Front-End): 
Ana sayfada kullanıcıyı karşılayan interaktif bir vücut haritası bulunmaktadır. Sayfanın 
sağ tarafında, ders kriterlerine uygun olarak hazırlanan duyuru alanı ve kayan 
yazılar (marquee) yer almaktadır. 
 
   Image Map: Vücut üzerindeki bölgelere tıklanabilir alanlar tanımlanmıştır. 
 
   Responsive Yapı: Sayfa, mobil cihazlara uyumlu olacak şekilde Flexbox ve 
Bootstrap kullanılarak tasarlanmıştır. 
 
 
 
KULLANICI PROFİLİ VE GRAFİK (Dashboard) 
Kullanıcı giriş yaptığında, $_SESSION oturum yönetimi ile karşılanır. Bu sayfada 
kullanıcının ağrı geçmişini gösteren dinamik bir Chart.js grafiği ve favori 
sakatlıklarını listelediği bir tablo bulunur. 
 
   Dinamik Grafik Entegrasyonu (Chart.js): Kullanıcının ağrı seviyelerini 
zamana bağlı olarak takip edebilmesi için harici bir JavaScript kütüphanesi olan 
Chart.js projeye dahil edilmiştir. Veritabanından çekilen veriler JSON formatına 
çevrilerek grafiğe aktarılmıştır. 
 
   Gelişmiş Tablo Biçimlendirmesi: Ders kriterlerinde belirtilen özel HTML 
formatları uygulanmıştır. Tablo içerisindeki verilerde kalın (<b>), italik (<i>), 
<u>altı çizili (<u>)</u> ve <strike>üstü çizili (<strike>)</strike> etiketleri 
kullanılarak veri gösterimi zenginleştirilmiştir. Ayrıca hücre içi hizalamalar (vertical-
align) yapılmıştır. 


### Page 6

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 6  
 
  
 
   Veri Tabanı Etkileşimi (Listeleme ve Silme): Kullanıcının favoriye aldığı 
sakatlıklar JOIN sorgusu ile çekilerek listelenmiştir. Tablo üzerindeki butonlar 
sayesinde kullanıcı, istediği kaydı veritabanından silebilir (CRUD - Delete İşlemi). 
   Oturum Kontrolü: Bu sayfa korumalı bir alandır. Sadece session_start() ile 
oturum açmış kullanıcılar (User ID'si olanlar) erişebilir; aksi halde sistem kullanıcıyı 
giriş sayfasına yönlendirir.  
 
 
 
 
 
 
 
     
   


### Page 7

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 7  
 
 
 
DETAY SAYFASI VE FRAME KULLANIMI 
 
Kullanıcı bir bölge seçtiğinde detay sayfasına yönlendirilir. Bu sayfada ilgili sakatlıklar 
veritabanından çekilir. Sayfanın alt kısmında <iframe> etiketi kullanılarak 
rehabilitasyon videoları gösterilmektedir. Ayrıca sayfa içi yönlendirme linkleri 
kullanılmıştır. 
 
   PHP (Backend): Sunucu taraflı işlemler, oturum yönetimi (Session) ve veritabanı 
iletişimi için kullanıldı. Kodun sürdürülebilirliği açısından Nesne Yönelimli 
Programlama (OOP) mimarisi uygulandı. 
 
   MySQL (Veritabanı): Projenin tüm verilerini (kullanıcı bilgileri, sakatlık 
detayları, ağrı geçmişi) güvenli ve düzenli bir şekilde saklamak için ilişkisel veritabanı 
yapısı kullanıldı. 
 
   HTML5 & CSS3 (Frontend): Web sayfalarının iskeletini oluşturmak ve görsel 
tasarımı sağlamak için kullanıldı. Bootstrap kütüphanesi ve Flexbox yapısı sayesinde 
mobil uyumlu (responsive) bir arayüz elde edildi. 
 
   JavaScript & Chart.js: Kullanıcı tarafındaki etkileşimler (menü aç/kapa, harita 
tıklamaları) ve özellikle profil sayfasındaki "Ağrı Grafiği"nin görselleştirilmesi için 
kullanıldı. 
 
   XAMPP (Apache Sunucusu): Projenin geliştirilmesi ve test edilmesi 
aşamasında yerel sunucu ortamı olarak kullanıldı. 
 
 
  


### Page 8

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 8  
 
 
BACKEND VE OOP YAPISI 
NESNE YÖNELİMLİ PROGRAMLAMA (OOP) 
 
Veritabanı bağlantısı, kod tekrarını önlemek ve güvenliği sağlamak amacıyla Veritabani 
isminde bir Class (Sınıf) olarak oluşturulmuştur. Try-Catch blokları ile hata yönetimi 
sağlanmıştır. 
 
 
 
 
 
 
 
 
 


### Page 9

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 9  
 
 
 
 
GÜVENLİK ÖNLEMLERİ 
 
   SQL Injection: Tüm veri girişlerinde Prepare ve Bind_param (Hazırlanmış 
Sorgular) kullanılarak SQL saldırıları engellenmiştir. 
 
   XSS Koruması: Ekrana basılan kullanıcı verilerinde htmlspecialchars() 
fonksiyonu kullanılmıştır. 
 
   Oturum Güvenliği: Giriş yapmayan kullanıcıların profil sayfasına erişmesi 
session_start() kontrolü ile engellenmiştir. 
 
 
 


### Page 10

 
 WEB TASARIMI VE PROGRAMLAMA DERSİ 
DÖNEM SONU PROJE RAPORU 
SAYFA 10  
 
 
 
     
   
  
 
  
   
Raporumu Değerlendirdiğiniz                            
için Teşekkür ederim 
 
 
