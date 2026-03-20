<?php

declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/ShortCut.php';
require_once __DIR__ . '/../app/models/AccessLog.php';
require_once __DIR__ . '/../app/controllers/ShortCutController.php';

$conn = db();
$shortCutModel = new ShortCut($conn);
$accessLogModel = new AccessLog($conn);
$controller = new ShortCutController($shortCutModel, $accessLogModel);

// Acciones backend
if (
    (isset($_GET['url']) && $_GET['url'] !== '') ||
    (isset($_POST['urlcode']) && $_POST['urlcode'] !== '')
) {
    $controller->handleRequest();
    exit;
}

// Vista principal (en public)
readfile(__DIR__ . '/index.html');
exit;