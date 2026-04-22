<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id                = $_POST['id'];
    $kode_kunjungan    = $_POST['kode_kunjungan'];
    $pasien_id         = $_POST['pasien_id'];
    $dokter_id         = $_POST['dokter_id'];
    $poli_id           = $_POST['poli_id'];
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $jam_kunjungan     = $_POST['jam_kunjungan'];
    $jenis_kunjungan   = $_POST['jenis_kunjungan'];
    $cara_bayar        = $_POST['cara_bayar'];
    $keluhan_utama     = $_POST['keluhan_utama'];
    $status_kunjungan  = $_POST['status_kunjungan'];

    mysqli_query($koneksi, "
        UPDATE kunjungan SET
            kode_kunjungan = '$kode_kunjungan',
            pasien_id = '$pasien_id',
            dokter_id = '$dokter_id',
            poli_id = '$poli_id',
            tanggal_kunjungan = '$tanggal_kunjungan',
            jam_kunjungan = '$jam_kunjungan',
            jenis_kunjungan = '$jenis_kunjungan',
            cara_bayar = '$cara_bayar',
            keluhan_utama = '$keluhan_utama',
            status_kunjungan = '$status_kunjungan'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>