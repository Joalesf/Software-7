<?php

require_once __DIR__ . '/Conexion.php';

class Cliente
{
    private $nombre;
    private $fechaNacimiento;
    private $genero;
    private $nacionalidad;
    private $direccion;

    public function __construct($nombre, $fechaNacimiento, $genero, $nacionalidad, $direccion)
    {
        $this->nombre = $nombre;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->genero = $genero;
        $this->nacionalidad = $nacionalidad;
        $this->direccion = $direccion;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function toArray()
    {
        return array(
            'nombre' => $this->nombre,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'genero' => $this->genero,
            'nacionalidad' => $this->nacionalidad,
            'direccion' => $this->direccion
        );
    }

    public function guardar($serviciosSeleccionados, $total)
    {
        try {
            $conexion = Conexion::Conectar();
            $conexion->beginTransaction();

            $consultaCliente = $conexion->prepare(
                'INSERT INTO clientes
                (nombre, fecha_nacimiento, genero, nacionalidad, direccion, total)
                VALUES
                (:nombre, :fecha_nacimiento, :genero, :nacionalidad, :direccion, :total)'
            );

            $consultaCliente->bindParam(':nombre', $this->nombre);
            $consultaCliente->bindParam(':fecha_nacimiento', $this->fechaNacimiento);
            $consultaCliente->bindParam(':genero', $this->genero);
            $consultaCliente->bindParam(':nacionalidad', $this->nacionalidad);
            $consultaCliente->bindParam(':direccion', $this->direccion);
            $consultaCliente->bindParam(':total', $total);
            $consultaCliente->execute();

            $idCliente = $conexion->lastInsertId();

            $consultaServicio = $conexion->prepare(
                'INSERT INTO cliente_servicios
                (id_cliente, id_servicio, precio)
                VALUES
                (:id_cliente, :id_servicio, :precio)'
            );

            foreach ($serviciosSeleccionados as $servicio) {
                $idServicio = $servicio['id_servicio'];
                $precio = $servicio['precio'];

                $consultaServicio->bindParam(':id_cliente', $idCliente);
                $consultaServicio->bindParam(':id_servicio', $idServicio);
                $consultaServicio->bindParam(':precio', $precio);
                $consultaServicio->execute();
            }

            $conexion->commit();
            return true;
        } catch (PDOException $e) {
            if (isset($conexion) && $conexion->inTransaction()) {
                $conexion->rollBack();
            }

            error_log($e->getMessage());
            return false;
        }
    }
}
?>
