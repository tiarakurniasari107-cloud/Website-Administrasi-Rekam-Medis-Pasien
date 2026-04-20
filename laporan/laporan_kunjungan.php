<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT k.*, p.nama_pasien, d.nama_dokter 
FROM kunjungan k
LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
LEFT JOIN dokter d ON k.id_dokter = d.id_dokter
ORDER BY k.tanggal_kunjungan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>
</head>
<body>
    <h2>Laporan Kunjungan</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Keluhan</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['tanggal_kunjungan']); ?></td>
            <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
            <td><?= htmlspecialchars($row['nama_dokter']); ?></td>
            <td><?= htmlspecialchars($row['keluhan']); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>