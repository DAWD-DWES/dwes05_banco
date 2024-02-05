<?php

class SaldoInsuficienteException extends Exception {

    private $idCuenta;

    public function __construct(string $idCuenta) {
        $this->idCuenta = $idCuenta;

        $message = "No hay suficiente saldo en la cuenta $idCuenta";
        parent::__construct($message);
    }
}
