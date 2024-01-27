<?php

require_once "TipoOperacion.php";

/**
 * Clase CuentaBanco
 */
class Operacion {

    private TipoOperacion $tipo;
    private float $cantidad;
    private DateTime $fecha;
    private string $asunto;

    public function __construct($tipo, $cantidad, $asunto) {
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
        $this->setFecha(new DateTime());
        $this->setAsunto($asunto);
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
    
    public function getAsunto() {
        return $this->asunto;
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
    
     public function setAsunto($asunto) {
        $this->asunto = $asunto;
        return $this;
    }
    
    public function __toString() {
        return ("Operación {$this->getTipo()->name} Cantidad {$this->getCantidad()} Fecha {$this->getFecha()->format('Y-m-d H:i:s')} Asunto {$this->getAsunto()})");
    }
}
