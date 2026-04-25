<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare($koneksi, "
    SELECT d.id, d.kode_dokter, d.nama_dokter, d.jenis_kelamin, d.spesialisasi, d.status, p.nama_poli
    FROM dokter d
    LEFT JOIN poli p ON d.poli_id = p.id
    ORDER BY d.id DESC
");
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<?php
$pageTitle = 'Data Dokter';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Data Dokter</h2>
        <p>Kelola data dokter klinik</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>

            <div class="toolbar-actions">
                <a href="create.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Tambah Dokter</a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Dokter</th>
                        <th>JK</th>
                        <th>Spesialisasi</th>
                        <th>Poli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($data)) {
                    $isLakiLaki = ($row['jenis_kelamin'] === 'L');
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="table-key"><?= htmlspecialchars($row['kode_dokter'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <span class="gender-badge <?= $isLakiLaki ? 'gender-badge-male' : 'gender-badge-female'; ?>">
                                <?= $isLakiLaki ? 'Laki-laki' : 'Perempuan'; ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['spesialisasi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
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

        <?php mysqli_stmt_close($stmt); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
