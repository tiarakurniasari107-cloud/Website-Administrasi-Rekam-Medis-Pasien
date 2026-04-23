<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "
    SELECT no_rm, nama_pasien, jenis_kelamin, no_telp, alamat
    FROM pasien
    ORDER BY id DESC
");
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
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
                <td><?= htmlspecialchars($row['no_rm'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= ($row['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                <td><?= htmlspecialchars($row['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

</body>
</html>