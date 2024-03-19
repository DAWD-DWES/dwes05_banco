<?php

require '../vendor/autoload.php';
$uri = "http://localhost/dwes06_tarea/servidorSoap";
$parametros = ['uri' => $uri];

use App\Operaciones;

try {
    $server = new SoapServer(NULL, $parametros);
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    error_log("error en server: " . $f->getMessage());
}
