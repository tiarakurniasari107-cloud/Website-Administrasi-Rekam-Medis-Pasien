<?php
require_once '../config/auth.php';

$stmtPoli = mysqli_prepare($koneksi, "SELECT id, nama_poli FROM poli ORDER BY nama_poli ASC");
mysqli_stmt_execute($stmtPoli);
$poli = mysqli_stmt_get_result($stmtPoli);
?>

<?php
$pageTitle = 'Tambah Dokter';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Tambah Dokter</h2>
        <p>Formulir pendaftaran dokter baru</p>
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
                    <label for="kode_dokter">Kode Dokter</label>
                    <input type="text" id="kode_dokter" name="kode_dokter" class="form-control" placeholder="Masukkan kode dokter" required>
                </div>

                <div class="mb-2 field-full">
                    <label for="nama_dokter">Nama Dokter</label>
                    <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" placeholder="Masukkan nama dokter" required>
                </div>

                <div class="mb-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="spesialisasi">Spesialisasi</label>
                    <input type="text" id="spesialisasi" name="spesialisasi" class="form-control" placeholder="Contoh: Umum">
                </div>

                <div class="mb-2">
                    <label for="no_sip">No SIP</label>
                    <input type="text" id="no_sip" name="no_sip" class="form-control" placeholder="Nomor SIP dokter">
                </div>

                <div class="mb-2">
                    <label for="no_telp">No Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>

                <div class="mb-2">
                    <label for="poli_id">Poli</label>
                    <select id="poli_id" name="poli_id" class="form-control">
                        <option value="">-- Pilih Poli --</option>
                        <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                            <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="mb-2 field-full">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat lengkap dokter"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php mysqli_stmt_close($stmtPoli); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
