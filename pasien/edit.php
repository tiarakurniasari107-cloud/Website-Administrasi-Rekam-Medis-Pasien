<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM pasien WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit;
}
?>

<?php
$pageTitle = 'Edit Pasien';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Edit Pasien</h2>
        <p>Ubah data rekam medis pasien</p>
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
                    <label for="no_rm">No RM</label>
                    <input type="text" id="no_rm" name="no_rm" class="form-control" value="<?= htmlspecialchars($data['no_rm'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2 field-full">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" class="form-control" value="<?= htmlspecialchars($data['nik'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2 field-full">
                    <label for="nama_pasien">Nama Pasien</label>
                    <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" value="<?= htmlspecialchars($data['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" value="<?= htmlspecialchars($data['tempat_lahir'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($data['tanggal_lahir'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" class="form-control" value="<?= htmlspecialchars((string) ($data['umur'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2 field-full">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control"><?= htmlspecialchars($data['alamat'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="mb-2 field-full">
                    <label for="no_telp">No Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" value="<?= htmlspecialchars($data['no_telp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2">
                    <label for="golongan_darah">Golongan Darah</label>
                    <select id="golongan_darah" name="golongan_darah" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="A" <?= ($data['golongan_darah'] == 'A') ? 'selected' : ''; ?>>A</option>
                        <option value="B" <?= ($data['golongan_darah'] == 'B') ? 'selected' : ''; ?>>B</option>
                        <option value="AB" <?= ($data['golongan_darah'] == 'AB') ? 'selected' : ''; ?>>AB</option>
                        <option value="O" <?= ($data['golongan_darah'] == 'O') ? 'selected' : ''; ?>>O</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status_kawin">Status Kawin</label>
                    <input type="text" id="status_kawin" name="status_kawin" class="form-control" value="<?= htmlspecialchars($data['status_kawin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-2 field-full">
                    <label for="alergi">Alergi</label>
                    <textarea id="alergi" name="alergi" class="form-control"><?= htmlspecialchars($data['alergi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="mb-2 field-full">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($data['pekerjaan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </section>
</div>

<?php mysqli_stmt_close($stmt); ?>

<?php require_once '../includes/footer.php'; ?>
