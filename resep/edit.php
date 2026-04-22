<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM resep
    WHERE id = '$id'
"));

$rekam_medis = mysqli_query($koneksi, "
    SELECT * FROM rekam_medis
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

$obat = mysqli_query($koneksi, "
    SELECT * FROM obat
    ORDER BY nama_obat ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Resep</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Resep</label>
            <input type="text"
                   name="kode_resep"
                   class="form-control"
                   value="<?= $data['kode_resep']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Rekam Medis</label>
            <select name="rekam_medis_id"
                    class="form-control"
                    required>
                <?php while($row = mysqli_fetch_assoc($rekam_medis)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['rekam_medis_id']) ? 'selected' : ''; ?>>
                        <?= $row['kode_rekam_medis']; ?>
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
            <label>Obat</label>
            <select name="obat_id"
                    class="form-control"
                    required>
                <?php while($row = mysqli_fetch_assoc($obat)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['obat_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_obat']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dosis</label>
            <input type="text"
                   name="dosis"
                   class="form-control"
                   value="<?= $data['dosis']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Aturan Pakai</label>
            <textarea name="aturan_pakai"
                      class="form-control"
                      required><?= $data['aturan_pakai']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Jumlah</label>
            <input type="number"
                   name="jumlah"
                   class="form-control"
                   value="<?= $data['jumlah']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Catatan</label>
            <textarea name="catatan"
                      class="form-control"><?= $data['catatan']; ?></textarea>
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