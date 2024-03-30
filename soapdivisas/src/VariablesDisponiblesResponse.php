<?php

namespace TipoCambio;

class VariablesDisponiblesResponse {

    /**
     * @var InfoVariable $VariablesDisponiblesResult
     */
    protected $VariablesDisponiblesResult = null;

    /**
     * @param InfoVariable $VariablesDisponiblesResult
     */
    public function __construct($VariablesDisponiblesResult) {
        $this->VariablesDisponiblesResult = $VariablesDisponiblesResult;
    }

    /**
     * @return InfoVariable
     */
    public function getVariablesDisponiblesResult() {
        return $this->VariablesDisponiblesResult;
    }

    /**
     * @param InfoVariable $VariablesDisponiblesResult
     * @return \TipoCambio\VariablesDisponiblesResponse
     */
    public function setVariablesDisponiblesResult($VariablesDisponiblesResult) {
        $this->VariablesDisponiblesResult = $VariablesDisponiblesResult;
        return $this;
    }
}
