<?php
require_once '../config/auth.php';

if (isset($_POST['simpan'])) {
    $kode_kunjungan = trim($_POST['kode_kunjungan'] ?? '');
    $pasien_id = isset($_POST['pasien_id']) ? (int) $_POST['pasien_id'] : 0;
    $jadwal_dokter_id = isset($_POST['jadwal_dokter_id']) ? (int) $_POST['jadwal_dokter_id'] : 0;
    $tanggal_kunjungan = trim($_POST['tanggal_kunjungan'] ?? '');
    $jam_kunjungan = trim($_POST['jam_kunjungan'] ?? '');
    $jenis_kunjungan = $_POST['jenis_kunjungan'] ?? '';
    $cara_bayar = $_POST['cara_bayar'] ?? '';
    $keluhan_utama = trim($_POST['keluhan_utama'] ?? '');
    $status_kunjungan = 'menunggu';

    // Validasi dasar
    if (
        $kode_kunjungan === '' ||
        $pasien_id <= 0 ||
        $jadwal_dokter_id <= 0 ||
        $tanggal_kunjungan === '' ||
        $jam_kunjungan === ''
    ) {
        header('Location: create.php?error=1');
        exit;
    }

    $jenisValid = ['baru', 'lama'];
    $caraValid = ['umum', 'bpjs', 'asuransi', 'lainnya'];

    if (
        !in_array($jenis_kunjungan, $jenisValid, true) ||
        !in_array($cara_bayar, $caraValid, true)
    ) {
        header('Location: create.php?error=2');
        exit;
    }

    // Get jadwal dokter info (dokter_id dan poli_id)
    $stmtJadwal = mysqli_prepare($koneksi, 'SELECT dokter_id, poli_id FROM jadwal_dokter WHERE id = ?');
    mysqli_stmt_bind_param($stmtJadwal, 'i', $jadwal_dokter_id);
    mysqli_stmt_execute($stmtJadwal);
    $resultJadwal = mysqli_stmt_get_result($stmtJadwal);
    
    if (!$resultJadwal || mysqli_num_rows($resultJadwal) === 0) {
        mysqli_stmt_close($stmtJadwal);
        header('Location: create.php?error=3');
        exit;
    }

    $jadwalRow = mysqli_fetch_assoc($resultJadwal);
    $dokter_id = $jadwalRow['dokter_id'];
    $poli_id = $jadwalRow['poli_id'];
    mysqli_stmt_close($stmtJadwal);

    // Validasi slot tidak boleh ada pasien lain di jam yang sama untuk poli ini
    if ($poli_id !== null) {
        $stmtCheck = mysqli_prepare($koneksi, 
            "SELECT COUNT(*) as count FROM kunjungan 
             WHERE tanggal_kunjungan = ? AND poli_id = ? AND jam_kunjungan = ? AND status_kunjungan != 'batal'"
        );
        mysqli_stmt_bind_param($stmtCheck, 'sis', $tanggal_kunjungan, $poli_id, $jam_kunjungan);
    } else {
        $stmtCheck = mysqli_prepare($koneksi, 
            "SELECT COUNT(*) as count FROM kunjungan 
             WHERE tanggal_kunjungan = ? AND poli_id IS NULL AND jam_kunjungan = ? AND status_kunjungan != 'batal'"
        );
        mysqli_stmt_bind_param($stmtCheck, 'ss', $tanggal_kunjungan, $jam_kunjungan);
    }

    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);
    mysqli_stmt_close($stmtCheck);

    if ($rowCheck['count'] > 0) {
        header('Location: create.php?error=slot');
        exit;
    }

    // Insert kunjungan
    if ($poli_id !== null) {
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
    } else {
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
    }

    mysqli_stmt_execute($stmt);
    
    if (!$stmt) {
        echo "Error preparing statement: " . mysqli_error($koneksi);
        exit;
    }
    
    if (mysqli_error($koneksi)) {
        echo "Error executing statement: " . mysqli_error($koneksi);
        exit;
    }
    
    mysqli_stmt_close($stmt);

    header('Location: index.php');
    exit;
}
