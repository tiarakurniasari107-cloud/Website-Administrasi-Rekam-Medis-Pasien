<?php
require_once '../config/auth.php';

if (isset($_POST['simpan'])) {
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

    if ($kunjungan_id <= 0) {
        header('Location: create.php');
        exit;
    }

    if ($tanggal_pemeriksaan === '') {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO rekam_medis (
                kunjungan_id, keluhan, riwayat_penyakit, tekanan_darah,
                suhu_tubuh, nadi, pernapasan, diagnosa_kerja,
                diagnosa_banding, pemeriksaan_fisik, terapi,
                catatan_dokter, tindak_lanjut
            ) VALUES (
                ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, '')
            )"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'issssssssssss',
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
            $tindak_lanjut
        );
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO rekam_medis (
                kunjungan_id, keluhan, riwayat_penyakit, tekanan_darah,
                suhu_tubuh, nadi, pernapasan, diagnosa_kerja,
                diagnosa_banding, pemeriksaan_fisik, terapi,
                catatan_dokter, tindak_lanjut, tanggal_pemeriksaan
            ) VALUES (
                ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                NULLIF(?, ''), NULLIF(?, ''), ?
            )"
        );
        mysqli_stmt_bind_param(
            $stmt,
            'isssssssssssss',
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
            $tanggal_pemeriksaan
        );
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: index.php');
    exit;
}
