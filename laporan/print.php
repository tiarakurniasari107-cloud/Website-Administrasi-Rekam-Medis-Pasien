<?php
require_once '../config/auth.php';

$jenis = $_GET['jenis'] ?? '';
$title = 'Laporan Data';
$headers = [];
$sql = '';
$types = '';
$params = [];

function normalizeDate($value)
{
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }

    $date = DateTime::createFromFormat('Y-m-d', $value);
    if (!$date || $date->format('Y-m-d') !== $value) {
        return '';
    }

    return $value;
}

$tanggal_awal = normalizeDate($_GET['tanggal_awal'] ?? '');
$tanggal_akhir = normalizeDate($_GET['tanggal_akhir'] ?? '');

function bindParams($stmt, $types, &$params)
{
    if ($types === '') {
        return;
    }

    $args = [$stmt, $types];
    foreach ($params as $key => $value) {
        $args[] = &$params[$key];
    }

    call_user_func_array('mysqli_stmt_bind_param', $args);
}

if (!in_array($jenis, ['pasien', 'dokter', 'poli', 'kunjungan', 'rekam_medis', 'obat', 'tindakan', 'resep'], true)) {
    die('Jenis laporan tidak ditemukan.');
}

switch ($jenis) {
    case 'pasien':
        $title = 'Laporan Data Pasien';
        $headers = ['No RM', 'Nama Pasien', 'Jenis Kelamin', 'No Telp', 'Alamat'];
        $sql = "SELECT no_rm, nama_pasien, jenis_kelamin, no_telp, alamat FROM pasien ORDER BY id DESC";
        break;

    case 'dokter':
        $title = 'Laporan Data Dokter';
        $headers = ['Kode Dokter', 'Nama Dokter', 'Spesialisasi', 'Poli', 'No SIP'];
        $sql = "SELECT d.kode_dokter, d.nama_dokter, d.spesialisasi, p.nama_poli, d.no_sip
                FROM dokter d
                LEFT JOIN poli p ON d.poli_id = p.id
                ORDER BY d.id DESC";
        break;

    case 'poli':
        $title = 'Laporan Data Poli';
        $headers = ['Nama Poli', 'Keterangan'];
        $sql = "SELECT nama_poli, keterangan FROM poli ORDER BY id DESC";
        break;

    case 'kunjungan':
        $title = 'Laporan Data Kunjungan';
        $headers = ['Kode Kunjungan', 'Tanggal', 'Pasien', 'Dokter', 'Poli', 'Keluhan Utama', 'Status'];
        $sql = "SELECT k.kode_kunjungan, k.tanggal_kunjungan, p.nama_pasien, d.nama_dokter, pl.nama_poli, k.keluhan_utama, k.status_kunjungan
                FROM kunjungan k
                INNER JOIN pasien p ON k.pasien_id = p.id
                INNER JOIN dokter d ON k.dokter_id = d.id
                LEFT JOIN poli pl ON k.poli_id = pl.id";

        if ($tanggal_awal !== '') {
            $sql .= ' WHERE DATE(k.tanggal_kunjungan) >= ?';
            $types .= 's';
            $params[] = $tanggal_awal;
        }

        if ($tanggal_akhir !== '') {
            $sql .= ($tanggal_awal !== '') ? ' AND ' : ' WHERE ';
            $sql .= 'DATE(k.tanggal_kunjungan) <= ?';
            $types .= 's';
            $params[] = $tanggal_akhir;
        }

        $sql .= ' ORDER BY k.id DESC';
        break;

    case 'rekam_medis':
        $title = 'Laporan Rekam Medis';
        $headers = ['Kode Kunjungan', 'Pasien', 'Dokter', 'Keluhan', 'Diagnosa Kerja', 'Terapi', 'Tanggal Pemeriksaan'];
        $sql = "SELECT k.kode_kunjungan, p.nama_pasien, d.nama_dokter, rm.keluhan, rm.diagnosa_kerja, rm.terapi, rm.tanggal_pemeriksaan
                FROM rekam_medis rm
                INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
                INNER JOIN pasien p ON k.pasien_id = p.id
                INNER JOIN dokter d ON k.dokter_id = d.id";

        if ($tanggal_awal !== '') {
            $sql .= ' WHERE DATE(rm.tanggal_pemeriksaan) >= ?';
            $types .= 's';
            $params[] = $tanggal_awal;
        }

        if ($tanggal_akhir !== '') {
            $sql .= ($tanggal_awal !== '') ? ' AND ' : ' WHERE ';
            $sql .= 'DATE(rm.tanggal_pemeriksaan) <= ?';
            $types .= 's';
            $params[] = $tanggal_akhir;
        }

        $sql .= ' ORDER BY rm.id DESC';
        break;

    case 'obat':
        $title = 'Laporan Data Obat';
        $headers = ['Nama Obat', 'Satuan', 'Stok', 'Harga', 'Keterangan'];
        $sql = "SELECT nama_obat, satuan, stok, harga, keterangan FROM obat ORDER BY id DESC";
        break;

    case 'tindakan':
        $title = 'Laporan Data Tindakan';
        $headers = ['Nama Tindakan', 'Tarif', 'Keterangan'];
        $sql = "SELECT nama_tindakan, tarif, keterangan FROM tindakan ORDER BY id DESC";
        break;

    case 'resep':
        $title = 'Laporan Data Resep';
        $headers = ['Kode Kunjungan', 'Pasien', 'Dokter', 'Tanggal Resep', 'Daftar Obat', 'Catatan'];
        $sql = "SELECT k.kode_kunjungan, p.nama_pasien, d.nama_dokter, r.tanggal_resep,
                    GROUP_CONCAT(CONCAT(o.nama_obat, ' (', rd.dosis, ', ', rd.jumlah, ')') SEPARATOR '; ') AS daftar_obat,
                    r.catatan
                FROM resep r
                INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
                INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
                INNER JOIN pasien p ON k.pasien_id = p.id
                INNER JOIN dokter d ON k.dokter_id = d.id
                LEFT JOIN resep_detail rd ON rd.resep_id = r.id
                LEFT JOIN obat o ON rd.obat_id = o.id";

        if ($tanggal_awal !== '') {
            $sql .= ' WHERE DATE(r.tanggal_resep) >= ?';
            $types .= 's';
            $params[] = $tanggal_awal;
        }

        if ($tanggal_akhir !== '') {
            $sql .= ($tanggal_awal !== '') ? ' AND ' : ' WHERE ';
            $sql .= 'DATE(r.tanggal_resep) <= ?';
            $types .= 's';
            $params[] = $tanggal_akhir;
        }

        $sql .= ' GROUP BY r.id, k.kode_kunjungan, p.nama_pasien, d.nama_dokter, r.tanggal_resep, r.catatan';
        $sql .= ' ORDER BY r.id DESC';
        break;
}

$stmt = mysqli_prepare($koneksi, $sql);
bindParams($stmt, $types, $params);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

function e($value)
{
    return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
}

function formatPeriode($tanggal)
{
    if ($tanggal === '') {
        return '';
    }

    $date = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$date) {
        return '';
    }

    return $date->format('d-m-Y');
}

$periode_awal = formatPeriode($tanggal_awal);
$periode_akhir = formatPeriode($tanggal_akhir);
$periode_label = '';

if ($periode_awal !== '' && $periode_akhir !== '') {
    $periode_label = $periode_awal . ' s/d ' . $periode_akhir;
} elseif ($periode_awal !== '') {
    $periode_label = 'Mulai ' . $periode_awal;
} elseif ($periode_akhir !== '') {
    $periode_label = 'Sampai ' . $periode_akhir;
}
?>
<?php
$pageTitle = $title;
$extraHead = <<<'HTML'
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            margin: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
HTML;

require_once '../includes/header.php';
?>

<div class="no-print mb-3">
    <button onclick="window.print()" class="btn btn-success">
        Print Sekarang
    </button>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>
</div>

<h2><?= $title; ?></h2>
<?php if ($periode_label !== '') { ?>
    <p class="text-center mb-4"><strong>Periode:</strong> <?= e($periode_label); ?></p>
<?php } ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <?php foreach ($headers as $header) { ?>
                <th><?= e($header); ?></th>
            <?php } ?>

        </tr>
    </thead>

    <tbody>

<?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <?php if ($jenis == 'pasien') { ?>
            <td><?= e($row['no_rm']); ?></td>
            <td><?= e($row['nama_pasien']); ?></td>
            <td><?= ($row['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
            <td><?= e($row['no_telp']); ?></td>
            <td><?= e($row['alamat']); ?></td>
        <?php } elseif ($jenis == 'dokter') { ?>
            <td><?= e($row['kode_dokter']); ?></td>
            <td><?= e($row['nama_dokter']); ?></td>
            <td><?= e($row['spesialisasi']); ?></td>
            <td><?= e($row['nama_poli']); ?></td>
            <td><?= e($row['no_sip']); ?></td>
        <?php } elseif ($jenis == 'poli') { ?>
            <td><?= e($row['nama_poli']); ?></td>
            <td><?= e($row['keterangan']); ?></td>
        <?php } elseif ($jenis == 'kunjungan') { ?>
            <td><?= e($row['kode_kunjungan']); ?></td>
            <td><?= e($row['tanggal_kunjungan']); ?></td>
            <td><?= e($row['nama_pasien']); ?></td>
            <td><?= e($row['nama_dokter']); ?></td>
            <td><?= e($row['nama_poli']); ?></td>
            <td><?= e($row['keluhan_utama']); ?></td>
            <td><?= e($row['status_kunjungan']); ?></td>
        <?php } elseif ($jenis == 'rekam_medis') { ?>
            <td><?= e($row['kode_kunjungan']); ?></td>
            <td><?= e($row['nama_pasien']); ?></td>
            <td><?= e($row['nama_dokter']); ?></td>
            <td><?= e($row['keluhan']); ?></td>
            <td><?= e($row['diagnosa_kerja']); ?></td>
            <td><?= e($row['terapi']); ?></td>
            <td><?= e($row['tanggal_pemeriksaan']); ?></td>
        <?php } elseif ($jenis == 'obat') { ?>
            <td><?= e($row['nama_obat']); ?></td>
            <td><?= e($row['satuan']); ?></td>
            <td><?= (int) $row['stok']; ?></td>
            <td><?= number_format((float) $row['harga'], 0, ',', '.'); ?></td>
            <td><?= e($row['keterangan']); ?></td>
        <?php } elseif ($jenis == 'tindakan') { ?>
            <td><?= e($row['nama_tindakan']); ?></td>
            <td><?= number_format((float) $row['tarif'], 0, ',', '.'); ?></td>
            <td><?= e($row['keterangan']); ?></td>
        <?php } elseif ($jenis == 'resep') { ?>
            <td><?= e($row['kode_kunjungan']); ?></td>
            <td><?= e($row['nama_pasien']); ?></td>
            <td><?= e($row['nama_dokter']); ?></td>
            <td><?= e($row['tanggal_resep']); ?></td>
            <td><?= e($row['daftar_obat']); ?></td>
            <td><?= e($row['catatan']); ?></td>
        <?php } ?>
    </tr>
<?php } ?>

    </tbody>
</table>

<?php mysqli_stmt_close($stmt); ?>

<?php
$extraScripts = <<<'HTML'
<script>
    window.onload = function () {
        window.print();
    }
</script>
HTML;

require_once '../includes/footer.php';
?>