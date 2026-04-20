<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT rm.*, p.nama_pasien, d.nama_dokter 
FROM rekam_medis rm
LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
ORDER BY rm.tanggal_rekam DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekam Medis</title>
</head>
<body>
    <h2>Rekam Medis</h2>
    <a href="create.php">+ Tambah Rekam Medis</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Diagnosa</th>
            <th>Tindakan</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['tanggal_rekam']); ?></td>
            <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
            <td><?= htmlspecialchars($row['nama_dokter']); ?></td>
            <td><?= htmlspecialchars($row['diagnosa']); ?></td>
            <td><?= htmlspecialchars($row['tindakan']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_rekam_medis']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id_rekam_medis']; ?>">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>