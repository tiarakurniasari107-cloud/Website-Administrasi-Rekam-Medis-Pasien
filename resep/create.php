<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$stmtRM = mysqli_prepare(
    $koneksi,
    "SELECT 
        rm.id,
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter,
        rm.diagnosa_kerja
    FROM rekam_medis rm
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN resep r ON r.rekam_medis_id = rm.id
    WHERE r.rekam_medis_id IS NULL
    ORDER BY rm.id DESC"
);
mysqli_stmt_execute($stmtRM);
$rekam_medis = mysqli_stmt_get_result($stmtRM);

$stmtObat = mysqli_prepare($koneksi, 'SELECT id, nama_obat FROM obat ORDER BY nama_obat ASC');
mysqli_stmt_execute($stmtObat);
$obat = mysqli_stmt_get_result($stmtObat);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Resep</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Tambah Resep</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Rekam Medis</label>
            <select name="rekam_medis_id" class="form-control" required>
                <option value="">-- Pilih Rekam Medis --</option>
                <?php while ($row = mysqli_fetch_assoc($rekam_medis)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= htmlspecialchars($row['kode_kunjungan'] . ' - ' . $row['nama_pasien'] . ' (' . ($row['diagnosa_kerja'] ?? '-') . ')', ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Resep (Opsional)</label>
            <input type="datetime-local" name="tanggal_resep" class="form-control">
        </div>

        <div class="mb-2">
            <label>Obat</label>
            <select name="obat_id" class="form-control" required>
                <option value="">-- Pilih Obat --</option>
                <?php while ($row = mysqli_fetch_assoc($obat)) { ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_obat'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dosis</label>
            <input type="text" name="dosis" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <div class="mb-2">
            <label>Aturan Pakai</label>
            <textarea name="aturan_pakai" class="form-control" required></textarea>
        </div>

        <div class="mb-2">
            <label>Catatan Resep</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

    <?php
    mysqli_stmt_close($stmtRM);
    mysqli_stmt_close($stmtObat);
    ?>

</div>

</body>
</html>
