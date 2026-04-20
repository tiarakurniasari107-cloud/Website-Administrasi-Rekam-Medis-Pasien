<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_kunjungan'];
    $tanggal = $_POST['tanggal_kunjungan'];
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $keluhan = $_POST['keluhan'];

    mysqli_query($koneksi, "UPDATE kunjungan SET
        tanggal_kunjungan='$tanggal',
        id_pasien='$id_pasien',
        id_dokter='$id_dokter',
        keluhan='$keluhan'
        WHERE id_kunjungan='$id'");

    header("Location: index.php");
}