<?php
require_once '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "
    DELETE FROM tindakan
    WHERE id = '$id'
");

header("Location: index.php");
exit;
?>