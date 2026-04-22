<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id               = $_POST['id'];
    $kode_resep       = $_POST['kode_resep'];
    $rekam_medis_id   = $_POST['rekam_medis_id'];
    $pasien_id        = $_POST['pasien_id'];
    $dokter_id        = $_POST['dokter_id'];
    $obat_id          = $_POST['obat_id'];
    $dosis            = $_POST['dosis'];
    $aturan_pakai     = $_POST['aturan_pakai'];
    $jumlah           = $_POST['jumlah'];
    $catatan          = $_POST['catatan'];

    mysqli_query($koneksi, "
        UPDATE resep SET
            kode_resep = '$kode_resep',
            rekam_medis_id = '$rekam_medis_id',
            pasien_id = '$pasien_id',
            dokter_id = '$dokter_id',
            obat_id = '$obat_id',
            dosis = '$dosis',
            aturan_pakai = '$aturan_pakai',
            jumlah = '$jumlah',
            catatan = '$catatan'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>