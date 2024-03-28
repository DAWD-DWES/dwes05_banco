<?php

namespace TipoCambio;

class VarCustom {

    /**
     * @var int $moneda
     */
    protected $moneda = null;

    /**
     * @var string $fecha
     */
    protected $fecha = null;

    /**
     * @var float $venta
     */
    protected $venta = null;

    /**
     * @var float $compra
     */
    protected $compra = null;

    /**
     * @param int $moneda
     * @param float $venta
     * @param float $compra
     */
    public function __construct($moneda, $venta, $compra) {
        $this->moneda = $moneda;
        $this->venta = $venta;
        $this->compra = $compra;
    }

    /**
     * @return int
     */
    public function getMoneda() {
        return $this->moneda;
    }

    /**
     * @param int $moneda
     * @return \TipoCambio\Var
     */
    public function setMoneda($moneda) {
        $this->moneda = $moneda;
        return $this;
    }

    /**
     * @return string
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     * @return \TipoCambio\Var
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return float
     */
    public function getVenta() {
        return $this->venta;
    }

    /**
     * @param float $venta
     * @return \TipoCambio\Var
     */
    public function setVenta($venta) {
        $this->venta = $venta;
        return $this;
    }

    /**
     * @return float
     */
    public function getCompra() {
        return $this->compra;
    }

    /**
     * @param float $compra
     * @return \TipoCambio\Var
     */
    public function setCompra($compra) {
        $this->compra = $compra;
        return $this;
    }
}
