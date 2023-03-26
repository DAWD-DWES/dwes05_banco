<?php

/*
 * @author daw-profesor daw-profesor@daw.es
 * @copyright 2023 Equipo Daw Distancia
 * @link https://elbanco.com Documentación de condiciones de uso del banco. 
 */

require '../src/CuentaBanco.php';

$cuenta1 = new CuentaBanco(150);

$cuenta2 = new CuentaBanco(300);

$cuenta1->ingreso(10);

try {
    $cuenta2->retirada(50);
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

echo "La cuenta ", $cuenta1->getId(), " tiene un saldo de ", $cuenta1->getSaldo(), "</br>";
echo "La cuenta ", $cuenta2->getId(), " tiene un saldo de ", $cuenta2->getSaldo();
