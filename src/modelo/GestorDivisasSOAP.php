<?php

namespace App\modelo;

use SoapClient;
use TipoCambio\{
    TipoCambio,
    VariablesDisponibles,
    TipoCambioRangoMoneda,
    VarCustom
};
use DateTime;
use DatePeriod;
use DateInterval;

enum Divisa: int {

    case Quetzal = 1;
    case Dolar_EEUU = 2;
    case Yen_Japones = 3;
    case Franco_Belga = 4;
    case Franco_Suizo = 5;
    case Franco_Frances = 6;
    case Dolar_Canadiense = 7;
    case Euro = 24;
}

/**
 * Clase Banco
 */
class GestorDivisasSOAP implements IGestorDivisas {

    private SoapClient $servicioDivisa;

    public function __construct() {
        $this->servicioDivisa = new TipoCambio();
    }

    public function listaDivisasDisponibles(): array {
        $servTipoCambio = new TipoCambio();
        $variablesDisponiblesResponse = $servTipoCambio->VariablesDisponibles(new VariablesDisponibles());
        $divisas = $variablesDisponiblesResponse->getVariablesDisponiblesResult()->getVariables()->getVariable();
        return $divisas;
    }

    public function consultarCambioDivisa($divisaOrigen, $divisaDestino, $fechaInicial, $fechaFinal = null): ?array {
        $fechaFinal = $fechaFinal ? (new DateTime($fechaFinal))->format('d/m/Y') : (new DateTime())->format('d/m/Y');
        $fechaInicial = (new DateTime($fechaInicial))->format('d/m/Y');
        $cambiosDivisaOrigen = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaOrigen))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $cambiosDivisaDestino = $this->servicioDivisa->TipoCambioRangoMoneda(new TipoCambioRangoMoneda($fechaInicial, $fechaFinal, $divisaDestino))->getTipoCambioRangoMonedaResult()->getVars()->getVar();
        $divisaOrigenNombre = array_values(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaOrigen) {
                            return ($variable->getMoneda() === $divisaOrigen);
                        }))[0]->getDescripcion();
        $divisaDestinoNombre = array_values(array_filter($this->listaDivisasDisponibles(), function ($variable) use ($divisaDestino) {
                            return ($variable->getMoneda() === $divisaDestino);
                        }))[0]->getDescripcion();
        $conversion = [];
        $cambios = compact('divisaOrigen', 'divisaDestino', 'divisaOrigenNombre', 'divisaDestinoNombre', 'conversion');
        $i = 0;
        $j = 0;
        while (isset($cambiosDivisaOrigen[$i]) && isset($cambiosDivisaDestino[$j])) {
            if (new DateTime($cambiosDivisaOrigen[$i]->getFecha()) < new DateTime($cambiosDivisaDestino[$j]->getFecha())) {
                $i++;
            } else if (new DateTime($cambiosDivisaOrigen[$i]->getFecha()) > new DateTime($cambiosDivisaDestino[$j]->getFecha())) {
                $j++;
            } else {
                if ($divisaOrigen == 24) { //caso especial de euro
                    $cambio = ["venta" => $cambiosDivisaOrigen[$j]->getVenta() * $cambiosDivisaDestino[$i]->getVenta(),
                        "compra" => $cambiosDivisaOrigen[$j]->getCompra() * $cambiosDivisaDestino[$i]->getCompra(),
                        "fecha" => $cambiosDivisaOrigen[$j]->getFecha()];
                } elseif ($divisaDestino == 24) { // caso especial de euro
                    $cambio = ["venta" => 1 / $cambiosDivisaOrigen[$j]->getVenta() * 1 / $cambiosDivisaDestino[$i]->getVenta(),
                        "compra" => 1 / $cambiosDivisaOrigen[$j]->getCompra() * 1 / $cambiosDivisaDestino[$i]->getCompra(),
                        "fecha" => $cambiosDivisaOrigen[$j]->getFecha()];
                } else {
                    $cambio = ["venta" => 1 / $cambiosDivisaOrigen[$j]->getVenta() * $cambiosDivisaDestino[$i]->getVenta(),
                        "compra" => 1 / $cambiosDivisaOrigen[$j]->getCompra() * $cambiosDivisaDestino[$i]->getCompra(),
                        "fecha" => $cambiosDivisaOrigen[$j]->getFecha()];
                }
                $cambios["conversion"][] = $cambio;
                $i++;
                $j++;
            }
        }
        return ($cambios);
    }
}
