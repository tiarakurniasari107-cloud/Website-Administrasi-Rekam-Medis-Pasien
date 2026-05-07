<?php
require_once '../config/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id < 1) {
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT rm.*, k.kode_kunjungan, k.tanggal_kunjungan, k.jam_kunjungan,
            p.nama_pasien, p.no_rm, p.jenis_kelamin, p.tanggal_lahir, p.no_telp, p.alamat,
            d.nama_dokter, pl.nama_poli
     FROM rekam_medis rm
     INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
     INNER JOIN pasien p ON k.pasien_id = p.id
     INNER JOIN dokter d ON k.dokter_id = d.id
     LEFT JOIN poli pl ON k.poli_id = pl.id
     WHERE rm.id = ?"
);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$rekamMedis = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$rekamMedis) {
    header('Location: index.php');
    exit;
}

$umur = '';
if ($rekamMedis['tanggal_lahir']) {
    $birthDate = new DateTime($rekamMedis['tanggal_lahir']);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    $umur = $age->y . ' tahun ' . $age->m . ' bulan';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekam Medis - <?= htmlspecialchars($rekamMedis['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></title>
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
        .section-title {
            font-size: 13px;
            font-weight: bold;
            background: #f5f5f5;
            padding: 5px 10px;
            margin: 15px 0 10px 0;
            border-left: 3px solid #333;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            background: #f9f9f9;
            font-weight: bold;
        }
        .vital-signs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 10px 0;
        }
        .vital-sign-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .vital-sign-item .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
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

    <div class="print-title">REKAM MEDIS</div>

    <div class="section-title">Data Pasien</div>
    <table class="info-table">
        <tr>
            <td>No RM</td>
            <td>: <?= htmlspecialchars($rekamMedis['no_rm'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: <?= htmlspecialchars($rekamMedis['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: <?= ($rekamMedis['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>: <?= $umur ?: '-'; ?></td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>: <?= htmlspecialchars($rekamMedis['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Data Kunjungan</div>
    <table class="info-table">
        <tr>
            <td>Kode Kunjungan</td>
            <td>: <?= htmlspecialchars($rekamMedis['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Tanggal Kunjungan</td>
            <td>: <?= htmlspecialchars($rekamMedis['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Jam Kunjungan</td>
            <td>: <?= htmlspecialchars($rekamMedis['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>: <?= htmlspecialchars($rekamMedis['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Poliklinik</td>
            <td>: <?= htmlspecialchars($rekamMedis['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Pemeriksaan</div>
    <table class="info-table">
        <tr>
            <td>Keluhan</td>
            <td>: <?= htmlspecialchars($rekamMedis['keluhan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Riwayat Penyakit</td>
            <td>: <?= htmlspecialchars($rekamMedis['riwayat_penyakit'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Pemeriksaan Fisik</td>
            <td>: <?= htmlspecialchars($rekamMedis['pemeriksaan_fisik'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Tanda Vital</div>
    <div class="vital-signs">
        <div class="vital-sign-item">
            <span class="label">Tekanan Darah</span>
            <?= htmlspecialchars($rekamMedis['tekanan_darah'] ?? '-', ENT_QUOTES, 'UTF-8'); ?> mmHg
        </div>
        <div class="vital-sign-item">
            <span class="label">Suhu Tubuh</span>
            <?= htmlspecialchars($rekamMedis['suhu_tubuh'] ?? '-', ENT_QUOTES, 'UTF-8'); ?> °C
        </div>
        <div class="vital-sign-item">
            <span class="label">Nadi</span>
            <?= htmlspecialchars($rekamMedis['nadi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?> x/menit
        </div>
        <div class="vital-sign-item">
            <span class="label">Pernapasan</span>
            <?= htmlspecialchars($rekamMedis['pernapasan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?> x/menit
        </div>
    </div>

    <div class="section-title">Diagnosa</div>
    <table class="info-table">
        <tr>
            <td>Diagnosa Kerja</td>
            <td>: <?= htmlspecialchars($rekamMedis['diagnosa_kerja'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Diagnosa Banding</td>
            <td>: <?= htmlspecialchars($rekamMedis['diagnosa_banding'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Terapi</div>
    <table class="info-table">
        <tr>
            <td>Terapi</td>
            <td>: <?= htmlspecialchars($rekamMedis['terapi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Catatan Dokter</div>
    <table class="info-table">
        <tr>
            <td>Catatan</td>
            <td>: <?= htmlspecialchars($rekamMedis['catatan_dokter'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td>Tindak Lanjut</td>
            <td>: <?= htmlspecialchars($rekamMedis['tindak_lanjut'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="section-title">Waktu Pemeriksaan</div>
    <table class="info-table">
        <tr>
            <td>Tanggal & Jam</td>
            <td>: <?= htmlspecialchars($rekamMedis['tanggal_pemeriksaan'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>

    <div class="print-footer">
        <div class="signature">
            <p><?= date('d F Y'); ?></p>
            <div class="space"></div>
            <p>( <?= htmlspecialchars($rekamMedis['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?> )</p>
            <p>Dokter Pemeriksa</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>
</body>
</html>
