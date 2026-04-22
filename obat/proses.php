<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

    $kode_obat      = $_POST['kode_obat'];
    $nama_obat      = $_POST['nama_obat'];
    $kategori_obat  = $_POST['kategori_obat'];
    $satuan         = $_POST['satuan'];
    $stok           = $_POST['stok'];
    $harga          = $_POST['harga'];
    $keterangan     = $_POST['keterangan'];

    mysqli_query($koneksi, "
        INSERT INTO obat (
            kode_obat,
            nama_obat,
            kategori_obat,
            satuan,
            stok,
            harga,
            keterangan
        ) VALUES (
            '$kode_obat',
            '$nama_obat',
            '$kategori_obat',
            '$satuan',
            '$stok',
            '$harga',
            '$keterangan'
        )
    ");

    header("Location: index.php");
    exit;
}
?>