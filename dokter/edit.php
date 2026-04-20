<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM dokter WHERE id_dokter='$id'"));
$poli = mysqli_query($koneksi, "SELECT * FROM poli ORDER BY nama_poli ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Dokter</title>
</head>
<body>
    <h2>Edit Dokter</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id_dokter" value="<?= $data['id_dokter']; ?>">
        <input type="text" name="nama_dokter" value="<?= htmlspecialchars($data['nama_dokter']); ?>" required><br><br>
        <input type="text" name="spesialis" value="<?= htmlspecialchars($data['spesialis']); ?>" required><br><br>
        <select name="id_poli" required>
            <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                <option value="<?= $row['id_poli']; ?>" <?= ($row['id_poli'] == $data['id_poli']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($row['nama_poli']); ?>
                </option>
            <?php } ?>
        </select><br><br>
        <input type="text" name="no_sip" value="<?= htmlspecialchars($data['no_sip']); ?>" required><br><br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>