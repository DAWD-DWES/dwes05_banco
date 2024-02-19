<?php

namespace App\excepciones;

use Exception;

class LimiteTarjetaSuperadoException extends Exception {

    private $numTarjeta;

    public function __construct(string $numTarjeta) {
        $this->numTarjeta = $numTarjeta;

        $message = "Limite de la tarjeta $numTarjeta superado";
        parent::__construct($message);
    }
}
