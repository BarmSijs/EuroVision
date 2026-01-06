<?php
// Define a BASE_URL that points to the public folder (auto-detected).
// Views can use this to build correct absolute links to assets and routes.
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($scriptDir, '/'));

require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Db.php';

$router = new Router();
$router->dispatch();