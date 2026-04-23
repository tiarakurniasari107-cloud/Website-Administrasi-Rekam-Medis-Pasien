<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$stmtPasien = mysqli_prepare($koneksi, 'SELECT id, nama_pasien FROM pasien ORDER BY nama_pasien ASC');
mysqli_stmt_execute($stmtPasien);
$pasien = mysqli_stmt_get_result($stmtPasien);

$stmtDokter = mysqli_prepare($koneksi, 'SELECT id, nama_dokter FROM dokter ORDER BY nama_dokter ASC');
mysqli_stmt_execute($stmtDokter);
$dokter = mysqli_stmt_get_result($stmtDokter);

$stmtPoli = mysqli_prepare($koneksi, 'SELECT id, nama_poli FROM poli ORDER BY nama_poli ASC');
mysqli_stmt_execute($stmtPoli);
$poli = mysqli_stmt_get_result($stmtPoli);
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
            <input type="text" name="kode_kunjungan" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Pasien</label>
            <select name="pasien_id" class="form-control" required>
                <option value="">-- Pilih Pasien --</option>
                <?php while ($row = mysqli_fetch_assoc($pasien)) { ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dokter</label>
            <select name="dokter_id" class="form-control" required>
                <option value="">-- Pilih Dokter --</option>
                <?php while ($row = mysqli_fetch_assoc($dokter)) { ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id" class="form-control">
                <option value="">-- Pilih Poli (Opsional) --</option>
                <?php while ($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal_kunjungan" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jam Kunjungan</label>
            <input type="time" name="jam_kunjungan" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kunjungan</label>
            <select name="jenis_kunjungan" class="form-control" required>
                <option value="baru">Baru</option>
                <option value="lama" selected>Lama</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Cara Bayar</label>
            <select name="cara_bayar" class="form-control" required>
                <option value="umum" selected>Umum</option>
                <option value="bpjs">BPJS</option>
                <option value="asuransi">Asuransi</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Keluhan Utama</label>
            <textarea name="keluhan_utama" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kunjungan</label>
            <select name="status_kunjungan" class="form-control" required>
                <option value="menunggu" selected>Menunggu</option>
                <option value="diperiksa">Diperiksa</option>
                <option value="selesai">Selesai</option>
                <option value="batal">Batal</option>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

    <?php
    mysqli_stmt_close($stmtPasien);
    mysqli_stmt_close($stmtDokter);
    mysqli_stmt_close($stmtPoli);
    ?>

</div>

</body>
</html>
