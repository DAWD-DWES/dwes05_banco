<?php


/**
 * Clase CuentaCorriente 
 */
class CuentaCorriente extends Cuenta{

    private static float $comisionCC = 0;
    
    public function __construct(string $idCliente, float $saldo = 0) {
        parent::__construct($idCliente, $saldo);
    }

    public function aplicaComision($comisionCC): void {
        if ($this->getSaldo() < 400) {
            $this->debito(self::$comisionCC, "Cargo de comisión de mantenimiento");
        }
    }
}
