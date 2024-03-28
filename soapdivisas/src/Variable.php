<?php

namespace TipoCambio;

class Variable {

    /**
     * @var int $moneda
     */
    protected $moneda = null;

    /**
     * @var string $descripcion
     */
    protected $descripcion = null;

    /**
     * @param int $moneda
     */
    public function __construct($moneda) {
        $this->moneda = $moneda;
    }

    /**
     * @return int
     */
    public function getMoneda() {
        return $this->moneda;
    }

    /**
     * @param int $moneda
     * @return \TipoCambio\Variable
     */
    public function setMoneda($moneda) {
        $this->moneda = $moneda;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return \TipoCambio\Variable
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }
}
