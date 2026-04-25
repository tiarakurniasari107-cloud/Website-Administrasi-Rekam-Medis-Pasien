<?php
require_once __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit;
}