<?php

use PHP2WSDL\PHPClass2WSDL;
require_once 'src\CalculoHipoteca.php';

$uri = 'http://localhost/servidorSoap/servidor.php';

$wsdlGenerator = new PHPClass2WSDL(CalculoHipoteca::class, $uri);
$wsdlGenerator->generateWSDL(true);
$fichero = $wsdlGenerator->save('calculohipoteca.wsdl');