<?php

namespace App\excepciones;

use Exception;

class CuentaNoEncontradaException extends Exception {

    private $idCuenta;

    public function __construct(string $idCuenta) {
        $this->idCuenta = $idCuenta;

        $message = "La cuenta $idCuenta no existe.";
        parent::__construct($message);
    }

    public function getIdCuenta() {
        return $this->idCuenta;
    }
}
