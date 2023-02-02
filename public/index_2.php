<?php

require '../src/BancoSolidario.php';

$banco = new BancoSolidario();
$cuentaId = $banco->abrirCuenta(500);
$resIngreso = $banco->realizarIngreso($cuentaId, 100);
$resRetirada = $banco->realizarRetirada($cuentaId, 300);
$saldo = $banco->consultarSaldo($cuentaId);
echo ($saldo);