<?php

require_once '../src/modelo/IProductoBancario.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/dao/OperacionDAO.php';

/**
 * Clase CuentaAhorros 
 */
class CuentaAhorros extends Cuenta implements IProductoBancario {

    public function __construct(OperacionDAO $operacionDAO, TipoCuenta $tipo, string $idCliente, float $saldo = 0) {
        parent::__construct($operacionDAO, $tipo, $idCliente, $saldo);
    }

    public function aplicaInteres(float $interes): void {
        $intereses = $this->getSaldo() * $interes / 100;
        $this->ingreso($intereses, "Intereses a tu favor.");
    }
}
