<?php
require '../../vendor/autoload.php';

use PHP2WSDL\PHPClass2WSDL;
use ServicioCalculadora\Operaciones;

$uri = 'http://localhost/dwes05_banco/servidorSoap/servidor.php';

$operaciones = new Operaciones();
$wsdlGenerator = new PHPClass2WSDL(ServicioCalculadora\Operaciones::class, $uri);
$wsdlGenerator->generateWSDL(true);
$fichero = $wsdlGenerator->save('operaciones.wsdl');