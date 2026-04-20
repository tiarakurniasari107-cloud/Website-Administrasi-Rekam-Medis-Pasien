<?php
include "../config/auth.php";
include "../config/koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM pasien WHERE id='$id'");
header("Location: index.php");
exit;
?>