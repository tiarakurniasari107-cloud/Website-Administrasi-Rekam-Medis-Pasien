<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $tanggal_resep = $_POST['tanggal_resep'];
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $catatan = $_POST['catatan'];

    mysqli_query($koneksi, "INSERT INTO resep (tanggal_resep, id_pasien, id_dokter, catatan)
    VALUES ('$tanggal_resep', '$id_pasien', '$id_dokter', '$catatan')");

    header("Location: index.php");
}