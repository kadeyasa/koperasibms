<?php 
    //if(!function_exists(check_bulan)){
        function check_bulan($bulan){
            switch($bulan){
                case '01':
                    $b='Januari';
                break;
                case '02':
                    $b='Pebruari';
                break;
                case '03':
                    $b='Maret';
                break;
                case '04':
                    $b='April';
                break;
                case '05':
                    $b='Mei';
                break;
                case '06':
                    $b='Juni';
                break;
                case '07':
                    $b='Juli';
                break;
                case '08':
                    $b='Agustus';
                break;
                case '09':
                    $b='September';
                break;
                case '10':
                    $b='Oktober';
                break;
                case '11':
                    $b='Nopember';
                break;
                case '12':
                    $b='Desember';
                break;
            }
            return $b;
        }

        function penyebut($angka) {
            $angka = (float)$angka;
            $bilangan = array(
                '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
            );
            
            if ($angka < 12) {
                return $bilangan[$angka];
            } elseif ($angka < 20) {
                return $bilangan[$angka - 10] . ' belas';
            } elseif ($angka < 100) {
                return $bilangan[intval($angka / 10)] . ' puluh' . ($angka % 10 != 0 ? ' ' . $bilangan[$angka % 10] : '');
            } elseif ($angka < 200) {
                return 'seratus' . ($angka % 100 != 0 ? ' ' . penyebut($angka % 100) : '');
            } elseif ($angka < 1000) {
                return $bilangan[intval($angka / 100)] . ' ratus' . ($angka % 100 != 0 ? ' ' . penyebut($angka % 100) : '');
            } elseif ($angka < 2000) {
                return 'seribu' . ($angka % 1000 != 0 ? ' ' . penyebut($angka % 1000) : '');
            } elseif ($angka < 1000000) {
                return penyebut(intval($angka / 1000)) . ' ribu' . ($angka % 1000 != 0 ? ' ' . penyebut($angka % 1000) : '');
            } elseif ($angka < 1000000000) {
                return penyebut(intval($angka / 1000000)) . ' juta' . ($angka % 1000000 != 0 ? ' ' . penyebut($angka % 1000000) : '');
            } elseif ($angka < 1000000000000) {
                return penyebut(intval($angka / 1000000000)) . ' miliar' . ($angka % 1000000000 != 0 ? ' ' . penyebut($angka % 1000000000) : '');
            } else {
                return penyebut(intval($angka / 1000000000000)) . ' triliun' . ($angka % 1000000000000 != 0 ? ' ' . penyebut($angka % 1000000000000) : '');
            }
        }
   // }
?>