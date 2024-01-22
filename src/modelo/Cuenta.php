<?php

require_once "Operacion.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Cuenta 
 */
class Cuenta {

    /**
     * Id de la cuenta
     * @var string
     */
    private string $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo;

    /**
     * Id del cliente dueño de la cuenta
     * @var string
     */
    private string $idCliente;

    /**
     * Operaciones realizadas en la cuenta
     * @param float $saldo
     */
    private array $operaciones;

    public function __construct(float $saldo = 0) {
        $this->setId(uniqid());
        $this->setSaldo($saldo);
    }

    public function getId() {
        return $this->id;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getIdCliente() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function ingreso($cantidad) {
        if ($cantidad > 0) {
            $operacion = new Operacion('Ingreso', $cantidad);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    public function debito($cantidad) {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion('Debito', $cantidad);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() - $cantidad);
        }
        else {
            throw new SaldoInsuficienteException();
        }
    }
}
