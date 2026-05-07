<?php
require_once '../config/bootstrap.php';

if (!isset($_POST['login'])) {
    header('Location: login.php');
    exit;
}

if (!($koneksi instanceof mysqli)) {
    header('Location: login.php?error=1');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = (string) ($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header('Location: login.php?error=1');
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    'SELECT id, nama_lengkap, username, password, role FROM users WHERE username = ? LIMIT 1'
);

if (!$stmt) {
    header('Location: login.php?error=1');
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$isValid = false;
$needsUpgrade = false;

if ($data) {
    $storedPassword = (string) ($data['password'] ?? '');
    $passwordInfo = password_get_info($storedPassword);
    $hasHash = (int) ($passwordInfo['algo'] ?? 0) !== 0;

    if ($hasHash) {
        $isValid = password_verify($password, $storedPassword);
        if ($isValid && password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
            $needsUpgrade = true;
        }
    } else {
        $isValid = hash_equals($storedPassword, $password);
        $needsUpgrade = $isValid;
    }
}

if (!$isValid) {
    header('Location: login.php?error=1');
    exit;
}

if ($needsUpgrade) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $stmtUpdate = mysqli_prepare($koneksi, 'UPDATE users SET password = ? WHERE id = ?');

    if ($stmtUpdate) {
        mysqli_stmt_bind_param($stmtUpdate, 'si', $newHash, $data['id']);
        mysqli_stmt_execute($stmtUpdate);
        mysqli_stmt_close($stmtUpdate);
    }
}

session_regenerate_id(true);
$_SESSION['login'] = true;
$_SESSION['id'] = $data['id'];
$_SESSION['nama'] = $data['nama_lengkap'];
$_SESSION['user_id'] = $data['id'];
$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
$_SESSION['role'] = $data['role'];

header('Location: ../dashboard/index.php');
exit;
?>
