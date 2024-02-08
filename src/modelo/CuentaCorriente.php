<?php

require_once "IProductoBancario.php";
require_once "Cuenta.php";

/**
 * Clase CuentaCorriente 
 */
class CuentaCorriente extends Cuenta implements IProductoBancario {

    public function __construct(string $idCliente, float $saldo = 0) {
        parent::__construct($idCliente, $saldo);
    }

    public function aplicaComision($comision, $minSaldo): void {
        if ($this->getSaldo() < $minSaldo) {
            $this->debito($comision, "Cargo de comisión de mantenimiento");
        }
    }
}