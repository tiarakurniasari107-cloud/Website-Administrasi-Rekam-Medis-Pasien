<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT *
    FROM pasien
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pasien</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Pasien</h2>

    <a href="index.php" class="btn btn-secondary">Kembali</a>

    <a href="print.php?jenis=pasien"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Alamat</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['no_rm']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['jenis_kelamin']; ?></td>
                <td><?= $row['no_hp']; ?></td>
                <td><?= $row['alamat']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>