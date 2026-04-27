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
        rm.keluhan,
        rm.diagnosa_kerja,
        rm.terapi,
        rm.tanggal_pemeriksaan
    FROM rekam_medis rm
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id";

$where = [];
$types = '';
$params = [];

if ($tanggal_awal !== '') {
    $where[] = 'DATE(rm.tanggal_pemeriksaan) >= ?';
    $types .= 's';
    $params[] = $tanggal_awal;
}

if ($tanggal_akhir !== '') {
    $where[] = 'DATE(rm.tanggal_pemeriksaan) <= ?';
    $types .= 's';
    $params[] = $tanggal_akhir;
}

if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY rm.id DESC';

$stmt = mysqli_prepare($koneksi, $sql);
bindParams($stmt, $types, $params);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
$totalRows = (int) mysqli_num_rows($data);

$printParams = ['jenis' => 'rekam_medis'];
if ($tanggal_awal !== '') {
    $printParams['tanggal_awal'] = $tanggal_awal;
}
if ($tanggal_akhir !== '') {
    $printParams['tanggal_akhir'] = $tanggal_akhir;
}
$printUrl = 'print.php?' . http_build_query($printParams);
?>

<?php
$pageTitle = 'Laporan Rekam Medis';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Laporan Rekam Medis</h2>
        <p>Daftar data rekam medis pasien</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
                <a href="<?= htmlspecialchars($printUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print</a>
            </div>
        </div>

        <div class="filter-panel">
            <form method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="<?= htmlspecialchars($tanggal_awal, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="<?= htmlspecialchars($tanggal_akhir, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" style="opacity:0;">Filter</label>
                        <div class="toolbar-actions">
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                            <a href="laporan_rekam_medis.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="report-summary">
            Total: <strong><?= $totalRows; ?></strong> Data
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kunjungan</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Keluhan</th>
                        <th>Diagnosa Kerja</th>
                        <th>Terapi</th>
                        <th>Tanggal Pemeriksaan</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="table-key"><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['keluhan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['diagnosa_kerja'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['terapi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pemeriksaan'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <?php mysqli_stmt_close($stmt); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
