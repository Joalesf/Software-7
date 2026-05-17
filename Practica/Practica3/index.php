<?php

//Jose Sanchez 
//Edgar Rosario
//Richard Rodriguez

require_once __DIR__ . '/config/inicio.php';

$route = $_GET['route'] ?? 'inicio';

switch ($route) {
    case 'iniciar_sesion':
        $controlador = new ControladorAutenticacion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlador->iniciarSesion();
            break;
        }

        $controlador->mostrarLogin();
        break;

    case 'registro':
        $controlador = new ControladorAutenticacion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlador->registrar();
            break;
        }

        $controlador->mostrarRegistro();
        break;

    case 'salir':
        (new ControladorAutenticacion())->cerrarSesion();
        break;

    case 'tema':
        (new ControladorTema())->actualizar();
        break;

    case 'inicio':
    default:
        (new ControladorInicio())->index();
        break;
}
