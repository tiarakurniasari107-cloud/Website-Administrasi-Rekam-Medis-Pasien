<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

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

    mysqli_query($koneksi, "INSERT INTO pasien (
        no_rm, nik, nama_pasien, jenis_kelamin,
        tempat_lahir, tanggal_lahir, umur,
        alamat, no_telp, golongan_darah,
        alergi, status_kawin, pekerjaan
    ) VALUES (
        '$no_rm', '$nik', '$nama_pasien', '$jenis_kelamin',
        '$tempat_lahir', '$tanggal_lahir', '$umur',
        '$alamat', '$no_telp', '$golongan_darah',
        '$alergi', '$status_kawin', '$pekerjaan'
    )");

    header("Location: index.php");
}
?>