<?php

namespace App\modelo;

/**
 * Clase Operacion
 */
class CambioDivisa {

    public function __construct(private int $divisaOrigen, private string $divisaOrigenNombre, private int $divisaDestino,
            private string $divisaDestinoNombre, private string $fecha, private float $compra, private float $venta) {
        
    }
    public function getDivisaOrigen(): int {
        return $this->divisaOrigen;
    }

    public function getDivisaOrigenNombre(): string {
        return $this->divisaOrigenNombre;
    }

    public function getDivisaDestino(): int {
        return $this->divisaDestino;
    }

    public function getDivisaDestinoNombre(): string {
        return $this->divisaDestinoNombre;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getCompra(): float {
        return $this->compra;
    }

    public function getVenta(): float {
        return $this->venta;
    }

    public function setDivisaOrigen(int $divisaOrigen): void {
        $this->divisaOrigen = $divisaOrigen;
    }

    public function setDivisaOrigenNombre(string $divisaOrigenNombre): void {
        $this->divisaOrigenNombre = $divisaOrigenNombre;
    }

    public function setDivisaDestino(int $divisaDestino): void {
        $this->divisaDestino = $divisaDestino;
    }

    public function setDivisaDestinoNombre(string $divisaDestinoNombre): void {
        $this->divisaDestinoNombre = $divisaDestinoNombre;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function setCompra(float $compra): void {
        $this->compra = $compra;
    }

    public function setVenta(float $venta): void {
        $this->venta = $venta;
    }


}
