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


<div class="container mt-4">

    <h2>Edit Pasien</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>No RM</label>
            <input type="text" name="no_rm" class="form-control"
                   value="<?= htmlspecialchars($data['no_rm'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="mb-2">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control"
                   value="<?= htmlspecialchars($data['nik'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control"
                   value="<?= htmlspecialchars($data['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                    Laki-laki
                </option>
                <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                    Perempuan
                </option>
            </select>
        </div>

        <div class="mb-2">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control"
                   value="<?= htmlspecialchars($data['tempat_lahir'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control"
                   value="<?= htmlspecialchars($data['tanggal_lahir'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control"
                   value="<?= htmlspecialchars((string) ($data['umur'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>No Telepon</label>
            <input type="text" name="no_telp" class="form-control"
                   value="<?= htmlspecialchars($data['no_telp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Golongan Darah</label>
            <select name="golongan_darah" class="form-control">
                <option value="">-- Pilih --</option>
                <option value="A" <?= ($data['golongan_darah'] == 'A') ? 'selected' : ''; ?>>A</option>
                <option value="B" <?= ($data['golongan_darah'] == 'B') ? 'selected' : ''; ?>>B</option>
                <option value="AB" <?= ($data['golongan_darah'] == 'AB') ? 'selected' : ''; ?>>AB</option>
                <option value="O" <?= ($data['golongan_darah'] == 'O') ? 'selected' : ''; ?>>O</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Alergi</label>
            <textarea name="alergi" class="form-control"><?= htmlspecialchars($data['alergi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="mb-2">
            <label>Status Kawin</label>
            <input type="text" name="status_kawin" class="form-control"
                   value="<?= htmlspecialchars($data['status_kawin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="mb-2">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control"
                   value="<?= htmlspecialchars($data['pekerjaan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <button type="submit" name="update" class="btn btn-success">
            Update
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?php mysqli_stmt_close($stmt); ?>

<?php require_once '../includes/footer.php'; ?>
