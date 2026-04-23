<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "
    SELECT d.kode_dokter, d.nama_dokter, d.spesialisasi, p.nama_poli, d.no_sip
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
                <td><?= htmlspecialchars($row['kode_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['spesialisasi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['no_sip'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

</body>
</html>