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

    public function __construct($idCuenta, $tipo, $cantidad, $asunto) {
        $this->setIdCuenta($idCuenta);
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
    
    public function getDescripcion(): string {
        return $this->descripcion;
    }
    
     public function getIdCuenta(): int {
        return $this->idCuenta;
    }

    public function setTipo(TipoOperacion $tipo): Operacion {
        $this->tipo = $tipo;
        return $this;
    }

    public function setCantidad(float $cantidad): Operacion {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function setFecha(DateTime $fecha): Operacion {
        $this->fecha = $fecha;
        return $this;
    }
    
     public function setDescripcion($descripcion): Operacion {
        $this->asunto = $descripcion;
        return $this;
    }
    
    public function __toString() {
        return ("{$this->getTipo()->name} Cantidad: {$this->getCantidad()} Fecha: {$this->getFecha()->format('Y-m-d H:i:s')} Descripción: {$this->getDescripcion()}");
    }
}
