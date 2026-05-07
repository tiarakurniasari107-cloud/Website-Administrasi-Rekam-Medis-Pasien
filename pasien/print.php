<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id < 1) {
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, 'SELECT * FROM pasien WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$pasien = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$pasien) {
    header('Location: index.php');
    exit;
}

$umur = '';
if ($pasien['tanggal_lahir']) {
    $birthDate = new DateTime($pasien['tanggal_lahir']);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    $umur = $age->y . ' tahun ' . $age->m . ' bulan';
}

$stmtKunjungan = mysqli_prepare($koneksi, 'SELECT COUNT(*) AS total FROM kunjungan WHERE pasien_id = ?');
mysqli_stmt_bind_param($stmtKunjungan, 'i', $id);
mysqli_stmt_execute($stmtKunjungan);
$totalKunjungan = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtKunjungan))['total'];
mysqli_stmt_close($stmtKunjungan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Pasien - <?= htmlspecialchars($pasien['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            padding: 20px;
            background: white;
        }
        .print-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .print-header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .print-header p {
            font-size: 12px;
            color: #666;
        }
        .print-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            background: #f5f5f5;
            font-weight: bold;
        }
        .print-footer {
            margin-top: 40px;
            text-align: right;
        }
        .print-footer .signature {
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        .print-footer .signature .space {
            height: 60px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h1>KLINIK PRATAMA</h1>
        <p>Pelayanan Kesehatan Prima</p>
    </div>

    <div class="print-title">DATA PASIEN</div>

    <table class="info-table">
        <tr>
            <td>No Rekam Medis</td>
            <td>: <?= htmlspecialchars($pasien['no_rm'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: <?= htmlspecialchars($pasien['nik'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: <?= htmlspecialchars($pasien['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: <?= ($pasien['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>: <?= htmlspecialchars($pasien['tempat_lahir'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>, <?= htmlspecialchars($pasien['tanggal_lahir'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>: <?= $umur ?: '-'; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: <?= htmlspecialchars($pasien['alamat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>: <?= htmlspecialchars($pasien['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Golongan Darah</td>
            <td>: <?= htmlspecialchars($pasien['golongan_darah'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Alergi</td>
            <td>: <?= htmlspecialchars($pasien['alergi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>: <?= htmlspecialchars($pasien['status_kawin'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: <?= htmlspecialchars($pasien['pekerjaan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Total Kunjungan</td>
            <td>: <?= $totalKunjungan; ?> kali</td>
        </tr>
    </table>

    <div class="print-footer">
        <div class="signature">
            <p><?= date('d F Y'); ?></p>
            <div class="space"></div>
            <p>( ................................. )</p>
            <p>Petugas Klinik</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>
</body>
</html>
