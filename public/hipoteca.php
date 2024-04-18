<?php

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';

use App\modelo\{
    GestorHipotecasSOAP
};
use eftec\bladeone\BladeOne;

// Inicializa el acceso a las variables de entorno


$vistas = __DIR__ . '/../vistas';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($vistas, $cache, BladeOne::MODE_DEBUG);
$blade->setBaseURL("http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}/");

$gestorHipotecas = new GestorHipotecasSOAP();

if (filter_has_var(INPUT_GET, 'petconsultahipoteca')) {
    echo $blade->run('consulta_hipoteca');
} elseif (filter_has_var(INPUT_POST, 'consultacuota')) {
    $consultaCuota = true;
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_UNSAFE_RAW);
    $anyos = filter_input(INPUT_POST, 'anyos', FILTER_UNSAFE_RAW);
    $tasaInteres = filter_input(INPUT_POST, 'tasainteres', FILTER_UNSAFE_RAW);

    $cuota = round($gestorHipotecas->calculoCuota($cantidad, $anyos, $tasaInteres));
    echo json_encode(['cuota' => round($cuota, 2)]);
} else {
    echo json_encode(['error' => 'Información insuficiente para calcular la cuota.']);
}

