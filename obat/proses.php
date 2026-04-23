<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama_obat = trim($_POST['nama_obat'] ?? '');
    $satuan = trim($_POST['satuan'] ?? '');
    $stok = isset($_POST['stok']) ? (int) $_POST['stok'] : 0;
    $harga = isset($_POST['harga']) ? (float) $_POST['harga'] : 0;
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($nama_obat === '') {
        header("Location: create.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "INSERT INTO obat (nama_obat, satuan, stok, harga, keterangan) VALUES (?, NULLIF(?, ''), ?, ?, NULLIF(?, ''))");
    mysqli_stmt_bind_param($stmt, "ssids", $nama_obat, $satuan, $stok, $harga, $keterangan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>