<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $tanggal_rekam = $_POST['tanggal_rekam'];
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];

    mysqli_query($koneksi, "INSERT INTO rekam_medis (tanggal_rekam, id_pasien, id_dokter, diagnosa, tindakan)
    VALUES ('$tanggal_rekam', '$id_pasien', '$id_dokter', '$diagnosa', '$tindakan')");

    header("Location: index.php");
}