<?php

class SaldoInsuficienteException extends Exception {

    public function __construct() {
        $message = "No hay suficiente saldo en la cuenta";
        parent::__construct($message);
    }
}
