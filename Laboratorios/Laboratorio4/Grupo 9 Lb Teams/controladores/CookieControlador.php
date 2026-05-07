<?php
// controladores/CookieControlador.php - Controlador para gestionar cookies

require_once __DIR__ . '/../modelos/Cookie.php';

class CookieControlador {
    
    public function mostrarFormulario() {
        include __DIR__ . '/../vistas/formulario.php';
    }
    
    public function guardarNombre() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
                $nombre = $_POST['nombre'];
                Cookie::crear($nombre);
                header("Location: index.php?accion=bienvenida");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        }
    }
    
    public function mostrarBienvenida() {
        include __DIR__ . '/../vistas/bienvenida.php';
    }
    
    public function eliminarCookie() {
        Cookie::eliminar();
        header("Location: index.php");
        exit();
    }
}
?>
