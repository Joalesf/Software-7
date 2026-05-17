<?php

class Usuario
{
    public static function buscarPorUsuario(string $usuario): ?array
    {
        $conexion = Conexion::conectar();
        $query = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        $query->bindValue(':usuario', $usuario);
        $query->execute();

        $resultado = $query->fetch();
        return $resultado ?: null;
    }

    public static function buscarPorCorreo(string $correo): ?array
    {
        $conexion = Conexion::conectar();
        $query = $conexion->prepare('SELECT * FROM usuarios WHERE correo = :correo LIMIT 1');
        $query->bindValue(':correo', $correo);
        $query->execute();

        $resultado = $query->fetch();
        return $resultado ?: null;
    }

    public static function buscarPorId(int $id): ?array
    {
        $conexion = Conexion::conectar();
        $query = $conexion->prepare('SELECT id, usuario, nombre_completo, correo, creado_en FROM usuarios WHERE id = :id LIMIT 1');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $usuario = $query->fetch();
        return $usuario ?: null;
    }

    public static function verificarCredenciales(string $usuario, string $contrasena): ?array
    {
        $resultado = self::buscarPorUsuario($usuario);

        if (!$resultado || !password_verify($contrasena, $resultado['clave_hash'])) {
            return null;
        }

        return [
            'id' => $resultado['id'],
            'usuario' => $resultado['usuario'],
            'nombre_completo' => $resultado['nombre_completo'],
            'correo' => $resultado['correo'],
        ];
    }

    public static function crear(string $usuario, string $contrasena, string $nombreCompleto, string $correo): array
    {
        $conexion = Conexion::conectar();
        $claveHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $query = $conexion->prepare(
            'INSERT INTO usuarios (usuario, clave_hash, nombre_completo, correo) VALUES (:usuario, :clave_hash, :nombre_completo, :correo)'
        );
        $query->bindValue(':usuario', $usuario);
        $query->bindValue(':clave_hash', $claveHash);
        $query->bindValue(':nombre_completo', $nombreCompleto);
        $query->bindValue(':correo', $correo);
        $query->execute();

        return [
            'id' => (int) $conexion->lastInsertId(),
            'usuario' => $usuario,
            'nombre_completo' => $nombreCompleto,
            'correo' => $correo,
        ];
    }
}
