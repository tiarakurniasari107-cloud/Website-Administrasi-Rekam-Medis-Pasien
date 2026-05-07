<?php
require_once __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

function clinic_normalize_role($role)
{
    $role = strtolower(trim((string) $role));
    $allowed = ['admin', 'petugas', 'dokter'];

    if (!in_array($role, $allowed, true)) {
        return 'petugas';
    }

    return $role;
}

function clinic_role_label($role = null)
{
    $role = $role === null ? ($_SESSION['role'] ?? 'petugas') : $role;
    $role = clinic_normalize_role($role);

    $labels = [
        'admin' => 'Admin',
        'petugas' => 'Pendaftaran',
        'dokter' => 'Dokter',
    ];

    return $labels[$role] ?? 'Pendaftaran';
}

function clinic_current_module_and_file()
{
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? ''));
    $segments = array_values(array_filter(explode('/', trim($scriptPath, '/'))));

    $segmentCount = count($segments);
    $module = $segmentCount >= 2 ? $segments[$segmentCount - 2] : '';
    $file = $segmentCount >= 1 ? $segments[$segmentCount - 1] : '';

    return [$module, $file];
}

function clinic_detect_action($fileName, $requestMethod)
{
    $method = strtoupper((string) $requestMethod);
    if (!in_array($method, ['GET', 'HEAD'], true)) {
        return 'write';
    }

    $writeFiles = [
        'create.php',
        'edit.php',
        'delete.php',
        'hapus.php',
        'proses.php',
        'proses_edit.php',
    ];

    if (in_array((string) $fileName, $writeFiles, true)) {
        return 'write';
    }

    return 'read';
}

function clinic_can_access_module($module, $action = 'read')
{
    $module = trim((string) $module);
    $action = strtolower(trim((string) $action));
    $role = clinic_normalize_role($_SESSION['role'] ?? 'petugas');

    $disabledModules = ['obat', 'resep', 'tindakan'];
    if (in_array($module, $disabledModules, true)) {
        return false;
    }

    $permissions = [
        'admin' => [
            '*' => ['read', 'write'],
        ],
        'petugas' => [
            'dashboard' => ['read'],
            'pasien' => ['read', 'write'],
            'kunjungan' => ['read', 'write'],
            'registrasi' => ['read', 'write'],
            'pemeriksaan' => ['read'],
            'laporan' => ['read'],
        ],
        'dokter' => [
            'dashboard' => ['read'],
            'kunjungan' => ['read'],
            'registrasi' => ['read'],
            'pemeriksaan' => ['read'],
            'rekam_medis' => ['read', 'write'],
            'laporan' => ['read'],
        ],
    ];

    $rolePermission = $permissions[$role] ?? [];

    if (isset($rolePermission['*']) && in_array($action, $rolePermission['*'], true)) {
        return true;
    }

    if (!isset($rolePermission[$module])) {
        return false;
    }

    return in_array($action, $rolePermission[$module], true);
}

function clinic_deny_access($message = 'Anda tidak memiliki akses ke menu ini.')
{
    $_SESSION['flash_error'] = (string) $message;
    header('Location: ../dashboard/index.php');
    exit;
}

$_SESSION['role'] = clinic_normalize_role($_SESSION['role'] ?? 'petugas');
[$currentModule, $currentFile] = clinic_current_module_and_file();
$currentAction = clinic_detect_action($currentFile, $_SERVER['REQUEST_METHOD'] ?? 'GET');

if (!clinic_can_access_module($currentModule, $currentAction)) {
    clinic_deny_access();
}
