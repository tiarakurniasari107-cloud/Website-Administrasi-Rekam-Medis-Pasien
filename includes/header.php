<?php
if (!isset($pageTitle) || trim((string) $pageTitle) === '') {
    $pageTitle = 'Rekam Medis Klinik';
}

$cssPath = isset($cssPath) && trim((string) $cssPath) !== ''
    ? $cssPath
    : '../assets/css/bootstrap.min.css';

$bodyAttributes = isset($bodyAttributes) ? trim((string) $bodyAttributes) : '';
$extraHead = isset($extraHead) ? (string) $extraHead : '';
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
<body<?= $bodyAttributes !== '' ? ' ' . $bodyAttributes : ''; ?>>