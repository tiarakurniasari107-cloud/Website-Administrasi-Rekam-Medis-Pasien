<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_POST['update'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $kode_kunjungan = trim($_POST['kode_kunjungan'] ?? '');
    $pasien_id = isset($_POST['pasien_id']) ? (int) $_POST['pasien_id'] : 0;
    $dokter_id = isset($_POST['dokter_id']) ? (int) $_POST['dokter_id'] : 0;
    $poli_id = isset($_POST['poli_id']) && $_POST['poli_id'] !== '' ? (int) $_POST['poli_id'] : null;
    $tanggal_kunjungan = trim($_POST['tanggal_kunjungan'] ?? '');
    $jam_kunjungan = trim($_POST['jam_kunjungan'] ?? '');
    $jenis_kunjungan = $_POST['jenis_kunjungan'] ?? '';
    $cara_bayar = $_POST['cara_bayar'] ?? '';
    $keluhan_utama = trim($_POST['keluhan_utama'] ?? '');
    $status_kunjungan = $_POST['status_kunjungan'] ?? '';

    $jenisValid = ['baru', 'lama'];
    $caraValid = ['umum', 'bpjs', 'asuransi', 'lainnya'];
    $statusValid = ['menunggu', 'diperiksa', 'selesai', 'batal'];

    if (
        $id <= 0 ||
        $kode_kunjungan === '' ||
        $pasien_id <= 0 ||
        $dokter_id <= 0 ||
        $tanggal_kunjungan === '' ||
        $jam_kunjungan === '' ||
        !in_array($jenis_kunjungan, $jenisValid, true) ||
        !in_array($cara_bayar, $caraValid, true) ||
        !in_array($status_kunjungan, $statusValid, true)
    ) {
        header('Location: index.php');
        exit;
    }

    if ($poli_id === null) {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE kunjungan SET
                kode_kunjungan = ?,
                pasien_id = ?,
                dokter_id = ?,
                poli_id = NULL,
                tanggal_kunjungan = ?,
                jam_kunjungan = ?,
                jenis_kunjungan = ?,
                cara_bayar = ?,
                keluhan_utama = NULLIF(?, ''),
                status_kunjungan = ?
            WHERE id = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'siissssssi',
            $kode_kunjungan,
            $pasien_id,
            $dokter_id,
            $tanggal_kunjungan,
            $jam_kunjungan,
            $jenis_kunjungan,
            $cara_bayar,
            $keluhan_utama,
            $status_kunjungan,
            $id
        );
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE kunjungan SET
                kode_kunjungan = ?,
                pasien_id = ?,
                dokter_id = ?,
                poli_id = ?,
                tanggal_kunjungan = ?,
                jam_kunjungan = ?,
                jenis_kunjungan = ?,
                cara_bayar = ?,
                keluhan_utama = NULLIF(?, ''),
                status_kunjungan = ?
            WHERE id = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'siiissssssi',
            $kode_kunjungan,
            $pasien_id,
            $dokter_id,
            $poli_id,
            $tanggal_kunjungan,
            $jam_kunjungan,
            $jenis_kunjungan,
            $cara_bayar,
            $keluhan_utama,
            $status_kunjungan,
            $id
        );
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: index.php');
    exit;
}
