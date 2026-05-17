<?php

class TokenRecuerdame
{
    public static function crear(int $usuarioId, string $tokenHash, string $expiraEn): void
    {
        $conexion = Conexion::conectar();
        $query = $conexion->prepare(
            'INSERT INTO tokens_recordarme (usuario_id, token_hash, expira_en) VALUES (:usuario_id, :token_hash, :expira_en)'
        );
        $query->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $query->bindValue(':token_hash', $tokenHash);
        $query->bindValue(':expira_en', $expiraEn);
        $query->execute();
    }

    public static function buscarValidoPorTokenPlano(string $plainToken): ?array
    {
        $conexion = Conexion::conectar();
        $tokenHash = hash('sha256', $plainToken);
        $query = $conexion->prepare(
            'SELECT id, usuario_id, expira_en FROM tokens_recordarme WHERE token_hash = :token_hash AND expira_en > NOW() LIMIT 1'
        );
        $query->bindValue(':token_hash', $tokenHash);
        $query->execute();

        $token = $query->fetch();
        return $token ?: null;
    }

    public static function eliminarPorTokenPlano(string $plainToken): void
    {
        $conexion = Conexion::conectar();
        $tokenHash = hash('sha256', $plainToken);
        $query = $conexion->prepare('DELETE FROM tokens_recordarme WHERE token_hash = :token_hash');
        $query->bindValue(':token_hash', $tokenHash);
        $query->execute();
    }

    public static function eliminarPorId(int $id): void
    {
        $conexion = Conexion::conectar();
        $query = $conexion->prepare('DELETE FROM tokens_recordarme WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }

    public static function eliminarExpirados(): void
    {
        $conexion = Conexion::conectar();
        $conexion->prepare('DELETE FROM tokens_recordarme WHERE expira_en <= NOW()')->execute();
    }
}
