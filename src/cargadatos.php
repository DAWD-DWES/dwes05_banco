<?php

use App\modelo\TipoCuenta;
use App\modelo\TipoOperacion;
use Faker\Factory;

function cargaDatos($banco) {
    $faker = Factory::create('es_ES');
    $datosClientes = array_map(fn($x) => ['dni' => $faker->dni(),
        'nombre' => $faker->firstName('male' | 'female'),
        'apellido1' => $faker->lastName(),
        'apellido2' => $faker->lastName(),
        'telefono' => $faker->mobileNumber(),
        'fechaNacimiento' => $faker->date('Y-m-d')], range(0, 9));

    foreach ($datosClientes as $datosCliente) {
        $banco->altaCliente($datosCliente['dni'], $datosCliente['nombre'], $datosCliente['apellido1'], $datosCliente['apellido2'], $datosCliente['telefono'], $datosCliente['fechaNacimiento']);
        // Crear cuentas bancarias para cada cliente
        $numCuentas = rand(1, 3);
        for ($numCuentas = 0; $numCuentas < 3; $numCuentas++) {
            $tipoCuenta = rand(0, 1) ? TipoCuenta::CORRIENTE : TipoCuenta::AHORROS;
            $idCuenta = $banco->altaCuentaCliente($datosCliente['dni'], $tipoCuenta);
            $cantidad = rand(0, 500);
            $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
            // Realizar operaciones de ingreso en las cada cuenta
            $numOperaciones = rand(1, 3);
            for ($numOperaciones = 0; $numOperaciones < 3; $numOperaciones++) {
                $tipoOperacion = rand(0, 1) ? TipoOperacion::INGRESO : TipoOperacion::DEBITO;
                $cantidad = rand(0, 500);
                try {
                    if ($tipoOperacion === TipoOperacion::INGRESO) {
                        $banco->ingresoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Ingreso de $cantidad € en la cuenta");
                    } else {
                        $banco->debitoCuentaCliente($datosCliente['dni'], $idCuenta, $cantidad, "Retirada de $cantidad € en la cuenta");
                    }
                } catch (Exception) {
                    
                }
            }
        }
    }
    try {
        $banco->aplicaComisionCC();
        $banco->aplicaInteresCA();
    } catch (Exception) {
        
    }
    $clientes = $banco->obtenerClientes();
    $dniCliente1 = $clientes[rand(0, count($clientes))]->getDni();
    $dniCliente2 = $clientes[rand(0, count($clientes))]->getDni();
    try {
        $banco->realizaTransferencia($dniCliente1, $dniCliente2, ($banco->obtenerCliente($dniCliente1)->getIdCuentas())[0], ($banco->obtenerCliente($dniCliente2)->getIdCuentas())[0], 500);
    } catch (Exception) {
        
    }
}
