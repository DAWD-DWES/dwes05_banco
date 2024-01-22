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
        $banco->altaCuentaCliente($datosCliente['dni'], rand(0, 500));
    }
}

// Mostrar las cuentas y saldos del primer cliente
$clientes = $banco->getClientes();

$primerCliente = reset($clientes);
$cuentas = $primerCliente->getCuentas();
// Imprime los ID de cuenta y saldos del primer cliente
foreach ($cuentas as $idCuenta) {
    $cuenta = $banco->obtenerCuenta($idCuenta);
    echo "ID de Cuenta: " . $cuenta->getId() . ", Saldo: " . $cuenta->getSaldo() . "€\n" . "</br>";
}



// En este punto, el banco tiene 3 clientes, cada uno con 3 cuentas bancarias.


// 
