<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_POST['update'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $detail_id = isset($_POST['detail_id']) ? (int) $_POST['detail_id'] : 0;
    $rekam_medis_id = isset($_POST['rekam_medis_id']) ? (int) $_POST['rekam_medis_id'] : 0;
    $tanggal_resep = trim($_POST['tanggal_resep'] ?? '');
    $obat_id = isset($_POST['obat_id']) ? (int) $_POST['obat_id'] : 0;
    $dosis = trim($_POST['dosis'] ?? '');
    $jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 0;
    $aturan_pakai = trim($_POST['aturan_pakai'] ?? '');
    $catatan = trim($_POST['catatan'] ?? '');

    if ($id <= 0 || $rekam_medis_id <= 0 || $obat_id <= 0 || $dosis === '' || $aturan_pakai === '' || $jumlah <= 0) {
        header('Location: index.php');
        exit;
    }

    mysqli_begin_transaction($koneksi);

    $ok = true;

    if ($tanggal_resep === '') {
        $stmtResep = mysqli_prepare(
            $koneksi,
            "UPDATE resep SET rekam_medis_id = ?, catatan = NULLIF(?, '') WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmtResep, 'isi', $rekam_medis_id, $catatan, $id);
    } else {
        $stmtResep = mysqli_prepare(
            $koneksi,
            "UPDATE resep SET rekam_medis_id = ?, tanggal_resep = ?, catatan = NULLIF(?, '') WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmtResep, 'issi', $rekam_medis_id, $tanggal_resep, $catatan, $id);
    }

    $ok = $ok && mysqli_stmt_execute($stmtResep);
    mysqli_stmt_close($stmtResep);

    if ($ok) {
        if ($detail_id > 0) {
            $stmtDetail = mysqli_prepare(
                $koneksi,
                'UPDATE resep_detail SET obat_id = ?, dosis = ?, jumlah = ?, aturan_pakai = ? WHERE id = ? AND resep_id = ?'
            );
            mysqli_stmt_bind_param($stmtDetail, 'isisii', $obat_id, $dosis, $jumlah, $aturan_pakai, $detail_id, $id);
            $ok = $ok && mysqli_stmt_execute($stmtDetail);
            mysqli_stmt_close($stmtDetail);
        } else {
            $stmtDetail = mysqli_prepare(
                $koneksi,
                'INSERT INTO resep_detail (resep_id, obat_id, dosis, jumlah, aturan_pakai) VALUES (?, ?, ?, ?, ?)'
            );
            mysqli_stmt_bind_param($stmtDetail, 'iisis', $id, $obat_id, $dosis, $jumlah, $aturan_pakai);
            $ok = $ok && mysqli_stmt_execute($stmtDetail);
            mysqli_stmt_close($stmtDetail);
        }
    }

    if ($ok) {
        mysqli_commit($koneksi);
        header('Location: index.php');
        exit;
    }

    mysqli_rollback($koneksi);
    header('Location: edit.php?id=' . $id);
    exit;
}
