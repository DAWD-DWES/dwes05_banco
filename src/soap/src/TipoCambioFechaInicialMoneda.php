<?php

namespace TipoCambio;

class TipoCambioFechaInicialMoneda {

    /**
     * @var string $fechainit
     */
    protected $fechainit = null;

    /**
     * @var int $moneda
     */
    protected $moneda = null;

    /**
     * @param string $fechainit
     * @param int $moneda
     */
    public function __construct($fechainit, $moneda) {
        $this->fechainit = $fechainit;
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
     * @return \TipoCambio\TipoCambioFechaInicialMoneda
     */
    public function setFechainit($fechainit) {
        $this->fechainit = $fechainit;
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
     * @return \TipoCambio\TipoCambioFechaInicialMoneda
     */
    public function setMoneda($moneda) {
        $this->moneda = $moneda;
        return $this;
    }
}
