<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];
        header("Location:../dashboard/index.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<?php
$pageTitle = 'Login';
require_once '../includes/header.php';
?>

<div class="login-shell">
    <div class="login-brand">
        <div class="clinic-logo" aria-hidden="true"></div>
        <h1 class="login-brand-title">KLINIK PRATAMA</h1>
        <p class="login-brand-subtitle">SISTEM REKAM MEDIS</p>
    </div>

    <div class="login-card">
        <h2 class="login-title">Login Klinik</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>

        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary">Masuk</button>
        </form>

        <p class="login-helper">Gunakan username &amp; password yang telah diberikan</p>
    </div>

    <p class="login-footer">&copy; <?= date('Y'); ?> Klinik Pratama -- Sistem Rekam Medis</p>
</div>

<?php require_once '../includes/footer.php'; ?>
