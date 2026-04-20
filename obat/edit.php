<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat='$id'"));
?>

<form action="proses_edit.php" method="POST">
    <input type="hidden" name="id_obat" value="<?= $data['id_obat']; ?>">

    <input type="text" name="nama_obat" value="<?= $data['nama_obat']; ?>" required><br><br>
    <input type="text" name="satuan" value="<?= $data['satuan']; ?>" required><br><br>
    <input type="number" name="stok" value="<?= $data['stok']; ?>" required><br><br>
    <input type="number" name="harga" value="<?= $data['harga']; ?>" required><br><br>

    <button type="submit" name="update">Update</button>
</form>