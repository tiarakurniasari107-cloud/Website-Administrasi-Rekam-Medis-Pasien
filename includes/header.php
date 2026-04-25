<?php
if (!isset($pageTitle) || trim((string) $pageTitle) === '') {
    $pageTitle = 'Rekam Medis Klinik';
}

$cssPath = isset($cssPath) && trim((string) $cssPath) !== ''
    ? $cssPath
    : '../assets/css/bootstrap.min.css';

$bodyAttributes = isset($bodyAttributes) ? trim((string) $bodyAttributes) : '';
$extraHead = isset($extraHead) ? (string) $extraHead : '';

$currentScript = str_replace('\\', '/', $_SERVER['PHP_SELF'] ?? '');
$isLoginPage = (substr($currentScript, -15) === '/auth/login.php');

$bodyClass = $isLoginPage ? 'login-page' : 'app-layout';
$customClass = '';

if (preg_match('/\bclass\s*=\s*(["\'])(.*?)\1/i', $bodyAttributes, $classMatch)) {
    $customClass = trim((string) ($classMatch[2] ?? ''));
    $bodyAttributes = preg_replace('/\s*\bclass\s*=\s*(["\']).*?\1/i', '', $bodyAttributes, 1);
}

if ($customClass !== '') {
    $bodyClass .= ' ' . $customClass;
}

$bodyAttributes = trim((string) $bodyAttributes);
$GLOBALS['isLoginPageLayout'] = $isLoginPage;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPath, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="../assets/css/style.css">
    <?= $extraHead; ?>
</head>
<body class="<?= htmlspecialchars(trim($bodyClass), ENT_QUOTES, 'UTF-8'); ?>"<?= $bodyAttributes !== '' ? ' ' . $bodyAttributes : ''; ?>>
<?php if (!$isLoginPage) { ?>
    <header class="clinic-topbar">
        <div class="clinic-brand">
            <div class="clinic-logo" aria-hidden="true"></div>
            <div class="clinic-brand-text">
                <strong>KLINIK PRATAMA</strong>
                <span>PELAYANAN KESEHATAN PRIMA</span>
            </div>
        </div>
    </header>
    <main class="clinic-main">
<?php } ?>