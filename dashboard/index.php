<?php
require_once '../config/auth.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');

$totals = [
    'pasien' => 0,
    'dokter' => 0,
    'poli' => 0,
    'kunjungan_hari_ini' => 0,
];

$queries = [
    'pasien' => 'SELECT COUNT(*) AS total FROM pasien',
    'dokter' => 'SELECT COUNT(*) AS total FROM dokter',
    'poli' => 'SELECT COUNT(*) AS total FROM poli',
    'kunjungan_hari_ini' => 'SELECT COUNT(*) AS total FROM kunjungan WHERE DATE(tanggal_kunjungan) = CURDATE()',
];

foreach ($queries as $key => $sql) {
    $result = mysqli_query($koneksi, $sql);
    if ($result instanceof mysqli_result) {
        $row = mysqli_fetch_assoc($result);
        $totals[$key] = (int) ($row['total'] ?? 0);
        mysqli_free_result($result);
    }
}

$namaUser = htmlspecialchars((string) ($_SESSION['nama'] ?? '-'), ENT_QUOTES, 'UTF-8');
$roleUser = htmlspecialchars((string) ($_SESSION['role'] ?? '-'), ENT_QUOTES, 'UTF-8');
?>

<?php
$pageTitle = 'Dashboard Klinik';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <strong><?= $namaUser; ?></strong></p>
        <p>Role: <strong><?= $roleUser; ?></strong></p>
    </section>

    <section class="dashboard-metrics">
        <article class="metric-card">
            <div class="metric-value"><?= $totals['pasien']; ?></div>
            <p class="metric-label">Total Pasien</p>
        </article>

        <article class="metric-card">
            <div class="metric-value"><?= $totals['dokter']; ?></div>
            <p class="metric-label">Total Dokter</p>
        </article>

        <article class="metric-card">
            <div class="metric-value"><?= $totals['poli']; ?></div>
            <p class="metric-label">Total Poli</p>
        </article>

        <article class="metric-card">
            <div class="metric-value"><?= $totals['kunjungan_hari_ini']; ?></div>
            <p class="metric-label">Kunjungan Hari Ini</p>
        </article>
    </section>

    <h3 class="menu-title">Menu Utama</h3>

    <section class="menu-grid">
        <a href="../pasien/index.php" class="menu-card">
            <span class="glyphicon glyphicon-user menu-icon icon-pasien" aria-hidden="true"></span>
            <h4 class="menu-name">Data Pasien</h4>
            <p class="menu-desc">Kelola data pasien klinik</p>
        </a>

        <a href="../dokter/index.php" class="menu-card">
            <span class="glyphicon glyphicon-plus-sign menu-icon icon-dokter" aria-hidden="true"></span>
            <h4 class="menu-name">Data Dokter</h4>
            <p class="menu-desc">Kelola data dokter</p>
        </a>

        <a href="../poli/index.php" class="menu-card">
            <span class="glyphicon glyphicon-th-large menu-icon icon-poli" aria-hidden="true"></span>
            <h4 class="menu-name">Data Poli</h4>
            <p class="menu-desc">Kelola data poliklinik</p>
        </a>

        <a href="../kunjungan/index.php" class="menu-card">
            <span class="glyphicon glyphicon-list-alt menu-icon icon-kunjungan" aria-hidden="true"></span>
            <h4 class="menu-name">Data Kunjungan</h4>
            <p class="menu-desc">Kelola data kunjungan</p>
        </a>

        <a href="../laporan/index.php" class="menu-card">
            <span class="glyphicon glyphicon-stats menu-icon icon-laporan" aria-hidden="true"></span>
            <h4 class="menu-name">Laporan</h4>
            <p class="menu-desc">Cetak &amp; lihat laporan</p>
        </a>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
