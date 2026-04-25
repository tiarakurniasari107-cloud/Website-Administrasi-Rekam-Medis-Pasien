<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmtData = mysqli_prepare($koneksi, 'SELECT id, rekam_medis_id, tanggal_resep, catatan FROM resep WHERE id = ?');
mysqli_stmt_bind_param($stmtData, 'i', $id);
mysqli_stmt_execute($stmtData);
$resultData = mysqli_stmt_get_result($stmtData);
$data = mysqli_fetch_assoc($resultData);

if (!$data) {
    mysqli_stmt_close($stmtData);
    header('Location: index.php');
    exit;
}

$stmtDetail = mysqli_prepare($koneksi, 'SELECT id, obat_id, dosis, jumlah, aturan_pakai FROM resep_detail WHERE resep_id = ? ORDER BY id ASC LIMIT 1');
mysqli_stmt_bind_param($stmtDetail, 'i', $id);
mysqli_stmt_execute($stmtDetail);
$resultDetail = mysqli_stmt_get_result($stmtDetail);
$detail = mysqli_fetch_assoc($resultDetail);

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
    WHERE r.rekam_medis_id IS NULL OR rm.id = ?
    ORDER BY rm.id DESC"
);
mysqli_stmt_bind_param($stmtRM, 'i', $data['rekam_medis_id']);
mysqli_stmt_execute($stmtRM);
$rekam_medis = mysqli_stmt_get_result($stmtRM);

$stmtObat = mysqli_prepare($koneksi, 'SELECT id, nama_obat FROM obat ORDER BY nama_obat ASC');
mysqli_stmt_execute($stmtObat);
$obat = mysqli_stmt_get_result($stmtObat);

$tanggalResep = '';
if (!empty($data['tanggal_resep'])) {
    $tanggalResep = date('Y-m-d\\TH:i', strtotime($data['tanggal_resep']));
}
?>
<?php
$pageTitle = 'Edit Resep';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Edit Resep</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">
        <input type="hidden" name="detail_id" value="<?= (int) ($detail['id'] ?? 0); ?>">

        <div class="mb-2">
            <label>Rekam Medis</label>
            <select name="rekam_medis_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($rekam_medis)) { ?>
                    <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) $data['rekam_medis_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['kode_kunjungan'] . ' - ' . $row['nama_pasien'] . ' (' . ($row['diagnosa_kerja'] ?? '-') . ')', ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Resep (Opsional)</label>
            <input type="datetime-local" name="tanggal_resep" class="form-control" value="<?= htmlspecialchars($tanggalResep, ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Obat</label>
            <select name="obat_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($obat)) { ?>
                    <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) ($detail['obat_id'] ?? 0)) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['nama_obat'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Dosis</label>
            <input type="text" name="dosis" class="form-control" value="<?= htmlspecialchars($detail['dosis'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="mb-2">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="<?= (int) ($detail['jumlah'] ?? 1); ?>" required>
        </div>

        <div class="mb-2">
            <label>Aturan Pakai</label>
            <textarea name="aturan_pakai" class="form-control" required><?= htmlspecialchars($detail['aturan_pakai'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Catatan Resep</label>
            <textarea name="catatan" class="form-control"><?= htmlspecialchars($data['catatan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

    <?php
    mysqli_stmt_close($stmtData);
    mysqli_stmt_close($stmtDetail);
    mysqli_stmt_close($stmtRM);
    mysqli_stmt_close($stmtObat);
    ?>

</div>

<?php require_once '../includes/footer.php'; ?>
