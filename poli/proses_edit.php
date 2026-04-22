<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($koneksi, "
        UPDATE poli SET
            nama_poli = '$nama_poli',
            keterangan = '$keterangan'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>