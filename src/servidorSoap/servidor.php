<?php

require '../vendor/autoload.php';
$url = "http://localhost/dwes05_banco/servidorSoap/servicio.wsdl";

use ServicioCalculadora\Operaciones;

try {
    $server = new SoapServer($url);
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}
