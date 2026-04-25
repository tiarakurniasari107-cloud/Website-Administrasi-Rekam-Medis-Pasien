<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
$pageTitle = 'Tambah Obat';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Tambah Obat</h2>

    <form action="proses.php" method="POST">

        <div class="mb-2">
            <label>Nama Obat</label>
            <input type="text"
                   name="nama_obat"
                   class="form-control"
                   required>
        </div>

        <div class="mb-2">
            <label>Satuan</label>
            <input type="text"
                   name="satuan"
                   class="form-control"
                   required>
        </div>

        <div class="mb-2">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   required>
        </div>

        <div class="mb-2">
            <label>Harga</label>
            <input type="number"
                   name="harga"
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
