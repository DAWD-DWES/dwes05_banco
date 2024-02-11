<?php

require_once "TipoOperacion.php";

/**
 * Clase Operacion
 */
class Operacion {

    /**
     * Tipo de la Operación
     * @var TipoOperacion
     */
    private TipoOperacion $tipo;
    /**
     * Cantidad de dinero
     * @var float
     */
    private float $cantidad;
    /**
     * Fecha y hora en la que se ha realizado la operación
     * @var DateTime
     */
    private DateTime $fecha;
    /**
     * Descripción de la operación
     * @var string
     */
    private string $descripcion;

    public function __construct($tipo, $cantidad, $descripcion) {
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
        $this->setFecha(new DateTime());
        $this->setDescripcion($descripcion);
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

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    private function setTipo(TipoOperacion $tipo) {
        $this->tipo = $tipo;
    }

    public function setCantidad(float $cantidad) {
        $this->cantidad = $cantidad;
    }

    private function setFecha(DateTime $fecha) {
        $this->fecha = $fecha;
    }

    public function setDescripcion(string $descripcion) {
        $this->descripcion = $descripcion;
    }

    public function __toString() {
        return ("{$this->getTipo()->name} Cantidad: {$this->getCantidad()} Fecha: {$this->getFecha()->format('Y-m-d H:i:s')} Descripción: {$this->getDescripcion()}");
    }
}
