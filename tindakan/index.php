<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM tindakan ORDER BY nama_tindakan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Tindakan</title>
</head>
<body>
    <h2>Data Tindakan</h2>
    <a href="create.php">+ Tambah Tindakan</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama Tindakan</th>
            <th>Biaya</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_tindakan']); ?></td>
            <td><?= htmlspecialchars($row['biaya']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_tindakan']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id_tindakan']; ?>">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>