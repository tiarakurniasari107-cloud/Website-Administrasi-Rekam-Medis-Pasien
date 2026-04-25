<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare($koneksi, "SELECT id, nama_poli, keterangan FROM poli ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<?php
$pageTitle = 'Data Poli';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Data Poli</h2>
        <p>Kelola data poliklinik</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>

            <div class="toolbar-actions">
                <a href="create.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Tambah Poli</a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Poli</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="table-key"><?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><?= htmlspecialchars($row['keterangan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
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
