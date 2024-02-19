<?php

namespace App\modelo;

use App\modelo\IProductoBancario;

/**
 * Clase Cuenta 
 */
class TarjetaCredito implements IProductoBancario {

    /**
     * Número de tarjeta
     * @var string
     */
    private string $numero;

    /**
     * limite de la tarjeta
     * @var float
     */
    private float $limite;

    /**
     * Id Cuenta asociada
     * @var string idCuenta
     */
    private string $idCuenta;

    /**
     * Id del cliente de la tarjeta
     * @var string dni
     */
    public function __construct(float $limite) {
        $this->setnumero(sprintf('%04d', mt_rand(0, 9999)) . " " . sprintf('%04d', mt_rand(0, 9999)) . " " . sprintf('%04d', mt_rand(0, 9999)) . " " . sprintf('%04d', mt_rand(0, 9999)));
        $this->setLimite($limite);
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getPin(): string {
        return $this->pin;
    }

    public function getLimite(): float {
        return $this->limite;
    }

    public function getIdCuenta(): string {
        return $this->idCuenta;
    }

    public function setNumero(string $numero): void {
        $this->numero = $numero;
    }

    public function setPin(string $pin): void {
        $this->pin = $pin;
    }

    public function setLimite(float $limite): void {
        $this->limite = $limite;
    }

    public function setIdCuenta(string $idCuenta): void {
        $this->idCuenta = $idCuenta;
    }

    /**
     * Ingreso de una cantidad en una tarjeta
     * @param type $cantidad Cantidad de dinero
     * @param type $descripcion Descripción del ingreso
     */
    public function ingreso(float $cantidad, string $descripcion): void {
        if ($cantidad > 0) {
            $this->setLimite($this->getLimite() + $cantidad);
        }
    }

    /**
     * 
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    public function debito(float $cantidad, string $descripcion): void {
        if ($cantidad <= $this->limite()) {
            $this->setLimite($this->getLimite() - $cantidad);
        } else {
            throw new LimiteTarjetaSuperadoException($this->getNumero());
        }
    }

    public function __toString() {
        return "Num Tarjeta: {$this->getNumero()}</br>" .
                "Limite: {$this->getLimite()}</br>";
    }
}
