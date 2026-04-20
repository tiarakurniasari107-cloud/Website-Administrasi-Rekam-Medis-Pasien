<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_obat = $_POST['nama_obat'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($koneksi, "INSERT INTO obat (nama_obat, satuan, stok, harga)
    VALUES ('$nama_obat', '$satuan', '$stok', '$harga')");

    header("Location: index.php");
}