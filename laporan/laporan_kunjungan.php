<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT 
        k.*,
        p.nama_pasien,
        d.nama_dokter
    FROM kunjungan k
    LEFT JOIN pasien p ON k.pasien_id = p.id
    LEFT JOIN dokter d ON k.dokter_id = d.id
    ORDER BY k.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Kunjungan</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=kunjungan"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Tanggal</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Keluhan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_kunjungan']; ?></td>
                <td><?= $row['tanggal_kunjungan']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['keluhan']; ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>