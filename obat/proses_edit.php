<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_obat'];
    $nama = $_POST['nama_obat'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($koneksi, "UPDATE obat SET
        nama_obat='$nama',
        satuan='$satuan',
        stok='$stok',
        harga='$harga'
        WHERE id_obat='$id'");

    header("Location: index.php");
}