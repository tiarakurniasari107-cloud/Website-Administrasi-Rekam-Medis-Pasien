<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id, nama_obat, satuan, stok, harga, keterangan FROM obat WHERE id = ?");
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
$pageTitle = 'Edit Obat';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Edit Obat</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Nama Obat</label>
            <input type="text"
                   name="nama_obat"
                   class="form-control"
                   value="<?= htmlspecialchars($data['nama_obat'], ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Satuan</label>
            <input type="text"
                   name="satuan"
                   class="form-control"
                     value="<?= htmlspecialchars($data['satuan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                     value="<?= (int) $data['stok']; ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Harga</label>
            <input type="number"
                     step="0.01"
                   name="harga"
                   class="form-control"
                     value="<?= htmlspecialchars((string) $data['harga'], ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan"
                      class="form-control"><?= htmlspecialchars($data['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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

    <?php mysqli_stmt_close($stmt); ?>

</div>

<?php require_once '../includes/footer.php'; ?>
