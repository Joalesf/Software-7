<?php

require_once ROOT_PATH . '/config/Herramientas.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Herramientas::conectar();
    }

    public function existeUsuario($usuario)
    {
        $sql = 'SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1';
        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->execute();

        return $consulta->fetch() !== false;
    }

    public function crearAspirante($usuario, $passwordHash)
    {
        $sql = "INSERT INTO usuarios (usuario, password_hash, rol)
                VALUES (:usuario, :password_hash, 'aspirante')";

        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->bindValue(':password_hash', $passwordHash);

        return $consulta->execute();
    }

    public function buscarPorUsuario($usuario)
    {
        $sql = 'SELECT id, usuario, password_hash, rol, intentos_fallidos, bloqueado_hasta
                FROM usuarios
                WHERE usuario = :usuario
                LIMIT 1';

        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->execute();

        $resultado = $consulta->fetch();

        return $resultado === false ? null : $resultado;
    }

    public function aumentarIntentosFallidos($id)
    {
        $sql = "UPDATE usuarios
                SET intentos_fallidos = intentos_fallidos + 1,
                    bloqueado_hasta = CASE
                        WHEN intentos_fallidos + 1 >= 5 THEN DATE_ADD(NOW(), INTERVAL 15 MINUTE)
                        ELSE bloqueado_hasta
                    END
                WHERE id = :id";

        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public function limpiarIntentosFallidos($id)
    {
        $sql = 'UPDATE usuarios
                SET intentos_fallidos = 0,
                    bloqueado_hasta = NULL
                WHERE id = :id';

        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }
}
