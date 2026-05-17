<?php

class ControladorAutenticacion extends Controlador
{
    public function mostrarLogin(): void
    {
        try {
            if (Autenticacion::verificarSesion() || Autenticacion::intentarSesionConCookie()) {
                $this->redireccionar('inicio');
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }

        $this->vista('iniciar_sesion', [
            'error' => $_SESSION['login_error'] ?? null,
            'usuarioAnterior' => $_SESSION['usuario_anterior'] ?? '',
            'theme' => Autenticacion::temaActual(),
        ]);

        unset($_SESSION['login_error'], $_SESSION['usuario_anterior']);
    }

    public function mostrarRegistro(): void
    {
        try {
            if (Autenticacion::verificarSesion() || Autenticacion::intentarSesionConCookie()) {
                $this->redireccionar('inicio');
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }

        $this->vista('registro', [
            'error' => $_SESSION['registro_error'] ?? null,
            'datos' => $_SESSION['registro_datos'] ?? [],
            'theme' => Autenticacion::temaActual(),
        ]);

        unset($_SESSION['registro_error'], $_SESSION['registro_datos']);
    }

    public function iniciarSesion(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireccionar('iniciar_sesion');
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';
        $recordar = isset($_POST['recordar']);

        if ($usuario === '' || $contrasena === '') {
            $_SESSION['login_error'] = 'Ingresa usuario y contrasena.';
            $_SESSION['usuario_anterior'] = $usuario;
            $this->redireccionar('iniciar_sesion');
        }

        try {
            $datosUsuario = Usuario::verificarCredenciales($usuario, $contrasena);

            if (!$datosUsuario) {
                $_SESSION['login_error'] = 'Usuario o contrasena incorrectos.';
                $_SESSION['usuario_anterior'] = $usuario;
                $this->redireccionar('iniciar_sesion');
            }

            Autenticacion::iniciarSesion($datosUsuario);

            if ($recordar) {
                Autenticacion::crearTokenRecuerdame((int) $datosUsuario['id']);
            } else {
                Autenticacion::eliminarTokenRecuerdame();
            }

            $this->redireccionar('inicio');
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $_SESSION['login_error'] = 'No se pudo conectar con la base de datos.';
            $_SESSION['usuario_anterior'] = $usuario;
            $this->redireccionar('iniciar_sesion');
        }
    }

    public function cerrarSesion(): void
    {
        Autenticacion::cerrarSesion();
        $this->redireccionar('iniciar_sesion');
    }

    public function registrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireccionar('registro');
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $nombreCompleto = trim($_POST['nombre_completo'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';

        $_SESSION['registro_datos'] = [
            'usuario' => $usuario,
            'nombre_completo' => $nombreCompleto,
            'correo' => $correo,
        ];

        if ($usuario === '' || $nombreCompleto === '' || $correo === '' || $contrasena === '') {
            $_SESSION['registro_error'] = 'Completa todos los campos.';
            $this->redireccionar('registro');
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['registro_error'] = 'Escribe un correo valido.';
            $this->redireccionar('registro');
        }

        if ($contrasena !== $confirmar) {
            $_SESSION['registro_error'] = 'Las contrasenas no coinciden.';
            $this->redireccionar('registro');
        }

        try {
            if (Usuario::buscarPorUsuario($usuario)) {
                $_SESSION['registro_error'] = 'Ese usuario ya existe.';
                $this->redireccionar('registro');
            }

            if (Usuario::buscarPorCorreo($correo)) {
                $_SESSION['registro_error'] = 'Ese correo ya esta registrado.';
                $this->redireccionar('registro');
            }

            $nuevoUsuario = Usuario::crear($usuario, $contrasena, $nombreCompleto, $correo);
            unset($_SESSION['registro_datos']);
            Autenticacion::iniciarSesion($nuevoUsuario);
            $this->redireccionar('inicio');
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $_SESSION['registro_error'] = 'No se pudo registrar el usuario.';
            $this->redireccionar('registro');
        }
    }
}
