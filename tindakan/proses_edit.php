<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['update'])) {

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nama_tindakan = trim($_POST['nama_tindakan'] ?? '');
    $tarif = isset($_POST['tarif']) ? (float) $_POST['tarif'] : 0;
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($id <= 0 || $nama_tindakan === '') {
        header("Location: index.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE tindakan SET nama_tindakan = ?, tarif = ?, keterangan = NULLIF(?, '') WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sdsi", $nama_tindakan, $tarif, $keterangan, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>