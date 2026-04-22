<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$poli = mysqli_query($koneksi, "
    SELECT * FROM poli
    ORDER BY nama_poli ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Dokter</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Tambah Dokter</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Kode Dokter</label>
            <input type="text" name="kode_dokter"
                   class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Nama Dokter</label>
            <input type="text" name="nama_dokter"
                   class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin"
                    class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Spesialisasi</label>
            <input type="text" name="spesialisasi"
                   class="form-control">
        </div>

        <div class="mb-2">
            <label>No SIP</label>
            <input type="text" name="no_sip"
                   class="form-control">
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text" name="no_telp"
                   class="form-control">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat"
                      class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id"
                    class="form-control">
                <option value="">-- Pilih Poli --</option>

                <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= $row['nama_poli']; ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status"
                    class="form-control" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
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