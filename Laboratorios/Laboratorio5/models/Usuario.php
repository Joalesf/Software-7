<?php

require_once 'config/herramientas.php';

class Usuario
{
    public static function validar($usuario, $clave)
    {
        try {
            $conexion = Herramientas::conectar();
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
            return false;
        }
    }
}
?>
