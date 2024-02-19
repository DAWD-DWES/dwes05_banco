<?php

namespace App\excepciones;

use Exception;

class SaldoInsuficienteException extends Exception {

    public function __construct() {
        $message = "No hay suficiente saldo en al cuenta";
        parent::__construct($message);
    }
}
