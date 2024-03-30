<?php

namespace App\modelo;

use SoapClient;
use TipoCambio\{
    TipoCambio,
    VariablesDisponibles,
    TipoCambioRangoMoneda,
};
use DateTime;
use App\modelo\CambioDivisa;

/**
 * Clase GestorDivisasSOAP
 */
class GestorDivisasSOAP implements IGestorDivisas {

    private SoapClient $servicioDivisa;

    const DIVISAS_DESAPARACIDAS = [1, 4, 6, 8, 11, 12, 13, 14, 27, 28, 42];

    public function __construct() {
        $this->servicioDivisa = new TipoCambio();
    }

    public function listaDivisasDisponibles(): ?array {
        $variablesDisponiblesResponse = $this->servicioDivisa->VariablesDisponibles(new VariablesDisponibles());
        $divisas = array_filter($variablesDisponiblesResponse->getVariablesDisponiblesResult()->getVariables()->getVariable(),
                function ($divisa) {
                    return !in_array($divisa->getMoneda(), self::DIVISAS_DESAPARACIDAS);
                });
        return $divisas;
    }

    public function consultarCambioDivisa($divisaOrigen, $divisaDestino, $fechaIni, $fechaFin = null): ?array {
        $cambios = [];
        $fechaFinal = $fechaFin ? (new DateTime($fechaFin))->format('d/m/Y') : (new DateTime('hoy'))->format('d/m/Y');
        $fechaInicial = (new DateTime($fechaIni))->format('d/m/Y');
        $cambiosDivisaOrigen = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaOrigen))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $cambiosDivisaDestino = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaDestino))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $divisaOrigenNombre = current(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaOrigen) {
                    return ($variable->getMoneda() == $divisaOrigen);
                }))->getDescripcion();
        $divisaDestinoNombre = current(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaDestino) {
                    return ($variable->getMoneda() == $divisaDestino);
                }))->getDescripcion();
        $i = 0;
        $j = 0;
        while (isset($cambiosDivisaOrigen[$i]) && isset($cambiosDivisaDestino[$j])) {
            if (DateTime::createFromFormat('d/m/Y', $cambiosDivisaOrigen[$i]->getFecha()) < DateTime::createFromFormat('d/m/Y', $cambiosDivisaDestino[$j]->getFecha())) {
                $i++;
            } else if (DateTime::createFromFormat('d/m/Y', $cambiosDivisaOrigen[$i]->getFecha()) < DateTime::createFromFormat('d/m/Y', $cambiosDivisaDestino[$j]->getFecha())) {
                $j++;
            } else {
                if (($divisaOrigen == 2) && ($divisaDestino == 24)) {
                    $venta = $cambiosDivisaDestino[$j]->getVenta();
                    $compra = $cambiosDivisaDestino[$j]->getCompra();
                } elseif (($divisaOrigen == 24) && ($divisaDestino == 2)) {
                    $venta = 1 / $cambiosDivisaOrigen[$i]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$i]->getCompra();
                } elseif ($divisaOrigen == 2) {
                    $venta = $cambiosDivisaDestino[$j]->getVenta();
                    $compra = $cambiosDivisaDestino[$j]->getCompra();
                } elseif ($divisaDestino == 2) {
                    $venta = 1 / $cambiosDivisaOrigen[$i]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$i]->getCompra();
                } elseif ($divisaOrigen == 24) { //caso especial de euro
                    $venta = $cambiosDivisaOrigen[$i]->getVenta() * $cambiosDivisaDestino[$j]->getVenta();
                    $compra = $cambiosDivisaOrigen[$i]->getCompra() * $cambiosDivisaDestino[$j]->getCompra();
                } elseif ($divisaDestino == 24) { // caso especial de euro
                    $venta = 1 / $cambiosDivisaOrigen[$i]->getVenta() * 1 / $cambiosDivisaDestino[$j]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$i]->getCompra() * 1 / $cambiosDivisaDestino[$j]->getCompra();
                } else {
                    $venta = 1 / $cambiosDivisaOrigen[$i]->getVenta() * $cambiosDivisaDestino[$j]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$i]->getCompra() * $cambiosDivisaDestino[$j]->getCompra();
                }
                $fecha = $cambiosDivisaOrigen[$i]->getFecha();
                $cambio = new CambioDivisa($divisaOrigen, $divisaOrigenNombre, $divisaDestino, $divisaDestinoNombre, $fecha, $compra, $venta);
                $cambios[] = $cambio;
                $i++;
                $j++;
            }
        }
        return ($cambios);
    }
}
