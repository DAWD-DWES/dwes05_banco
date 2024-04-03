<?php

namespace App\modelo;

use SoapClient;
use Hipoteca\CalculoHipotecaService;

/**
 * Clase GestorDivisasSOAP
 */
class GestorHipotecasSOAP {

    private SoapClient $servicioHipoteca;


    public function __construct() {
        $this->servicioHipoteca = new CalculoHipotecaService();
    }

    public function calculoCuota(float $cantidad, int $anyos, float $tasaInteresAnual): float {
        $resul = $this->servicioHipoteca->calculoCuota($cantidad, $anyos, $tasaInteresAnual);
        return $resul;
    }
}
