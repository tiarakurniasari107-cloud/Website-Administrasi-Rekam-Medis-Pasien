<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT d.*, p.nama_poli
    FROM dokter d
    LEFT JOIN poli p ON d.poli_id = p.id
    ORDER BY d.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Dokter</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Dokter</h2>

    <a href="index.php" class="btn btn-secondary">Kembali</a>

    <a href="print.php?jenis=dokter"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Dokter</th>
                <th>Nama Dokter</th>
                <th>Spesialis</th>
                <th>Poli</th>
                <th>No SIP</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_dokter']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['spesialis']; ?></td>
                <td><?= $row['nama_poli']; ?></td>
                <td><?= $row['no_sip']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>