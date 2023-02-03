<?php

require '../src/CuentaBanco.php';

$cuenta1 = new CuentaBanco(uniqid(), 150);

$cuenta2 = new CuentaBanco(uniqid(), 300);

$cuenta1->ingreso(10);

$cuenta2->retirada(50);

echo "La cuenta ", $cuenta1->getId(), " tiene un saldo de ", $cuenta1->getSaldo(), "</br>";
echo "La cuenta ", $cuenta2->getId(), " tiene un saldo de ", $cuenta2->getSaldo();
