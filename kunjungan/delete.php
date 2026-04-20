<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM kunjungan WHERE id_kunjungan='$id'");
header("Location: index.php");