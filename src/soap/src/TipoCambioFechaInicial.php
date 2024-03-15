<?php

namespace TipoCambio;

class TipoCambioFechaInicial {

    /**
     * @var string $fechainit
     */
    protected $fechainit = null;

    /**
     * @param string $fechainit
     */
    public function __construct($fechainit) {
        $this->fechainit = $fechainit;
    }

    /**
     * @return string
     */
    public function getFechainit() {
        return $this->fechainit;
    }

    /**
     * @param string $fechainit
     * @return \TipoCambio\TipoCambioFechaInicial
     */
    public function setFechainit($fechainit) {
        $this->fechainit = $fechainit;
        return $this;
    }
}
