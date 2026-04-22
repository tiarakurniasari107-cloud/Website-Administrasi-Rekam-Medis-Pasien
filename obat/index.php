<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT * FROM obat
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Obat</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Obat
    </a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_obat']; ?></td>
                <td><?= $row['nama_obat']; ?></td>
                <td><?= $row['kategori_obat']; ?></td>
                <td><?= $row['satuan']; ?></td>
                <td><?= $row['stok']; ?></td>
                <td><?= $row['harga']; ?></td>
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