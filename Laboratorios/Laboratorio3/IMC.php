<?php
class IMC {
    private $nombre;
    private $peso;
    private $altura;
    private $imc;

    public function __construct($nombre, $peso, $altura) {
        $this->nombre = $nombre;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->imc = $this->calcularIMC();
    }

    private function calcularIMC() {
        if ($this->altura > 0) {
            return $this->peso / ($this->altura * $this->altura);
        }
        return 0;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getAltura() {
        return $this->altura;
    }

    public function getIMC() {
        return $this->imc;
    }

    public function getClasificacion() {
        if ($this->imc < 18.5) {
            return "Bajo peso";
        } elseif ($this->imc < 25) {
            return "Normal";
        } elseif ($this->imc < 30) {
            return "Sobrepeso";
        } else {
            return "Obeso";
        }
    }
}
?>