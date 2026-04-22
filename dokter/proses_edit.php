<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $kode_dokter = $_POST['kode_dokter'];
    $nama_dokter = $_POST['nama_dokter'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_sip = $_POST['no_sip'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $poli_id = $_POST['poli_id'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "
        UPDATE dokter SET
            kode_dokter = '$kode_dokter',
            nama_dokter = '$nama_dokter',
            jenis_kelamin = '$jenis_kelamin',
            spesialisasi = '$spesialisasi',
            no_sip = '$no_sip',
            no_telp = '$no_telp',
            alamat = '$alamat',
            poli_id = '$poli_id',
            status = '$status'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>