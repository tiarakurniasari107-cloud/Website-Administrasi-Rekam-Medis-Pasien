<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['update'])) {

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nama_poli = trim($_POST['nama_poli'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($id <= 0 || $nama_poli === '') {
        header("Location: index.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE poli SET nama_poli = ?, keterangan = NULLIF(?, '') WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nama_poli, $keterangan, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>