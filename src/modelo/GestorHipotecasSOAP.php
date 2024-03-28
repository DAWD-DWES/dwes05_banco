<?php

namespace App\modelo;

use SoapClient;
use Hipoteca\CalculoHipoteca;

/**
 * Clase GestorDivisasSOAP
 */
class GestorHipotecasSOAP {

    private SoapClient $servicioHipoteca;


    public function __construct() {
        $this->servicioHipoteca = new CalculoHipoteca();
    }

    public function calculoCuota(float $cantidad, int $anyos, float $tasaInteresAnual): float {
        $resul = $this->servicioHipoteca->calculoCuota($cantidad, $anyos, $tasaInteresAnual);
        return $resul;
    }
}
