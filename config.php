<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "db_rekamedis";

    $connect = new mysqli( $hostname,$username,$password,$database);
    if ($connect->connect_error) {
        die("Koneksi gagal: ". $connect->connect_error);
    }

$main_url = "http://localhost/5865_rekamedis_app/";

?>