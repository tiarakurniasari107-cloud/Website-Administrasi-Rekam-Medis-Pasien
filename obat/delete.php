<?php
require_once '../config/koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat='$id'");
header("Location: index.php");