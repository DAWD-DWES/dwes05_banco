<?php
interface Banco {
    public function abrirCuentaAhorros($saldo);
    public function cerrarCuentaAhorros($cuentaId);
    public function realizarIngreso($cuentaId, $cantidad);
    public function realizarRetirada($cuentaId, $cantidad);
    public function consultarSaldo($cuentaId);
}

