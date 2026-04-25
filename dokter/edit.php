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


<div class="container mt-4">

    <h2>Edit Dokter</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Kode Dokter</label>
            <input type="text"
                   name="kode_dokter"
                   class="form-control"
                     value="<?= htmlspecialchars($data['kode_dokter'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Nama Dokter</label>
            <input type="text"
                   name="nama_dokter"
                   class="form-control"
                     value="<?= htmlspecialchars($data['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin"
                    class="form-control"
                    required>
                <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                    Laki-laki
                </option>

                <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                    Perempuan
                </option>
            </select>
        </div>

        <div class="mb-2">
            <label>Spesialisasi</label>
            <input type="text"
                   name="spesialisasi"
                   class="form-control"
                     value="<?= htmlspecialchars($data['spesialisasi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>No SIP</label>
            <input type="text"
                   name="no_sip"
                   class="form-control"
                     value="<?= htmlspecialchars($data['no_sip'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text"
                   name="no_telp"
                   class="form-control"
                     value="<?= htmlspecialchars($data['no_telp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat"
                      class="form-control"><?= htmlspecialchars($data['alamat'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Poli</label>
            <select name="poli_id"
                    class="form-control">

                <option value="">-- Pilih Poli --</option>

                <?php while($row = mysqli_fetch_assoc($poli)) { ?>
                    <option value="<?= $row['id']; ?>"
                        <?= ($row['id'] == $data['poli_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status"
                    class="form-control"
                    required>

                <option value="aktif"
                    <?= ($data['status'] == 'aktif') ? 'selected' : ''; ?>>
                    Aktif
                </option>

                <option value="nonaktif"
                    <?= ($data['status'] == 'nonaktif') ? 'selected' : ''; ?>>
                    Nonaktif
                </option>

            </select>
        </div>

        <button type="submit"
                name="update"
                class="btn btn-success">
            Update
        </button>

        <a href="index.php"
           class="btn btn-secondary">
           Kembali
        </a>

    </form>

    <?php mysqli_stmt_close($stmtData); ?>
    <?php mysqli_stmt_close($stmtPoli); ?>

</div>

<?php require_once '../includes/footer.php'; ?>
