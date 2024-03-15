<?php

namespace TipoCambio;

class TipoCambioFechaInicialMonedaResponse {

    /**
     * @var DataVariable $TipoCambioFechaInicialMonedaResult
     */
    protected $TipoCambioFechaInicialMonedaResult = null;

    /**
     * @param DataVariable $TipoCambioFechaInicialMonedaResult
     */
    public function __construct($TipoCambioFechaInicialMonedaResult) {
        $this->TipoCambioFechaInicialMonedaResult = $TipoCambioFechaInicialMonedaResult;
    }

    /**
     * @return DataVariable
     */
    public function getTipoCambioFechaInicialMonedaResult() {
        return $this->TipoCambioFechaInicialMonedaResult;
    }

    /**
     * @param DataVariable $TipoCambioFechaInicialMonedaResult
     * @return \TipoCambio\TipoCambioFechaInicialMonedaResponse
     */
    public function setTipoCambioFechaInicialMonedaResult($TipoCambioFechaInicialMonedaResult) {
        $this->TipoCambioFechaInicialMonedaResult = $TipoCambioFechaInicialMonedaResult;
        return $this;
    }
}
