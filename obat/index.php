<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM obat ORDER BY nama_obat ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Obat</title>
</head>
<body>
    <h2>Data Obat</h2>
    <a href="create.php">+ Tambah Obat</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_obat']); ?></td>
            <td><?= htmlspecialchars($row['satuan']); ?></td>
            <td><?= htmlspecialchars($row['stok']); ?></td>
            <td><?= htmlspecialchars($row['harga']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_obat']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id_obat']; ?>">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>