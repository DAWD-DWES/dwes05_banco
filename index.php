<?php

require 'CuentaBanco.php';

$cuenta1 = new CuentaBanco (1000, 150);

$cuenta2 = new CuentaBanco (1001, 300);

$cuenta1->ingreso (10);

$cuenta2->retirada (50);

echo "La cuenta ", $cuenta1->getNumero(), " tiene un saldo de ", $cuenta1->getSaldo(), "</br>";
echo "La cuenta ", $cuenta2->getNumero(), " tiene un saldo de ", $cuenta2->getSaldo();