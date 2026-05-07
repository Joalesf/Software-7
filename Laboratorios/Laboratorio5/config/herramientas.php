<?php

class Herramientas
{
    public static function conectar()
    {
        $host = 'localhost';
        $puerto = '3306';
        $baseDeDatos = 'laboratorio7';
        $usuario = 'root';
        $contrasena = '';

        $conexion = new PDO(
            "mysql:host=$host;port=$puerto;dbname=$baseDeDatos;charset=utf8mb4",
            $usuario,
            $contrasena
        );

        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }
}
?>
