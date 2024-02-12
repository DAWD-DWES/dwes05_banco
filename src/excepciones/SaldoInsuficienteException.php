<?php

class SaldoInsuficienteException extends Exception {

    private $idCuenta;

    public function __construct(string $idCuenta, float $cantidad) {
        $this->idCuenta = $idCuenta;

        $message = "No hay suficiente saldo en la cuenta $idCuenta para extraer $cantidad €";
        parent::__construct($message);
    }
}
