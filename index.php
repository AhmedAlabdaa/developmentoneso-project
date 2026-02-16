<?php


use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$dir = __DIR__;
$base = file_exists($dir . '/vendor/autoload.php') ? $dir : dirname($dir);
$maintenance = $base . '/storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

$autoload = $base . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    http_response_code(500);
    exit("Missing autoload file: {$autoload}");
}
require $autoload;

$appFile = $base . '/bootstrap/app.php';
if (!file_exists($appFile)) {
    http_response_code(500);
    exit("Missing bootstrap file: {$appFile}");
}

$app = require_once $appFile;
$app->handleRequest(Request::capture());
