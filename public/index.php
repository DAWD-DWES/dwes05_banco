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
};
use TipoCambio\{
    TipoCambio,
    VariablesDisponibles
};
use eftec\bladeone\BladeOne;

$vistas = __DIR__ . '/../vistas';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($vistas, $cache, BladeOne::MODE_DEBUG);
$blade->setBaseURL("http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}/");

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
    } elseif (filter_has_var(INPUT_POST, 'infocliente')) {
        $dni = filter_input(INPUT_POST, 'dnicliente');
        $cliente = $banco->obtenerCliente($dni);
        $cuentas = array_map(fn($idCuenta) => $cuentaDAO->obtenerPorId($idCuenta), $cliente->getIdCuentas());
        echo $blade->run('datos_cliente', compact('cliente', 'cuentas'));
    } elseif (filter_has_var(INPUT_POST, 'infocuenta')) {
        $idCuenta = filter_input(INPUT_POST, 'idcuenta');
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo $blade->run('datos_cuenta', compact('cuenta'));
    } elseif (filter_has_var(INPUT_GET, 'pettransferencia')) {
        echo $blade->run('transferencia');
    } elseif (filter_has_var(INPUT_POST, 'transferencia')) {
        try {
            $dniClienteOrigen = filter_input(INPUT_POST, 'dniclienteorigen', FILTER_UNSAFE_RAW);
            $idCuentaOrigen = (int) filter_input(INPUT_POST, 'idcuentaorigen', FILTER_UNSAFE_RAW);
            $dniClienteDestino = filter_input(INPUT_POST, 'dniclientedestino', FILTER_UNSAFE_RAW);
            $idCuentaDestino = (int) filter_input(INPUT_POST, 'idcuentadestino', FILTER_UNSAFE_RAW);
            $cantidad = (float) filter_input(INPUT_POST, 'cantidad', FILTER_UNSAFE_RAW);
            $asunto = filter_input(INPUT_POST, 'asunto', FILTER_UNSAFE_RAW);
            $banco->realizaTransferencia($dniClienteOrigen, $dniClienteDestino, $idCuentaOrigen, $idCuentaDestino, $cantidad, $asunto);
            $message = "Transferencia realizada con éxito";
        } catch (Exception $ex) {
            $message = $ex->getMessage();
        }
        echo $blade->run('transferencia', compact('message', 'dniClienteOrigen', 'idCuentaOrigen',
                        'dniClienteDestino', 'idCuentaDestino', 'cantidad', 'asunto'));
    } elseif (filter_has_var(INPUT_GET, 'movimientos')) {
        $idCuenta = filter_input(INPUT_GET, 'idCuenta');
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo $blade->run('datos_cuenta', compact('cuenta'));
    } elseif (filter_has_var(INPUT_GET, 'petconsultadivisa')) {
        $servTipoCambio = new TipoCambio();
        $divisas = $servTipoCambio->VariablesDisponibles(new VariablesDisponibles());
        echo $blade->run('consulta_divisa', compact('divisas'));
    } else {
        echo $blade->run('principal');
    }
}