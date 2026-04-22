<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM obat
    WHERE id = '$id'
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Obat</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Obat</label>
            <input type="text"
                   name="kode_obat"
                   class="form-control"
                   value="<?= $data['kode_obat']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Nama Obat</label>
            <input type="text"
                   name="nama_obat"
                   class="form-control"
                   value="<?= $data['nama_obat']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Kategori Obat</label>
            <input type="text"
                   name="kategori_obat"
                   class="form-control"
                   value="<?= $data['kategori_obat']; ?>">
        </div>

        <div class="mb-2">
            <label>Satuan</label>
            <input type="text"
                   name="satuan"
                   class="form-control"
                   value="<?= $data['satuan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   value="<?= $data['stok']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Harga</label>
            <input type="number"
                   name="harga"
                   class="form-control"
                   value="<?= $data['harga']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan"
                      class="form-control"><?= $data['keterangan']; ?></textarea>
        </div>

        <button type="submit"
                name="update"
                class="btn btn-success">
            Update
        </button>

        <a href="index.php"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>