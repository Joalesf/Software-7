<?php
require_once 'models/Usuario.php'; require_once 'models/Cliente.php'; require_once 'models/Servicio.php';

class LaboratorioControlador
{
    public function __construct() { session_start(); }

    public function mostrarLogin()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?accion=formulario'); exit();
        }

        $error = $_SESSION['error_login'] ?? '';
        unset($_SESSION['error_login']);
        include 'views/login.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $clave = trim($_POST['clave'] ?? '');

            if (Usuario::validar($usuario, $clave)) {
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php?accion=formulario'); exit();
            }

            $_SESSION['error_login'] = 'Usuario o contrasena incorrectos.';
        }

        header('Location: index.php'); exit();
    }

    public function mostrarFormulario()
    {
        $this->verificarSesion();
        $servicios = Servicio::obtenerTodos();
        $errores = $_SESSION['errores'] ?? array();
        $datos = $_SESSION['datos'] ?? array();
        unset($_SESSION['errores'], $_SESSION['datos']);
        include 'views/formulario.php';
    }

    public function procesarFormulario()
    {
        $this->verificarSesion();
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?accion=formulario'); exit();
        }

        $datos = array(
            'nombre' => trim($_POST['nombre'] ?? ''),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento'] ?? ''),
            'genero' => trim($_POST['genero'] ?? ''),
            'nacionalidad' => trim($_POST['nacionalidad'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'servicios' => $_POST['servicios'] ?? array()
        );

        $errores = array();
        $mensajes = array(
            'nombre' => 'Ingrese el nombre del cliente.',
            'fecha_nacimiento' => 'Ingrese la fecha de nacimiento.',
            'genero' => 'Seleccione el genero.',
            'nacionalidad' => 'Ingrese la nacionalidad.',
            'direccion' => 'Ingrese la direccion de residencia.'
        );

        foreach ($mensajes as $campo => $mensaje) {
            if ($datos[$campo] == '') $errores[] = $mensaje;
        }

        $serviciosSeleccionados = Servicio::obtenerSeleccionados($datos['servicios']);
        if (count($serviciosSeleccionados) == 0) $errores[] = 'Debe seleccionar al menos un servicio.';

        if (count($errores) > 0) {
            $_SESSION['errores'] = $errores;
            $_SESSION['datos'] = $datos;
            header('Location: index.php?accion=formulario'); exit();
        }

        $cliente = new Cliente(
            $datos['nombre'], $datos['fecha_nacimiento'], $datos['genero'],
            $datos['nacionalidad'], $datos['direccion']
        );
        $total = Servicio::calcularTotal($serviciosSeleccionados);

        if (!$cliente->guardar($serviciosSeleccionados, $total)) {
            $_SESSION['errores'] = array('No se pudo guardar la informacion en la base de datos.');
            $_SESSION['datos'] = $datos;
            header('Location: index.php?accion=formulario'); exit();
        }

        $_SESSION['resultado'] = array(
            'cliente' => $cliente->toArray(),
            'servicios' => $serviciosSeleccionados,
            'total' => $total
        );

        header('Location: index.php?accion=resultado'); exit();
    }

    public function mostrarResultado()
    {
        $this->verificarSesion();
        if (!isset($_SESSION['resultado'])) {
            header('Location: index.php?accion=formulario'); exit();
        }

        $resultado = $_SESSION['resultado'];
        include 'views/resultado.php';
    }

    public function salir()
    {
        session_destroy();
        header('Location: index.php'); exit();
    }

    private function verificarSesion()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php'); exit();
        }
    }
}
