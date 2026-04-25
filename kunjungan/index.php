<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT 
        k.id,
        k.kode_kunjungan,
        p.nama_pasien,
        d.nama_dokter,
        pl.nama_poli,
        k.tanggal_kunjungan,
        k.jam_kunjungan,
        k.jenis_kunjungan,
        k.cara_bayar,
        k.status_kunjungan
    FROM kunjungan k
    INNER JOIN pasien p ON k.pasien_id = p.id
    INNER JOIN dokter d ON k.dokter_id = d.id
    LEFT JOIN poli pl ON k.poli_id = pl.id
    ORDER BY k.id DESC"
);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>
<?php
$pageTitle = 'Data Kunjungan';
require_once '../includes/header.php';
?>


<div class="container mt-4">

    <h2>Data Kunjungan</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
    <a href="create.php" class="btn btn-primary">+ Tambah Kunjungan</a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jenis</th>
                <th>Cara Bayar</th>
                <th>Status</th>
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
                <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['jenis_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['cara_bayar'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['status_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
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
