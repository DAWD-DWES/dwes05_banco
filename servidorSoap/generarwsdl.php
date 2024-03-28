<?php
require '../vendor/autoload.php';

use PHP2WSDL\PHPClass2WSDL;
use ServicioHipoteca\CalculoHipoteca;

$uri = 'http://localhost/dwes05_banco/servidorSoap/servidor.php';

$calculoHipoteca = new CalculoHipoteca();
$wsdlGenerator = new PHPClass2WSDL(ServicioHipoteca\CalculoHipoteca::class, $uri);
$wsdlGenerator->generateWSDL(true);
$fichero = $wsdlGenerator->save('calculohipoteca.wsdl');