<?php

namespace TipoCambio;

class TipoCambioFechaInicialResponse {

    /**
     * @var DataVariable $TipoCambioFechaInicialResult
     */
    protected $TipoCambioFechaInicialResult = null;

    /**
     * @param DataVariable $TipoCambioFechaInicialResult
     */
    public function __construct($TipoCambioFechaInicialResult) {
        $this->TipoCambioFechaInicialResult = $TipoCambioFechaInicialResult;
    }

    /**
     * @return DataVariable
     */
    public function getTipoCambioFechaInicialResult() {
        return $this->TipoCambioFechaInicialResult;
    }

    /**
     * @param DataVariable $TipoCambioFechaInicialResult
     * @return \TipoCambio\TipoCambioFechaInicialResponse
     */
    public function setTipoCambioFechaInicialResult($TipoCambioFechaInicialResult) {
        $this->TipoCambioFechaInicialResult = $TipoCambioFechaInicialResult;
        return $this;
    }
}
