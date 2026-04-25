<?php
require_once '../config/auth.php';

$jenis = isset($_GET['jenis']) ? trim($_GET['jenis']) : '';

$allowed = ['pasien', 'dokter', 'poli', 'obat', 'tindakan'];
if (!in_array($jenis, $allowed, true)) {
    header('Location: index.php');
    exit;
}

$config = [
    'pasien' => [
        'title' => 'Laporan Pasien',
        'subtitle' => 'Daftar lengkap data seluruh pasien klinik',
        'print_jenis' => 'pasien',
        'headers' => ['No', 'No RM', 'Nama Pasien', 'Jenis Kelamin', 'No HP', 'Alamat'],
        'sql' => 'SELECT no_rm, nama_pasien, jenis_kelamin, no_telp, alamat FROM pasien ORDER BY id DESC',
        'render' => function ($row, $no) {
            $jk = ($row['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan';
            return [$no, $row['no_rm'], $row['nama_pasien'], $jk, $row['no_telp'] ?? '-', $row['alamat'] ?? '-'];
        },
    ],
    'dokter' => [
        'title' => 'Laporan Dokter',
        'subtitle' => 'Daftar lengkap data seluruh dokter klinik',
        'print_jenis' => 'dokter',
        'headers' => ['No', 'Kode Dokter', 'Nama Dokter', 'Spesialis', 'Poli', 'No SIP'],
        'sql' => 'SELECT d.kode_dokter, d.nama_dokter, d.spesialisasi, p.nama_poli, d.no_sip FROM dokter d LEFT JOIN poli p ON d.poli_id = p.id ORDER BY d.id DESC',
        'render' => function ($row, $no) {
            return [$no, $row['kode_dokter'], $row['nama_dokter'], $row['spesialisasi'] ?? '-', $row['nama_poli'] ?? '-', $row['no_sip'] ?? '-'];
        },
    ],
    'poli' => [
        'title' => 'Laporan Poli',
        'subtitle' => 'Daftar lengkap data seluruh poli klinik',
        'print_jenis' => 'poli',
        'headers' => ['No', 'Nama Poli', 'Keterangan'],
        'sql' => 'SELECT nama_poli, keterangan FROM poli ORDER BY id DESC',
        'render' => function ($row, $no) {
            return [$no, $row['nama_poli'], $row['keterangan'] ?? '-'];
        },
    ],
    'obat' => [
        'title' => 'Laporan Obat',
        'subtitle' => 'Daftar lengkap data stok obat klinik',
        'print_jenis' => 'obat',
        'headers' => ['No', 'Nama Obat', 'Satuan', 'Stok', 'Harga', 'Keterangan'],
        'sql' => 'SELECT nama_obat, satuan, stok, harga, keterangan FROM obat ORDER BY id DESC',
        'render' => function ($row, $no) {
            return [
                $no,
                $row['nama_obat'],
                $row['satuan'] ?? '-',
                (int) $row['stok'],
                number_format((float) $row['harga'], 0, ',', '.'),
                $row['keterangan'] ?? '-',
            ];
        },
    ],
    'tindakan' => [
        'title' => 'Laporan Tindakan',
        'subtitle' => 'Daftar lengkap data tindakan klinik',
        'print_jenis' => 'tindakan',
        'headers' => ['No', 'Nama Tindakan', 'Tarif', 'Keterangan'],
        'sql' => 'SELECT nama_tindakan, tarif, keterangan FROM tindakan ORDER BY id DESC',
        'render' => function ($row, $no) {
            return [$no, $row['nama_tindakan'], number_format((float) $row['tarif'], 0, ',', '.'), $row['keterangan'] ?? '-'];
        },
    ],
];

$current = $config[$jenis];

$stmt = mysqli_prepare($koneksi, $current['sql']);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

$totalRows = (int) mysqli_num_rows($data);
$maleCount = 0;
$femaleCount = 0;

if ($jenis === 'pasien') {
    $summaryResult = mysqli_query(
        $koneksi,
        "SELECT
            SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS laki_laki,
            SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS perempuan
        FROM pasien"
    );

    if ($summaryResult instanceof mysqli_result) {
        $summaryRow = mysqli_fetch_assoc($summaryResult);
        $maleCount = (int) ($summaryRow['laki_laki'] ?? 0);
        $femaleCount = (int) ($summaryRow['perempuan'] ?? 0);
        mysqli_free_result($summaryResult);
    }
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<?php
$pageTitle = $current['title'];
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2><?= e($current['title']); ?></h2>
        <p><?= e($current['subtitle']); ?></p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
                <a href="print.php?jenis=<?= urlencode($current['print_jenis']); ?>" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print</a>
            </div>
        </div>

        <div class="report-summary">
            <?php if ($jenis === 'pasien') { ?>
                Total: <strong><?= $totalRows; ?></strong> Pasien
                <span style="margin-left:16px;">Laki-laki: <strong><?= $maleCount; ?></strong></span>
                <span class="female-count" style="margin-left:16px;">Perempuan: <strong><?= $femaleCount; ?></strong></span>
            <?php } else { ?>
                Total: <strong><?= $totalRows; ?></strong> Data
            <?php } ?>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php foreach ($current['headers'] as $header) { ?>
                            <th><?= e($header); ?></th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
                    <?php $cells = $current['render']($row, $no++); ?>
                    <tr>
                        <?php foreach ($cells as $cellIndex => $cell) { ?>
                            <td>
                                <?php if ($jenis === 'pasien' && $cellIndex === 1) { ?>
                                    <span class="table-key"><?= e($cell); ?></span>
                                <?php } elseif ($jenis === 'pasien' && $cellIndex === 3) { ?>
                                    <span class="gender-badge <?= ((string) $cell === 'Laki-laki') ? 'gender-badge-male' : 'gender-badge-female'; ?>">
                                        <?= e($cell); ?>
                                    </span>
                                <?php } else { ?>
                                    <?= e($cell); ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <?php mysqli_stmt_close($stmt); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
