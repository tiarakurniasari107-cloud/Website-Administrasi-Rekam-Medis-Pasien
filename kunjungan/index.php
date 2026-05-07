<?php
require_once '../config/auth.php';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT 
        k.id,
        k.pasien_id,
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
$canManageRegistrasi = clinic_can_access_module('kunjungan', 'write');
?>
<?php
$pageTitle = 'Data Registrasi';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Data Registrasi</h2>
        <p>Kelola data pendaftaran kunjungan pasien</p>
    </section>

    <section class="content-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="../dashboard/index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
                <a href="../registrasi/list_hari_ini.php" class="btn btn-info"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>List Hari Ini</a>
            </div>

            <?php if ($canManageRegistrasi) { ?>
                <div class="toolbar-actions">
                    <a href="create.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Tambah Registrasi</a>
                </div>
            <?php } ?>
        </div>

        <div class="table-wrapper">
            <table class="table table-bordered">
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
                        <th>History</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="table-key"><?= htmlspecialchars($row['kode_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['nama_dokter'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['nama_poli'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['jam_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['jenis_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['cara_bayar'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($row['status_kunjungan'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="../registrasi/history.php?pasien_id=<?= (int) $row['pasien_id']; ?>" class="btn btn-info btn-sm btn-table">History</a>
                        </td>
                        <td>
                            <?php if ($canManageRegistrasi) { ?>
                                <div class="toolbar-actions">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm btn-table">Edit</a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-table" onclick="return confirm('Yakin hapus data?')">Hapus</a>
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

        <?php mysqli_stmt_close($stmt); ?>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
