<?php

namespace TipoCambio;

class DataVariable {

    /**
     * @var ArrayOfVar $Vars
     */
    protected $Vars = null;

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
     * @return ArrayOfVar
     */
    public function getVars() {
        return $this->Vars;
    }

    /**
     * @param ArrayOfVar $Vars
     * @return \TipoCambio\DataVariable
     */
    public function setVars($Vars) {
        $this->Vars = $Vars;
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
     * @return \TipoCambio\DataVariable
     */
    public function setTotalItems($TotalItems) {
        $this->TotalItems = $TotalItems;
        return $this;
    }
}
