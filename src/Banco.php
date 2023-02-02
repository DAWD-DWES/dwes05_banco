<?php
interface Banco {
    public function abrirCuenta($saldo);
    public function cerrarCuenta($cuentaId);
    public function realizarIngreso($cuentaId, $cantidad);
    public function realizarRetirada($cuentaId, $cantidad);
    public function consultarSaldo($cuentaId);
}

