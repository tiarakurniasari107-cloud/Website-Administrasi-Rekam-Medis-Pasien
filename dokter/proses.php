<?php
require_once '../config/koneksi.php';

if (isset($_POST['simpan'])) {

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
        INSERT INTO dokter (
            kode_dokter,
            nama_dokter,
            jenis_kelamin,
            spesialisasi,
            no_sip,
            no_telp,
            alamat,
            poli_id,
            status
        ) VALUES (
            '$kode_dokter',
            '$nama_dokter',
            '$jenis_kelamin',
            '$spesialisasi',
            '$no_sip',
            '$no_telp',
            '$alamat',
            '$poli_id',
            '$status'
        )
    ");

    header("Location: index.php");
    exit;
}
?>