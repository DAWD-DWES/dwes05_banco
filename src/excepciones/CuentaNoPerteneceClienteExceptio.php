<?php

namespace App\excepciones;

use Exception;

class CuentaNoEncontradaException extends Exception {

    private $dni;
    private $idCuenta;

    public function __construct(string $dni, string $idCuenta) {
        $this->dni = $dni;
        $this->idCuenta = $idCuenta;

        $message = "La cuenta $idCuenta no pertenece al cliente con dni $dni";
        parent::__construct($message);
    }

    public function getIdCuenta() {
        return $this->idCuenta;
    }

    public function getdni() {
        return $this->dni;
    }
}
