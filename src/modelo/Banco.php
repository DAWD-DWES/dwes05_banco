<?php

require_once "Cliente.php";
require_once "Cuenta.php";
require_once "CuentaCorriente.php";
require_once "CuentaAhorros.php";
require_once "TipoCuenta.php";
require_once "../src/dao/ClienteDAO.php";
require_once "../src/dao/CuentaDAO.php";
require_once "../src/dao/OperacionDAO.php";
require_once "../src/excepciones/ClienteNoEncontradoException.php";
require_once "../src/excepciones/CuentaNoEncontradaException.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Banco
 */
class Banco {

    /**
     * Comisión de mantenimiento de la cuenta corriente en euros
     * @var float
     */
    private float $comisionCC = 0;

    /**
     * Mínimo saldo para no pagar comisión
     * @var float
     */
    private float $minSaldoComisionCC = 0;

    /**
     * Interés de la cuenta de ahorros en porcentaje
     * @var float
     */
    private float $interesCA = 0;

    /**
     * Nombre del banco
     * @var string
     */
    private string $nombre;

    /**
     * DAO para persistir clientes
     * @var IDAO
     */
    private IDAO $clienteDAO;

    /**
     * DAO para persistir cuentas
     * @var IDAO
     */
    private IDAO $cuentaDAO;

    /**
     * DAO para persistir operaciones
     * @var IDAO
     */
    private IDAO $operacionDAO;

    /**
     * Colección de clientes del banco
     * @var array
     */
    // private array $clientes;

    /**
     * Colección de cuentas bancarias abiertas
     * @var array
     */
    // private array $cuentas;

    /**
     * Constructor de la clase Banco
     * 
     * @param string $nombre Nombre del banco
     */
    public function __construct(IDAO $clienteDAO, IDAO $cuentaDAO, IDAO $operacionDAO, string $nombre) {
        $this->setNombre($nombre);
        $this->clienteDAO = $clienteDAO;
        $this->cuentaDAO = $cuentaDAO;
        $this->operacionDAO = $operacionDAO;
        //  $this->setClientes();
        //  $this->setCuentas();
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
        return $this->clienteDAO->obtenerTodos();
    }

    /**
     * Obtiene las cuentas del banco
     * 
     * @return array
     */
    public function getCuentas(): array {
        return $this->cuentaDAO->obtenerTodos();
    }

    /**
     * Obtiene la comisión del banco
     * 
     * @return string
     */
    public function getComisionCC(): float {
        return $this->comisionCC;
    }

    /**
     * Obtiene el mínimo saldo sin comisión
     * 
     * @return string
     */
    public function getminSaldoComisionCC(): float {
        return $this->minSaldoComisionCC;
    }

    /**
     * Obtiene el interés del banco
     * 
     * @return string
     */
    public function getInteresCA(): float {
        return $this->interesCA;
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
//    public function setClientes(array $clientes = []) {
//        $this->clientes = $clientes;
//        return $this;
//    }

    /**
     * Establece la colección de cuentas del banco
     *  
     * @param array $cuentas Colección de cuentas del banco
     * @return $this
     */
//    public function setCuentas(array $cuentas = []) {
//        $this->cuentas = $cuentas;
//        return $this;
//    }

    /**
     * Establece la comision de cuenta corriente del banco
     * 
     * @param float $comisionCC Comisión del banco
     * @return $this
     */
    public function setComisionCC(float $comisionCC) {
        $this->comisionCC = $comisionCC;
    }

    /**
     * Establece el mínimo saldo para no pagar comisión
     * 
     * @param float $minSaldoComisionCC mínimo saldo sin comisión
     * @return $this
     */
    public function setMinSaldoComisionCC(float $minSaldoComisionCC) {
        $this->minSaldoComisionCC = $minSaldoComisionCC;
    }

    /**
     * Establece el interés de la cuenta de ahorros del banco
     * 
     * @param float $interesCA Interés del banco
     * @return $this
     */
    public function setInteresCA(float $interesCA) {
        $this->interesCA = $interesCA;
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
    public function altaCliente(string $dni, string $nombre, string $apellido1, string $apellido2, string $telefono, string $fechaNacimiento): void {
        $cliente = new Cliente($dni, $nombre, $apellido1, $apellido2, $telefono, $fechaNacimiento);
        $this->clienteDAO->crear($cliente);
    }

    /**
     * Realiza una baja de cliente del banco
     * 
     * @param string $dni
     */
    public function bajaCliente(string $dni) {
        $cliente = $this->clienteDAO->obtenerPorDni($dni);
        $cuentas = $cliente->obtenerIdCuentas();
        foreach ($cuentas as $idCuenta) {
            $this->cuentaDAO->eliminar($idCuenta);
        }
        $this->clienteDAO->eliminar($cliente->getId());
    }

    /**
     * Obtiene el objeto cliente del banco
     * 
     * @param string $dni
     * @return Cliente
     * @throws ClienteNoEncontradoException
     */
    public function obtenerCliente(string $dni): ?Cliente {
        $cliente = $this->clienteDAO->obtenerPorDNI($dni);
        if ($cliente) {
            return $cliente;
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
        $clienteDAO = new ClienteDAO($this->pdo);
        $cliente = $clienteDAO->obtenerPorDNI($dni);
        return $cliente;
    }

    /**
     * Crea una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param float $saldo
     */
    public function altaCuentaCliente(string $dni, float $saldo = 0, TipoCuenta $tipo = TipoCuenta::CORRIENTE): Cuenta {
        $cliente = $this->obtenerCliente($dni);
        if ($tipo == TipoCuenta::CORRIENTE) {
            $cuenta = new CuentaCorriente($this->operacionDAO, $cliente->getId(), $saldo);
        } elseif ($tipo == TipoCuenta::AHORROS) {
            $cuenta = new CuentaAhorros($this->operacionDAO, $cliente->getId(), $saldo);
        }
        $this->cuentaDAO->crear($cuenta);
        return $cuenta;
    }

    /**
     * Elimina una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     */
    public function bajaCuentaCliente(string $dni, int $idCuenta) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = $this->cuentaDAO->obtenerCuenta($idCuenta);
        $this->cuentaDAO->eliminar($cuenta->getId());
    }

    /**
     * Obtener cuenta bancaria
     * 
     * @param string $idCuenta
     * @return type
     */
    public function obtenerCuenta(int $idCuenta): ?Cuenta {
        $cuenta = $this->cuentaDAO->obtenerPorId($idCuenta);
        if ($cuenta) {
            return $cuenta;
        } else {
            throw new CuentaNoEncontradaException($idCuenta);
        }
    }

    /**
     * Predicado para saber si una cuenta existe
     * 
     * @param string $idCuenta
     * @return bool
     */
    public function existeCuenta(int $idCuenta): bool {
        return (isset($this->cuentas[$idCuenta]));
    }

    /**
     * Operación de ingreso en una cuenta de un cliente
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $cantidad
     */
    public function ingresoCuentaCliente(string $dni, int $idCuenta, float $cantidad, string $descripcion) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = $this->obtenerCuenta($idCuenta);
        $cuenta->ingreso($cantidad, $descripcion);
        $this->cuentaDAO->modificar($cuenta);
    }

    /**
     * Realiza un debito a una cuenta del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     * @param float $saldo
     */
    public function debitoCuentaCliente(string $dni, int $idCuenta, float $cantidad, string $descripcion) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = ($this->cuentas)[$idCuenta];
        $cuenta->debito($cantidad, $descripcion);
        $this->cuentaDAO->modificar($cuenta);
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
    public function realizaTransferencia(string $dniClienteOrigen, string $dniClienteDestino, int $idCuentaOrigen, int $idCuentaDestino, float $saldo) {
        $clienteOrigen = $this->obtenerCliente($dniClienteOrigen);
        $clienteDestino = $this->obtenerCliente($dniClienteDestino);
        $cuentaOrigen = $this->obtenerCuenta($idCuentaOrigen);
        $cuentaDestino = $this->obtenerCuenta($idCuentaDestino);

        try {
            $this->cuentaDAO->beginTransaction();
            $cuenta->debito($cantidad, "Transferencia de $cantidad € desde su cuenta $idCuentaOrigen a la cuenta $idCuentaDestino");
            $cuenta->ingreso($cantidad, "Transferencia de $cantidad € desde la cuenta $idCuentaOrigen a su cuenta $idCuentaDestino");
            $this->cuentaDAO->commit();
        } catch (Exception $ex) {
            $this->cuentaDAO->rollback();
        }
    }

    /**
     * Aplica cargos de comisión a la cuenta corriente
     */
    public function aplicaComisionCC() {
        $cuentasCorrientes = array_filter($this->cuentas, fn($cuenta) => $cuenta instanceof CuentaCorriente);

        // Captura las propiedades necesarias con 'use'
        $comisionCC = $this->getComisionCC();
        $minSaldoComisionCC = $this->getminSaldoComisionCC();

        array_walk($cuentasCorrientes, function ($cuentaCC) use ($comisionCC, $minSaldoComisionCC) {
            $cuentaCC->aplicaComision($comisionCC, $minSaldoComisionCC);
        });
    }

    public function aplicaInteresCA() {
        $cuentasAhorros = array_filter($this->cuentas, fn($cuenta) => $cuenta instanceof CuentaAhorros);

        // Captura las propiedades necesarias con 'use'
        $interesCA = $this->getInteresCA();

        array_walk($cuentasAhorros, function ($cuentaCA) use ($interesCA) {
            $cuentaCA->aplicaInteres($interesCA);
        });
    }
}
