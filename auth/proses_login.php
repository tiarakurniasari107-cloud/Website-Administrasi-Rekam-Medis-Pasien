<?php
session_start();
require_once '../config/koneksi.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users 
        WHERE username='$username' 
        AND password='$password'");

    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);

        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];

        header("Location: ../dashboard/index.php");
        exit;
    } else {
        echo "<script>
            alert('Username / Password salah!');
            window.location='login.php';
        </script>";
    }
}
?>