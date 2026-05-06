<?php
class Contacto {
    private $nombre;
    private $correo;
    private $cedula;
    private $edad;

    public function __construct($nombre, $correo, $cedula, $edad) {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->cedula = $cedula;
        $this->edad = $edad;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getEdad() {
        return $this->edad;
    }
}
?>