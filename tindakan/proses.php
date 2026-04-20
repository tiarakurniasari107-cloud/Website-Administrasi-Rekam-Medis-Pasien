<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_tindakan = $_POST['nama_tindakan'];
    $biaya = $_POST['biaya'];

    mysqli_query($koneksi, "INSERT INTO tindakan (nama_tindakan, biaya)
    VALUES ('$nama_tindakan', '$biaya')");

    header("Location: index.php");
}