<?php
require_once '../config/auth.php';

if (isset($_POST['simpan'])) {
    $rekam_medis_id = isset($_POST['rekam_medis_id']) ? (int) $_POST['rekam_medis_id'] : 0;
    $tanggal_resep = trim($_POST['tanggal_resep'] ?? '');
    $obat_id = isset($_POST['obat_id']) ? (int) $_POST['obat_id'] : 0;
    $dosis = trim($_POST['dosis'] ?? '');
    $jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 0;
    $aturan_pakai = trim($_POST['aturan_pakai'] ?? '');
    $catatan = trim($_POST['catatan'] ?? '');

    if ($rekam_medis_id <= 0 || $obat_id <= 0 || $dosis === '' || $aturan_pakai === '' || $jumlah <= 0) {
        header('Location: create.php');
        exit;
    }

    mysqli_begin_transaction($koneksi);

    $ok = true;

    if ($tanggal_resep === '') {
        $stmtResep = mysqli_prepare(
            $koneksi,
            "INSERT INTO resep (rekam_medis_id, catatan) VALUES (?, NULLIF(?, ''))"
        );
        mysqli_stmt_bind_param($stmtResep, 'is', $rekam_medis_id, $catatan);
    } else {
        $stmtResep = mysqli_prepare(
            $koneksi,
            "INSERT INTO resep (rekam_medis_id, tanggal_resep, catatan) VALUES (?, ?, NULLIF(?, ''))"
        );
        mysqli_stmt_bind_param($stmtResep, 'iss', $rekam_medis_id, $tanggal_resep, $catatan);
    }

    $ok = $ok && mysqli_stmt_execute($stmtResep);
    $resep_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmtResep);

    if ($ok) {
        $stmtDetail = mysqli_prepare(
            $koneksi,
            'INSERT INTO resep_detail (resep_id, obat_id, dosis, jumlah, aturan_pakai) VALUES (?, ?, ?, ?, ?)'
        );
        mysqli_stmt_bind_param($stmtDetail, 'iisis', $resep_id, $obat_id, $dosis, $jumlah, $aturan_pakai);
        $ok = $ok && mysqli_stmt_execute($stmtDetail);
        mysqli_stmt_close($stmtDetail);
    }

    if ($ok) {
        mysqli_commit($koneksi);
        header('Location: index.php');
        exit;
    }

    mysqli_rollback($koneksi);
    header('Location: create.php');
    exit;
}
