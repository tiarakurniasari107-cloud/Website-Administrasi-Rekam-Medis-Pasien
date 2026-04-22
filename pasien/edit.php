<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM pasien WHERE id='$id'")
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pasien</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Pasien</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>No RM</label>
            <input type="text" name="no_rm" class="form-control"
                   value="<?= $data['no_rm']; ?>" required>
        </div>

        <div class="mb-2">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control"
                   value="<?= $data['nik']; ?>">
        </div>

        <div class="mb-2">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control"
                   value="<?= $data['nama_pasien']; ?>" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                    Laki-laki
                </option>
                <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                    Perempuan
                </option>
            </select>
        </div>

        <div class="mb-2">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control"
                   value="<?= $data['tempat_lahir']; ?>">
        </div>

        <div class="mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control"
                   value="<?= $data['tanggal_lahir']; ?>">
        </div>

        <div class="mb-2">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control"
                   value="<?= $data['umur']; ?>">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= $data['alamat']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text" name="no_telp" class="form-control"
                   value="<?= $data['no_telp']; ?>">
        </div>

        <div class="mb-2">
            <label>Golongan Darah</label>
            <select name="golongan_darah" class="form-control">
                <option value="">-- Pilih --</option>
                <option value="A" <?= ($data['golongan_darah'] == 'A') ? 'selected' : ''; ?>>A</option>
                <option value="B" <?= ($data['golongan_darah'] == 'B') ? 'selected' : ''; ?>>B</option>
                <option value="AB" <?= ($data['golongan_darah'] == 'AB') ? 'selected' : ''; ?>>AB</option>
                <option value="O" <?= ($data['golongan_darah'] == 'O') ? 'selected' : ''; ?>>O</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Alergi</label>
            <textarea name="alergi" class="form-control"><?= $data['alergi']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kawin</label>
            <input type="text" name="status_kawin" class="form-control"
                   value="<?= $data['status_kawin']; ?>">
        </div>

        <div class="mb-2">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control"
                   value="<?= $data['pekerjaan']; ?>">
        </div>

        <button type="submit" name="update" class="btn btn-success">
            Update
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>