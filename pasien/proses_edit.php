<?php
require_once '../config/auth.php';

if (isset($_POST['update'])) {

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
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

    if ($id <= 0 || $no_rm === '' || $nama_pasien === '' || !in_array($jenis_kelamin, ['L', 'P'], true)) {
        header("Location: index.php");
        exit;
    }

    // Validasi NIK hanya angka
    if ($nik !== '' && !preg_match('/^[0-9]+$/', $nik)) {
        header("Location: edit.php?id=$id");
        exit;
    }

    // Validasi No Telepon hanya angka
    if ($no_telp !== '' && !preg_match('/^[0-9]+$/', $no_telp)) {
        header("Location: edit.php?id=$id");
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
        "UPDATE pasien SET
            no_rm = ?,
            nik = NULLIF(?, ''),
            nama_pasien = ?,
            jenis_kelamin = ?,
            tempat_lahir = NULLIF(?, ''),
            tanggal_lahir = NULLIF(?, ''),
            umur = NULLIF(?, ''),
            alamat = NULLIF(?, ''),
            no_telp = NULLIF(?, ''),
            golongan_darah = NULLIF(?, ''),
            alergi = NULLIF(?, ''),
            status_kawin = NULLIF(?, ''),
            pekerjaan = NULLIF(?, '')
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssi",
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
        $pekerjaan,
        $id
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>
