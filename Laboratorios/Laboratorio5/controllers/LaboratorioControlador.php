<?php

require_once 'models/Usuario.php';
require_once 'models/Cliente.php';
require_once 'models/Servicio.php';

class LaboratorioControlador
{
    public function __construct()
    {
        session_start();
    }

    public function mostrarLogin()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?accion=formulario');
            exit();
        }

        $error = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : '';
        unset($_SESSION['error_login']);

        include 'views/login.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = trim(isset($_POST['usuario']) ? $_POST['usuario'] : '');
            $clave = trim(isset($_POST['clave']) ? $_POST['clave'] : '');

            if (Usuario::validar($usuario, $clave)) {
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php?accion=formulario');
                exit();
            }

            $_SESSION['error_login'] = 'Usuario o contrasena incorrectos.';
        }

        header('Location: index.php');
        exit();
    }

    public function mostrarFormulario()
    {
        $this->verificarSesion();

        $servicios = Servicio::obtenerTodos();
        $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : array();
        $datos = isset($_SESSION['datos']) ? $_SESSION['datos'] : array();

        unset($_SESSION['errores']);
        unset($_SESSION['datos']);

        include 'views/formulario.php';
    }

    public function procesarFormulario()
    {
        $this->verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim(isset($_POST['nombre']) ? $_POST['nombre'] : '');
            $fechaNacimiento = trim(isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '');
            $genero = trim(isset($_POST['genero']) ? $_POST['genero'] : '');
            $nacionalidad = trim(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : '');
            $direccion = trim(isset($_POST['direccion']) ? $_POST['direccion'] : '');
            $seleccionados = isset($_POST['servicios']) ? $_POST['servicios'] : array();

            $datos = array(
                'nombre' => $nombre,
                'fecha_nacimiento' => $fechaNacimiento,
                'genero' => $genero,
                'nacionalidad' => $nacionalidad,
                'direccion' => $direccion,
                'servicios' => $seleccionados
            );

            $errores = array();

            if ($nombre == '') {
                $errores[] = 'Ingrese el nombre del cliente.';
            }

            if ($fechaNacimiento == '') {
                $errores[] = 'Ingrese la fecha de nacimiento.';
            }

            if ($genero == '') {
                $errores[] = 'Seleccione el genero.';
            }

            if ($nacionalidad == '') {
                $errores[] = 'Ingrese la nacionalidad.';
            }

            if ($direccion == '') {
                $errores[] = 'Ingrese la direccion de residencia.';
            }

            $serviciosSeleccionados = Servicio::obtenerSeleccionados($seleccionados);

            if (count($serviciosSeleccionados) == 0) {
                $errores[] = 'Debe seleccionar al menos un servicio.';
            }

            if (count($errores) > 0) {
                $_SESSION['errores'] = $errores;
                $_SESSION['datos'] = $datos;
                header('Location: index.php?accion=formulario');
                exit();
            }

            $cliente = new Cliente($nombre, $fechaNacimiento, $genero, $nacionalidad, $direccion);
            $total = Servicio::calcularTotal($serviciosSeleccionados);

            if ($cliente->guardar($serviciosSeleccionados, $total)) {
                $_SESSION['resultado'] = array(
                    'cliente' => $cliente->toArray(),
                    'servicios' => $serviciosSeleccionados,
                    'total' => $total
                );

                header('Location: index.php?accion=resultado');
                exit();
            }

            $_SESSION['errores'] = array('No se pudo guardar la informacion en la base de datos.');
            $_SESSION['datos'] = $datos;
        }

        header('Location: index.php?accion=formulario');
        exit();
    }

    public function mostrarResultado()
    {
        $this->verificarSesion();

        if (!isset($_SESSION['resultado'])) {
            header('Location: index.php?accion=formulario');
            exit();
        }

        $resultado = $_SESSION['resultado'];
        include 'views/resultado.php';
    }

    public function salir()
    {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    private function verificarSesion()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit();
        }
    }
}
?>
