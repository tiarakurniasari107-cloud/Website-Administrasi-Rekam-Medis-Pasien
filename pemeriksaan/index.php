<?php
require_once '../config/auth.php';

$polis = [];
$stmtPoli = mysqli_prepare($koneksi, 'SELECT id, nama_poli FROM poli ORDER BY nama_poli ASC');
mysqli_stmt_execute($stmtPoli);
$resultPoli = mysqli_stmt_get_result($stmtPoli);
while ($row = mysqli_fetch_assoc($resultPoli)) {
    $polis[] = $row;
}
mysqli_stmt_close($stmtPoli);
?>
<?php
$pageTitle = 'Pemeriksaan';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Pemeriksaan Pasien</h2>
        <p>Pilih poliklinik untuk melihat daftar pasien yang akan diperiksa</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>
        </div>

        <div class="poli-selection">
            <h4>Pilih Poliklinik</h4>
            <div class="poli-grid">
                <?php foreach ($polis as $poli): ?>
                    <?php
                    $stmtCount = mysqli_prepare($koneksi, 'SELECT COUNT(*) AS total FROM kunjungan WHERE poli_id = ? AND DATE(tanggal_kunjungan) = CURDATE() AND status_kunjungan != "batal"');
                    mysqli_stmt_bind_param($stmtCount, 'i', $poli['id']);
                    mysqli_stmt_execute($stmtCount);
                    $count = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
                    mysqli_stmt_close($stmtCount);
                    ?>
                    <a href="poli.php?id=<?= $poli['id']; ?>" class="poli-card">
                        <div class="poli-icon">
                            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                        </div>
                        <h5><?= htmlspecialchars($poli['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="poli-count"><?= $count; ?> pasien hari ini</p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
