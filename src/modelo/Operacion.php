<?php

namespace App\modelo;

use DateTime;

/**
 * Clase Operacion
 */
class Operacion {

    private int $id;
    private int $idCuenta;
    private $tipo;
    private float $cantidad;
    private $fecha;
    private string $descripcion;

    public function __construct($idCuenta = '', $tipo = null, $cantidad = 0, $descripcion = '') {
        if (func_num_args() > 0) {
            $this->setIdCuenta($idCuenta);
            $this->setTipo($tipo);
            $this->setCantidad($cantidad);
            $this->setFecha(new DateTime());
            $this->setDescripcion($descripcion);
        }
        /* else {
          if (is_string($this->tipo)) {
          $this->fechaNacimiento = new DateTime($this->fechaNacimiento);
          }
          } */
    }

    public function getId(): int {
        return $this->id;
    }

    // Cuidado con el tipo

    public function getTipo() {
        return $this->tipo;
    }

    public function getCantidad(): float {
        return $this->cantidad;
    }

    // Cuidado tipo
    public function getFecha() {
        return $this->fecha;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function getIdCuenta(): int {
        return $this->idCuenta;
    }

    public function setId(int $id) {
        $this->id = $id;
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
