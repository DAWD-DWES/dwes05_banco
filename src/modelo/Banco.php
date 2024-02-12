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
     * Obtiene los clientes del banco como array de aliases de los clientes
     * 
     * @return array
     */
    private function getClientes(): array {
        return ($this->clientes);
    }

    /**
     * Obtiene las cuentas del banco como array de aliases de las cuentas
     * 
     * @return array
     */
    private function getCuentas(): array {
        return ($this->cuentas);
    }

    /**
     * Establece el nombre del banco
     * 
     * @param string $nombre Nombre del banco
     * @return $this
     */
    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Establece la colección de clientes del banco
     *  
     * @param array $clientes Colección de clientes del banco
     * @return $this
     */
    public function setClientes(array $clientes = []) {
        $this->clientes = $clientes;
    }

    /**
     * Establece la colección de cuentas del banco
     *  
     * @param array $cuentas Colección de cuentas del banco
     * @return $this
     */
    public function setCuentas(array $cuentas = []) {
        $this->cuentas = $cuentas;
    }

    // Gestión de la colección de clientes del banco

    /**
     * Elimina un cliente de la lista de clientes del banco
     * @param string $dni
     */
    private function eliminaCliente(string $dni) {
        unset($this->clientes[$dni]);
    }

    /**
     * Añade un clientes a la lista de clientes del banco
     * @param Cliente $cliente
     */
    private function agregaCliente(Cliente $cliente) {
        $this->clientes[$cliente->getDni()] = $cliente;
    }

    /**
     * Muestra si un cliente existe o no
     * 
     * @param string $dni
     * @return ?Cliente Si el cliente existe devuelve el cliente sino devuelve nulo
     */
    private function existeCliente(string $dni): ?Cliente {
        return ($this->clientes[$dni] ?? null);
    }

    /**
     * Obtiene un cliente del banco (como alias del cliente en la colección)
     * 
     * @param string DNI del cliente
     * @return Cliente
     * @throws ClienteNoEncontradoException
     */
    private function getCliente(string $dni): Cliente {
        $cliente = $this->existeCliente($dni);
        if ($cliente) {
            return $cliente;
        } else {
            throw new ClienteNoEncontradoException($dni);
        }
    }

    // Gestión de la colección de cuentas del banco  

    /**
     * Elimina una cuenta de la lista de cuentas del banco
     * @param string $idCuenta
     */
    private function eliminaCuenta(string $idCuenta) {
        unset($this->cuentas[$idCuenta]);
    }

    /**
     * Añade una cuenta a la lista de cuentas del banco
     * @param Cuenta $cuenta
     */
    private function agregaCuenta(Cuenta $cuenta) {
        $this->cuentas[$cuenta->getId()] = $cuenta;
    }

    /**
     * Predicado para saber si una cuenta existe o no
     * 
     * @param string $idCuenta
     * @return ?Cuenta
     */
    private function existeCuenta(string $idCuenta): ?Cuenta {
        return ($this->cuentas[$idCuenta] ?? null);
    }

    /**
     * Obtiene una cuenta del banco (como alias de la cuenta en la colección)
     * 
     * @param string Id de la cuenta
     * @return Cuenta
     * @throws CuentaNoEncontradaException
     */
    private function getCuenta(string $idCuenta): Cuenta {
        $cuenta = $this->existeCuenta($idCuenta);
        if ($cuenta) {
            return $cuenta;
        } else {
            throw new CuentaNoEncontradaException($idCuenta);
        }
    }
    
    /**
     * Obtiene las cuentas del banco (como array de copias de la colección)
     * 
     * @return array
     */
    public function obtenerCuentas(): array {
        return unserialize(serialize($this->cuentas));
    }

    // Operaciones del interfaz del banco

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
        $this->agregaCliente($cliente);
    }

    /**
     * Realiza una baja de cliente del banco
     * 
     * @param string $dni
     */
    public function bajaCliente(string $dni) {
        $cliente = $this->getCliente($dni);
        $cuentas = $cliente->getIdCuentas();
        $cliente->setIdCuentas([]);
        foreach ($cuentas as $idCuenta) {
            $this->eliminaCuenta($idCuenta);
        }
        $this->eliminaCliente($dni);
    }

    /**
     * Obtiene un cliente del banco (como copia del cliente en la colección)
     * 
     * @param string DNI del cliente
     * @return Cliente
     * @throws ClienteNoEncontradoException
     */
    public function obtenerCliente(string $dni): Cliente {
        return unserialize(serialize($this->getCliente($dni)));
    }
    
    /**
     * Obtiene los clientes del banco como array de copias de los clientes
     * 
     * @return array
     */
    public function obtenerClientes(): array {
        return unserialize(serialize($this->clientes));
    }


    /**
     * Crea una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param float $saldo
     */
    public function altaCuentaCliente(string $dni, float $saldo = 0): string {
        $cliente = $this->getCliente($dni);
        $cuenta = new Cuenta($dni, $saldo);
        $this->agregaCuenta($cuenta);
        $cliente->altaCuenta($cuenta->getId());
        return $cuenta->getId();
    }

    /**
     * Elimina una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     */
    public function bajaCuentaCliente(string $dni, string $idCuenta) {
        $cliente = $this->getCliente($dni);
        $this->eliminaCuenta($idCuenta);
        $cliente->bajaCuenta($idCuenta);
    }

    /**
     * Obtener cuenta bancaria
     * 
     * @param string $idCuenta
     * @return type
     */
    public function obtenerCuenta(string $idCuenta): Cuenta {
        return unserialize(serialize($this->getCuenta($idCuenta)));
    }

    /**
     * Operación de ingreso en una cuenta de un cliente
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $cantidad
     * @param string $descripcion
     */
    public function ingresoCuentaCliente(string $dni, string $idCuenta, float $cantidad, string $descripcion) {
        $cliente = $this->getCliente($dni);
        $cuenta = $this->getCuenta($idCuenta);
        $cuenta->ingreso($cantidad, $descripcion);
    }

    /**
     * Realiza un debito a una cuenta del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $cantidad
     * @param string $descripcion
     */
    public function debitoCuentaCliente(string $dni, string $idCuenta, float $cantidad, string $descripcion) {
        $cliente = $this->getCliente($dni);
        $cuenta = $this->getCuenta($idCuenta);
        $cuenta->debito($cantidad, $descripcion);
    }

    /**
     * Operación para realizar una transferencia de una cuenta de un cliente a otra
     * 
     * @param string $dniClienteOrigen
     * @param string $dniClienteDestino
     * @param string $idCuentaOrigen
     * @param string $idCuentaDestino
     * @param float $cantidad
     */
    public function realizaTransferencia(string $dniClienteOrigen, string $dniClienteDestino, string $idCuentaOrigen, string $idCuentaDestino, float $cantidad) {
        $clienteOrigen = $this->getCliente($dniClienteOrigen);
        $clienteDestino = $this->getCliente($dniClienteDestino);
        $clienteOrigen->compruebaIdCuenta($idCuentaOrigen);
        $clienteDestino->compruebaIdCuenta($idCuentaDestino);
        $this->debitoCuentaCliente($dniClienteOrigen, $idCuentaOrigen, $cantidad, "Transferencia de $cantidad € desde su cuenta $idCuentaOrigen a la cuenta $idCuentaDestino");
        $this->ingresoCuentaCliente($dniClienteDestino, $idCuentaDestino, $cantidad, "Transferencia de $cantidad € a su cuenta $idCuentaDestino desde la cuenta $idCuentaOrigen");
    }
}
