<?php

class CookieUsuario
{
    private $nombreCookie = 'nombre_usuario';
    private $tiempoExpiracion = 10; // 10 segundos

    public function guardarNombre($nombre)
    {
        setcookie($this->nombreCookie, $nombre, time() + $this->tiempoExpiracion, '/');
        $_COOKIE[$this->nombreCookie] = $nombre;
    }

    public function obtenerNombre()
    {
        if (isset($_COOKIE[$this->nombreCookie]) && $_COOKIE[$this->nombreCookie] !== '') {
            return $_COOKIE[$this->nombreCookie];
        }

        return null;
    }

    public function eliminarNombre()
    {
        setcookie($this->nombreCookie, '', time() - 3600, '/');
        unset($_COOKIE[$this->nombreCookie]);
    }
}
