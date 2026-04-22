<?php
require_once '../config/koneksi.php';

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $no_rm = $_POST['no_rm'];
    $nik = $_POST['nik'];
    $nama_pasien = $_POST['nama_pasien'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $golongan_darah = $_POST['golongan_darah'];
    $alergi = $_POST['alergi'];
    $status_kawin = $_POST['status_kawin'];
    $pekerjaan = $_POST['pekerjaan'];

    mysqli_query($koneksi, "UPDATE pasien SET
        no_rm='$no_rm',
        nik='$nik',
        nama_pasien='$nama_pasien',
        jenis_kelamin='$jenis_kelamin',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir='$tanggal_lahir',
        umur='$umur',
        alamat='$alamat',
        no_telp='$no_telp',
        golongan_darah='$golongan_darah',
        alergi='$alergi',
        status_kawin='$status_kawin',
        pekerjaan='$pekerjaan'
        WHERE id='$id'
    ");

    header("Location: index.php");
    exit;
}
?>