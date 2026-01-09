<?php
declare(strict_types=1);

// Start session (optioneel maar meestal nodig)
session_start();

// Error reporting (handig tijdens development)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Base path van het project (belangrijk!)
define('BASE_PATH', '/BramS/EuroVision');

// Autoload / includes
require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Db.php';

// Dispatch router
$router = new Router();
$router->dispatch();

