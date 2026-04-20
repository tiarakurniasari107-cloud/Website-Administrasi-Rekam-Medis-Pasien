<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tindakan</title>
</head>
<body>
    <h2>Tambah Tindakan</h2>
    <form action="proses.php" method="POST">
        <input type="text" name="nama_tindakan" placeholder="Nama Tindakan" required><br><br>
        <input type="number" name="biaya" placeholder="Biaya" required><br><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>