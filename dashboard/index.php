<?php
require_once '../config/auth.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
?>

<?php
$pageTitle = 'Dashboard Klinik';
require_once '../includes/header.php';
?>


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

<?php require_once '../includes/footer.php'; ?>
