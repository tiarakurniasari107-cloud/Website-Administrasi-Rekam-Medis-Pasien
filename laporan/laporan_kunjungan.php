<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

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

$tanggal_awal = normalizeDate($_GET['tanggal_awal'] ?? '');
$tanggal_akhir = normalizeDate($_GET['tanggal_akhir'] ?? '');

$sql = "SELECT 
        k.kode_kunjungan,
        k.tanggal_kunjungan,
        p.nama_pasien,
        d.nama_dokter,
        pl.nama_poli,
        k.keluhan_utama,
        k.status_kunjungan
    FROM kunjungan k
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN poli pl ON k.poli_id = pl.id";

$where = [];
$types = '';
$params = [];

if ($tanggal_awal !== '') {
    $where[] = 'DATE(k.tanggal_kunjungan) >= ?';
    $types .= 's';
    $params[] = $tanggal_awal;
}

if ($tanggal_akhir !== '') {
    $where[] = 'DATE(k.tanggal_kunjungan) <= ?';
    $types .= 's';
    $params[] = $tanggal_akhir;
}

if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY k.id DESC';

$stmt = mysqli_prepare($koneksi, $sql);
bindParams($stmt, $types, $params);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

$printParams = ['jenis' => 'kunjungan'];
if ($tanggal_awal !== '') {
    $printParams['tanggal_awal'] = $tanggal_awal;
}
if ($tanggal_akhir !== '') {
    $printParams['tanggal_akhir'] = $tanggal_akhir;
}
$printUrl = 'print.php?' . http_build_query($printParams);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Laporan Kunjungan</h2>

    <a href="index.php" class="btn btn-secondary">
        Kembali
    </a>

    <form method="GET" class="row g-2 align-items-end mt-3 mb-3">
        <div class="col-md-3">
            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
            <input
                type="date"
                id="tanggal_awal"
                name="tanggal_awal"
                class="form-control"
                value="<?= htmlspecialchars($tanggal_awal, ENT_QUOTES, 'UTF-8'); ?>"
            >
        </div>

        <div class="col-md-3">
            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
            <input
                type="date"
                id="tanggal_akhir"
                name="tanggal_akhir"
                class="form-control"
                value="<?= htmlspecialchars($tanggal_akhir, ENT_QUOTES, 'UTF-8'); ?>"
            >
        </div>

        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            <a href="laporan_kunjungan.php" class="btn btn-outline-secondary">Reset</a>
            <a href="<?= htmlspecialchars($printUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-success">Print</a>
        </div>
    </form>

    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Tanggal</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Keluhan Utama</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['keluhan_utama'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['status_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

</body>
</html>