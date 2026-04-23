<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['update'])) {

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nama_obat = trim($_POST['nama_obat'] ?? '');
    $satuan = trim($_POST['satuan'] ?? '');
    $stok = isset($_POST['stok']) ? (int) $_POST['stok'] : 0;
    $harga = isset($_POST['harga']) ? (float) $_POST['harga'] : 0;
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($id <= 0 || $nama_obat === '') {
        header("Location: index.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE obat SET nama_obat = ?, satuan = NULLIF(?, ''), stok = ?, harga = ?, keterangan = NULLIF(?, '') WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssidsi", $nama_obat, $satuan, $stok, $harga, $keterangan, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>