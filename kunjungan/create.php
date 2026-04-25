<?php
require_once '../config/auth.php';

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
<?php
$pageTitle = 'Tambah Kunjungan';
require_once '../includes/header.php';
?>
<div class="container">
    <section class="page-header">
        <h2>Tambah Kunjungan</h2>
        <p>Formulir pendaftaran kunjungan baru</p>
    </section>

    <section class="content-card form-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>
        </div>

        <form action="proses.php" method="POST" autocomplete="off">
            <div class="form-grid">
                <div class="mb-2 field-full">
                    <label for="kode_kunjungan">Kode Kunjungan</label>
                    <input type="text" id="kode_kunjungan" name="kode_kunjungan" class="form-control" placeholder="Masukkan kode kunjungan" required>
                </div>

                <div class="mb-2">
                    <label for="pasien_id">Pasien</label>
                    <select id="pasien_id" name="pasien_id" class="form-control" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php while ($row = mysqli_fetch_assoc($pasien)) { ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="dokter_id">Dokter</label>
                    <select id="dokter_id" name="dokter_id" class="form-control" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php while ($row = mysqli_fetch_assoc($dokter)) { ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="poli_id">Poli</label>
                    <select id="poli_id" name="poli_id" class="form-control">
                        <option value="">-- Pilih Poli (Opsional) --</option>
                        <?php while ($row = mysqli_fetch_assoc($poli)) { ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="jenis_kunjungan">Jenis Kunjungan</label>
                    <select id="jenis_kunjungan" name="jenis_kunjungan" class="form-control" required>
                        <option value="baru">Baru</option>
                        <option value="lama" selected>Lama</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                    <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="jam_kunjungan">Jam Kunjungan</label>
                    <input type="time" id="jam_kunjungan" name="jam_kunjungan" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="cara_bayar">Cara Bayar</label>
                    <select id="cara_bayar" name="cara_bayar" class="form-control" required>
                        <option value="umum" selected>Umum</option>
                        <option value="bpjs">BPJS</option>
                        <option value="asuransi">Asuransi</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status_kunjungan">Status Kunjungan</label>
                    <select id="status_kunjungan" name="status_kunjungan" class="form-control" required>
                        <option value="menunggu" selected>Menunggu</option>
                        <option value="diperiksa">Diperiksa</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>

                <div class="mb-2 field-full">
                    <label for="keluhan_utama">Keluhan Utama</label>
                    <textarea id="keluhan_utama" name="keluhan_utama" class="form-control" placeholder="Keluhan utama pasien"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php
        mysqli_stmt_close($stmtPasien);
        mysqli_stmt_close($stmtDokter);
        mysqli_stmt_close($stmtPoli);
        ?>
    </section>

</div>

<?php require_once '../includes/footer.php'; ?>
