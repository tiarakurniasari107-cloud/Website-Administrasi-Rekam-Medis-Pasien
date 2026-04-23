<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $no_rm = trim($_POST['no_rm'] ?? '');
    $nik = trim($_POST['nik'] ?? '');
    $nama_pasien = trim($_POST['nama_pasien'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tempat_lahir = trim($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $umur = trim($_POST['umur'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');
    $golongan_darah = trim($_POST['golongan_darah'] ?? '');
    $alergi = trim($_POST['alergi'] ?? '');
    $status_kawin = trim($_POST['status_kawin'] ?? '');
    $pekerjaan = trim($_POST['pekerjaan'] ?? '');

    if ($no_rm === '' || $nama_pasien === '' || !in_array($jenis_kelamin, ['L', 'P'], true)) {
        header("Location: create.php");
        exit;
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO pasien (
            no_rm, nik, nama_pasien, jenis_kelamin,
            tempat_lahir, tanggal_lahir, umur,
            alamat, no_telp, golongan_darah,
            alergi, status_kawin, pekerjaan
        ) VALUES (
            ?, NULLIF(?, ''), ?, ?,
            NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
            NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
            NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, '')
        )"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssss",
        $no_rm,
        $nik,
        $nama_pasien,
        $jenis_kelamin,
        $tempat_lahir,
        $tanggal_lahir,
        $umur,
        $alamat,
        $no_telp,
        $golongan_darah,
        $alergi,
        $status_kawin,
        $pekerjaan
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>