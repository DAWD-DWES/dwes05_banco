<?php

namespace TipoCambio;

class VariablesResponse {

    /**
     * @var InfoVariable $VariablesResult
     */
    protected $VariablesResult = null;

    /**
     * @param InfoVariable $VariablesResult
     */
    public function __construct($VariablesResult) {
        $this->VariablesResult = $VariablesResult;
    }

    /**
     * @return InfoVariable
     */
    public function getVariablesResult() {
        return $this->VariablesResult;
    }

    /**
     * @param InfoVariable $VariablesResult
     * @return \TipoCambio\VariablesResponse
     */
    public function setVariablesResult($VariablesResult) {
        $this->VariablesResult = $VariablesResult;
        return $this;
    }
}
