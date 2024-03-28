<?php

namespace TipoCambio;

class TipoCambioRango {

    /**
     * @var string $fechainit
     */
    protected $fechainit = null;

    /**
     * @var string $fechafin
     */
    protected $fechafin = null;

    /**
     * @param string $fechainit
     * @param string $fechafin
     */
    public function __construct($fechainit, $fechafin) {
        $this->fechainit = $fechainit;
        $this->fechafin = $fechafin;
    }

    /**
     * @return string
     */
    public function getFechainit() {
        return $this->fechainit;
    }

    /**
     * @param string $fechainit
     * @return \TipoCambio\TipoCambioRango
     */
    public function setFechainit($fechainit) {
        $this->fechainit = $fechainit;
        return $this;
    }

    /**
     * @return string
     */
    public function getFechafin() {
        return $this->fechafin;
    }

    /**
     * @param string $fechafin
     * @return \TipoCambio\TipoCambioRango
     */
    public function setFechafin($fechafin) {
        $this->fechafin = $fechafin;
        return $this;
    }
}
