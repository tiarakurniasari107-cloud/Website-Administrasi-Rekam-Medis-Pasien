<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($koneksi, "
        INSERT INTO poli (
            nama_poli,
            keterangan
        ) VALUES (
            '$nama_poli',
            '$keterangan'
        )
    ");

    header("Location: index.php");
    exit;
}
?>