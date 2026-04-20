<?php
require_once '../config/koneksi.php';
$pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Resep</title>
</head>
<body>
    <h2>Tambah Resep</h2>
    <form action="proses.php" method="POST">
        <input type="date" name="tanggal_resep" required><br><br>
        <select name="id_pasien" required>
            <option value="">-- Pilih Pasien --</option>
            <?php while($row = mysqli_fetch_assoc($pasien)) { ?>
                <option value="<?= $row['id_pasien']; ?>"><?= htmlspecialchars($row['nama_pasien']); ?></option>
            <?php } ?>
        </select><br><br>
        <select name="id_dokter" required>
            <option value="">-- Pilih Dokter --</option>
            <?php while($row = mysqli_fetch_assoc($dokter)) { ?>
                <option value="<?= $row['id_dokter']; ?>"><?= htmlspecialchars($row['nama_dokter']); ?></option>
            <?php } ?>
        </select><br><br>
        <textarea name="catatan" placeholder="Catatan"></textarea><br><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>