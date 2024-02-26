<?php

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';

use App\bd\BD;
use App\dao\{
OperacionDAO,
 CuentaDAO,
 ClienteDAO
};
use App\modelo\{
Banco,
 Cliente,
 Cuenta
};
use App\modelo\TipoCuenta;
use App\modelo\TipoOperacion;
use App\excepciones\SaldoInsuficienteException;
use Faker\Factory;
use eftec\bladeone\BladeOne;

$vistas = __DIR__ . '/../vistas';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($vistas, $cache, BladeOne::MODE_DEBUG);



$pdo = BD::getConexion();

$operacionDAO = new OperacionDAO($pdo);
$cuentaDAO = new CuentaDAO($pdo, $operacionDAO);
$clienteDAO = new ClienteDAO($pdo, $cuentaDAO);

$banco = new Banco($clienteDAO, $cuentaDAO, $operacionDAO, "Molocos");

$banco->setComisionCC(5);
$banco->setMinSaldoComisionCC(1000);
$banco->setInteresCA(2);

if (input_filter(INPUT_POST, 'info_cliente')) {
    $dni = input_filter(INPUT_POST, 'dnicliente');
    $cliente = $banco->obtenerCliente($dni);
    $cuentas = $banco->obtenerCuentasCliente($dni);
    echo $blade->run('cliente', compact('cliente', 'cuentas'));
} else {
    echo $blade->run('principal');
}