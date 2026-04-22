<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id                 = $_POST['id'];
    $kode_tindakan      = $_POST['kode_tindakan'];
    $nama_tindakan      = $_POST['nama_tindakan'];
    $kategori_tindakan  = $_POST['kategori_tindakan'];
    $biaya              = $_POST['biaya'];
    $keterangan         = $_POST['keterangan'];

    mysqli_query($koneksi, "
        UPDATE tindakan SET
            kode_tindakan = '$kode_tindakan',
            nama_tindakan = '$nama_tindakan',
            kategori_tindakan = '$kategori_tindakan',
            biaya = '$biaya',
            keterangan = '$keterangan'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>