<?php

require_once __DIR__ . '/Conexion.php';

class Usuario
{
    private static $ultimoError = '';

    public static function validar($usuario, $clave)
    {
        self::$ultimoError = '';

        try {
            $conexion = Conexion::Conectar();
            $consulta = $conexion->prepare(
                'SELECT id_usuario FROM usuarios
                 WHERE usuario = :usuario AND contrasena = :contrasena
                 LIMIT 1'
            );

            $consulta->bindParam(':usuario', $usuario);
            $consulta->bindParam(':contrasena', $clave);
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            self::$ultimoError = 'No se pudo consultar la base de datos.';
            return false;
        }
    }

    public static function obtenerError()
    {
        return self::$ultimoError;
    }
}
?>
