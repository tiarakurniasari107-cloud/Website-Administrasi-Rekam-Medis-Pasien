<?php
require_once '../config/auth.php';

$today = date('Y-m-d');

$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$start = ($page - 1) * $limit;

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$validStatus = ['menunggu', 'diperiksa', 'selesai', 'batal'];
if (!in_array($status, $validStatus, true)) {
    $status = '';
}

$where = ['DATE(k.tanggal_kunjungan) = ?'];
$params = [$today];
$types = 's';

if ($keyword !== '') {
    $like = '%' . $keyword . '%';
    $where[] = '(p.nama_pasien LIKE ? OR k.kode_kunjungan LIKE ? OR p.no_rm LIKE ?)';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= 'sss';
}

if ($status !== '') {
    $where[] = 'k.status_kunjungan = ?';
    $params[] = $status;
    $types .= 's';
}

$whereClause = 'WHERE ' . implode(' AND ', $where);

$countSql = "SELECT COUNT(*) AS total FROM kunjungan k
             INNER JOIN pasien p ON k.pasien_id = p.id
             $whereClause";

$stmtCount = mysqli_prepare($koneksi, $countSql);
mysqli_stmt_bind_param($stmtCount, $types, ...$params);
mysqli_stmt_execute($stmtCount);
$total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
mysqli_stmt_close($stmtCount);

$sql = "SELECT
        k.id,
        k.pasien_id,
        k.kode_kunjungan,
        p.nama_pasien,
        p.no_rm,
        p.jenis_kelamin,
        p.no_telp,
        d.nama_dokter,
        pl.nama_poli,
        k.tanggal_kunjungan,
        k.jam_kunjungan,
        k.jenis_kunjungan,
        k.cara_bayar,
        k.status_kunjungan,
        k.keluhan_utama
        FROM kunjungan k
        INNER JOIN pasien p ON k.pasien_id = p.id
        INNER JOIN dokter d ON k.dokter_id = d.id
        LEFT JOIN poli pl ON k.poli_id = pl.id
        $whereClause
        ORDER BY k.jam_kunjungan ASC
        LIMIT ?, ?";

$paramsLimit = [...$params, $start, $limit];
$typesLimit = $types . 'ii';

$stmtData = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmtData, $typesLimit, ...$paramsLimit);
mysqli_stmt_execute($stmtData);
$data = mysqli_stmt_get_result($stmtData);
$canManageRegistrasi = clinic_can_access_module('kunjungan', 'write');

$total_page = (int) ceil($total_data / $limit);
if ($total_page < 1) {
    $total_page = 1;
}

$todayFormatted = date('d F Y', strtotime($today));
?>
<?php
$pageTitle = 'List Registrasi Hari Ini';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>List Registrasi Hari Ini</h2>
        <p>Daftar pasien yang terdaftar pada tanggal <strong><?= $todayFormatted; ?></strong></p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>

            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-info"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Semua Registrasi</a>
                <a href="list_hari_ini.php?print=1" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</a>
            </div>
        </div>

        <div class="filter-panel">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama / no RM / kode kunjungan" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu" <?= ($status === 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                            <option value="diperiksa" <?= ($status === 'diperiksa') ? 'selected' : ''; ?>>Diperiksa</option>
                            <option value="selesai" <?= ($status === 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="batal" <?= ($status === 'batal') ? 'selected' : ''; ?>>Batal</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                    <div class="col-md-2">
                        <a href="list_hari_ini.php" class="btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Reg</th>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>JK</th>
                        <th>No Telp</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Keluhan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = $start + 1;
                    while ($row = mysqli_fetch_assoc($data)) {
                        $statusClass = '';
                        switch ($row['status_kunjungan']) {
                            case 'menunggu':
                                $statusClass = 'status-waiting';
                                break;
                            case 'diperiksa':
                                $statusClass = 'status-examining';
                                break;
                            case 'selesai':
                                $statusClass = 'status-completed';
                                break;
                            case 'batal':
                                $statusClass = 'status-cancelled';
                                break;
                        }
                        $isLakiLaki = ($row['jenis_kelamin'] === 'L');
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><span class="table-key"><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><?= htmlspecialchars($row['no_rm'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="gender-badge <?= $isLakiLaki ? 'gender-badge-male' : 'gender-badge-female'; ?>">
                                    <?= $isLakiLaki ? 'L' : 'P'; ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><span class="status-badge <?= $statusClass; ?>"><?= htmlspecialchars($row['status_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><?= htmlspecialchars(substr($row['keluhan_utama'] ?? '-', 0, 30), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="toolbar-actions">
                                    <?php if ($canManageRegistrasi) { ?>
                                        <a href="../kunjungan/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm btn-table">Edit</a>
                                    <?php } ?>
                                    <a href="history.php?pasien_id=<?= $row['pasien_id']; ?>" class="btn btn-info btn-sm btn-table">History</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="page-item <?= ($page === $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&status=<?= urlencode($status); ?>"><?= $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </section>
</div>

<?php mysqli_stmt_close($stmtData); ?>
<?php require_once '../includes/footer.php'; ?>
