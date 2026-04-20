<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM poli ORDER BY nama_poli ASC");
?>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Nama Poli</th>
        <th>Keterangan</th>
    </tr>

    <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama_poli']; ?></td>
        <td><?= $row['keterangan']; ?></td>
    </tr>
    <?php } ?>
</table>