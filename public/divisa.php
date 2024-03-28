<?php

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';

use App\modelo\{
    GestorDivisasSOAP
};
use eftec\bladeone\BladeOne;

// Inicializa el acceso a las variables de entorno


$vistas = __DIR__ . '/../vistas';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($vistas, $cache, BladeOne::MODE_DEBUG);
$blade->setBaseURL("http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}/");

$gestorDivisas = new GestorDivisasSOAP();


if (filter_has_var(INPUT_GET, 'petconsultadivisa')) {
    $divisas = $gestorDivisas->listaDivisasDisponibles();
    echo $blade->run('consulta_divisa', compact('divisas'));
} elseif (filter_has_var(INPUT_POST, 'consultadivisa')) {
    $consultaDivisa = true;
    $divisaOrigen = filter_input(INPUT_POST, 'divisaorigen');
    $divisaDestino = filter_input(INPUT_POST, 'divisadestino');
    $fechaInicial = filter_input(INPUT_POST, 'fechainicial');
    $fechaFinal = filter_input(INPUT_POST, 'fechafinal');
    $divisas = $gestorDivisas->listaDivisasDisponibles();
    $divisaOrigenNombre = array_filter($divisas, function ($variable) use ($divisaOrigen) {
        return ($variable->getMoneda() === $divisaOrigen);
    });
    $divisaDestinoNombre = array_filter($divisas, function ($variable) use ($divisaOrigen) {
        return ($variable->getMoneda() === $divisaOrigen);
    });
    $cambios = $gestorDivisas->consultarCambioDivisa($divisaOrigen, $divisaDestino, $fechaInicial, $fechaFinal);
    echo $blade->run('consulta_divisa', compact('divisaOrigen', 'divisaDestino', 'fechaInicial', 'fechaFinal', 'divisas', 'cambios', 'consultaDivisa'));
} else {
    echo $blade->run('principal');
}


