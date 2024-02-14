<?php

require_once "TipoOperacion.php";

/**
 * Clase Operacion
 */
class Operacion {

    private int $id;
    private int $idCuenta;
    private TipoOperacion $tipo;
    private float $cantidad;
    private $fecha;
    private string $descripcion;

    public function __construct($idCuenta, $tipo, $cantidad, $descripcion) {
        $this->setIdCuenta($idCuenta);
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
    
     public function getIdCuenta(): int {
        return $this->idCuenta;
    }

    public function setTipo(TipoOperacion $tipo) {
        $this->tipo = $tipo;
    }

    public function setCantidad(float $cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setFecha(DateTime $fecha) {
        $this->fecha = $fecha;
    }
    
     public function setDescripcion(string $descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function setIdCuenta(int $idCuenta) {
        $this->idCuenta = $idCuenta;
    }
    
    public function __toString() {
        return ("{$this->getTipo()->name} Cantidad: {$this->getCantidad()} Fecha: {$this->getFecha()->format('Y-m-d H:i:s')} Descripción: {$this->getDescripcion()}");
    }
}
