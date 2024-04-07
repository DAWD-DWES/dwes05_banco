<?php

require_once '../src/error_handler.php';
require_once '../src/bd/BD.php';
require_once '../src/modelo/Banco.php';
require_once '../src/modelo/Cliente.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/modelo/TipoCuenta.php';

$pdo = BD::getConexion();

$operacionDAO = new OperacionDAO($pdo);
$cuentaDAO = new CuentaDAO($pdo, $operacionDAO);
$clienteDAO = new ClienteDAO($pdo, $cuentaDAO);

$banco = new Banco($clienteDAO, $cuentaDAO, $operacionDAO, "Midas");

$banco->setComisionCC(5);
$banco->setMinSaldoComisionCC(1000);
$banco->setInteresCA(2);

// Datos de clientes de ejemplo
$datosClientes = [
    ['dni' => '12345678A', 'nombre' => 'Juan', 'apellido1' => 'Pérez', 'apellido2' => 'López', 'telefono' => '123456789', 'fechaNacimiento' => '1980-01-01'],
    ['dni' => '23456789B', 'nombre' => 'Ana', 'apellido1' => 'García', 'apellido2' => 'Martín', 'telefono' => '987654321', 'fechaNacimiento' => '1985-02-02'],
    ['dni' => '34567890C', 'nombre' => 'Carlos', 'apellido1' => 'Fernández', 'apellido2' => 'González', 'telefono' => '112233445', 'fechaNacimiento' => '1990-03-03']
];

// Crear tres clientes y agregar tres cuentas a cada uno
foreach ($datosClientes as $datosCliente) {
    $banco->altaCliente($datosCliente['dni'], $datosCliente['nombre'], $datosCliente['apellido1'], $datosCliente['apellido2'], $datosCliente['telefono'], $datosCliente['fechaNacimiento']);
    // Crear tres cuentas bancarias para cada cliente
    for ($i = 0; $i < 3; $i++) {
        $tipoCuenta = rand(0, 1) ? TipoCuenta::CORRIENTE : TipoCuenta::AHORROS;
        $idCuenta = $banco->altaCuentaCliente($datosCliente['dni'], $tipoCuenta);
        $cantidad = rand(0, 500);
        $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
        // Realizar tres operaciones de ingreso en las cada cuenta
        for ($j = 0; $j < 3; $j++) {
            $tipoOperacion = rand(0, 1) ? TipoOperacion::INGRESO : TipoOperacion::DEBITO;
            $cantidad = rand(0, 500);
            try {
                if ($tipoOperacion === TipoOperacion::INGRESO) {
                    $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
                } else {
                    $banco->debitoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Retirada de $cantidad € en la cuenta");
                }
            } catch (SaldoInsuficienteException $ex) {
                echo $ex->getMessage() . "</br>";
            }
        }
    }
}

try {
    $banco->aplicaComisionCC();

    $banco->aplicaInteresCA();
} catch (SaldoInsuficienteException $ex) {
    echo $ex->getMessage() . "</br>";
}

 try {
    $banco->realizaTransferencia('12345678A', '23456789B', ($banco->obtenerCliente('12345678A')->getIdCuentas())[1], ($banco->obtenerCliente('23456789B')->getIdCuentas())[0], 250);
} catch (SaldoInsuficienteException $ex) {
    echo $ex->getMessage();
}



// Mostrar las cuentas y saldos de las cuentas de los clientes
echo "<h1>Clientes y cuentas del banco</h1>";

$clientes = $banco->obtenerClientes();
foreach ($clientes as $dniCliente => $cliente) {
    echo "Datos del cliente con DNI: {$cliente->getDni()} </br>";
    $idCuentas = $cliente->getIdCuentas();
    foreach ($idCuentas as $idCuenta) {
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo "</br>$cuenta </br>";
    }
    echo "</br>";
}

$banco->bajaCuentaCliente('12345678A', ($banco->obtenerCliente('12345678A')->getIdCuentas())[0]);
$banco->bajaCliente('34567890C');


// Mostrar las cuentas y saldos de las cuentas de los clientes despues de la baja
echo "<h1>Clientes y cuentas del banco (baja de una cuenta y un cliente)</h1>";
$clientes = $banco->obtenerClientes();
foreach ($clientes as $dniCliente => $cliente) {
    echo "</br> Datos del cliente con DNI: {$cliente->getDni()} </br>";
    $idCuentas = $cliente->getIdCuentas();
    foreach ($idCuentas as $idCuenta) {
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo "</br>$cuenta</br>";
    }
}
