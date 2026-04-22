<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id                  = $_POST['id'];
    $kode_rekam_medis    = $_POST['kode_rekam_medis'];
    $kunjungan_id        = $_POST['kunjungan_id'];
    $pasien_id           = $_POST['pasien_id'];
    $dokter_id           = $_POST['dokter_id'];
    $anamnesa            = $_POST['anamnesa'];
    $pemeriksaan_fisik   = $_POST['pemeriksaan_fisik'];
    $diagnosa            = $_POST['diagnosa'];
    $tindakan_medis      = $_POST['tindakan_medis'];
    $catatan_dokter      = $_POST['catatan_dokter'];

    mysqli_query($koneksi, "
        UPDATE rekam_medis SET
            kode_rekam_medis = '$kode_rekam_medis',
            kunjungan_id = '$kunjungan_id',
            pasien_id = '$pasien_id',
            dokter_id = '$dokter_id',
            anamnesa = '$anamnesa',
            pemeriksaan_fisik = '$pemeriksaan_fisik',
            diagnosa = '$diagnosa',
            tindakan_medis = '$tindakan_medis',
            catatan_dokter = '$catatan_dokter'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>