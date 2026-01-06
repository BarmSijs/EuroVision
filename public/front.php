<?php

$uri = $_SERVER['REQUEST_URI'];

if (!str_ends_with($uri, '/')) {
    header('Location: ' . $uri . '/');
    exit;
}

// Define BASE_URL
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($scriptDir, '/'));

require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Db.php';

$router = new Router();
$router->dispatch();
