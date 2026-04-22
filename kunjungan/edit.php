<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "
        SELECT * FROM kunjungan
        WHERE id = '$id'
    ")
);

$pasien = mysqli_query($koneksi, "
    SELECT * FROM pasien
    ORDER BY nama_pasien ASC
");

$dokter = mysqli_query($koneksi, "
    SELECT * FROM dokter
    ORDER BY nama_dokter ASC
");

$poli = mysqli_query($koneksi, "
    SELECT * FROM poli
    ORDER BY nama_poli ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kunjungan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Kunjungan</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Kunjungan</label>
            <input type="text"
                   name="kode_kunjungan"
                   class="form-control"
                   value="<?= $data['kode_kunjungan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Pasien</label>
            <select name="pasien_id" class="form-control" required>
                <?php while($row = mysqli_fetch_assoc($pasien)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['pasien_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_pasien']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dokter</label>
            <select name="dokter_id" class="form-control" required>
                <?php while($row = mysqli_fetch_assoc($dokter)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['dokter_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_dokter']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id" class="form-control" required>
                <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['poli_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_poli']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Kunjungan</label>
            <input type="date"
                   name="tanggal_kunjungan"
                   class="form-control"
                   value="<?= $data['tanggal_kunjungan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Jam Kunjungan</label>
            <input type="time"
                   name="jam_kunjungan"
                   class="form-control"
                   value="<?= $data['jam_kunjungan']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Jenis Kunjungan</label>
            <input type="text"
                   name="jenis_kunjungan"
                   class="form-control"
                   value="<?= $data['jenis_kunjungan']; ?>">
        </div>

        <div class="mb-2">
            <label>Cara Bayar</label>
            <input type="text"
                   name="cara_bayar"
                   class="form-control"
                   value="<?= $data['cara_bayar']; ?>">
        </div>

        <div class="mb-2">
            <label>Keluhan Utama</label>
            <textarea name="keluhan_utama"
                      class="form-control"><?= $data['keluhan_utama']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kunjungan</label>
            <select name="status_kunjungan" class="form-control">
                <option value="menunggu"
                    <?= ($data['status_kunjungan'] == 'menunggu') ? 'selected' : ''; ?>>
                    Menunggu
                </option>

                <option value="diperiksa"
                    <?= ($data['status_kunjungan'] == 'diperiksa') ? 'selected' : ''; ?>>
                    Diperiksa
                </option>

                <option value="selesai"
                    <?= ($data['status_kunjungan'] == 'selesai') ? 'selected' : ''; ?>>
                    Selesai
                </option>
            </select>
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