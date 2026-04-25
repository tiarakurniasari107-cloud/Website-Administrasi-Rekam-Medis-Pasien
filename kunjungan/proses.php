<?php
require_once '../config/auth.php';

if (isset($_POST['simpan'])) {
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
        $kode_kunjungan === '' ||
        $pasien_id <= 0 ||
        $dokter_id <= 0 ||
        $tanggal_kunjungan === '' ||
        $jam_kunjungan === '' ||
        !in_array($jenis_kunjungan, $jenisValid, true) ||
        !in_array($cara_bayar, $caraValid, true) ||
        !in_array($status_kunjungan, $statusValid, true)
    ) {
        header('Location: create.php');
        exit;
    }

    if ($poli_id === null) {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO kunjungan (
                kode_kunjungan, pasien_id, dokter_id, poli_id,
                tanggal_kunjungan, jam_kunjungan, jenis_kunjungan,
                cara_bayar, keluhan_utama, status_kunjungan
            ) VALUES (?, ?, ?, NULL, ?, ?, ?, ?, NULLIF(?, ''), ?)"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'siissssss',
            $kode_kunjungan,
            $pasien_id,
            $dokter_id,
            $tanggal_kunjungan,
            $jam_kunjungan,
            $jenis_kunjungan,
            $cara_bayar,
            $keluhan_utama,
            $status_kunjungan
        );
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO kunjungan (
                kode_kunjungan, pasien_id, dokter_id, poli_id,
                tanggal_kunjungan, jam_kunjungan, jenis_kunjungan,
                cara_bayar, keluhan_utama, status_kunjungan
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?, ''), ?)"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'siiissssss',
            $kode_kunjungan,
            $pasien_id,
            $dokter_id,
            $poli_id,
            $tanggal_kunjungan,
            $jam_kunjungan,
            $jenis_kunjungan,
            $cara_bayar,
            $keluhan_utama,
            $status_kunjungan
        );
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: index.php');
    exit;
}
