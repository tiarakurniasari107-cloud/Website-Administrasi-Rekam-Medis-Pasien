<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';

$title = "Laporan Data";

switch ($jenis) {

    case 'pasien':
        $title = "Laporan Data Pasien";
        $query = mysqli_query($koneksi, "
            SELECT *
            FROM pasien
            ORDER BY id DESC
        ");
        break;

    case 'dokter':
        $title = "Laporan Data Dokter";
        $query = mysqli_query($koneksi, "
            SELECT d.*, p.nama_poli
            FROM dokter d
            LEFT JOIN poli p ON d.poli_id = p.id
            ORDER BY d.id DESC
        ");
        break;

    case 'poli':
        $title = "Laporan Data Poli";
        $query = mysqli_query($koneksi, "
            SELECT *
            FROM poli
            ORDER BY id DESC
        ");
        break;

    case 'kunjungan':
        $title = "Laporan Data Kunjungan";
        $query = mysqli_query($koneksi, "
            SELECT k.*, p.nama_pasien, d.nama_dokter
            FROM kunjungan k
            LEFT JOIN pasien p ON k.pasien_id = p.id
            LEFT JOIN dokter d ON k.dokter_id = d.id
            ORDER BY k.id DESC
        ");
        break;

    case 'rekam_medis':
        $title = "Laporan Rekam Medis";
        $query = mysqli_query($koneksi, "
            SELECT rm.*, p.nama_pasien, d.nama_dokter
            FROM rekam_medis rm
            LEFT JOIN pasien p ON rm.pasien_id = p.id
            LEFT JOIN dokter d ON rm.dokter_id = d.id
            ORDER BY rm.id DESC
        ");
        break;

    case 'obat':
        $title = "Laporan Data Obat";
        $query = mysqli_query($koneksi, "
            SELECT *
            FROM obat
            ORDER BY id DESC
        ");
        break;

    case 'tindakan':
        $title = "Laporan Data Tindakan";
        $query = mysqli_query($koneksi, "
            SELECT *
            FROM tindakan
            ORDER BY id DESC
        ");
        break;

    case 'resep':
        $title = "Laporan Data Resep";
        $query = mysqli_query($koneksi, "
            SELECT r.*, p.nama_pasien, d.nama_dokter, o.nama_obat
            FROM resep r
            LEFT JOIN pasien p ON r.pasien_id = p.id
            LEFT JOIN dokter d ON r.dokter_id = d.id
            LEFT JOIN obat o ON r.obat_id = o.id
            ORDER BY r.id DESC
        ");
        break;

    default:
        die("Jenis laporan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            margin: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="no-print mb-3">
    <button onclick="window.print()" class="btn btn-success">
        Print Sekarang
    </button>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>
</div>

<h2><?= $title; ?></h2>

<table class="table table-bordered">
    <thead>
        <tr>

<?php
if ($jenis == 'pasien') {
    echo "
        <th>No RM</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
        <th>No HP</th>
    ";
}

elseif ($jenis == 'dokter') {
    echo "
        <th>Kode Dokter</th>
        <th>Nama Dokter</th>
        <th>Spesialis</th>
        <th>Poli</th>
    ";
}

elseif ($jenis == 'poli') {
    echo "
        <th>Kode Poli</th>
        <th>Nama Poli</th>
        <th>Keterangan</th>
    ";
}

elseif ($jenis == 'kunjungan') {
    echo "
        <th>Kode Kunjungan</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Keluhan</th>
    ";
}

elseif ($jenis == 'rekam_medis') {
    echo "
        <th>Kode Rekam Medis</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Diagnosa</th>
    ";
}

elseif ($jenis == 'obat') {
    echo "
        <th>Kode Obat</th>
        <th>Nama Obat</th>
        <th>Stok</th>
        <th>Harga</th>
    ";
}

elseif ($jenis == 'tindakan') {
    echo "
        <th>Kode Tindakan</th>
        <th>Nama Tindakan</th>
        <th>Biaya</th>
    ";
}

elseif ($jenis == 'resep') {
    echo "
        <th>Kode Resep</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Obat</th>
        <th>Jumlah</th>
    ";
}
?>

        </tr>
    </thead>

    <tbody>

<?php while($row = mysqli_fetch_assoc($query)) { ?>
<tr>

<?php

if ($jenis == 'pasien') {
    echo "
        <td>{$row['no_rm']}</td>
        <td>{$row['nama_pasien']}</td>
        <td>{$row['jenis_kelamin']}</td>
        <td>{$row['no_hp']}</td>
    ";
}

elseif ($jenis == 'dokter') {
    echo "
        <td>{$row['kode_dokter']}</td>
        <td>{$row['nama_dokter']}</td>
        <td>{$row['spesialis']}</td>
        <td>{$row['nama_poli']}</td>
    ";
}

elseif ($jenis == 'poli') {
    echo "
        <td>{$row['kode_poli']}</td>
        <td>{$row['nama_poli']}</td>
        <td>{$row['keterangan']}</td>
    ";
}

elseif ($jenis == 'kunjungan') {
    echo "
        <td>{$row['kode_kunjungan']}</td>
        <td>{$row['nama_pasien']}</td>
        <td>{$row['nama_dokter']}</td>
        <td>{$row['keluhan']}</td>
    ";
}

elseif ($jenis == 'rekam_medis') {
    echo "
        <td>{$row['kode_rekam_medis']}</td>
        <td>{$row['nama_pasien']}</td>
        <td>{$row['nama_dokter']}</td>
        <td>{$row['diagnosa']}</td>
    ";
}

elseif ($jenis == 'obat') {
    echo "
        <td>{$row['kode_obat']}</td>
        <td>{$row['nama_obat']}</td>
        <td>{$row['stok']}</td>
        <td>{$row['harga']}</td>
    ";
}

elseif ($jenis == 'tindakan') {
    echo "
        <td>{$row['kode_tindakan']}</td>
        <td>{$row['nama_tindakan']}</td>
        <td>{$row['biaya']}</td>
    ";
}

elseif ($jenis == 'resep') {
    echo "
        <td>{$row['kode_resep']}</td>
        <td>{$row['nama_pasien']}</td>
        <td>{$row['nama_dokter']}</td>
        <td>{$row['nama_obat']}</td>
        <td>{$row['jumlah']}</td>
    ";
}
?>

</tr>
<?php } ?>

    </tbody>
</table>

<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>