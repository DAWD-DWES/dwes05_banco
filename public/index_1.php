<?php

require '../src/CuentaAhorros.php';

$cuenta1 = new CuentaAhorros(1002, 150, 0.2);

$cuenta2 = new CuentaAhorros(1003, 350, 0.1);

$cuenta1->sumaInteres();

$cuenta2->sumaInteres();

echo "La cuenta ", $cuenta1->getNumero(), " tiene un saldo de ", $cuenta1->getSaldo(), "</br>";
echo "La cuenta ", $cuenta2->getNumero(), " tiene un saldo de ", $cuenta2->getSaldo();
