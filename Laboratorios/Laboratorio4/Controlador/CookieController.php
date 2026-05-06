<?php
require_once '../Modelo/CookieUsuario.php';

class CookieController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new CookieUsuario();
    }

    public function mostrarFormulario()
    {
        require '../Vista/Formulario.php';
    }

    public function guardarNombre()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Formulario.php');
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');

        if ($nombre !== '') {
            $this->modelo->guardarNombre($nombre);
        }

        header('Location: Bienvenida.php');
        exit;
    }

    public function mostrarBienvenida()
    {
        $nombre = $this->modelo->obtenerNombre();
        require '../Vista/Bienvenida.php';
    }

    public function salir()
    {
        $this->modelo->eliminarNombre();
        header('Location: Formulario.php');
        exit;
    }
}
