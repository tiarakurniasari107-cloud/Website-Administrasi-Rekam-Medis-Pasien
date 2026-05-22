<?php
require_once '../config/auth.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['tanggal']) || !isset($_POST['poli_id']) || !isset($_POST['jam'])) {
    echo json_encode(['available' => false, 'message' => 'Parameter tidak lengkap']);
    exit;
}

$id = (int)$_POST['id'];
$tanggal = trim($_POST['tanggal']);
$poliId = $_POST['poli_id'] !== '' ? (int)$_POST['poli_id'] : null;
$jam = trim($_POST['jam']);

// Validasi format tanggal
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
    echo json_encode(['available' => false, 'message' => 'Format tanggal tidak valid']);
    exit;
}

// Cek apakah sudah ada pasien lain di sesi dan poli yang sama (exclude kunjungan dengan id yang sama)
if ($poliId !== null) {
    $stmt = mysqli_prepare($koneksi, 
        "SELECT COUNT(*) as count FROM kunjungan 
         WHERE id != ? AND tanggal_kunjungan = ? AND poli_id = ? AND jam_kunjungan = ? AND status_kunjungan != 'batal'"
    );
    mysqli_stmt_bind_param($stmt, 'isis', $id, $tanggal, $poliId, $jam);
} else {
    $stmt = mysqli_prepare($koneksi, 
        "SELECT COUNT(*) as count FROM kunjungan 
         WHERE id != ? AND tanggal_kunjungan = ? AND poli_id IS NULL AND jam_kunjungan = ? AND status_kunjungan != 'batal'"
    );
    mysqli_stmt_bind_param($stmt, 'iss', $id, $tanggal, $jam);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$isAvailable = $row['count'] == 0;

echo json_encode([
    'available' => $isAvailable,
    'message' => $isAvailable ? 'Slot tersedia' : 'Slot sudah terpakai'
]);
?>
