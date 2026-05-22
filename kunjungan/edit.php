<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmtData = mysqli_prepare($koneksi, 'SELECT * FROM kunjungan WHERE id = ?');
mysqli_stmt_bind_param($stmtData, 'i', $id);
mysqli_stmt_execute($stmtData);
$resultData = mysqli_stmt_get_result($stmtData);
$data = mysqli_fetch_assoc($resultData);

if (!$data) {
    mysqli_stmt_close($stmtData);
    header('Location: index.php');
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

// Get jadwal dokter dengan join
$stmtJadwal = mysqli_prepare($koneksi, '
    SELECT jd.id, d.nama_dokter, p.nama_poli, jd.hari, jd.jam_mulai, jd.jam_selesai, jd.dokter_id, jd.poli_id, jd.keterangan
    FROM jadwal_dokter jd
    JOIN dokter d ON jd.dokter_id = d.id
    LEFT JOIN poli p ON jd.poli_id = p.id
    ORDER BY jd.hari, jd.jam_mulai
');
mysqli_stmt_execute($stmtJadwal);
$jadwal = mysqli_stmt_get_result($stmtJadwal);
$jadwalData = mysqli_fetch_all($jadwal, MYSQLI_ASSOC);
mysqli_stmt_close($stmtJadwal);

$statusOptions = ['menunggu' => 'Menunggu', 'diperiksa' => 'Diperiksa', 'selesai' => 'Selesai', 'batal' => 'Batal'];
$hasRekamMedis = false;
$stmtRekam = mysqli_prepare($koneksi, 'SELECT id FROM rekam_medis WHERE kunjungan_id = ?');
mysqli_stmt_bind_param($stmtRekam, 'i', $id);
mysqli_stmt_execute($stmtRekam);
$resultRekam = mysqli_stmt_get_result($stmtRekam);
$hasRekamMedis = mysqli_num_rows($resultRekam) > 0;
mysqli_stmt_close($stmtRekam);
?>
<?php
$pageTitle = 'Edit Kunjungan';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Edit Kunjungan</h2>
        <p>Ubah data kunjungan pasien</p>
    </section>

    <section class="content-card form-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>
        </div>

        <form action="proses_edit.php" method="POST" autocomplete="off">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <div class="form-grid">
                <div class="mb-2 field-full">
                    <label for="kode_kunjungan">Kode Kunjungan</label>
                    <input type="text" id="kode_kunjungan" name="kode_kunjungan" class="form-control" value="<?= htmlspecialchars($data['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2">
                    <label for="pasien_id">Pasien</label>
                    <select id="pasien_id" name="pasien_id" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($pasien)) { ?>
                            <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) $data['pasien_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="jadwal_dokter_id">Jadwal Dokter</label>
                    <select id="jadwal_dokter_id" name="jadwal_dokter_id" class="form-control">
                        <option value="">-- Pilih Jadwal Dokter (Opsional) --</option>
                        <?php foreach ($jadwalData as $row) { ?>
                            <option value="<?= $row['id']; ?>" data-dokter-id="<?= $row['dokter_id']; ?>" data-poli-id="<?= $row['poli_id']; ?>" data-jam-mulai="<?= htmlspecialchars($row['jam_mulai'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?> - <?= htmlspecialchars($row['hari'], ENT_QUOTES, 'UTF-8'); ?> (<?= htmlspecialchars($row['jam_mulai'], ENT_QUOTES, 'UTF-8'); ?> - <?= htmlspecialchars($row['jam_selesai'], ENT_QUOTES, 'UTF-8'); ?>) - <?= htmlspecialchars($row['nama_poli'] ?? 'Umum', ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="dokter_id">Dokter</label>
                    <select id="dokter_id" name="dokter_id" class="form-control" required>
                        <?php 
                        // Reset dokter result
                        $stmtDokter2 = mysqli_prepare($koneksi, 'SELECT id, nama_dokter FROM dokter ORDER BY nama_dokter ASC');
                        mysqli_stmt_execute($stmtDokter2);
                        $dokter2 = mysqli_stmt_get_result($stmtDokter2);
                        while ($row = mysqli_fetch_assoc($dokter2)) { ?>
                            <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) $data['dokter_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } 
                        mysqli_stmt_close($stmtDokter2);
                        ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="poli_id">Poli</label>
                    <select id="poli_id" name="poli_id" class="form-control">
                        <option value="">-- Pilih Poli (Opsional) --</option>
                        <?php 
                        // Reset poli result
                        $poliResult = mysqli_query($koneksi, 'SELECT id, nama_poli FROM poli ORDER BY nama_poli ASC');
                        while ($row = mysqli_fetch_assoc($poliResult)) { ?>
                            <option value="<?= $row['id']; ?>" <?= ((int) $row['id'] === (int) $data['poli_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="jenis_kunjungan">Jenis Kunjungan</label>
                    <select id="jenis_kunjungan" name="jenis_kunjungan" class="form-control" required>
                        <option value="baru" <?= ($data['jenis_kunjungan'] === 'baru') ? 'selected' : ''; ?>>Baru</option>
                        <option value="lama" <?= ($data['jenis_kunjungan'] === 'lama') ? 'selected' : ''; ?>>Lama</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                    <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" class="form-control" value="<?= htmlspecialchars($data['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2">
                    <label for="jam_kunjungan">Jam Kunjungan</label>
                    <input type="time" id="jam_kunjungan" name="jam_kunjungan" class="form-control" value="<?= htmlspecialchars($data['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2">
                    <label for="cara_bayar">Cara Bayar</label>
                    <select id="cara_bayar" name="cara_bayar" class="form-control" required>
                        <option value="umum" <?= ($data['cara_bayar'] === 'umum') ? 'selected' : ''; ?>>Umum</option>
                        <option value="bpjs" <?= ($data['cara_bayar'] === 'bpjs') ? 'selected' : ''; ?>>BPJS</option>
                        <option value="asuransi" <?= ($data['cara_bayar'] === 'asuransi') ? 'selected' : ''; ?>>Asuransi</option>
                        <option value="lainnya" <?= ($data['cara_bayar'] === 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status_kunjungan">Status Kunjungan</label>
                    <select id="status_kunjungan" name="status_kunjungan" class="form-control" required <?= $hasRekamMedis ? 'disabled' : ''; ?>>
                        <?php foreach ($statusOptions as $key => $label): ?>
                            <option value="<?= $key; ?>" <?= ($data['status_kunjungan'] === $key) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($hasRekamMedis): ?>
                        <small class="form-text text-muted">Status terkunci karena sudah ada rekam medis</small>
                    <?php endif; ?>
                </div>

                <div class="mb-2 field-full">
                    <label for="keluhan_utama">Keluhan Utama</label>
                    <textarea id="keluhan_utama" name="keluhan_utama" class="form-control"><?= htmlspecialchars($data['keluhan_utama'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php
        mysqli_stmt_close($stmtData);
        mysqli_stmt_close($stmtPasien);
        mysqli_stmt_close($stmtPoli);
        ?>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jadwalSelect = document.getElementById('jadwal_dokter_id');
    const dokterSelect = document.getElementById('dokter_id');
    const poliSelect = document.getElementById('poli_id');
    const jamKunjunganInput = document.getElementById('jam_kunjungan');

    // Handle jadwal dokter change
    jadwalSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const dokterId = selectedOption.dataset.dokterId;
        const poliId = selectedOption.dataset.poliId;
        const jamMulai = selectedOption.dataset.jamMulai;

        if (dokterId) {
            dokterSelect.value = dokterId;
        }
        
        if (poliId) {
            poliSelect.value = poliId;
        } else {
            poliSelect.value = '';
        }
        
        if (jamMulai) {
            jamKunjunganInput.value = jamMulai;
        }
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
