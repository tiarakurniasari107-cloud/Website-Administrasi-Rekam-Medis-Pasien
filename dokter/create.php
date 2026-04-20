<?php
require_once '../config/koneksi.php';
$poli = mysqli_query($koneksi, "SELECT * FROM poli ORDER BY nama_poli ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Dokter</title>
</head>
<body>
    <h2>Tambah Dokter</h2>
    <form action="proses.php" method="POST">
        <input type="text" name="nama_dokter" placeholder="Nama Dokter" required><br><br>
        <input type="text" name="spesialis" placeholder="Spesialis" required><br><br>
        <select name="id_poli" required>
            <option value="">-- Pilih Poli --</option>
            <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                <option value="<?= $row['id_poli']; ?>"><?= htmlspecialchars($row['nama_poli']); ?></option>
            <?php } ?>
        </select><br><br>
        <input type="text" name="no_sip" placeholder="No. SIP" required><br><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>