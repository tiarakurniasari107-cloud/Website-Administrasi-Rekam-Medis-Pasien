<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama_poli = trim($_POST['nama_poli'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($nama_poli === '') {
        header("Location: create.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "INSERT INTO poli (nama_poli, keterangan) VALUES (?, NULLIF(?, ''))");
    mysqli_stmt_bind_param($stmt, "ss", $nama_poli, $keterangan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>