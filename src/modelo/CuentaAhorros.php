<?php

namespace App\modelo;

use App\modelo\Cuenta;
use App\dao\OperacionDAO;

/**
 * Clase CuentaAhorros 
 */
class CuentaAhorros extends Cuenta implements IProductoBancario {

    public function __construct(OperacionDAO $operacionDAO, TipoCuenta $tipo, string $idCliente) {
        parent::__construct($operacionDAO, $tipo, $idCliente);
    }

    public function aplicaInteres(float $interes): void {
        $intereses = $this->getSaldo() * $interes / 100;
        $this->ingreso($intereses, "Intereses a tu favor.");
    }
}
