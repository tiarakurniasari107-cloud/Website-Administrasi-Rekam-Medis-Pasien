<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM poli WHERE id_poli='$id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Poli</title>
</head>
<body>
    <h2>Edit Poli</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id_poli" value="<?= $data['id_poli']; ?>">
        <input type="text" name="nama_poli" value="<?= htmlspecialchars($data['nama_poli']); ?>" required><br><br>
        <textarea name="keterangan"><?= htmlspecialchars($data['keterangan']); ?></textarea><br><br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>