<?php

namespace App\modelo;

use App\dao\IDAO;
use App\excepciones\ClienteNoEncontradoException;
use App\excepciones\CuentaNoEncontradaException;
use PDOException;

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
    private ?IDAO $clienteDAO;

    /**
     * DAO para persistir cuentas
     * @var IDAO
     */
    private ?IDAO $cuentaDAO;

    /**
     * DAO para persistir operaciones
     * @var IDAO
     */
    private ?IDAO $operacionDAO;

    /**
     * Constructor de la clase Banco
     * 
     * @param string $nombre Nombre del banco
     */
    public function __construct( string $nombre, IDAO $clienteDAO = null, IDAO $cuentaDAO = null, IDAO $operacionDAO = null) {
        $this->setNombre($nombre);
        $this->clienteDAO = $clienteDAO;
        $this->cuentaDAO = $cuentaDAO;
        $this->operacionDAO = $operacionDAO;
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
    public function obtenerClientes(): array {
        return $this->clienteDAO->obtenerTodos();
    }

    /**
     * Obtiene las cuentas del banco
     * 
     * @return array
     */
    public function obtenerCuentas(): array {
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
    public function getMinSaldoComisionCC(): float {
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
    public function setClientes(array $clientes = []) {
        foreach ($clientes as $cliente) {
            $this->clienteDAO->crear($cliente);
        }
    }

    /**
     * Establece la colección de cuentas del banco
     *  
     * @param array $cuentas Colección de cuentas del banco
     * @return $this
     */
    public function setCuentas(array $cuentas = []) {
        foreach ($cuentas as $cuenta) {
            $this->cuentaDAO->crear($cuenta);
        }
    }

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
     * Establece el cliente DAO
     * 
     * @return void
     */
    public function setClienteDAO(IDAO $clienteDAO): void {
        $this->clienteDAO = $clienteDAO;
    }
    
    /**
     * Establece la cuenta DAO
     * 
     * @return void
     */
    public function setCuentaDAO(IDAO $cuentaDAO): void {
        $this->cuentaDAO = $cuentaDAO;
    }
    
    
    /**
     * Establece la operación DAO
     * 
     * @return void
     */
    public function setOperacionDAO(IDAO $operacionDAO): void {
        $this->operacionDAO = $operacionDAO;
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
        $cuentas = $cliente->getIdCuentas();
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
    public function altaCuentaCliente(string $dni, TipoCuenta $tipo = TipoCuenta::CORRIENTE): string {
        $cliente = $this->obtenerCliente($dni);
        if ($tipo == TipoCuenta::CORRIENTE) {
            $cuenta = new CuentaCorriente($this->operacionDAO, TipoCuenta::CORRIENTE, $cliente->getId());
        } elseif ($tipo == TipoCuenta::AHORROS) {
            $cuenta = new CuentaAhorros($this->operacionDAO, TipoCuenta::AHORROS, $cliente->getId());
        }
        $this->cuentaDAO->crear($cuenta);
        return $cuenta->getId();
    }

    /**
     * Elimina una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     */
    public function bajaCuentaCliente(string $dni, int $idCuenta) {
        $cliente = $this->obtenerCliente($dni);
        $cuenta = $this->cuentaDAO->obtenerPorId($idCuenta);
        $this->cuentaDAO->eliminar($cuenta->getId());
    }

    /**
     * Crea una tarjeta de un cliente del banco
     * 
     * @param string $dni
     * @param float $saldo
     */
    public function altaTarjetaCreditoCliente(string $dni): TarjetaCredito {
        $cliente = $this->getCliente($dni);
        $tarjeta = new TarjetaCredito(10000);
        return $tarjeta;
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
        $cuenta = $this->obtenerCuenta($idCuenta);
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
    public function realizaTransferencia(string $dniClienteOrigen, string $dniClienteDestino,
            int $idCuentaOrigen, int $idCuentaDestino, float $cantidad, string $asunto) {
        $clienteOrigen = $this->obtenerCliente($dniClienteOrigen);
        $clienteDestino = $this->obtenerCliente($dniClienteDestino);
        $cuentaOrigen = $this->obtenerCuenta($idCuentaOrigen);
        $cuentaDestino = $this->obtenerCuenta($idCuentaDestino);

        try {
            $this->cuentaDAO->beginTransaction();
            $cuentaOrigen->debito($cantidad, "Transferencia de $cantidad € desde su cuenta $idCuentaOrigen a la cuenta $idCuentaDestino");
            $this->cuentaDAO->modificar($cuentaOrigen);
            $cuentaDestino->ingreso($cantidad, "Transferencia de $cantidad €. Asunto: $asunto");
            $this->cuentaDAO->modificar($cuentaDestino);
            $this->cuentaDAO->commit();
            $this->cuentaDAO->endTransaction();
        } catch (PDOException) {
            $this->cuentaDAO->rollback();
            $this->cuentaDAO->endTransaction();
        }
    }

    /**
     * Aplica cargos de comisión a la cuenta corriente
     */
    public function aplicaComisionCC() {
        $cuentasCorrientes = array_filter($this->obtenerCuentas(), fn($cuenta) => $cuenta instanceof CuentaCorriente);

        // Captura las propiedades necesarias con 'use'
        $comisionCC = $this->getComisionCC();
        $minSaldoComisionCC = $this->getMinSaldoComisionCC();

        array_walk($cuentasCorrientes, function ($cuentaCC) use ($comisionCC, $minSaldoComisionCC) {
            $cuentaCC->aplicaComision($comisionCC, $minSaldoComisionCC);
            $this->cuentaDAO->modificar($cuentaCC);
        });
    }

    public function aplicaInteresCA() {
        $cuentasAhorros = array_filter($this->obtenerCuentas(), fn($cuenta) => $cuenta instanceof CuentaAhorros);

        // Captura las propiedades necesarias con 'use'
        $interesCA = $this->getInteresCA();

        array_walk($cuentasAhorros, function ($cuentaCA) use ($interesCA) {
            $cuentaCA->aplicaInteres($interesCA);
            $this->cuentaDAO->modificar($cuentaCA);
        });
    }

}
