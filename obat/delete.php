<?php
require_once '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "
    DELETE FROM obat
    WHERE id = '$id'
");

header("Location: index.php");
exit;
?>