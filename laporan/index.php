<?php
require_once '../config/auth.php';
?>

<?php
$pageTitle = 'Menu Laporan';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Menu Laporan</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <div class="list-group">

        <a href="laporan_simple.php?jenis=pasien" class="list-group-item list-group-item-action">
            Laporan Pasien
        </a>

        <a href="laporan_simple.php?jenis=dokter" class="list-group-item list-group-item-action">
            Laporan Dokter
        </a>

        <a href="laporan_simple.php?jenis=poli" class="list-group-item list-group-item-action">
            Laporan Poli
        </a>

        <a href="laporan_kunjungan.php" class="list-group-item list-group-item-action">
            Laporan Kunjungan
        </a>

        <a href="laporan_rekam_medis.php" class="list-group-item list-group-item-action">
            Laporan Rekam Medis
        </a>

        <a href="laporan_simple.php?jenis=obat" class="list-group-item list-group-item-action">
            Laporan Obat
        </a>

        <a href="laporan_simple.php?jenis=tindakan" class="list-group-item list-group-item-action">
            Laporan Tindakan
        </a>

        <a href="laporan_resep.php" class="list-group-item list-group-item-action">
            Laporan Resep
        </a>

    </div>

</div>

<?php require_once '../includes/footer.php'; ?>
