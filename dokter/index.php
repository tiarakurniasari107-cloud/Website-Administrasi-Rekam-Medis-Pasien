<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "
    SELECT d.id, d.kode_dokter, d.nama_dokter, d.jenis_kelamin, d.spesialisasi, d.status, p.nama_poli
    FROM dokter d
    LEFT JOIN poli p ON d.poli_id = p.id
    ORDER BY d.id DESC
");
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Dokter</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
    <a href="create.php" class="btn btn-primary">+ Tambah Dokter</a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Dokter</th>
                <th>JK</th>
                <th>Spesialisasi</th>
                <th>Poli</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_dokter'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= ($row['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                <td><?= htmlspecialchars($row['spesialisasi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
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

    <?php mysqli_stmt_close($stmt); ?>

</div>

</body>
</html>