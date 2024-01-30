<?php

require_once "Operacion.php";
require_once "TipoCuenta.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Cuenta 
 */
class Cuenta {

    /**
     * Id de la cuenta
     * @var int
     */
    private int $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo = 0;

    /**
     * Id del cliente dueño de la cuenta
     * @var string
     */
    private int $idCliente;

    /**
     * Tipo de Cuenta
     * @var TipoCuenta
     */
    private TipoCuenta $tipo;

    /**
     * Fecha de Creación de la cuenta
     * @var DateTime
     */
    private DateTime $fechaCreacion;

    /**
     * Operaciones realizadas en la cuenta
     * @param float $saldo
     */
    private array $operaciones;

    public function __construct(string $dni = null, float $saldo = 0) {
        if (!is_null($dni)) {
            $this->setDNI($dni);
        }
        if ($saldo > 0) {
            $this->setSaldo($saldo);
            $this->ingreso($saldo, "Ingreso inicial de $saldo € en la cuenta");
        }
        $this->fechaCreacion = (is_string($this->fechaCreacion)) ? new DateTime($this->fechaCreacion) : $this->fechaCreacion = new DateTime();
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

    public function getTipo(): array {
        return $this->tipo;
    }

    public function getFechaCreacion(): DateTime {
        return $this->fechaCreación;
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

    public function setTipo($tipoCuenta) {
        $this->tipo = $tipoCuenta;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion($fechaCreacion);
    }

    public function ingreso($cantidad, $asunto): void {
        if ($cantidad > 0) {
            $operacion = new Operacion(TipoOperacion::INGRESO, $cantidad, $asunto);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    public function debito($cantidad, $asunto): void {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion(TipoOperacion::DEBITO, $cantidad, $asunto);
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
