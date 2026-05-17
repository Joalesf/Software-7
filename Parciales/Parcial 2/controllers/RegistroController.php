<?php

require_once ROOT_PATH . '/models/Usuario.php';

class RegistroController
{
    public function procesar()
    {
        $title = 'Crear cuenta';
        $errores = array();
        $mensaje = '';
        $usuario = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmarPassword = isset($_POST['confirmar_password']) ? $_POST['confirmar_password'] : '';

            if ($usuario === '') {
                $errores[] = 'El usuario es obligatorio.';
            }

            if ($usuario !== '' && !preg_match('/^[a-zA-Z0-9_]{4,30}$/', $usuario)) {
                $errores[] = 'El usuario debe tener entre 4 y 30 caracteres y solo puede usar letras, numeros o guion bajo.';
            }

            if (!$this->passwordEsSeguro($password)) {
                $errores[] = 'La contrasena debe tener minimo 15 caracteres, letras, numeros y caracteres especiales.';
            }

            if ($password !== $confirmarPassword) {
                $errores[] = 'Las contrasenas no coinciden.';
            }

            if (empty($errores)) {
                $modeloUsuario = new Usuario();

                if ($modeloUsuario->existeUsuario($usuario)) {
                    $errores[] = 'El usuario ya esta registrado.';
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $creado = $modeloUsuario->crearAspirante($usuario, $passwordHash);

                    if ($creado) {
                        $mensaje = 'Cuenta creada correctamente. Ahora puedes iniciar sesion.';
                        $usuario = '';
                    } else {
                        $errores[] = 'No se pudo crear la cuenta. Intenta nuevamente.';
                    }
                }
            }
        }

        require ROOT_PATH . '/views/registro.php';
    }

    private function passwordEsSeguro($password)
    {
        if (strlen($password) < 15) {
            return false;
        }

        $tieneLetra = preg_match('/[a-zA-Z]/', $password);
        $tieneNumero = preg_match('/[0-9]/', $password);
        $tieneEspecial = preg_match('/[^a-zA-Z0-9]/', $password);

        return $tieneLetra && $tieneNumero && $tieneEspecial;
    }
}
