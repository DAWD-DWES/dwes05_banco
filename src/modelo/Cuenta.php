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
     * @var string
     */
    private string $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo = 0;

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

    public function __construct(string $idCliente, float $cantidad = 0) {
        $this->setId(uniqid());
        $this->ingreso($cantidad, "Ingreso inicial de $cantidad € en la cuenta");
        $this->setIdCliente($idCliente);
        $this->setOperaciones([]);
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

    public function getTipoCuenta(): array {
        return $this->tipoCuenta;
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

    public function setTipoCuenta($tipoCuenta) {
        $this->tipoCuenta = $tipoCuenta;
    }
    
    public function setOperaciones(array $operaciones) {
        $this->operaciones = $operaciones;
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

    public function __toString() {
        $saldoFormatted = number_format($this->getSaldo(), 2); // Formatear el saldo con dos decimales
        $operacionesStr = implode("</br>", array_map(fn($operacion) => "{$operacion->__toString()}", $this->getOperaciones())); // Convertir las operaciones en una cadena separada por saltos de línea

        return "Cuenta ID: {$this->getId()}</br>" .
                // "Cliente ID: {$this->getIdCliente()}</br>" .
                "Saldo: $saldoFormatted</br>" .
                "$operacionesStr";
    }
}
