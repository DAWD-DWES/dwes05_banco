<?php

namespace TipoCambio;

class TipoCambioDiaStringResponse {

    /**
     * @var string $TipoCambioDiaStringResult
     */
    protected $TipoCambioDiaStringResult = null;

    /**
     * @param string $TipoCambioDiaStringResult
     */
    public function __construct($TipoCambioDiaStringResult) {
        $this->TipoCambioDiaStringResult = $TipoCambioDiaStringResult;
    }

    /**
     * @return string
     */
    public function getTipoCambioDiaStringResult() {
        return $this->TipoCambioDiaStringResult;
    }

    /**
     * @param string $TipoCambioDiaStringResult
     * @return \TipoCambio\TipoCambioDiaStringResponse
     */
    public function setTipoCambioDiaStringResult($TipoCambioDiaStringResult) {
        $this->TipoCambioDiaStringResult = $TipoCambioDiaStringResult;
        return $this;
    }
}
