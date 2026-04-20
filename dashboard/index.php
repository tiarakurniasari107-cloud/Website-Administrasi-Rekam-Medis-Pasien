<?php
include "../config/auth.php";
include "../config/koneksi.php";
include "../config/fungsi.php";

$pasien = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM pasien"));
$dokter = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM dokter"));
$kunjungan = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM kunjungan"));
$rekam = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM rekam_medis"));
?>
<?php include "../includes/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"><?php include "../includes/sidebar.php"; ?></div>
        <div class="col-md-10 p-4">
            <h3>Dashboard</h3>
            <div class="row mt-4">
                <div class="col-md-3"><div class="card p-3">Pasien <h4><?= $pasien ?></h4></div></div>
                <div class="col-md-3"><div class="card p-3">Dokter <h4><?= $dokter ?></h4></div></div>
                <div class="col-md-3"><div class="card p-3">Kunjungan <h4><?= $kunjungan ?></h4></div></div>
                <div class="col-md-3"><div class="card p-3">Rekam Medis <h4><?= $rekam ?></h4></div></div>
            </div>
        </div>
    </div>
</div>
<?php include "../includes/footer.php"; ?>