<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM poli WHERE id_poli='$id'");
header("Location: index.php");