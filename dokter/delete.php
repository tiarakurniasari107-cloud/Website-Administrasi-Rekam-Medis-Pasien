<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM dokter WHERE id_dokter='$id'");
header("Location: index.php");