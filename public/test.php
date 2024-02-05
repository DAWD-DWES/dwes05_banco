<?php

require "../src/bd/BD.php";
require "../src/modelo/Cliente.php";
require "../src/dao/ClienteDAO.php";

$bd = BD::getConexion();

$cliente = new Cliente('12345678O', 'Juan', 'Pérez', 'López', '123456789', '1980-01-01');
 $clienteDAO = new ClienteDAO($bd);
$clienteDAO->crear($cliente);

$cliente2 = $clienteDAO->obtenerPorId(2);

echo "done";
