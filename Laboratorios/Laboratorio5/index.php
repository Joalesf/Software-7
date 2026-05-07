<?php
require_once __DIR__ . '/controllers/LaboratorioControlador.php';

$controlador = new LaboratorioControlador();
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'login';

switch ($accion) {
    case 'autenticar':
        $controlador->autenticar();
        break;
    case 'formulario':
        $controlador->mostrarFormulario();
        break;
    case 'procesar':
        $controlador->procesarFormulario();
        break;
    case 'resultado':
        $controlador->mostrarResultado();
        break;
    case 'salir':
        $controlador->salir();
        break;
    default:
        $controlador->mostrarLogin();
        break;
}
?>
