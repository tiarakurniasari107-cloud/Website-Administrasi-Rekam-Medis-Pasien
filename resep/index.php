<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT 
        r.id,
        r.tanggal_resep,
        r.catatan,
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter,
        GROUP_CONCAT(CONCAT(o.nama_obat, ' (', rd.dosis, ', ', rd.jumlah, ')') SEPARATOR '; ') AS daftar_obat
    FROM resep r
    INNER JOIN rekam_medis rm ON r.rekam_medis_id = rm.id
    INNER JOIN kunjungan k ON rm.kunjungan_id = k.id
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN resep_detail rd ON rd.resep_id = r.id
    LEFT JOIN obat o ON rd.obat_id = o.id
    GROUP BY r.id, r.tanggal_resep, r.catatan, k.kode_kunjungan, p.nama_pasien, d.nama_dokter
    ORDER BY r.id DESC"
);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>
<?php
$pageTitle = 'Data Resep';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Data Resep</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
    <a href="create.php" class="btn btn-primary">+ Tambah Resep</a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Resep</th>
                <th>Daftar Obat</th>
                <th>Catatan</th>
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
                <td><?= htmlspecialchars($row['tanggal_resep'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['daftar_obat'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['catatan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
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
