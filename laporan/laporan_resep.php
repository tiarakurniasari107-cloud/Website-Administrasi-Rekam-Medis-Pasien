<?php
require_once '../config/auth.php';

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
        p.nama_pasien,
        d.nama_dokter,
        r.tanggal_resep,
        r.catatan,
        GROUP_CONCAT(CONCAT(o.nama_obat, ' (', rd.dosis, ', ', rd.jumlah, ')') SEPARATOR '; ') AS daftar_obat
    FROM resep r
    INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN resep_detail rd ON rd.resep_id = r.id
    LEFT JOIN obat o ON rd.obat_id = o.id";

$where = [];
$types = '';
$params = [];

if ($tanggal_awal !== '') {
    $where[] = 'DATE(r.tanggal_resep) >= ?';
    $types .= 's';
    $params[] = $tanggal_awal;
}

if ($tanggal_akhir !== '') {
    $where[] = 'DATE(r.tanggal_resep) <= ?';
    $types .= 's';
    $params[] = $tanggal_akhir;
}

if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' GROUP BY r.id, k.kode_kunjungan, p.nama_pasien, d.nama_dokter, r.tanggal_resep, r.catatan';
$sql .= ' ORDER BY r.id DESC';

$stmt = mysqli_prepare($koneksi, $sql);
bindParams($stmt, $types, $params);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

$printParams = ['jenis' => 'resep'];
if ($tanggal_awal !== '') {
    $printParams['tanggal_awal'] = $tanggal_awal;
}
if ($tanggal_akhir !== '') {
    $printParams['tanggal_akhir'] = $tanggal_akhir;
}
$printUrl = 'print.php?' . http_build_query($printParams);
?>

<?php
$pageTitle = 'Laporan Resep';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Laporan Resep</h2>

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
            <a href="laporan_resep.php" class="btn btn-outline-secondary">Reset</a>
            <a href="<?= htmlspecialchars($printUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-success">Print</a>
        </div>
    </form>

    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Resep</th>
                <th>Daftar Obat</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['tanggal_resep'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['daftar_obat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['catatan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

<?php require_once '../includes/footer.php'; ?>
