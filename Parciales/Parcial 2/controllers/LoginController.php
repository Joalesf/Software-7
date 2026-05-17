<?php

require_once ROOT_PATH . '/models/Usuario.php';

class LoginController
{
    public function procesar()
    {
        if (estaLogueado()) {
            $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'aspirante';
            header('Location: ' . $this->rutaPorRol($rol));
            exit;
        }

        $title = 'Iniciar sesion';
        $errores = array();
        $usuario = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if ($usuario === '' || $password === '') {
                $errores[] = 'Usuario y contrasena son obligatorios.';
            }

            if (empty($errores)) {
                $modeloUsuario = new Usuario();
                $datosUsuario = $modeloUsuario->buscarPorUsuario($usuario);

                if ($datosUsuario === null) {
                    $errores[] = 'Usuario o contrasena incorrectos.';
                } elseif ($this->estaBloqueado($datosUsuario['bloqueado_hasta'])) {
                    $errores[] = 'La cuenta esta bloqueada temporalmente. Intenta mas tarde.';
                } elseif (password_verify($password, $datosUsuario['password_hash'])) {
                    $modeloUsuario->limpiarIntentosFallidos((int) $datosUsuario['id']);
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = (int) $datosUsuario['id'];
                    $_SESSION['usuario'] = $datosUsuario['usuario'];
                    $_SESSION['rol'] = $datosUsuario['rol'];

                    header('Location: ' . $this->rutaPorRol($datosUsuario['rol']));
                    exit;
                } else {
                    $modeloUsuario->aumentarIntentosFallidos((int) $datosUsuario['id']);
                    $errores[] = 'Usuario o contrasena incorrectos.';
                }
            }
        }

        require ROOT_PATH . '/views/login.php';
    }

    public function logout()
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
        header('Location: ' . url('inicio'));
        exit;
    }

    private function estaBloqueado($bloqueadoHasta)
    {
        if ($bloqueadoHasta === null) {
            return false;
        }

        return strtotime($bloqueadoHasta) > time();
    }

    private function rutaPorRol($rol)
    {
        if ($rol === 'rh') {
            return url('rh');
        }

        return url('aspirante');
    }
}
