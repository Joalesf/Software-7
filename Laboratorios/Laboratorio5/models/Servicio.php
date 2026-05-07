<?php

require_once 'config/herramientas.php';

class Servicio
{
    public static function obtenerTodos()
    {
        try {
            $conexion = Herramientas::conectar();
            $consulta = $conexion->prepare(
                'SELECT id_servicio, nombre, precio
                 FROM servicios
                 ORDER BY id_servicio'
            );
            $consulta->execute();

            $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $servicios = array();

            foreach ($filas as $fila) {
                $servicios[$fila['id_servicio']] = array(
                    'id_servicio' => $fila['id_servicio'],
                    'nombre' => $fila['nombre'],
                    'precio' => $fila['precio']
                );
            }

            return $servicios;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return array();
        }
    }

    public static function obtenerSeleccionados($ids)
    {
        $todos = self::obtenerTodos();
        $seleccionados = array();

        foreach ($ids as $id) {
            $id = (int) $id;

            if (isset($todos[$id])) {
                $seleccionados[$id] = $todos[$id];
            }
        }

        return $seleccionados;
    }

    public static function calcularTotal($servicios)
    {
        $total = 0;

        foreach ($servicios as $servicio) {
            $total += (float) $servicio['precio'];
        }

        return $total;
    }
}
?>
