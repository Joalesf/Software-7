<?php
//Integrantes:
//- Richard Rodríguez
//- Jose Sánchez
//- Egard Rosario
// index.php - Punto de entrada (Enrutador)

require_once __DIR__ . '/modelos/Cookie.php';
require_once __DIR__ . '/controladores/CookieControlador.php';

$controlador = new CookieControlador();
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

switch ($accion) {
    case 'guardar':
        $controlador->guardarNombre();
        break;
    case 'bienvenida':
        $controlador->mostrarBienvenida();
        break;
    case 'eliminar':
        $controlador->eliminarCookie();
        break;
    default:
        $controlador->mostrarFormulario();
        break;
}
