<?php

namespace TipoCambio;

class TipoCambioRangoMonedaResponse {

    /**
     * @var DataVariable $TipoCambioRangoMonedaResult
     */
    protected $TipoCambioRangoMonedaResult = null;

    /**
     * @param DataVariable $TipoCambioRangoMonedaResult
     */
    public function __construct($TipoCambioRangoMonedaResult) {
        $this->TipoCambioRangoMonedaResult = $TipoCambioRangoMonedaResult;
    }

    /**
     * @return DataVariable
     */
    public function getTipoCambioRangoMonedaResult() {
        return $this->TipoCambioRangoMonedaResult;
    }

    /**
     * @param DataVariable $TipoCambioRangoMonedaResult
     * @return \TipoCambio\TipoCambioRangoMonedaResponse
     */
    public function setTipoCambioRangoMonedaResult($TipoCambioRangoMonedaResult) {
        $this->TipoCambioRangoMonedaResult = $TipoCambioRangoMonedaResult;
        return $this;
    }
}
