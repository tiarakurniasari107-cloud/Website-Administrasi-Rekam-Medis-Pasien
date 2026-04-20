<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT d.*, p.nama_poli 
FROM dokter d 
LEFT JOIN poli p ON d.id_poli = p.id_poli 
ORDER BY d.nama_dokter ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Data Dokter</h2>
        <a href="create.php">+ Tambah Dokter</a>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th>Spesialis</th>
                    <th>Poli</th>
                    <th>No. SIP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_dokter']); ?></td>
                    <td><?= htmlspecialchars($row['spesialis']); ?></td>
                    <td><?= htmlspecialchars($row['nama_poli']); ?></td>
                    <td><?= htmlspecialchars($row['no_sip']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id_dokter']; ?>">Edit</a> |
                        <a href="delete.php?id=<?= $row['id_dokter']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>