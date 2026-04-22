<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Pasien</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
    <a href="create.php" class="btn btn-primary">+ Tambah Pasien</a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No RM</th>
                <th>NIK</th>
                <th>Nama Pasien</th>
                <th>JK</th>
                <th>No Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['no_rm']; ?></td>
                <td><?= $row['nik']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['jenis_kelamin']; ?></td>
                <td><?= $row['no_telp']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                    <a href="delete.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin hapus data?')"
                       class="btn btn-danger btn-sm">
                       Hapus
                    </a>
                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>