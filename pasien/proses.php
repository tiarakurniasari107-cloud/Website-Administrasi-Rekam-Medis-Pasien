<?php
require_once '../config/auth.php';

if (isset($_POST['simpan'])) {

    $no_rm = trim($_POST['no_rm'] ?? '');
    $nik = trim($_POST['nik'] ?? '');
    $nama_pasien = trim($_POST['nama_pasien'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tempat_lahir = trim($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $umur = '';
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

    // Validasi NIK hanya angka
    if ($nik !== '' && !preg_match('/^[0-9]+$/', $nik)) {
        header("Location: create.php");
        exit;
    }

    // Validasi No Telepon hanya angka
    if ($no_telp !== '' && !preg_match('/^[0-9]+$/', $no_telp)) {
        header("Location: create.php");
        exit;
    }

    if ($tanggal_lahir !== '') {
        $tanggalObj = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
        if ($tanggalObj && $tanggalObj->format('Y-m-d') === $tanggal_lahir) {
            $umur = (string) $tanggalObj->diff(new DateTime())->y;
        }
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
