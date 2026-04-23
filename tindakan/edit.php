<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id, nama_tindakan, tarif, keterangan FROM tindakan WHERE id = ?");
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tindakan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Tindakan</h2>

    <form action="proses_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="mb-2">
            <label>Nama Tindakan</label>
            <input type="text"
                   name="nama_tindakan"
                   class="form-control"
                 value="<?= htmlspecialchars($data['nama_tindakan'], ENT_QUOTES, 'UTF-8'); ?>"
                   required>
        </div>

        <div class="mb-2">
             <label>Tarif</label>
            <input type="number"
                 step="0.01"
                 name="tarif"
                   class="form-control"
                 value="<?= htmlspecialchars((string) $data['tarif'], ENT_QUOTES, 'UTF-8'); ?>"
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

</body>
</html>