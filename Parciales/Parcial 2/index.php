<?php

ini_set('display_errors', '0');
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__);

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
session_start();

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function url($ruta = 'inicio')
{
    return 'index.php?ruta=' . urlencode($ruta);
}

function estaLogueado()
{
    return isset($_SESSION['usuario_id']);
}

function esRh()
{
    return estaLogueado() && isset($_SESSION['rol']) && $_SESSION['rol'] === 'rh';
}

require ROOT_PATH . '/controllers/InicioController.php';
require ROOT_PATH . '/controllers/RegistroController.php';
require ROOT_PATH . '/controllers/LoginController.php';
require ROOT_PATH . '/controllers/AspiranteController.php';
require ROOT_PATH . '/controllers/RhController.php';

$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'inicio';

switch ($ruta) {
    case '':
    case 'inicio':
        $controladorInicio = new InicioController();
        $controladorInicio->index();
        break;

    case 'login':
        $controladorLogin = new LoginController();
        $controladorLogin->procesar();
        break;

    case 'logout':
        $controladorLogin = new LoginController();
        $controladorLogin->logout();
        break;

    case 'registro':
        $controladorRegistro = new RegistroController();
        $controladorRegistro->procesar();
        break;

    case 'aspirante':
        $controladorAspirante = new AspiranteController();
        $controladorAspirante->index();
        break;

    case 'rh':
        $controladorRh = new RhController();
        $controladorRh->index();
        break;

    default:
        http_response_code(404);
        require ROOT_PATH . '/views/error404.php';
        break;
}
