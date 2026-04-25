<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT 
        rm.id,
        rm.keluhan,
        rm.diagnosa_kerja,
        rm.terapi,
        rm.tanggal_pemeriksaan,
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter
    FROM rekam_medis rm
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    ORDER BY rm.id DESC"
);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>
<?php
$pageTitle = 'Rekam Medis';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Data Rekam Medis</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
    <a href="create.php" class="btn btn-primary">+ Tambah Rekam Medis</a>

    <br><br>

    <table class="table table-bordered table-striped">
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
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['keluhan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['diagnosa_kerja'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['terapi'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['tanggal_pemeriksaan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php mysqli_stmt_close($stmt); ?>
</div>

<?php require_once '../includes/footer.php'; ?>
