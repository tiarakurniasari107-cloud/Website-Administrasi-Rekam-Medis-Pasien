<?php
require_once '../config/auth.php';

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