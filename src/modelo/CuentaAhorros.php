<?php

require_once "Cuenta.php";

/**
 * Clase CuentaAhorros 
 */
class CuentaAhorros extends Cuenta {

    public function __construct(string $idCliente, float $saldo = 0) {
        parent::__construct($idCliente, $saldo);
    }

    public function aplicaInteres(float $interes): void {
        $intereses = $this->getSaldo() * $interes / 100;
        $this->ingreso($intereses, "Intereses a tu favor.");
    }
}
