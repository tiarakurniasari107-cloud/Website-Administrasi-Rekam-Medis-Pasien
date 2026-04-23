<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter,
        r.tanggal_resep,
        r.catatan,
        GROUP_CONCAT(CONCAT(o.nama_obat, ' (', rd.dosis, ', ', rd.jumlah, ')') SEPARATOR '; ') AS daftar_obat
    FROM resep r
    INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN resep_detail rd ON rd.resep_id = r.id
    LEFT JOIN obat o ON rd.obat_id = o.id
    GROUP BY r.id, k.kode_kunjungan, p.nama_pasien, d.nama_dokter, r.tanggal_resep, r.catatan
    ORDER BY r.id DESC"
);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resep</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Resep</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="print.php?jenis=resep"
       target="_blank"
       class="btn btn-success">
        Print
    </a>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Resep</th>
                <th>Daftar Obat</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['tanggal_resep'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['daftar_obat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['catatan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

</body>
</html>