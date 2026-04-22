<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$jk = isset($_GET['jk']) ? $_GET['jk'] : '';

$where = " WHERE 1=1 ";

if ($keyword != '') {
    $where .= " AND (
        nama_pasien LIKE '%$keyword%'
        OR no_rm LIKE '%$keyword%'
        OR nik LIKE '%$keyword%'
    )";
}

if ($jk != '') {
    $where .= " AND jenis_kelamin = '$jk'";
}

$total_query = mysqli_query($koneksi, "
    SELECT COUNT(*) as total
    FROM pasien
    $where
");

$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_page = ceil($total_data / $limit);

$data = mysqli_query($koneksi, "
    SELECT *
    FROM pasien
    $where
    ORDER BY id DESC
    LIMIT $start, $limit
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">

        <h2>Data Pasien</h2>

        <a href="../dashboard/index.php" class="btn btn-secondary">
            Kembali
        </a>

        <a href="create.php" class="btn btn-primary">
            + Tambah Pasien
        </a>

        <br><br>

        <form method="GET">

            <div class="row">

                <div class="col-md-4">
                    <input type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari nama / no RM / NIK"
                        value="<?= $keyword ?>">
                </div>

                <div class="col-md-3">
                    <select name="jk" class="form-control">
                        <option value="">Semua Gender</option>

                        <option value="Laki-laki"
                            <?= ($jk == 'Laki-laki') ? 'selected' : '' ?>>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            <?= ($jk == 'Perempuan') ? 'selected' : '' ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success">
                        Search
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="index.php" class="btn btn-danger">
                        Reset
                    </a>
                </div>

            </div>

        </form>

        <br>
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $no = $start + 1;
                while ($row = mysqli_fetch_assoc($data)) {
                ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['no_rm']; ?></td>
                        <td><?= $row['nama_pasien']; ?></td>
                        <td><?= $row['jenis_kelamin']; ?></td>
                        <td><?= $row['no_hp']; ?></td>
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
        <nav>
            <ul class="pagination">

                <?php for ($i = 1; $i <= $total_page; $i++) { ?>

                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">

                        <a class="page-link"
                            href="?page=<?= $i ?>&keyword=<?= $keyword ?>&jk=<?= $jk ?>">
                            <?= $i ?>
                        </a>

                    </li>

                <?php } ?>

            </ul>
        </nav>

    </div>

</body>

</html>