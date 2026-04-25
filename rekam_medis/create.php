<?php
require_once '../config/auth.php';

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
    WHERE rm.kunjungan_id IS NULL
    ORDER BY k.tanggal_kunjungan DESC, k.id DESC"
);
mysqli_stmt_execute($stmtKunjungan);
$kunjungan = mysqli_stmt_get_result($stmtKunjungan);
?>
<?php
$pageTitle = 'Tambah Rekam Medis';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Tambah Rekam Medis</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Kunjungan</label>
            <select name="kunjungan_id" class="form-control" required>
                <option value="">-- Pilih Kunjungan --</option>
                <?php while ($row = mysqli_fetch_assoc($kunjungan)) { ?>
                    <option value="<?= $row['id']; ?>">
                        <?= htmlspecialchars($row['kode_kunjungan'] . ' - ' . $row['nama_pasien'] . ' (' . $row['nama_dokter'] . ')', ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Keluhan</label>
            <textarea name="keluhan" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Riwayat Penyakit</label>
            <textarea name="riwayat_penyakit" class="form-control"></textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-2">
                <label>Tekanan Darah</label>
                <input type="text" name="tekanan_darah" class="form-control" placeholder="120/80">
            </div>
            <div class="col-md-3 mb-2">
                <label>Suhu Tubuh</label>
                <input type="text" name="suhu_tubuh" class="form-control" placeholder="36.5">
            </div>
            <div class="col-md-3 mb-2">
                <label>Nadi</label>
                <input type="text" name="nadi" class="form-control" placeholder="80">
            </div>
            <div class="col-md-3 mb-2">
                <label>Pernapasan</label>
                <input type="text" name="pernapasan" class="form-control" placeholder="20">
            </div>
        </div>

        <div class="mb-2">
            <label>Diagnosa Kerja</label>
            <textarea name="diagnosa_kerja" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Diagnosa Banding</label>
            <textarea name="diagnosa_banding" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Pemeriksaan Fisik</label>
            <textarea name="pemeriksaan_fisik" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Terapi</label>
            <textarea name="terapi" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Catatan Dokter</label>
            <textarea name="catatan_dokter" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Tindak Lanjut</label>
            <textarea name="tindak_lanjut" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label>Tanggal Pemeriksaan (Opsional)</label>
            <input type="datetime-local" name="tanggal_pemeriksaan" class="form-control">
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

    <?php mysqli_stmt_close($stmtKunjungan); ?>

</div>

<?php require_once '../includes/footer.php'; ?>
