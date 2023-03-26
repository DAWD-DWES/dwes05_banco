<?php

/**
 * Clase para representar un cuenta de banco
 *
 * Esta clase representa una cuenta de banco con propiedades como el identificador,
 * y saldo. También incluye métodos para realizar ingresos y retiradas de efectivo
 *
 * @category   Banco
 * @package    CuentaBanco
 * @subpackage Clases
 * @since 2.0.0
 * @version    2.1.0
 */
class CuentaBanco {

    /**
     * El identificador de la cuenta de banco
     *
     * @var string
     */
    private $id;

    /**
     * El valor del saldo de la cuenta
     *
     * @var float
     */
    private $saldo;

    /**
     * Constructor de la clase CuentaBanco
     *
     * @param float $saldo El saldo de la cuenta del banco
     */
    public function __construct($saldo) {
        $this->id = uniqid();
        $this->saldo = $saldo;
    }

    /**
     * Obtiene el identificador de la cuenta de banco
     *
     * @return string El identificador de la cuenta de banco
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Obtiene el saldo de la cuenta de banco
     *
     * @return float El nuevo saldo de la cuenta de banco
     */
    public function getSaldo() {
        return $this->saldo;
    }

    /**
     * Establece el identificador de la cuenta de banco
     *
     * @param string $id El identificador de la cuenta de banco
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Establece el saldo de la cuenta de banco
     *
     * @param float $saldo El saldo de la cuenta de banco
     */
    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    /**
     * Realiza un ingreso en la cuenta de banco
     *
     * @param float $cantidad La cantidad a ingresar en la cuenta de banco
     * @return float El saldo de la cuenta de banco
     */
    public function ingreso($cantidad) {
        if ($cantidad > 0) {
            $this->saldo += $cantidad;
        }
        return $this->saldo;
    }

    /**
     * Realiza una retirada de la cuenta de banco
     *
     * @param float $cantidad La cantidad a retirar de la cuenta de banco
     * @return saldo El saldo de la cuenta de banco o lanza una excepción si no se ha podido hacer la retirada
     * @throws Exception Excepción por intentar retirar dinero de una cuenta sin suficientes fondos
     */
    public function retirada($cantidad) {
        if ($cantidad <= $this->saldo) {
            $this->saldo -= $cantidad;
            return $this->saldo;
        } else {
            throw new Exception('La retirada no puede realizarse por falta de fondos');
        }
    }

}
