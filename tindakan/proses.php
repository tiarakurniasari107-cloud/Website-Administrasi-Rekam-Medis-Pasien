<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama_tindakan = trim($_POST['nama_tindakan'] ?? '');
    $tarif = isset($_POST['tarif']) ? (float) $_POST['tarif'] : 0;
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($nama_tindakan === '') {
        header("Location: create.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "INSERT INTO tindakan (nama_tindakan, tarif, keterangan) VALUES (?, ?, NULLIF(?, ''))");
    mysqli_stmt_bind_param($stmt, "sds", $nama_tindakan, $tarif, $keterangan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>