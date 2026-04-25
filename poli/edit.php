<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id, nama_poli, keterangan FROM poli WHERE id = ?");
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
$pageTitle = 'Edit Poli';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Edit Poli</h2>
        <p>Ubah data poliklinik</p>
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
                    <label for="nama_poli">Nama Poli</label>
                    <input type="text" id="nama_poli" name="nama_poli" class="form-control" value="<?= htmlspecialchars($data['nama_poli'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-2 field-full">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control"><?= htmlspecialchars($data['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php mysqli_stmt_close($stmt); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
