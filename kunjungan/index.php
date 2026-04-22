<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kunjungan</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2>Data Kunjungan</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary">
        Kembali
    </a>

    <a href="create.php" class="btn btn-primary">
        + Tambah Kunjungan
    </a>

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

        <?php $no = 1; while($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode_kunjungan']; ?></td>
                <td><?= $row['nama_pasien']; ?></td>
                <td><?= $row['nama_dokter']; ?></td>
                <td><?= $row['nama_poli']; ?></td>
                <td><?= $row['tanggal_kunjungan']; ?></td>
                <td><?= $row['jam_kunjungan']; ?></td>
                <td><?= $row['jenis_kunjungan']; ?></td>
                <td><?= $row['cara_bayar']; ?></td>
                <td><?= $row['status_kunjungan']; ?></td>
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

</div>

</body>
</html>