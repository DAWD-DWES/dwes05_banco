<?php

require_once "Cliente.php";
require_once "Cuenta.php";
require_once "../src/excepciones/ClienteNoEncontradoException.php";
require_once "../src/excepciones/CuentaNoEncontradaException.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Banco
 */
class Banco {

    /**
     * Nombre del banco
     * @var string
     */
    private string $nombre;

    /**
     * Colección de clientes del banco
     * @var array
     */
    private array $clientes;

    /**
     * Colección de cuentas bancarias abiertas
     * @var array
     */
    private array $cuentas;

    /**
     * Constructor de la clase Banco
     * 
     * @param string $nombre Nombre del banco
     */
    public function __construct(string $nombre) {
        $this->setNombre($nombre);
        $this->setClientes();
        $this->setCuentas();
    }

    /**
     * Obtiene el nombre del banco
     * 
     * @return string
     */
    public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * Obtiene los clientes del banco
     * 
     * @return array
     */
    public function getClientes(): array {
        return $this->clientes;
    }

    /**
     * Obtiene las cuentas del banco
     * 
     * @return array
     */
    public function getCuentas(): array {
        return $this->cuentas;
    }

    /**
     * Establece el nombre del banco
     * 
     * @param string $nombre Nombre del banco
     * @return $this
     */
    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Establece la colección de clientes del banco
     *  
     * @param array $clientes Colección de clientes del banco
     * @return $this
     */
    public function setClientes(array $clientes = []) {
        $this->clientes = $clientes;
        return $this;
    }

    /**
     * Establece la colección de cuentas del banco
     *  
     * @param array $cuentas Colección de cuentas del banco
     * @return $this
     */
    public function setCuentas(array $cuentas = []) {
        $this->clientes = $cuentas;
        return $this;
    }

    /**
     * Realiza un alta de cliente del banco
     * 
     * @param string $dni
     * @param string $nombre
     * @param string $apellido1
     * @param string $apellido2
     * @param string telefono
     * @param DateTime $fechaNacimiento
     * @return bool
     */
    public function altaCliente(string $dni, string $nombre, string $apellido1, string $apellido2, string $telefono, string $fechaNacimiento) {
        $cliente = new Cliente($dni, $nombre, $apellido1, $apellido2, $telefono, $fechaNacimiento);
        $this->clientes[$dni] = $cliente;
    }

    /**
     * Realiza una baja de cliente del banco
     * 
     * @param string $dni
     */
    public function bajaCliente(string $dni) {
        $cliente = $this->obtenerCliente($dni);
        $cuentas = $cliente->obtenerCuentas();
        foreach ($cuentas as $idCuenta) {
            $this->bajaCuenta($idCuenta);
        }
        unset($this->clientes[$dni]);
    }

    /**
     * Obtiene el objeto cliente del banco
     * 
     * @param string $dni
     * @return Cliente
     * @throws ClienteNoEncontradoException
     */
    public function obtenerCliente(string $dni): Cliente {
        if (isset($this->getClientes()[$dni])) {
            return $this->getClientes()[$dni];
        } else {
            throw new ClienteNoEncontradoException($dni);
        }
    }

    /**
     * Predicado para saber si un cliente existe o no
     * 
     * @param string $dni
     * @return bool
     */
    public function existeCliente(string $dni): bool {
        return (isset($this->clientes[$dni]));
    }

    /**
     * Crea una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param float $saldo
     */
    public function altaCuentaCliente(string $dni, float $saldo = 0): string {
        $cuenta = $this->altaCuenta($saldo, $dni);
        $cliente = $this->obtenerCliente($dni);
        $cliente->altaCuenta($cuenta->getId());
        return $cuenta->getId();
    }

    /**
     * Crea una cuenta
     * @param type $saldo
     * @return Cuenta
     */
    public function altaCuenta($saldo, $dni): Cuenta {
        $cuenta = new Cuenta($dni, $saldo);
        $this->cuentas[$cuenta->getId()] = $cuenta;
        return $cuenta;
    }

    /**
     * Elimina una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     */
    public function bajaCuentaCliente(string $dni, string $idCuenta) {
        $cliente = $this->obtenerCliente($dni);
        $this->bajaCuenta($idCuenta);
        $cliente->bajaCuenta($idCuenta);
    }

    /**
     * Elimina un cuenta
     * 
     * @param string $idCuenta
     */
    public function bajaCuenta(string $idCuenta) {
        $cuenta = $this->obtenerCuenta($idCuenta);
        unset($this->cuentas[$idCuenta]);
    }

    /**
     * Obtener cuenta bancaria
     * 
     * @param string $idCuenta
     * @return type
     */
    public function obtenerCuenta(string $idCuenta): Cuenta {
        if (isset($this->cuentas[$idCuenta])) {
            return ($this->cuentas[$idCuenta]);
        } else {
            throw new CuentaNoEncontradaException($dni);
        }
    }

    /**
     * Predicado para saber si una cuenta existe
     * 
     * @param string $idCuenta
     * @return bool
     */
    public function existeCuenta(string $idCuenta): bool {
        return (isset($this->cuentas[$idCuenta]));
    }

    /**
     * Operación de ingreso en una cuenta de un cliente
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $cantidad
     */
    public function ingresoCuentaCliente(string $dni, string $idCuenta, float $cantidad) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = $this->obtenerCuenta($idCuenta);
        $cuenta->ingreso($cantidad);
    }

    /**
     * Realiza un debito a una cuenta del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $saldo
     */
    public function debitoCuentaCliente(string $dni, string $idCuenta, float $cantidad) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = $this->obtenerCuenta($idCuenta);
        $cuenta->debito($cantidad);
    }

    /**
     * Operación para realizar una transferencia de una cuenta de un cliente a otra
     * 
     * @param string $dniClienteOrigen
     * @param string $dniClienteDestino
     * @param string $idCuentaOrigen
     * @param string $idCuentaDestino
     * @param float $saldo
     * @return bool
     */
    public function realizaTransferencia(string $dniClienteOrigen, string $dniClienteDestino, string $idCuentaOrigen, string $idCuentaDestino, float $saldo) {
        $clienteOrigen = $this->obtenerCliente($dniClienteOrigen);
        $clienteDestino = $this->obtenerCliente($dniClienteDestino);

        if (isset($this->cuentas[$idCuentaOrigen]) && isset($this->cuentas[$idCuentaDestino])) {
            if ($this->cuentas[$idCuentaOrigen]->debito($saldo)) {
                $this->cuentas[$idCuentaDestino]->ingreso($saldo);
            }
        }
    }
}
