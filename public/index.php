<?php

require_once '../src/modelo/Banco.php';
require_once '../src/modelo/Cliente.php';
require_once '../src/modelo/Cuenta.php';

$banco = new Banco("Molocos");

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
        $idCuenta = $banco->altaCuentaCliente($datosCliente['dni'], rand(0, 100));
        // Realizar tres operaciones de ingreso en las cada cuenta
        for ($i = 0; $i < 3; $i++) {
            $cantidad = rand(0, 500);
            $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
        }
    }
}

// Mostrar las cuentas y saldos de las cuentas de los clientes
$clientes = $banco->getClientes();
foreach ($clientes as $dniCliente => $cliente) {
    echo "Datos del cliente con DNI: $dniCliente </br>";
    $idCuentas = $cliente->getCuentas();
    foreach ($idCuentas as $idCuenta) {
        echo "Datos de la cuenta: $idCuenta </br>";
        $cuenta = $banco->obtenerCuenta($idCuenta);
        $operaciones = $cuenta->getOperaciones();
        foreach ($operaciones as $clave => $operacion) {
            echo $operacion . "</br>";
        }
    }
}
