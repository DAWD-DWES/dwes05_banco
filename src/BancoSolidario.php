<?php

require "Banco.php";
require "CuentaBanco.php";

class BancoSolidario implements Banco {

    private $cuentas = [];

    public function abrirCuenta($saldo) {
        $cuentaId = uniqid();
        $cuenta = new CuentaBanco($cuentaId, $saldo);
        $this->anadeCuenta($cuenta);
        return $cuentaId;
    }

    public function cerrarCuenta($cuentaId) {
        $existeCuenta = $this->existeCuenta($cuentaId);
        if ($existeCuenta) {
            $this->eliminaCuenta($cuentaId);
        }
        return $existeCuenta;
    }

    public function realizarIngreso($cuentaId, $cantidad) {
        return ($this->existeCuenta($cuentaId) ?
                $this->getCuenta($cuentaId)->ingreso($cantidad) : null);
    }

    public function realizarRetirada($cuentaId, $cantidad) {
        return ($this->existeCuenta($cuentaId) ?
                $this->getCuenta($cuentaId)->retirada($cantidad) : null);
    }

    public function consultarSaldo($cuentaId) {
        return ($this->existeCuenta($cuentaId) ?
                $this->getCuenta($cuentaId)->getSaldo() : null);
    }

    public function getCuentas() {
        return $this->cuentas;
    }

    private function anadeCuenta($cuenta) {
        $this->cuentas[$cuenta->getNumero()] = $cuenta;
    }

    private function eliminaCuenta($cuentaId) {
        unset($this->cuentas[$cuentaId]);
    }

    private function existeCuenta($cuentaId) {
        return (isset($this->getCuentas()[$cuentaId]));
    }

    private function getCuenta($cuentaId) {
        return ($this->cuentas[$cuentaId]);
    }

}
