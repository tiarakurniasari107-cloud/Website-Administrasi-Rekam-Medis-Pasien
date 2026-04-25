<?php
require_once '../config/auth.php';
?>

<?php
$pageTitle = 'Menu Laporan';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Menu Laporan</h2>
        <p>Pilih jenis laporan yang ingin ditampilkan</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>
        </div>

        <div class="report-link-grid">
            <a href="laporan_simple.php?jenis=pasien"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Laporan Pasien</a>
            <a href="laporan_simple.php?jenis=dokter"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Laporan Dokter</a>
            <a href="laporan_simple.php?jenis=poli"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>Laporan Poli</a>
            <a href="laporan_kunjungan.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Laporan Kunjungan</a>
            <a href="laporan_rekam_medis.php"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>Laporan Rekam Medis</a>
            <a href="laporan_simple.php?jenis=obat"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>Laporan Obat</a>
            <a href="laporan_simple.php?jenis=tindakan"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>Laporan Tindakan</a>
            <a href="laporan_resep.php"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Laporan Resep</a>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
