<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT r.*, p.nama_pasien, d.nama_dokter 
FROM resep r
LEFT JOIN pasien p ON r.id_pasien = p.id_pasien
LEFT JOIN dokter d ON r.id_dokter = d.id_dokter
ORDER BY r.tanggal_resep DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Resep</title>
</head>
<body>
    <h2>Data Resep</h2>
    <a href="create.php">+ Tambah Resep</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['tanggal_resep']); ?></td>
            <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
            <td><?= htmlspecialchars($row['nama_dokter']); ?></td>
            <td><?= htmlspecialchars($row['catatan']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_resep']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id_resep']; ?>">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>