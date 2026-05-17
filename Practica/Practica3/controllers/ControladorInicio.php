<?php

class ControladorInicio extends Controlador
{
    public function index(): void
    {
        try {
            if (!Autenticacion::verificarSesion() && !Autenticacion::intentarSesionConCookie()) {
                $this->redireccionar('iniciar_sesion');
            }

            $usuario = Usuario::buscarPorId((int) $_SESSION['user_id']);

            if (!$usuario) {
                Autenticacion::cerrarSesion();
                $this->redireccionar('iniciar_sesion');
            }

            $this->vista('perfil', [
                'usuario' => $usuario,
                'theme' => Autenticacion::temaActual(),
            ]);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $_SESSION['login_error'] = 'No se pudo conectar con la base de datos.';
            $this->redireccionar('iniciar_sesion');
        }
    }
}
