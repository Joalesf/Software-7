<?php

define('BASE_PATH', dirname(__DIR__));

$appConfig = require BASE_PATH . '/config/aplicacion.php';
$GLOBALS['app_config'] = $appConfig;

$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

session_name($appConfig['session_name']);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function (string $class): void {
    $folders = ['config', 'models', 'controllers'];

    foreach ($folders as $folder) {
        $file = BASE_PATH . '/' . $folder . '/' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

function app_config(string $key, mixed $default = null): mixed
{
    return $GLOBALS['app_config'][$key] ?? $default;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function route_url(string $route = 'inicio'): string
{
    return 'index.php?route=' . urlencode($route);
}

function asset_url(string $path): string
{
    return 'public/assets/' . ltrim($path, '/');
}
