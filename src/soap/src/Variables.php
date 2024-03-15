<?php

namespace TipoCambio;

class Variables {

    /**
     * @var int $variable
     */
    protected $variable = null;

    /**
     * @param int $variable
     */
    public function __construct($variable) {
        $this->variable = $variable;
    }

    /**
     * @return int
     */
    public function getVariable() {
        return $this->variable;
    }

    /**
     * @param int $variable
     * @return \TipoCambio\Variables
     */
    public function setVariable($variable) {
        $this->variable = $variable;
        return $this;
    }
}
