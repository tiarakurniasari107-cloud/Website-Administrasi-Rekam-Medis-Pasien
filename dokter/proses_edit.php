<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {
    $id_dokter  = $_POST['id_dokter'];
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis   = $_POST['spesialis'];
    $id_poli     = $_POST['id_poli'];
    $no_sip      = $_POST['no_sip'];

    mysqli_query($koneksi, "UPDATE dokter SET 
        nama_dokter='$nama_dokter',
        spesialis='$spesialis',
        id_poli='$id_poli',
        no_sip='$no_sip'
        WHERE id_dokter='$id_dokter'");

    header("Location: index.php");
}