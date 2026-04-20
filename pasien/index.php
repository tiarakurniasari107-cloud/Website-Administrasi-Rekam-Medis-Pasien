<?php
include "../config/auth.php";
include "../config/koneksi.php";
?>
<?php include "../includes/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"><?php include "../includes/sidebar.php"; ?></div>
        <div class="col-md-10 p-4">
            <h3>Data Pasien</h3>
            <a href="tambah.php" class="btn btn-primary mb-3">Tambah Pasien</a>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?= $row['no_rm'] ?></td>
                        <td><?= $row['nama_pasien'] ?></td>
                        <td><?= $row['jenis_kelamin'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['no_telp'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../includes/footer.php"; ?>