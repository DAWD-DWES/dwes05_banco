<?php
require "CuentaBanco.php";

class CuentaAhorros extends CuentaBanco {

    private $interes;

    public function __construct($cuenta, $saldo, $interes) {
        parent::__construct($cuenta, $saldo, $interes);
        $this->interes = $interes;
    }

    public function sumaInteres() {
        // Calcula el interés
        $intereses = $this->interes * $this->getSaldo();
        // Ingresa intereses
        $this->ingreso($intereses);
    }

    public function getInteres() {
        return $this->interes;
    }

    public function setInteres($interes): void {
        $this->interes = $interes;
    }

}
