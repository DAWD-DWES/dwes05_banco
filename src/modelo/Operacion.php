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

    public function getTipo(): TipoOperacion {
        return $this->tipo;
    }

    public function getCantidad(): float {
        return $this->cantidad;
    }

    public function getFecha(): DateTime {
        return $this->fecha;
    }
    
    public function getAsunto(): string {
        return $this->asunto;
    }

    public function setTipo(TipoOperacion $tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setCantidad(float $cantidad) {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function setFecha(DateTime $fecha) {
        $this->fecha = $fecha;
        return $this;
    }
    
    public function setAsunto(string $asunto) {
        $this->asunto = $asunto;
        return $this;
    }
    
    public function __toString() {
        return ("Operación: {$this->getTipo()->name} Cantidad: {$this->getCantidad()} Fecha: {$this->getFecha()->format('Y-m-d H:i:s')} Asunto: {$this->getAsunto()}");
    }
}
