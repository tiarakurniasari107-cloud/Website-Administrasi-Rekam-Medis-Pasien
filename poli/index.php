<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT * FROM poli
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Poli</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Poli</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Poli
    </a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_poli']; ?></td>
                <td><?= $row['nama_poli']; ?></td>
                <td><?= $row['keterangan']; ?></td>
                <td>

                    <a href="edit.php?id=<?= $row['id']; ?>"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

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