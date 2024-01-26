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

    public function __construct(string $idCliente, float $saldo = 0) {
        $this->setId(uniqid());
        $this->setSaldo($saldo);
        $this->setIdCliente($idCliente);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getIdCliente(): string {
        return $this->id;
    }

    public function getOperaciones(): array {
        return $this->operaciones;
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
            $operacion = new Operacion(TipoOperacion::INGRESO, $cantidad);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    public function debito($cantidad) {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion(TipoOperacion::DEBITO, $cantidad);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() - $cantidad);
        } else {
            throw new SaldoInsuficienteException();
        }
    }

    public function agregaOperacion($operacion) {
        $this->operaciones[] = $operacion;
    }
}
