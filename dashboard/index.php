<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Klinik</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">

    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <b><?= $_SESSION['nama']; ?></b></p>
    <p>Role: <b><?= $_SESSION['role']; ?></b></p>

    <hr>

    <a href="../pasien/index.php" class="btn btn-primary">Data Pasien</a>
    <a href="../dokter/index.php" class="btn btn-success">Data Dokter</a>
    <a href="../poli/index.php" class="btn btn-warning">Data Poli</a>
    <a href="../kunjungan/index.php" class="btn btn-info">Data Kunjungan</a>
    <a href="../laporan/index.php" class="btn btn-dark">Laporan</a>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>

</div>

</body>
</html>