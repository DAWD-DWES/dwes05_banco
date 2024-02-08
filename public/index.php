<?php

require_once '../src/modelo/Banco.php';
require_once '../src/modelo/Cliente.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/modelo/TipoCuenta.php';

$banco = new Banco("Molocos");

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
        $idCuenta = $banco->altaCuentaCliente($datosCliente['dni'], rand(0, 100), $tipoCuenta);
        // Realizar tres operaciones de ingreso en las cada cuenta
        for ($i = 0; $i < 3; $i++) {
            $cantidad = rand(0, 500);
            $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
        }
    }
}

$banco->aplicaComisionCC();

$banco->aplicaInteresCA();

try {
    $banco->realizaTransferencia('12345678A', '23456789B', ($banco->obtenerCliente('12345678A')->getIdCuentas())[1], ($banco->obtenerCliente('23456789B')->getIdCuentas())[0], 500);
} catch (SaldoInsuficienteException $ex) {
    echo $ex->getMessage();
}

// Mostrar las cuentas y saldos de las cuentas de los clientes
$clientes = $banco->obtenerClientes();
foreach ($clientes as $dniCliente => $cliente) {
    echo "Datos del cliente con DNI: $dniCliente </br>";
    $idCuentas = $cliente->getIdCuentas();
    foreach ($idCuentas as $idCuenta) {
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo "</br>$cuenta </br>";
    }
}

$banco->bajaCuentaCliente('12345678A', ($banco->obtenerCliente('12345678A')->getIdCuentas())[0]);
$banco->bajaCliente('34567890C');

// Mostrar las cuentas y saldos de las cuentas de los clientes
$clientes = $banco->obtenerClientes();
foreach ($clientes as $dniCliente => $cliente) {
    echo "</br> Datos del cliente con DNI: $dniCliente</br>";
    $idCuentas = $cliente->getIdCuentas();
    foreach ($idCuentas as $idCuenta) {
        $cuenta = $banco->obtenerCuenta($idCuenta);
        echo "</br>$cuenta </br>";
    }
}