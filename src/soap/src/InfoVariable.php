<?php

namespace TipoCambio;

class InfoVariable {

    /**
     * @var ArrayOfVariable $Variables
     */
    protected $Variables = null;

    /**
     * @var ArrayOfVar $CambioDia
     */
    protected $CambioDia = null;

    /**
     * @var ArrayOfVarDolar $CambioDolar
     */
    protected $CambioDolar = null;

    /**
     * @var int $TotalItems
     */
    protected $TotalItems = null;

    /**
     * @param int $TotalItems
     */
    public function __construct($TotalItems) {
        $this->TotalItems = $TotalItems;
    }

    /**
     * @return ArrayOfVariable
     */
    public function getVariables() {
        return $this->Variables;
    }

    /**
     * @param ArrayOfVariable $Variables
     * @return \TipoCambio\InfoVariable
     */
    public function setVariables($Variables) {
        $this->Variables = $Variables;
        return $this;
    }

    /**
     * @return ArrayOfVar
     */
    public function getCambioDia() {
        return $this->CambioDia;
    }

    /**
     * @param ArrayOfVar $CambioDia
     * @return \TipoCambio\InfoVariable
     */
    public function setCambioDia($CambioDia) {
        $this->CambioDia = $CambioDia;
        return $this;
    }

    /**
     * @return ArrayOfVarDolar
     */
    public function getCambioDolar() {
        return $this->CambioDolar;
    }

    /**
     * @param ArrayOfVarDolar $CambioDolar
     * @return \TipoCambio\InfoVariable
     */
    public function setCambioDolar($CambioDolar) {
        $this->CambioDolar = $CambioDolar;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalItems() {
        return $this->TotalItems;
    }

    /**
     * @param int $TotalItems
     * @return \TipoCambio\InfoVariable
     */
    public function setTotalItems($TotalItems) {
        $this->TotalItems = $TotalItems;
        return $this;
    }
}
