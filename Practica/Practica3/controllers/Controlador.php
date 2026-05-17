<?php

class Controlador
{
    protected function vista(string $vista, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);
        require BASE_PATH . '/views/' . $vista . '.php';
    }

    protected function redireccionar(string $ruta): void
    {
        header('Location: ' . route_url($ruta));
        exit;
    }
}
