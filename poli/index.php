<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM poli ORDER BY nama_poli ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Poli</title>
</head>
<body>
    <h2>Data Poli</h2>
    <a href="create.php">+ Tambah Poli</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama Poli</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_poli']); ?></td>
            <td><?= htmlspecialchars($row['keterangan']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_poli']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id_poli']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>