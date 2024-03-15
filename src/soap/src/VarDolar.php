<?php

namespace TipoCambio;

class VarDolar {

    /**
     * @var string $fecha
     */
    protected $fecha = null;

    /**
     * @var float $referencia
     */
    protected $referencia = null;

    /**
     * @param float $referencia
     */
    public function __construct($referencia) {
        $this->referencia = $referencia;
    }

    /**
     * @return string
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     * @return \TipoCambio\VarDolar
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return float
     */
    public function getReferencia() {
        return $this->referencia;
    }

    /**
     * @param float $referencia
     * @return \TipoCambio\VarDolar
     */
    public function setReferencia($referencia) {
        $this->referencia = $referencia;
        return $this;
    }
}
