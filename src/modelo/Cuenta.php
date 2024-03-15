<?php

namespace App\modelo;

use App\dao\OperacionDAO;
use App\excepciones\SaldoInsuficienteException;
use DateTime;

/**
 * Clase Cuenta 
 */
class Cuenta implements IProductoBancario {

    private OperacionDAO $operacionDAO;

    /**
     * Id de la cuenta
     * @var string
     */
    private int $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo;

    /**
     * Fecha y hora de creación de la cuenta
     * @var DateTime
     */
    private DateTime $fechaCreacion;

    /**
     * Tipo de la cuenta
     * @var TipoCuenta
     */
    private TipoCuenta $tipo;

    /**
     * Id del cliente dueño de la cuenta
     * @var string
     */
    private int $idCliente;

    /**
     * Operaciones realizadas en la cuenta
     * @param float $saldo
     */
    private array $operaciones;

    public function __construct(OperacionDAO $operacionDAO, TipoCuenta $tipo, string $idCliente) {
        if (func_num_args() > 0) {
            $this->operacionDAO = $operacionDAO;
            $this->tipo = $tipo;
            $this->setSaldo(0);
            $this->setOperaciones([]);
            $this->setFechaCreacion(new DateTime());
            $this->setIdCliente($idCliente);
        }
    }

    public function getId(): string {
        return $this->id;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getFechaCreacion(): DateTime {
        return $this->fechaCreacion;
    }

    public function getTipo(): TipoCuenta {
        return $this->tipo;
    }

    public function getIdCliente(): string {
        return $this->idCliente;
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

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
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

    /**
     * Ingreso de una cantidad en una cuenta
     * @param type $cantidad Cantidad de dinero
     * @param type $descripcion Descripción del ingreso
     */
    public function ingreso(float $cantidad, string $descripcion): void {
        if ($cantidad > 0) {
            $operacion = new Operacion($this->getId(), TipoOperacion::INGRESO, $cantidad, $descripcion);
            $this->operacionDAO->crear($operacion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    /**
     * 
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    public function debito(float $cantidad, string $descripcion): void {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion($this->getId(), TipoOperacion::DEBITO, $cantidad, $descripcion);
            $this->operacionDAO->crear($operacion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() - $cantidad);
        } else {
            throw new SaldoInsuficienteException($this->getId());
        }
    }

    public function __toString() {
        $saldoFormatted = number_format($this->getSaldo(), 2); // Formatear el saldo con dos decimales
        $operacionesStr = implode("</br>", array_map(fn($operacion) => "{$operacion->__toString()}", $this->getOperaciones())); // Convertir las operaciones en una cadena separada por saltos de línea

        return "Cuenta ID: {$this->getId()}</br>" .
                "Tipo Cuenta: " . get_class($this) . "</br>" .
                // "Cliente ID: {$this->getIdCliente()}</br>" .
                "Saldo: $saldoFormatted</br>" .
                "$operacionesStr";
    }

    /**
     * Agrega operación a la lista de operaciones de la cuenta
     * @param type $operacion Operación a añadir
     */
    private function agregaOperacion(Operacion $operacion) {
        $this->operaciones[] = $operacion;
    }
}
