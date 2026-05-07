<?php
// controllers/LaboratorioControlador.php - Controla login, formulario y resultado

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Servicio.php';

class LaboratorioControlador
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            session_start();
        }
    }

    public function mostrarLogin()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?accion=formulario');
            exit();
        }

        $error = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : '';
        unset($_SESSION['error_login']);

        include __DIR__ . '/../views/login.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit();
        }

        $usuario = trim(isset($_POST['usuario']) ? $_POST['usuario'] : '');
        $clave = trim(isset($_POST['clave']) ? $_POST['clave'] : '');

        if (Usuario::validar($usuario, $clave)) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = $usuario;
            header('Location: index.php?accion=formulario');
            exit();
        }

        $errorBaseDatos = Usuario::obtenerError();
        $_SESSION['error_login'] = $errorBaseDatos !== '' ? $errorBaseDatos : 'Usuario o contrasena incorrectos.';
        header('Location: index.php');
        exit();
    }

    public function mostrarFormulario()
    {
        $this->verificarSesion();

        $servicios = Servicio::obtenerTodos();
        $errores = isset($_SESSION['errores']) ? $_SESSION['errores'] : array();
        $datos = isset($_SESSION['datos']) ? $_SESSION['datos'] : array();

        if (count($servicios) === 0) {
            $errores[] = 'No se pudieron cargar los servicios. Verifique que MySQL este activo y que la base laboratorio7 este importada.';
        }

        unset($_SESSION['errores']);
        unset($_SESSION['datos']);

        include __DIR__ . '/../views/formulario.php';
    }

    public function procesarFormulario()
    {
        $this->verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?accion=formulario');
            exit();
        }

        $datos = array(
            'nombre' => trim(isset($_POST['nombre']) ? $_POST['nombre'] : ''),
            'fecha_nacimiento' => trim(isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : ''),
            'genero' => trim(isset($_POST['genero']) ? $_POST['genero'] : ''),
            'nacionalidad' => trim(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : ''),
            'direccion' => trim(isset($_POST['direccion']) ? $_POST['direccion'] : '')
        );

        $seleccionados = isset($_POST['servicios']) ? $_POST['servicios'] : array();
        if (!is_array($seleccionados)) {
            $seleccionados = array();
        }

        $datos['servicios'] = $seleccionados;
        $cliente = new Cliente(
            $datos['nombre'],
            $datos['fecha_nacimiento'],
            $datos['genero'],
            $datos['nacionalidad'],
            $datos['direccion']
        );

        $errores = $this->validarCliente($cliente);
        $serviciosSeleccionados = Servicio::obtenerSeleccionados($seleccionados);

        if (count($serviciosSeleccionados) === 0) {
            $errores[] = 'Debe seleccionar al menos un servicio.';
        }

        if (count($errores) > 0) {
            $_SESSION['errores'] = $errores;
            $_SESSION['datos'] = $datos;
            header('Location: index.php?accion=formulario');
            exit();
        }

        $total = Servicio::calcularTotal($serviciosSeleccionados);

        if (!$cliente->guardar($serviciosSeleccionados, $total)) {
            $_SESSION['errores'] = array('No se pudo guardar la informacion en la base de datos.');
            $_SESSION['datos'] = $datos;
            header('Location: index.php?accion=formulario');
            exit();
        }

        $_SESSION['resultado'] = array(
            'cliente' => $cliente->toArray(),
            'servicios' => $serviciosSeleccionados,
            'total' => $total
        );

        header('Location: index.php?accion=resultado');
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
        include __DIR__ . '/../views/resultado.php';
    }

    public function salir()
    {
        $_SESSION = array();

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

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

    private function validarCliente($cliente)
    {
        $errores = array();

        if ($cliente->getNombre() === '') {
            $errores[] = 'Ingrese el nombre del cliente.';
        }

        if ($cliente->getFechaNacimiento() === '') {
            $errores[] = 'Ingrese la fecha de nacimiento.';
        }

        if ($cliente->getGenero() === '') {
            $errores[] = 'Seleccione el genero.';
        }

        if ($cliente->getNacionalidad() === '') {
            $errores[] = 'Ingrese la nacionalidad.';
        }

        if ($cliente->getDireccion() === '') {
            $errores[] = 'Ingrese la direccion de residencia.';
        }

        return $errores;
    }
}
?>
