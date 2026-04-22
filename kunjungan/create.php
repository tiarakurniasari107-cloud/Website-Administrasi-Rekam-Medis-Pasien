<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
$poli   = mysqli_query($koneksi, "SELECT * FROM poli ORDER BY nama_poli ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kunjungan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Tambah Kunjungan</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Kode Kunjungan</label>
            <input type="text" name="kode_kunjungan"
                   class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Pasien</label>
            <select name="pasien_id" class="form-control" required>
                <option value="">-- Pilih Pasien --</option>
                <?php while($row = mysqli_fetch_assoc($pasien)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= $row['nama_pasien']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dokter</label>
            <select name="dokter_id" class="form-control" required>
                <option value="">-- Pilih Dokter --</option>
                <?php while($row = mysqli_fetch_assoc($dokter)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= $row['nama_dokter']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id" class="form-control" required>
                <option value="">-- Pilih Poli --</option>
                <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= $row['nama_poli']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal_kunjungan"
                   class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jam Kunjungan</label>
            <input type="time" name="jam_kunjungan"
                   class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kunjungan</label>
            <input type="text" name="jenis_kunjungan"
                   class="form-control">
        </div>

        <div class="mb-2">
            <label>Cara Bayar</label>
            <input type="text" name="cara_bayar"
                   class="form-control">
        </div>

        <div class="mb-2">
            <label>Keluhan Utama</label>
            <textarea name="keluhan_utama"
                      class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kunjungan</label>
            <select name="status_kunjungan"
                    class="form-control">
                <option value="menunggu">Menunggu</option>
                <option value="diperiksa">Diperiksa</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <button type="submit"
                name="simpan"
                class="btn btn-primary">
            Simpan
        </button>

        <a href="index.php"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>