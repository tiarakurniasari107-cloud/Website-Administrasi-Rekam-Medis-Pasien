<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_POST['update'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $kunjungan_id = isset($_POST['kunjungan_id']) ? (int) $_POST['kunjungan_id'] : 0;
    $keluhan = trim($_POST['keluhan'] ?? '');
    $riwayat_penyakit = trim($_POST['riwayat_penyakit'] ?? '');
    $tekanan_darah = trim($_POST['tekanan_darah'] ?? '');
    $suhu_tubuh = trim($_POST['suhu_tubuh'] ?? '');
    $nadi = trim($_POST['nadi'] ?? '');
    $pernapasan = trim($_POST['pernapasan'] ?? '');
    $diagnosa_kerja = trim($_POST['diagnosa_kerja'] ?? '');
    $diagnosa_banding = trim($_POST['diagnosa_banding'] ?? '');
    $pemeriksaan_fisik = trim($_POST['pemeriksaan_fisik'] ?? '');
    $terapi = trim($_POST['terapi'] ?? '');
    $catatan_dokter = trim($_POST['catatan_dokter'] ?? '');
    $tindak_lanjut = trim($_POST['tindak_lanjut'] ?? '');
    $tanggal_pemeriksaan = trim($_POST['tanggal_pemeriksaan'] ?? '');

    if ($id <= 0 || $kunjungan_id <= 0) {
        header('Location: index.php');
        exit;
    }

    if ($tanggal_pemeriksaan === '') {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE rekam_medis SET
                kunjungan_id = ?,
                keluhan = NULLIF(?, ''),
                riwayat_penyakit = NULLIF(?, ''),
                tekanan_darah = NULLIF(?, ''),
                suhu_tubuh = NULLIF(?, ''),
                nadi = NULLIF(?, ''),
                pernapasan = NULLIF(?, ''),
                diagnosa_kerja = NULLIF(?, ''),
                diagnosa_banding = NULLIF(?, ''),
                pemeriksaan_fisik = NULLIF(?, ''),
                terapi = NULLIF(?, ''),
                catatan_dokter = NULLIF(?, ''),
                tindak_lanjut = NULLIF(?, '')
            WHERE id = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'issssssssssssi',
            $kunjungan_id,
            $keluhan,
            $riwayat_penyakit,
            $tekanan_darah,
            $suhu_tubuh,
            $nadi,
            $pernapasan,
            $diagnosa_kerja,
            $diagnosa_banding,
            $pemeriksaan_fisik,
            $terapi,
            $catatan_dokter,
            $tindak_lanjut,
            $id
        );
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE rekam_medis SET
                kunjungan_id = ?,
                keluhan = NULLIF(?, ''),
                riwayat_penyakit = NULLIF(?, ''),
                tekanan_darah = NULLIF(?, ''),
                suhu_tubuh = NULLIF(?, ''),
                nadi = NULLIF(?, ''),
                pernapasan = NULLIF(?, ''),
                diagnosa_kerja = NULLIF(?, ''),
                diagnosa_banding = NULLIF(?, ''),
                pemeriksaan_fisik = NULLIF(?, ''),
                terapi = NULLIF(?, ''),
                catatan_dokter = NULLIF(?, ''),
                tindak_lanjut = NULLIF(?, ''),
                tanggal_pemeriksaan = ?
            WHERE id = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'isssssssssssssi',
            $kunjungan_id,
            $keluhan,
            $riwayat_penyakit,
            $tekanan_darah,
            $suhu_tubuh,
            $nadi,
            $pernapasan,
            $diagnosa_kerja,
            $diagnosa_banding,
            $pemeriksaan_fisik,
            $terapi,
            $catatan_dokter,
            $tindak_lanjut,
            $tanggal_pemeriksaan,
            $id
        );
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: index.php');
    exit;
}
