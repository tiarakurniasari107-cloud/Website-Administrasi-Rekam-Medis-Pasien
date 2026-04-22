<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM tindakan
    WHERE id = '$id'
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tindakan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Tindakan</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Tindakan</label>
            <input type="text"
                   name="kode_tindakan"
                   class="form-control"
                   value="<?= $data['kode_tindakan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Nama Tindakan</label>
            <input type="text"
                   name="nama_tindakan"
                   class="form-control"
                   value="<?= $data['nama_tindakan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Kategori Tindakan</label>
            <input type="text"
                   name="kategori_tindakan"
                   class="form-control"
                   value="<?= $data['kategori_tindakan']; ?>">
        </div>

        <div class="mb-2">
            <label>Biaya</label>
            <input type="number"
                   name="biaya"
                   class="form-control"
                   value="<?= $data['biaya']; ?>"
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