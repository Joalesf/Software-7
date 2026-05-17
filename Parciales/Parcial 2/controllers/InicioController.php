<?php

class InicioController
{
    public function index()
    {
        $title = 'Registro de aspirantes';

        require ROOT_PATH . '/views/inicio.php';
    }
}
