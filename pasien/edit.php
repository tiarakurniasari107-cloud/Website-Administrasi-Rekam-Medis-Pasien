<?php
include "../config/auth.php";
include "../config/koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pasien WHERE id='$id'"));

if (isset($_POST['update'])) {
    $no_rm = $_POST['no_rm'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama_pasien'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['no_telp'];

    mysqli_query($koneksi, "UPDATE pasien SET no_rm='$no_rm', nik='$nik', nama_pasien='$nama', jenis_kelamin='$jk', alamat='$alamat', no_telp='$telp' WHERE id='$id'");
    header("Location: index.php");
    exit;
}
?>
<?php include "../includes/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"><?php include "../includes/sidebar.php"; ?></div>
        <div class="col-md-10 p-4">
            <h3>Edit Pasien</h3>
            <form method="post">
                <input type="text" name="no_rm" value="<?= $data['no_rm'] ?>" class="form-control mb-2">
                <input type="text" name="nik" value="<?= $data['nik'] ?>" class="form-control mb-2">
                <input type="text" name="nama_pasien" value="<?= $data['nama_pasien'] ?>" class="form-control mb-2">
                <select name="jenis_kelamin" class="form-control mb-2">
                    <option value="L" <?= $data['jenis_kelamin']=='L'?'selected':'' ?>>Laki-laki</option>
                    <option value="P" <?= $data['jenis_kelamin']=='P'?'selected':'' ?>>Perempuan</option>
                </select>
                <textarea name="alamat" class="form-control mb-2"><?= $data['alamat'] ?></textarea>
                <input type="text" name="no_telp" value="<?= $data['no_telp'] ?>" class="form-control mb-2">
                <button type="submit" name="update" class="btn btn-warning">Update</button>
            </form>
        </div>
    </div>
</div>
<?php include "../includes/footer.php"; ?>