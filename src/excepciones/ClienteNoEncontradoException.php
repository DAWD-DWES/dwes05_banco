<?php

namespace App\excepciones;

use Exception;

class ClienteNoEncontradoException extends Exception {

    private $idCliente;

    public function __construct(string $idCliente) {
        $this->idCliente = $idCliente;

        $message = "El cliente $idCliente no existe.";
        parent::__construct($message);
    }

    public function getIdCliente() {
        return $this->idCliente;
    }
}
