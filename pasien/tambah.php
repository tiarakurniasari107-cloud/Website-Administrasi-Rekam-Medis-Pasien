<?php
include "../config/auth.php";
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $no_rm = $_POST['no_rm'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama_pasien'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['no_telp'];

    mysqli_query($koneksi, "INSERT INTO pasien (no_rm, nik, nama_pasien, jenis_kelamin, alamat, no_telp) VALUES ('$no_rm','$nik','$nama','$jk','$alamat','$telp')");
    header("Location: index.php");
    exit;
}
?>
<?php include "../includes/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"><?php include "../includes/sidebar.php"; ?></div>
        <div class="col-md-10 p-4">
            <h3>Tambah Pasien</h3>
            <form method="post">
                <input type="text" name="no_rm" class="form-control mb-2" placeholder="No RM" required>
                <input type="text" name="nik" class="form-control mb-2" placeholder="NIK">
                <input type="text" name="nama_pasien" class="form-control mb-2" placeholder="Nama Pasien" required>
                <select name="jenis_kelamin" class="form-control mb-2" required>
                    <option value="">Pilih JK</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <textarea name="alamat" class="form-control mb-2" placeholder="Alamat"></textarea>
                <input type="text" name="no_telp" class="form-control mb-2" placeholder="No Telp">
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?php include "../includes/footer.php"; ?>