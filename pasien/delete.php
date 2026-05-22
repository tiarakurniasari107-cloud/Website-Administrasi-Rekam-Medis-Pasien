<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

if ($id > 0) {
    try {
        // Disable foreign key checks temporarily
        mysqli_query($koneksi, 'SET FOREIGN_KEY_CHECKS=0');
        
        // Delete related data in order
        // 1. Delete resep_detail related to resep
        $stmt = mysqli_prepare($koneksi, '
            DELETE rd FROM resep_detail rd
            INNER JOIN resep r ON rd.resep_id = r.id
            INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
            INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
            WHERE k.pasien_id = ?
        ');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 2. Delete resep
        $stmt = mysqli_prepare($koneksi, '
            DELETE r FROM resep r
            INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
            INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
            WHERE k.pasien_id = ?
        ');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 3. Delete rekam_medis_tindakan
        $stmt = mysqli_prepare($koneksi, '
            DELETE rmt FROM rekam_medis_tindakan rmt
            INNER JOIN rekam_medis rm ON rmt.rekam_medis_id = rm.id
            INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
            WHERE k.pasien_id = ?
        ');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 4. Delete rekam_medis
        $stmt = mysqli_prepare($koneksi, '
            DELETE rm FROM rekam_medis rm
            INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
            WHERE k.pasien_id = ?
        ');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 5. Delete kunjungan
        $stmt = mysqli_prepare($koneksi, 'DELETE FROM kunjungan WHERE pasien_id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 6. Delete pasien
        $stmt = mysqli_prepare($koneksi, 'DELETE FROM pasien WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Re-enable foreign key checks
        mysqli_query($koneksi, 'SET FOREIGN_KEY_CHECKS=1');
        
    } catch (Exception $e) {
        // Re-enable foreign key checks on error
        mysqli_query($koneksi, 'SET FOREIGN_KEY_CHECKS=1');
        $error = $e->getMessage();
    }
}

header('Location: index.php');
exit;
