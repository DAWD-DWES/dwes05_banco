<?php

namespace App\modelo;

use App\modelo\Cuenta;
use App\dao\OperacionDAO;

/**
 * Clase CuentaCorriente 
 */
class CuentaCorriente extends Cuenta implements IProductoBancario {

    public function __construct(OperacionDAO $operacionDAO, TipoCuenta $tipo, string $idCliente) {
        parent::__construct($operacionDAO, $tipo, $idCliente);
    }

    public function aplicaComision($comision, $minSaldo): void {
        if ($this->getSaldo() < $minSaldo) {
            $this->debito($comision, "Cargo de comisión de mantenimiento");
        }
    }
}
