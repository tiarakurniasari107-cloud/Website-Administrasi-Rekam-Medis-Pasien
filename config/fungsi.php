<?php
function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

function tgl_indo($tanggal) {
    $bulan = [
        1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",
        7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"
    ];
    $pecah = explode("-", $tanggal);
    return $pecah[2] . " " . $bulan[(int)$pecah[1]] . " " . $pecah[0];
}
?>