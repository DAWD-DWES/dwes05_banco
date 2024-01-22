<?php

require_once "TipoOperacion.php";

/**
 * Clase CuentaBanco
 */
class Operacion {

    private TipoOperacion $tipo;
    private float $cantidad;
    private DateTime $fecha;

    public function __construct($tipo, $cantidad) {
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
        $this->setFecha(new DateTime());
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }
}
