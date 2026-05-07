<?php
require_once '../config/auth.php';

$pasien_id = isset($_GET['pasien_id']) ? (int) $_GET['pasien_id'] : 0;

if ($pasien_id < 1) {
    header('Location: index.php');
    exit;
}

$stmtPasien = mysqli_prepare($koneksi, 'SELECT * FROM pasien WHERE id = ?');
mysqli_stmt_bind_param($stmtPasien, 'i', $pasien_id);
mysqli_stmt_execute($stmtPasien);
$pasien = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtPasien));
mysqli_stmt_close($stmtPasien);

if (!$pasien) {
    header('Location: index.php');
    exit;
}

$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$start = ($page - 1) * $limit;

$countSql = 'SELECT COUNT(*) AS total FROM kunjungan WHERE pasien_id = ?';
$stmtCount = mysqli_prepare($koneksi, $countSql);
mysqli_stmt_bind_param($stmtCount, 'i', $pasien_id);
mysqli_stmt_execute($stmtCount);
$total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
mysqli_stmt_close($stmtCount);

$sql = "SELECT
        k.id,
        k.kode_kunjungan,
        d.nama_dokter,
        pl.nama_poli,
        k.tanggal_kunjungan,
        k.jam_kunjungan,
        k.jenis_kunjungan,
        k.cara_bayar,
        k.status_kunjungan,
        k.keluhan_utama,
        rm.diagnosa_kerja,
        rm.terapi
        FROM kunjungan k
        INNER JOIN dokter d ON k.dokter_id = d.id
        LEFT JOIN poli pl ON k.poli_id = pl.id
        LEFT JOIN rekam_medis rm ON k.id = rm.kunjungan_id
        WHERE k.pasien_id = ?
        ORDER BY k.tanggal_kunjungan DESC, k.jam_kunjungan DESC
        LIMIT ?, ?";

$stmtData = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmtData, 'iii', $pasien_id, $start, $limit);
mysqli_stmt_execute($stmtData);
$data = mysqli_stmt_get_result($stmtData);

$total_page = (int) ceil($total_data / $limit);
if ($total_page < 1) {
    $total_page = 1;
}

$umur = '';
if ($pasien['tanggal_lahir']) {
    $birthDate = new DateTime($pasien['tanggal_lahir']);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    $umur = $age->y . ' thn ' . $age->m . ' bln';
}
$canReadPasien = clinic_can_access_module('pasien', 'read');
$canReadRekamMedis = clinic_can_access_module('rekam_medis', 'read');
?>
<?php
$pageTitle = 'History Kunjungan Pasien';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>History Kunjungan Pasien</h2>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>

            <div class="toolbar-actions">
                <?php if ($canReadPasien) { ?>
                    <a href="../pasien/index.php" class="btn btn-info"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Data Pasien</a>
                <?php } ?>
                <a href="history.php?pasien_id=<?= $pasien_id; ?>&print=1" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</a>
            </div>
        </div>

        <div class="patient-info-card">
            <h4>Informasi Pasien</h4>
            <div class="row">
                <div class="col-md-3">
                    <strong>No RM:</strong><br>
                    <span class="table-key"><?= htmlspecialchars($pasien['no_rm'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Nama Pasien:</strong><br>
                    <?= htmlspecialchars($pasien['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="col-md-2">
                    <strong>JK:</strong><br>
                    <?= ($pasien['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan'; ?>
                </div>
                <div class="col-md-2">
                    <strong>Umur:</strong><br>
                    <?= $umur ?: '-'; ?>
                </div>
                <div class="col-md-2">
                    <strong>No Telp:</strong><br>
                    <?= htmlspecialchars($pasien['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                    <strong>Alamat:</strong><br>
                    <?= htmlspecialchars($pasien['alamat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="col-md-3">
                    <strong>Golongan Darah:</strong><br>
                    <?= htmlspecialchars($pasien['golongan_darah'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="col-md-3">
                    <strong>Alergi:</strong><br>
                    <?= htmlspecialchars($pasien['alergi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
        </div>

        <h4 style="margin-top: 20px;">Riwayat Kunjungan (<?= $total_data; ?> kali)</h4>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Jenis</th>
                        <th>Cara Bayar</th>
                        <th>Status</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Terapi</th>
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
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><span class="table-key"><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><?= htmlspecialchars($row['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['jenis_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($row['cara_bayar'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><span class="status-badge <?= $statusClass; ?>"><?= htmlspecialchars($row['status_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><?= htmlspecialchars(substr($row['keluhan_utama'] ?? '-', 0, 30), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars(substr($row['diagnosa_kerja'] ?? '-', 0, 30), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars(substr($row['terapi'] ?? '-', 0, 30), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($canReadRekamMedis) { ?>
                                    <div class="toolbar-actions">
                                        <a href="../rekam_medis/index.php?kunjungan_id=<?= $row['id']; ?>" class="btn btn-info btn-sm btn-table">Detail</a>
                                    </div>
                                <?php } else { ?>
                                    <span>-</span>
                                <?php } ?>
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
                        <a class="page-link" href="?pasien_id=<?= $pasien_id; ?>&page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </section>
</div>

<?php mysqli_stmt_close($stmtData); ?>
<?php require_once '../includes/footer.php'; ?>
