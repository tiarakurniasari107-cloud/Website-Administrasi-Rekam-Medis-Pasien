<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $keluhan = $_POST['keluhan'];

    mysqli_query($koneksi, "INSERT INTO kunjungan (tanggal_kunjungan, id_pasien, id_dokter, keluhan)
    VALUES ('$tanggal_kunjungan', '$id_pasien', '$id_dokter', '$keluhan')");

    header("Location: index.php");
}