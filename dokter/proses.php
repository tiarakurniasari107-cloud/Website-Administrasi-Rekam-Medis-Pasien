<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $kode_dokter = trim($_POST['kode_dokter'] ?? '');
    $nama_dokter = trim($_POST['nama_dokter'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $spesialisasi = trim($_POST['spesialisasi'] ?? '');
    $no_sip = trim($_POST['no_sip'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $poli_id = isset($_POST['poli_id']) && $_POST['poli_id'] !== '' ? (int) $_POST['poli_id'] : null;
    $status = $_POST['status'] ?? '';

    if ($kode_dokter === '' || $nama_dokter === '' || !in_array($jenis_kelamin, ['L', 'P'], true) || !in_array($status, ['aktif', 'nonaktif'], true)) {
        header("Location: create.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "
        INSERT INTO dokter (
            kode_dokter, nama_dokter, jenis_kelamin, spesialisasi,
            no_sip, no_telp, alamat, poli_id, status
        ) VALUES (?, ?, ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), ?, ?)
    ");
    mysqli_stmt_bind_param($stmt, "sssssssis", $kode_dokter, $nama_dokter, $jenis_kelamin, $spesialisasi, $no_sip, $no_telp, $alamat, $poli_id, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit;
}
?>