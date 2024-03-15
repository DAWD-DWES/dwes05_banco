<?php

namespace TipoCambio;

class TipoCambioRangoResponse {

    /**
     * @var DataVariable $TipoCambioRangoResult
     */
    protected $TipoCambioRangoResult = null;

    /**
     * @param DataVariable $TipoCambioRangoResult
     */
    public function __construct($TipoCambioRangoResult) {
        $this->TipoCambioRangoResult = $TipoCambioRangoResult;
    }

    /**
     * @return DataVariable
     */
    public function getTipoCambioRangoResult() {
        return $this->TipoCambioRangoResult;
    }

    /**
     * @param DataVariable $TipoCambioRangoResult
     * @return \TipoCambio\TipoCambioRangoResponse
     */
    public function setTipoCambioRangoResult($TipoCambioRangoResult) {
        $this->TipoCambioRangoResult = $TipoCambioRangoResult;
        return $this;
    }
}
