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
        d.nama_dokter,
        k.kode_kunjungan
    FROM rekam_medis rm
    LEFT JOIN pasien p ON rm.pasien_id = p.id
    LEFT JOIN dokter d ON rm.dokter_id = d.id
    LEFT JOIN kunjungan k ON rm.kunjungan_id = k.id
    ORDER BY rm.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Rekam Medis</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Rekam Medis
    </a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode RM</th>
                <th>Kode Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_rekam_medis']; ?></td>
                <td><?= $row['kode_kunjungan']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['diagnosa']; ?></td>
                <td><?= $row['tindakan_medis']; ?></td>
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