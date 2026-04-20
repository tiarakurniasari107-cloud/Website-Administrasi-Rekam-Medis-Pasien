<?php
require_once '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM tindakan ORDER BY nama_tindakan ASC");
?>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Nama Tindakan</th>
        <th>Biaya</th>
    </tr>

    <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama_tindakan']; ?></td>
        <td><?= $row['biaya']; ?></td>
    </tr>
    <?php } ?>
</table>