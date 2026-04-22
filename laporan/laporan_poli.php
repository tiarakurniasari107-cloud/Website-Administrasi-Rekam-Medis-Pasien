<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT *
    FROM poli
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Poli</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Poli</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=poli"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Poli</th>
                <th>Nama Poli</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_poli']; ?></td>
                <td><?= $row['nama_poli']; ?></td>
                <td><?= $row['keterangan']; ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>