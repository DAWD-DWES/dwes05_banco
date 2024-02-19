<?php

require_once "../src/modelo/Cliente.php";
require_once "../src/modelo/Cuenta.php";
require_once "../src/modelo/TarjetaCredito.php";
require_once "../src/modelo/CuentaCorriente.php";
require_once "../src/modelo/CuentaAhorros.php";
require_once "../src/modelo/TipoCuenta.php";
require_once "../src/excepciones/ClienteNoEncontradoException.php";
require_once "../src/excepciones/CuentaNoEncontradaException.php";

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
     * Predicado para saber si un cliente existe o no
     * 
     * @param string $dni
     * @return ?Cliente
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
    public function getCliente(string $dni): Cliente {
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
    public function getCuenta(string $idCuenta): Cuenta {
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
    public function altaCuentaCliente(string $dni, float $saldo = 0, TipoCuenta $tipo = TipoCuenta::CORRIENTE): string {
        $cliente = $this->getCliente($dni);
        if ($tipo == TipoCuenta::CORRIENTE) {
            $cuenta = new CuentaCorriente($dni, $saldo);
        } elseif ($tipo == TipoCuenta::AHORROS) {
            $cuenta = new CuentaAhorros($dni, $saldo);
        }
        $this->agregaCuenta($cuenta);
        $cliente->altaCuenta($cuenta->getId());
        return $cuenta->getId();
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
     * Elimina una cuenta de un cliente del banco
     * 
     * @param string $dni
     * @param string $idCuenta
     */
    public function bajaCuentaCliente(string $dni, string $idCuenta) {
        $cliente = $this->getCliente($dni);
        if ($cliente->compruebaIdCuenta($idCuenta)) {
            $this->eliminaCuenta($idCuenta);
            $cliente->bajaCuenta($idCuenta);
        }
    }

    /**
     * Obtener cuenta bancaria (como copia del objeto cuenta del banco)
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
        if ($cliente->compruebaIdCuenta($idCuenta)) {
            $cuenta = $this->getCuenta($idCuenta);
            $cuenta->ingreso($cantidad, $descripcion);
        }
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
        if ($cliente->compruebaIdCuenta($idCuenta)) {
            $cuenta = $this->getCuenta($idCuenta);
            $cuenta->debito($cantidad, $descripcion);
        }
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
        if ($clienteOrigen->compruebaIdCuenta($idCuentaOrigen) && $clienteDestino->compruebaIdCuenta($idCuentaDestino)) {
            $this->debitoCuentaCliente($dniClienteOrigen, $idCuentaOrigen, $cantidad, "Transferencia de $cantidad € desde su cuenta $idCuentaOrigen a la cuenta $idCuentaDestino");
            $this->ingresoCuentaCliente($dniClienteDestino, $idCuentaDestino, $cantidad, "Transferencia de $cantidad € a su cuenta $idCuentaDestino desde la cuenta $idCuentaOrigen");
        }
    }

    /**
     * Aplica cargos de comisión a la cuenta corriente
     */
    public function aplicaComisionCC() {
        $cuentasCorrientes = array_filter($this->getCuentas(), fn($cuenta) => $cuenta instanceof CuentaCorriente);

        // Captura las propiedades necesarias con 'use'
        $comisionCC = $this->getComisionCC();
        $minSaldoComisionCC = $this->getminSaldoComisionCC();

        array_walk($cuentasCorrientes, function ($cuentaCC) use ($comisionCC, $minSaldoComisionCC) {
            $cuentaCC->aplicaComision($comisionCC, $minSaldoComisionCC);
        });
    }

    /**
     * Aplica intereses a la cuenta de ahorros
     */
    public function aplicaInteresCA() {
        $cuentasAhorros = array_filter($this->getCuentas(), fn($cuenta) => $cuenta instanceof CuentaAhorros);
        // Captura las propiedades necesarias con 'use'
        $interesCA = $this->getInteresCA();
        array_walk($cuentasAhorros, function ($cuentaCA) use ($interesCA) {
            $cuentaCA->aplicaInteres($interesCA);
        });
    }

    /**
     * Realiza un ingreso a un producto bancario cualquiera
     * 
     * @param string $dni
     * @param IProductoBancario $productoBancario
     * @param float $cantidad
     * @param string $descripcion
     */
    public function ingresoProductoBancarioCliente(string $dni, IProductoBancario $productoBancario, float $cantidad, string $descripcion) {
        $cliente = $this->getCliente($dni);
        $productoBancario->ingreso($cantidad, $descripcion);
    }

    /**
     * Realiza un debito a un producto bancario cualquiera
     * @param string $dni
     * @param IProductoBancario $productoBancario
     * @param float $cantidad
     * @param string $descripcion
     */
    public function debitoProductoBancarioCliente(string $dni, IProductoBancario $productoBancario, float $cantidad, string $descripcion) {
        $cliente = $this->getCliente($dni);
        $productoBancario->debito($cantidad, $descripcion);
    }

    /**
     * Realiza un cargo a un producto bancario
     * @param IProductoBancario $productoBancario
     * @param float $cantidad
     * @param string $descripcion
     */
  /*  public function realizarCargo(IProductoBancario $productoBancario, float $cantidad, string $descripcion) {
        $productoBancario->debito($cantidad, $descripcion);
    } */

    /**
     * Aplica una bonificación a un producto bancario
     * @param IProductoBancario $productoBancario
     * @param float $cantidad
     * @param string $descripcion
     */
   /* public function AplicoBonificacion(IProductoBancario $productoBancario, float $cantidad, string $descripcion) {
        $productoBancario->ingreso($cantidad, $descripcion);
    } */
}
