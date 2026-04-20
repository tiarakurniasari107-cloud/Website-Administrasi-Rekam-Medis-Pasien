<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kunjungan WHERE id_kunjungan='$id'"));
$pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>

<form action="proses_edit.php" method="POST">
    <input type="hidden" name="id_kunjungan" value="<?= $data['id_kunjungan']; ?>">

    <input type="date" name="tanggal_kunjungan" value="<?= $data['tanggal_kunjungan']; ?>" required><br><br>

    <select name="id_pasien" required>
        <?php while($row = mysqli_fetch_assoc($pasien)) { ?>
            <option value="<?= $row['id_pasien']; ?>" <?= ($row['id_pasien'] == $data['id_pasien']) ? 'selected' : ''; ?>>
                <?= $row['nama_pasien']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <select name="id_dokter" required>
        <?php while($row = mysqli_fetch_assoc($dokter)) { ?>
            <option value="<?= $row['id_dokter']; ?>" <?= ($row['id_dokter'] == $data['id_dokter']) ? 'selected' : ''; ?>>
                <?= $row['nama_dokter']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <textarea name="keluhan"><?= $data['keluhan']; ?></textarea><br><br>

    <button type="submit" name="update">Update</button>
</form>