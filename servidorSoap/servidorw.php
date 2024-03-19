<?php

require '../vendor/autoload.php';
$url = "http://localhost/dwes06_tarea/servidorSoap/servicio.wsdl";

use Clases\Operaciones;

try {
    $server = new SoapServer($url);
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}
