<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
$pageTitle = 'Tambah Tindakan';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Tambah Tindakan</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Nama Tindakan</label>
            <input type="text"
                   name="nama_tindakan"
                   class="form-control"
                   required>
        </div>

        <div class="mb-2">
                 <label>Tarif</label>
            <input type="number"
                     step="0.01"
                     name="tarif"
                   class="form-control"
                   required>
        </div>

        <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan"
                      class="form-control"></textarea>
        </div>

        <button type="submit"
                name="simpan"
                class="btn btn-primary">
            Simpan
        </button>

        <a href="index.php"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?php require_once '../includes/footer.php'; ?>
