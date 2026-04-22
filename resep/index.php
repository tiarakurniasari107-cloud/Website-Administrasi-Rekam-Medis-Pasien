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
        rm.kode_rekam_medis,
        p.nama_pasien,
        d.nama_dokter,
        o.nama_obat
    FROM resep r
    LEFT JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Resep</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Resep</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Resep
    </a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Resep</th>
                <th>Rekam Medis</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Obat</th>
                <th>Dosis</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_resep']; ?></td>
                <td><?= $row['kode_rekam_medis']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['nama_obat']; ?></td>
                <td><?= $row['dosis']; ?></td>
                <td><?= $row['jumlah']; ?></td>
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