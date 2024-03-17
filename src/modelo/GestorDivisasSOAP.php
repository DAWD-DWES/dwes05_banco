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

    public function __construct() {
        $this->servicioDivisa = new TipoCambio();
    }

    public function listaDivisasDisponibles(): ?array {
        $servTipoCambio = new TipoCambio();
        $variablesDisponiblesResponse = $servTipoCambio->VariablesDisponibles(new VariablesDisponibles());
        $divisas = $variablesDisponiblesResponse->getVariablesDisponiblesResult()->getVariables()->getVariable();
        return $divisas;
    }

    public function consultarCambioDivisa($divisaOrigen, $divisaDestino, $fechaInicial, $fechaFinal = null): ?array {
        $cambios = [];
        $fechaFinal = $fechaFinal ? (new DateTime($fechaFinal))->format('d/m/Y') : (new DateTime('hoy'))->format('d/m/Y');
        $fechaInicial = (new DateTime($fechaInicial))->format('d/m/Y');
        $cambiosDivisaOrigen = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaOrigen))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $cambiosDivisaDestino = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaDestino))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $divisaOrigenNombre = current(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaOrigen) {
                    return ($variable->getMoneda() === $divisaOrigen);
                }))->getDescripcion();
        $divisaDestinoNombre = current(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaDestino) {
                            return ($variable->getMoneda() === $divisaDestino);
                        }))->getDescripcion();
        $i = 0;
        $j = 0;
        while (isset($cambiosDivisaOrigen[$i]) && isset($cambiosDivisaDestino[$j])) {
            if (DateTime::createFromFormat('d/m/Y', $cambiosDivisaOrigen[$i]->getFecha()) < DateTime::createFromFormat('d/m/Y', $cambiosDivisaDestino[$i]->getFecha())) {
                $i++;
            } else if (DateTime::createFromFormat('d/m/Y', $cambiosDivisaOrigen[$i]->getFecha()) < DateTime::createFromFormat('d/m/Y', $cambiosDivisaDestino[$i]->getFecha())) {
                $j++;
            } else {
                if ($divisaOrigen == 24) { //caso especial de euro
                    $venta = $cambiosDivisaOrigen[$j]->getVenta() * $cambiosDivisaDestino[$i]->getVenta();
                    $compra = $cambiosDivisaOrigen[$j]->getCompra() * $cambiosDivisaDestino[$i]->getCompra();
                } elseif ($divisaDestino == 24) { // caso especial de euro
                    $venta = 1 / $cambiosDivisaOrigen[$j]->getVenta() * 1 / $cambiosDivisaDestino[$i]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$j]->getCompra() * 1 / $cambiosDivisaDestino[$i]->getCompra();
                } else {
                    $venta = 1 / $cambiosDivisaOrigen[$j]->getVenta() * $cambiosDivisaDestino[$i]->getVenta();
                    $compra = 1 / $cambiosDivisaOrigen[$j]->getCompra() * $cambiosDivisaDestino[$i]->getCompra();
                }
                $fecha = $cambiosDivisaOrigen[$j]->getFecha();
                $cambio = new CambioDivisa($divisaOrigen, $divisaOrigenNombre, $divisaDestino, $divisaDestinoNombre, $fecha, $compra, $venta);
                $cambios[] = $cambio;
                $i++;
                $j++;
            }
        }
        return ($cambios);
    }
}
