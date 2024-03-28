<?php

$url = "http://localhost/servidorSoap/calculohipoteca.wsdl";

require_once 'src\CalculoHipoteca.php';

try {
    $server = new SoapServer($url);
    $server->setClass(CalculoHipoteca::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}
