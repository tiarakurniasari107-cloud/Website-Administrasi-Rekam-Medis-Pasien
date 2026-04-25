<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmtData = mysqli_prepare($koneksi, "SELECT * FROM dokter WHERE id = ?");
mysqli_stmt_bind_param($stmtData, "i", $id);
mysqli_stmt_execute($stmtData);
$resultData = mysqli_stmt_get_result($stmtData);
$data = mysqli_fetch_assoc($resultData);

if (!$data) {
    mysqli_stmt_close($stmtData);
    header("Location: index.php");
    exit;
}

$stmtPoli = mysqli_prepare($koneksi, "SELECT id, nama_poli FROM poli ORDER BY nama_poli ASC");
mysqli_stmt_execute($stmtPoli);
$poli = mysqli_stmt_get_result($stmtPoli);
?>

<?php
$pageTitle = 'Edit Dokter';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Edit Dokter</h2>
        <p>Ubah data dokter klinik</p>
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
                    <label for="kode_dokter">Kode Dokter</label>
                    <input type="text" id="kode_dokter" name="kode_dokter" class="form-control" value="<?= htmlspecialchars($data['kode_dokter'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2 field-full">
                    <label for="nama_dokter">Nama Dokter</label>
                    <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" value="<?= htmlspecialchars($data['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="spesialisasi">Spesialisasi</label>
                    <input type="text" id="spesialisasi" name="spesialisasi" class="form-control" value="<?= htmlspecialchars($data['spesialisasi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="no_sip">No SIP</label>
                    <input type="text" id="no_sip" name="no_sip" class="form-control" value="<?= htmlspecialchars($data['no_sip'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="no_telp">No Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" value="<?= htmlspecialchars($data['no_telp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="poli_id">Poli</label>
                    <select id="poli_id" name="poli_id" class="form-control">
                        <option value="">-- Pilih Poli --</option>
                        <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                            <option value="<?= $row['id']; ?>" <?= ($row['id'] == $data['poli_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif" <?= ($data['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?= ($data['status'] == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="mb-2 field-full">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control"><?= htmlspecialchars($data['alamat'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php mysqli_stmt_close($stmtData); ?>
        <?php mysqli_stmt_close($stmtPoli); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
