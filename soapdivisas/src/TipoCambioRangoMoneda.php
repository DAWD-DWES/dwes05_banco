<?php

namespace TipoCambio;

class TipoCambioRangoMoneda {

    /**
     * @var string $fechainit
     */
    protected $fechainit = null;

    /**
     * @var string $fechafin
     */
    protected $fechafin = null;

    /**
     * @var int $moneda
     */
    protected $moneda = null;

    /**
     * @param string $fechainit
     * @param string $fechafin
     * @param int $moneda
     */
    public function __construct($fechainit, $fechafin, $moneda) {
        $this->fechainit = $fechainit;
        $this->fechafin = $fechafin;
        $this->moneda = $moneda;
    }

    /**
     * @return string
     */
    public function getFechainit() {
        return $this->fechainit;
    }

    /**
     * @param string $fechainit
     * @return \TipoCambio\TipoCambioRangoMoneda
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
     * @return \TipoCambio\TipoCambioRangoMoneda
     */
    public function setFechafin($fechafin) {
        $this->fechafin = $fechafin;
        return $this;
    }

    /**
     * @return int
     */
    public function getMoneda() {
        return $this->moneda;
    }

    /**
     * @param int $moneda
     * @return \TipoCambio\TipoCambioRangoMoneda
     */
    public function setMoneda($moneda) {
        $this->moneda = $moneda;
        return $this;
    }
}
