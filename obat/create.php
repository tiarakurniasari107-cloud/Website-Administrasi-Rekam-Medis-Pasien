<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Obat</title>
</head>
<body>
    <h2>Tambah Obat</h2>
    <form action="proses.php" method="POST">
        <input type="text" name="nama_obat" placeholder="Nama Obat" required><br><br>
        <input type="text" name="satuan" placeholder="Satuan" required><br><br>
        <input type="number" name="stok" placeholder="Stok" required><br><br>
        <input type="number" name="harga" placeholder="Harga" required><br><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>