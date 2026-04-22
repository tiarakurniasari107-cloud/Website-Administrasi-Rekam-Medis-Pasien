<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id             = $_POST['id'];
    $kode_obat      = $_POST['kode_obat'];
    $nama_obat      = $_POST['nama_obat'];
    $kategori_obat  = $_POST['kategori_obat'];
    $satuan         = $_POST['satuan'];
    $stok           = $_POST['stok'];
    $harga          = $_POST['harga'];
    $keterangan     = $_POST['keterangan'];

    mysqli_query($koneksi, "
        UPDATE obat SET
            kode_obat = '$kode_obat',
            nama_obat = '$nama_obat',
            kategori_obat = '$kategori_obat',
            satuan = '$satuan',
            stok = '$stok',
            harga = '$harga',
            keterangan = '$keterangan'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>