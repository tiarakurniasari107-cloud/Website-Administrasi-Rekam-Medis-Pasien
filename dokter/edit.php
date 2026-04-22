<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM dokter WHERE id='$id'")
);

$poli = mysqli_query($koneksi, "
    SELECT * FROM poli
    ORDER BY nama_poli ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Dokter</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Dokter</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Dokter</label>
            <input type="text"
                   name="kode_dokter"
                   class="form-control"
                   value="<?= $data['kode_dokter']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Nama Dokter</label>
            <input type="text"
                   name="nama_dokter"
                   class="form-control"
                   value="<?= $data['nama_dokter']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin"
                    class="form-control"
                    required>
                <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                    Laki-laki
                </option>

                <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                    Perempuan
                </option>
            </select>
        </div>

        <div class="mb-2">
            <label>Spesialisasi</label>
            <input type="text"
                   name="spesialisasi"
                   class="form-control"
                   value="<?= $data['spesialisasi']; ?>">
        </div>

        <div class="mb-2">
            <label>No SIP</label>
            <input type="text"
                   name="no_sip"
                   class="form-control"
                   value="<?= $data['no_sip']; ?>">
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text"
                   name="no_telp"
                   class="form-control"
                   value="<?= $data['no_telp']; ?>">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat"
                      class="form-control"><?= $data['alamat']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id"
                    class="form-control">

                <option value="">-- Pilih Poli --</option>

                <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['poli_id']) ? 'selected' : ''; ?>>
                        <?= $row['nama_poli']; ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status"
                    class="form-control"
                    required>

                <option value="aktif"
                    <?= ($data['status'] == 'aktif') ? 'selected' : ''; ?>>
                    Aktif
                </option>

                <option value="nonaktif"
                    <?= ($data['status'] == 'nonaktif') ? 'selected' : ''; ?>>
                    Nonaktif
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