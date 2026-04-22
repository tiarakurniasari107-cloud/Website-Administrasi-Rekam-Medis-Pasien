<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

    $kode_kunjungan   = $_POST['kode_kunjungan'];
    $pasien_id        = $_POST['pasien_id'];
    $dokter_id        = $_POST['dokter_id'];
    $poli_id          = $_POST['poli_id'];
    $tanggal_kunjungan= $_POST['tanggal_kunjungan'];
    $jam_kunjungan    = $_POST['jam_kunjungan'];
    $jenis_kunjungan  = $_POST['jenis_kunjungan'];
    $cara_bayar       = $_POST['cara_bayar'];
    $keluhan_utama    = $_POST['keluhan_utama'];
    $status_kunjungan = $_POST['status_kunjungan'];

    mysqli_query($koneksi, "
        INSERT INTO kunjungan (
            kode_kunjungan,
            pasien_id,
            dokter_id,
            poli_id,
            tanggal_kunjungan,
            jam_kunjungan,
            jenis_kunjungan,
            cara_bayar,
            keluhan_utama,
            status_kunjungan
        ) VALUES (
            '$kode_kunjungan',
            '$pasien_id',
            '$dokter_id',
            '$poli_id',
            '$tanggal_kunjungan',
            '$jam_kunjungan',
            '$jenis_kunjungan',
            '$cara_bayar',
            '$keluhan_utama',
            '$status_kunjungan'
        )
    ");

    header("Location: index.php");
    exit;
}
?>