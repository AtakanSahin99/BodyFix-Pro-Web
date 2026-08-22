<?php

if (!class_exists('Veritabani')) {

    class Veritabani
    {
        private $sunucu = "127.0.0.1";
        private $vt_ismi = "bodyfix";
        private $kadi = "root";
        private $sifre = "";
        private $port = 3307;
        public $bag;

        public function baglan()
        {
            $this->bag = null;

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $this->bag = new mysqli($this->sunucu, $this->kadi, $this->sifre, $this->vt_ismi, $this->port);

                $this->bag->set_charset("utf8");

            } catch (mysqli_sql_exception $e) {
                die("Veritabanı Bağlantı Hatası: " . $e->getMessage());
            }

            return $this->bag;
        }
    }

}
?>