<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT *
    FROM tindakan
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tindakan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Tindakan</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=tindakan"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Kategori</th>
                <th>Biaya</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_tindakan']; ?></td>
                <td><?= $row['nama_tindakan']; ?></td>
                <td><?= $row['kategori_tindakan']; ?></td>
                <td><?= $row['biaya']; ?></td>
                <td><?= $row['keterangan']; ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>