<?php

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';
require_once '../src/cargadatos.php';

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
if (filter_has_var(INPUT_POST, 'creardatos')) {
    cargaDatos($banco);
    echo $blade->run('principal');
} else {
    if ($clienteDAO->numeroClientes() == 0) {
        echo $blade->run('carga_datos');
    } elseif (filter_has_var(INPUT_POST, 'creardatos')) {
        cargaDatos($banco);
        echo $blade->run('principal');
    } elseif (filter_has_var(INPUT_POST, 'infocliente')) {
        $dni = filter_input(INPUT_POST, 'dnicliente');
        $cliente = $banco->obtenerCliente($dni);
        $cuentas = array_map(fn($idCuenta) => $cuentaDAO->obtenerPorId($idCuenta), $cliente->getIdCuentas());
        echo $blade->run('datos_cliente', compact('cliente', 'cuentas'));
    } elseif (filter_has_var(INPUT_GET, 'pettransferencia')) {
        echo $blade->run('transferencia');
    } else {
        echo $blade->run('principal');
    }
}