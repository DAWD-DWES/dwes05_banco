<?php

namespace TipoCambio;

class TipoCambioDiaResponse {

    /**
     * @var InfoVariable $TipoCambioDiaResult
     */
    protected $TipoCambioDiaResult = null;

    /**
     * @param InfoVariable $TipoCambioDiaResult
     */
    public function __construct($TipoCambioDiaResult) {
        $this->TipoCambioDiaResult = $TipoCambioDiaResult;
    }

    /**
     * @return InfoVariable
     */
    public function getTipoCambioDiaResult() {
        return $this->TipoCambioDiaResult;
    }

    /**
     * @param InfoVariable $TipoCambioDiaResult
     * @return \TipoCambio\TipoCambioDiaResponse
     */
    public function setTipoCambioDiaResult($TipoCambioDiaResult) {
        $this->TipoCambioDiaResult = $TipoCambioDiaResult;
        return $this;
    }
}
