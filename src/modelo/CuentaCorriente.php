<?php

require_once '../src/modelo/IProductoBancario.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/dao/OperacionDAO.php';

/**
 * Clase CuentaCorriente 
 */
class CuentaCorriente extends Cuenta implements IProductoBancario {

    public function __construct(OperacionDAO $operacionDAO, TipoCuenta $tipo, string $idCliente, float $saldo = 0) {
        parent::__construct($operacionDAO, $tipo, $idCliente, $saldo);
    }

    public function aplicaComision($comision, $minSaldo): void {
        if ($this->getSaldo() < $minSaldo) {
            $this->debito($comision, "Cargo de comisión de mantenimiento");
        }
    }
}
