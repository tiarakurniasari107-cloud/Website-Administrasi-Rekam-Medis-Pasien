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


<div class="container mt-4">

    <h2>Data Poli</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Poli
    </a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>

        <tbody>

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_poli'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['keterangan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td>

                    <a href="edit.php?id=<?= $row['id']; ?>"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="delete.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin hapus data?')"
                       class="btn btn-danger btn-sm">
                        Hapus
                    </a>

                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>

</div>

<?php require_once '../includes/footer.php'; ?>
