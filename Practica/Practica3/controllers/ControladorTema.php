<?php

class ControladorTema extends Controlador
{
    public function actualizar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireccionar('inicio');
        }

        try {
            if (!Autenticacion::verificarSesion() && !Autenticacion::intentarSesionConCookie()) {
                $this->redireccionar('iniciar_sesion');
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $this->redireccionar('iniciar_sesion');
        }

        Autenticacion::guardarTema($_POST['theme'] ?? 'default');
        $this->redireccionar('inicio');
    }
}
