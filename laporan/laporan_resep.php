<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT
        r.*,
        p.nama_pasien,
        d.nama_dokter,
        o.nama_obat
    FROM resep r
    LEFT JOIN pasien p ON r.pasien_id = p.id
    LEFT JOIN dokter d ON r.dokter_id = d.id
    LEFT JOIN obat o ON r.obat_id = o.id
    ORDER BY r.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resep</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Resep</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=resep"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Resep</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Obat</th>
                <th>Dosis</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_resep']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['nama_obat']; ?></td>
                <td><?= $row['dosis']; ?></td>
                <td><?= $row['jumlah']; ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>