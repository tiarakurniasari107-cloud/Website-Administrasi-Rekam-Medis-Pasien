<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

    $kode_rekam_medis   = $_POST['kode_rekam_medis'];
    $kunjungan_id       = $_POST['kunjungan_id'];
    $pasien_id          = $_POST['pasien_id'];
    $dokter_id          = $_POST['dokter_id'];
    $anamnesa           = $_POST['anamnesa'];
    $pemeriksaan_fisik  = $_POST['pemeriksaan_fisik'];
    $diagnosa           = $_POST['diagnosa'];
    $tindakan_medis     = $_POST['tindakan_medis'];
    $catatan_dokter     = $_POST['catatan_dokter'];

    mysqli_query($koneksi, "
        INSERT INTO rekam_medis (
            kode_rekam_medis,
            kunjungan_id,
            pasien_id,
            dokter_id,
            anamnesa,
            pemeriksaan_fisik,
            diagnosa,
            tindakan_medis,
            catatan_dokter
        ) VALUES (
            '$kode_rekam_medis',
            '$kunjungan_id',
            '$pasien_id',
            '$dokter_id',
            '$anamnesa',
            '$pemeriksaan_fisik',
            '$diagnosa',
            '$tindakan_medis',
            '$catatan_dokter'
        )
    ");

    header("Location: index.php");
    exit;
}
?>