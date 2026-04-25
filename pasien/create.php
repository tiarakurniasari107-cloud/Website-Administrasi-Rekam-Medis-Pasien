<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
$pageTitle = 'Tambah Pasien';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Tambah Pasien</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>No RM</label>
            <input type="text" name="no_rm" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control">
        </div>

        <div class="mb-2">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control">
        </div>

        <div class="mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control">
        </div>

        <div class="mb-2">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text" name="no_telp" class="form-control">
        </div>

        <div class="mb-2">
            <label>Golongan Darah</label>
            <select name="golongan_darah" class="form-control">
                <option value="">-- Pilih --</option>
                <option>A</option>
                <option>B</option>
                <option>AB</option>
                <option>O</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Alergi</label>
            <textarea name="alergi" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kawin</label>
            <input type="text" name="status_kawin" class="form-control">
        </div>

        <div class="mb-2">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control">
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">
            Simpan
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?php require_once '../includes/footer.php'; ?>
