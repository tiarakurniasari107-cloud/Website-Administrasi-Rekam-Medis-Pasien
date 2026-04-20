<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis   = $_POST['spesialis'];
    $id_poli     = $_POST['id_poli'];
    $no_sip      = $_POST['no_sip'];

    mysqli_query($koneksi, "INSERT INTO dokter (nama_dokter, spesialis, id_poli, no_sip)
    VALUES ('$nama_dokter', '$spesialis', '$id_poli', '$no_sip')");

    header("Location: index.php");
}