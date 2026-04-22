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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Laporan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Menu Laporan</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary mb-3">
        Kembali
    </a>

    <div class="list-group">

        <a href="laporan_pasien.php" class="list-group-item list-group-item-action">
            Laporan Pasien
        </a>

        <a href="laporan_dokter.php" class="list-group-item list-group-item-action">
            Laporan Dokter
        </a>

        <a href="laporan_poli.php" class="list-group-item list-group-item-action">
            Laporan Poli
        </a>

        <a href="laporan_kunjungan.php" class="list-group-item list-group-item-action">
            Laporan Kunjungan
        </a>

        <a href="laporan_rekam_medis.php" class="list-group-item list-group-item-action">
            Laporan Rekam Medis
        </a>

        <a href="laporan_obat.php" class="list-group-item list-group-item-action">
            Laporan Obat
        </a>

        <a href="laporan_tindakan.php" class="list-group-item list-group-item-action">
            Laporan Tindakan
        </a>

        <a href="laporan_resep.php" class="list-group-item list-group-item-action">
            Laporan Resep
        </a>

    </div>

</div>

</body>
</html>