<?php
session_start();

// Hapus semua data session.
$_SESSION = [];

// Hapus cookie session agar browser tidak menyimpan sesi lama.
if (ini_get('session.use_cookies')) {
	$params = session_get_cookie_params();
	setcookie(
		session_name(),
		'',
		time() - 42000,
		$params['path'],
		$params['domain'],
		$params['secure'],
		$params['httponly']
	);
}

session_destroy();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
header("Location: login.php");
exit;
?>