<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmtData = mysqli_prepare($koneksi, 'SELECT * FROM rekam_medis WHERE id = ?');
mysqli_stmt_bind_param($stmtData, 'i', $id);
mysqli_stmt_execute($stmtData);
$resultData = mysqli_stmt_get_result($stmtData);
$data = mysqli_fetch_assoc($resultData);

if (!$data) {
    mysqli_stmt_close($stmtData);
    header('Location: index.php');
    exit;
}

$stmtKunjungan = mysqli_prepare(
    $koneksi,
    "SELECT 
        k.id,
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter
    FROM kunjungan k
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN rekam_medis rm ON rm.kunjungan_id = k.id
    WHERE rm.kunjungan_id IS NULL OR k.id = ?
    ORDER BY k.tanggal_kunjungan DESC, k.id DESC"
);
mysqli_stmt_bind_param($stmtKunjungan, 'i', $data['kunjungan_id']);
mysqli_stmt_execute($stmtKunjungan);
$kunjungan = mysqli_stmt_get_result($stmtKunjungan);

$tanggalPemeriksaan = '';
if (!empty($data['tanggal_pemeriksaan'])) {
    $tanggalPemeriksaan = date('Y-m-d\\TH:i', strtotime($data['tanggal_pemeriksaan']));
}
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
            <label>Kunjungan</label>
            <select name="kunjungan_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($kunjungan)) { ?>
                    <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) $data['kunjungan_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['kode_kunjungan'] . ' - ' . $row['nama_pasien'] . ' (' . $row['nama_dokter'] . ')', ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Keluhan</label>
            <textarea name="keluhan" class="form-control"><?= htmlspecialchars($data['keluhan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Riwayat Penyakit</label>
            <textarea name="riwayat_penyakit" class="form-control"><?= htmlspecialchars($data['riwayat_penyakit'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-2">
                <label>Tekanan Darah</label>
                <input type="text" name="tekanan_darah" class="form-control" value="<?= htmlspecialchars($data['tekanan_darah'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="col-md-3 mb-2">
                <label>Suhu Tubuh</label>
                <input type="text" name="suhu_tubuh" class="form-control" value="<?= htmlspecialchars($data['suhu_tubuh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="col-md-3 mb-2">
                <label>Nadi</label>
                <input type="text" name="nadi" class="form-control" value="<?= htmlspecialchars($data['nadi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="col-md-3 mb-2">
                <label>Pernapasan</label>
                <input type="text" name="pernapasan" class="form-control" value="<?= htmlspecialchars($data['pernapasan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <div class="mb-2">
            <label>Diagnosa Kerja</label>
            <textarea name="diagnosa_kerja" class="form-control"><?= htmlspecialchars($data['diagnosa_kerja'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Diagnosa Banding</label>
            <textarea name="diagnosa_banding" class="form-control"><?= htmlspecialchars($data['diagnosa_banding'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Pemeriksaan Fisik</label>
            <textarea name="pemeriksaan_fisik" class="form-control"><?= htmlspecialchars($data['pemeriksaan_fisik'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Terapi</label>
            <textarea name="terapi" class="form-control"><?= htmlspecialchars($data['terapi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Catatan Dokter</label>
            <textarea name="catatan_dokter" class="form-control"><?= htmlspecialchars($data['catatan_dokter'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Tindak Lanjut</label>
            <textarea name="tindak_lanjut" class="form-control"><?= htmlspecialchars($data['tindak_lanjut'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Tanggal Pemeriksaan (Opsional)</label>
            <input type="datetime-local" name="tanggal_pemeriksaan" class="form-control" value="<?= htmlspecialchars($tanggalPemeriksaan, ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

    <?php
    mysqli_stmt_close($stmtData);
    mysqli_stmt_close($stmtKunjungan);
    ?>

</div>

</body>
</html>
