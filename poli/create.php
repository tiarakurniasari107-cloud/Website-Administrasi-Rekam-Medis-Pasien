<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
$pageTitle = 'Tambah Poli';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Tambah Poli</h2>
        <p>Formulir penambahan data poli</p>
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
                    <label for="nama_poli">Nama Poli</label>
                    <input type="text" id="nama_poli" name="nama_poli" class="form-control" placeholder="Masukkan nama poli" required>
                </div>

                <div class="mb-2 field-full">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Deskripsi atau catatan poli"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </section>
    </div>

<?php require_once '../includes/footer.php'; ?>
