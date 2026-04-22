<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM rekam_medis
    WHERE id = '$id'
"));

$kunjungan = mysqli_query($koneksi, "
    SELECT * FROM kunjungan
    ORDER BY id DESC
");

$pasien = mysqli_query($koneksi, "
    SELECT * FROM pasien
    ORDER BY nama_pasien ASC
");

$dokter = mysqli_query($koneksi, "
    SELECT * FROM dokter
    ORDER BY nama_dokter ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekam Medis</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Rekam Medis</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Rekam Medis</label>
            <input type="text"
                   name="kode_rekam_medis"
                   class="form-control"
                   value="<?= $data['kode_rekam_medis']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Kunjungan</label>
            <select name="kunjungan_id"
                    class="form-control"
                    required>
                <?php while($row = mysqli_fetch_assoc($kunjungan)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['kunjungan_id']) ? 'selected' : ''; ?>>
                        <?= $row['kode_kunjungan']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Pasien</label>
            <select name="pasien_id"
                    class="form-control"
                    required>
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
            <select name="dokter_id"
                    class="form-control"
                    required>
                <?php while($row = mysqli_fetch_assoc($dokter)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['dokter_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_dokter']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Anamnesa</label>
            <textarea name="anamnesa"
                      class="form-control"><?= $data['anamnesa']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Pemeriksaan Fisik</label>
            <textarea name="pemeriksaan_fisik"
                      class="form-control"><?= $data['pemeriksaan_fisik']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Diagnosa</label>
            <textarea name="diagnosa"
                      class="form-control"
                      required><?= $data['diagnosa']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Tindakan Medis</label>
            <textarea name="tindakan_medis"
                      class="form-control"
                      required><?= $data['tindakan_medis']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Catatan Dokter</label>
            <textarea name="catatan_dokter"
                      class="form-control"><?= $data['catatan_dokter']; ?></textarea>
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