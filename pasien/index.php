<?php
require_once '../config/auth.php';

$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$start = ($page - 1) * $limit;

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$jk = isset($_GET['jk']) ? $_GET['jk'] : '';
if (!in_array($jk, ['L', 'P'], true)) {
    $jk = '';
}

if ($keyword !== '' && $jk !== '') {
    $like = '%' . $keyword . '%';

    $stmtCount = mysqli_prepare(
        $koneksi,
        'SELECT COUNT(*) AS total FROM pasien WHERE (nama_pasien LIKE ? OR no_rm LIKE ? OR nik LIKE ?) AND jenis_kelamin = ?'
    );
    mysqli_stmt_bind_param($stmtCount, 'ssss', $like, $like, $like, $jk);
    mysqli_stmt_execute($stmtCount);
    $total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
    mysqli_stmt_close($stmtCount);

    $stmtData = mysqli_prepare(
        $koneksi,
        'SELECT * FROM pasien WHERE (nama_pasien LIKE ? OR no_rm LIKE ? OR nik LIKE ?) AND jenis_kelamin = ? ORDER BY id DESC LIMIT ?, ?'
    );
    mysqli_stmt_bind_param($stmtData, 'ssssii', $like, $like, $like, $jk, $start, $limit);
} elseif ($keyword !== '') {
    $like = '%' . $keyword . '%';

    $stmtCount = mysqli_prepare(
        $koneksi,
        'SELECT COUNT(*) AS total FROM pasien WHERE (nama_pasien LIKE ? OR no_rm LIKE ? OR nik LIKE ?)'
    );
    mysqli_stmt_bind_param($stmtCount, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmtCount);
    $total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
    mysqli_stmt_close($stmtCount);

    $stmtData = mysqli_prepare(
        $koneksi,
        'SELECT * FROM pasien WHERE (nama_pasien LIKE ? OR no_rm LIKE ? OR nik LIKE ?) ORDER BY id DESC LIMIT ?, ?'
    );
    mysqli_stmt_bind_param($stmtData, 'sssii', $like, $like, $like, $start, $limit);
} elseif ($jk !== '') {
    $stmtCount = mysqli_prepare(
        $koneksi,
        'SELECT COUNT(*) AS total FROM pasien WHERE jenis_kelamin = ?'
    );
    mysqli_stmt_bind_param($stmtCount, 's', $jk);
    mysqli_stmt_execute($stmtCount);
    $total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
    mysqli_stmt_close($stmtCount);

    $stmtData = mysqli_prepare(
        $koneksi,
        'SELECT * FROM pasien WHERE jenis_kelamin = ? ORDER BY id DESC LIMIT ?, ?'
    );
    mysqli_stmt_bind_param($stmtData, 'sii', $jk, $start, $limit);
} else {
    $stmtCount = mysqli_prepare($koneksi, 'SELECT COUNT(*) AS total FROM pasien');
    mysqli_stmt_execute($stmtCount);
    $total_data = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
    mysqli_stmt_close($stmtCount);

    $stmtData = mysqli_prepare($koneksi, 'SELECT * FROM pasien ORDER BY id DESC LIMIT ?, ?');
    mysqli_stmt_bind_param($stmtData, 'ii', $start, $limit);
}

mysqli_stmt_execute($stmtData);
$data = mysqli_stmt_get_result($stmtData);

$total_page = (int) ceil($total_data / $limit);
if ($total_page < 1) {
    $total_page = 1;
}
?>
<?php
$pageTitle = 'Data Pasien';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Data Pasien</h2>
        <p>Kelola data rekam medis pasien</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>

            <div class="toolbar-actions">
                <a href="create.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Tambah Pasien</a>
            </div>
        </div>

        <div class="filter-panel">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama / no RM / NIK" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="col-md-2">
                        <select name="jk" class="form-control">
                            <option value="">Semua Gender</option>
                            <option value="L" <?= ($jk === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= ($jk === 'P') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                    <div class="col-md-2">
                        <a href="index.php" class="btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No RM</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = $start + 1;
                    while ($row = mysqli_fetch_assoc($data)) {
                        $isLakiLaki = ($row['jenis_kelamin'] === 'L');
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><span class="table-key"><?= htmlspecialchars($row['no_rm'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="gender-badge <?= $isLakiLaki ? 'gender-badge-male' : 'gender-badge-female'; ?>">
                                    <?= $isLakiLaki ? 'Laki-laki' : 'Perempuan'; ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['no_telp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="toolbar-actions">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm btn-table">Edit</a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm btn-table">Hapus</a>
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
                        <a class="page-link" href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&jk=<?= urlencode($jk); ?>"><?= $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </section>
</div>

    <?php mysqli_stmt_close($stmtData); ?>
<?php require_once '../includes/footer.php'; ?>
