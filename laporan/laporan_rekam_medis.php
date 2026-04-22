<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT 
        rm.*,
        p.nama_pasien,
        d.nama_dokter
    FROM rekam_medis rm
    LEFT JOIN pasien p ON rm.pasien_id = p.id
    LEFT JOIN dokter d ON rm.dokter_id = d.id
    ORDER BY rm.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekam Medis</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Rekam Medis</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=rekam_medis"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Rekam Medis</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_rekam_medis']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['diagnosa']; ?></td>
                <td><?= $row['tindakan']; ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>