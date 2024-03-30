<?php

namespace App\dao;

use App\modelo\CuentaAhorros;
use App\modelo\CuentaCorriente;
use App\modelo\TipoCuenta;
use App\dao\OperacionDAO;
use PDO;
use DateTime;
use InvalidArgumentException;

/**
 * Clase CuentaDAO
 */
class CuentaDAO implements IDAO {

    /**
     * Conexión a la base de datos
     * @var PDO
     */
    private PDO $pdo;

    /**
     * DAO para gestionar operaciones
     * @var OperacionDAO
     */
    private OperacionDAO $operacionDAO;

    public function __construct(PDO $pdo, OperacionDAO $operacionDAO) {
        $this->pdo = $pdo;
        $this->operacionDAO = $operacionDAO;
    }

    /**
     * Obtener una cuenta dado su identificador
     * @param int $id
     * @return CuentaCorriente|CuentaAhorros|null
     */
    public function obtenerPorId(int $id): CuentaCorriente|CuentaAhorros|null {
        $sql = "SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas WHERE cuenta_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $datosCuenta = $stmt->fetch();
        return $datosCuenta ? $this->crearCuenta($datosCuenta) : null;
    }

    /**
     * Obtener los identificadores de las cuentas de un cliente dado su identificador
     * @param int $idCliente
     * @return array
     */
    public function obtenerIdCuentasPorClienteId(int $idCliente): array {
        $sql = "SELECT cuenta_id FROM cuentas WHERE cliente_id = :idCliente;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idCliente' => $idCliente]);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $idCuentas = $stmt->fetchAll() ?? [];
        return array_merge(...$idCuentas);
    }

    /**
     * Obtener los identificadores de las cuentas de un cliente dado su DNI
     * @param string $dni
     * @return array
     */
    public function obtenerIdCuentasPorClienteDni(string $dni): array {
        $sql = "SELECT cuenta_id FROM cuentas WHERE dni = :dni;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['dni' => $dni]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $idCuentas = $stmt->fetchAll() ?? [];
        return $idCuentas;
    }

    /**
     * Crea una cuenta a partir de los datos obtenidos del registro
     * 
     * @param object $datosCuenta
     * @return CuentaCorriente|CuentaAhorros
     */
    private function crearCuenta(object $datosCuenta): CuentaCorriente|CuentaAhorros {
        $cuenta = match ($datosCuenta?->tipo) {
            TipoCuenta::AHORROS->value => (new CuentaAhorros($this->operacionDAO, TipoCuenta::AHORROS, $datosCuenta->idCliente)),
            TipoCuenta::CORRIENTE->value => (new CuentaCorriente($this->operacionDAO, TipoCuenta::CORRIENTE, $datosCuenta->idCliente)),
            default => null
        };
        if (is_string($datosCuenta->fechaCreacion)) {
            $cuenta->setFechaCreacion(new DateTime($datosCuenta->fechaCreacion));
        }
        $cuenta->setId($datosCuenta->id);
        $cuenta->setSaldo($datosCuenta->saldo);
        $operaciones = $this->operacionDAO->obtenerPorIdCuenta($datosCuenta->id);
        $cuenta->setOperaciones($operaciones);
        return $cuenta;
    }

    /**
     * Obtiene todas las cuentas de la base de datos
     * 
     * @return array
     */
    public function obtenerTodos(): array {
        $sql = "SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas;";
        $stmt = $this->pdo->query($sql);
        $cuentasDatos = $stmt->fetchAll(PDO::FETCH_OBJ);
        return array_map(fn($datos) => $this->crearCuenta($datos), $cuentasDatos);
    }

    /**
     * Crea un registro de una instancia de cuenta
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function crear(object $object): bool {
        $sql = "INSERT INTO cuentas (cliente_id, tipo, saldo) VALUES (:cliente_id, :tipo, :saldo);";
        if ($object instanceof \App\modelo\Cuenta) {
            $cuenta = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'cliente_id' => $cuenta->getIdCliente(),
                'tipo' => $cuenta->getTipo()->value,
                'saldo' => $cuenta->getSaldo(),
            ]);
            $stmt->closeCursor();
            if ($result) {
                $cuenta->setId($this->pdo->lastInsertId());
            }
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cuenta.');
        }
        return $result;
    }

    /**
     * Modifica un registro de una instancia de cuenta
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function modificar(object $object): bool {
        $sql = "UPDATE cuentas SET cliente_id = :cliente_id, tipo = :tipo, saldo = :saldo, fecha_creacion = :fecha_creacion WHERE cuenta_id = :id;";
        if ($object instanceof \App\modelo\Cuenta) {
            $cuenta = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'id' => $cuenta->getId(),
                'cliente_id' => $cuenta->getIdCliente(),
                'tipo' => $cuenta->getTipo()->value,
                'saldo' => $cuenta->getSaldo(),
                'fecha_creacion' => $cuenta->getFechaCreacion()->format('Y-m-d H:i:s')
            ]);
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cuenta.');
        }
        return $result;
    }

    /**
     * Elimina un registro de una instancia de cuenta
     * @param int $id
     */
    public function eliminar(int $id): bool {
        $sql = "DELETE FROM cuentas WHERE cuenta_id = :id";
        $operaciones = $this->operacionDAO->obtenerPorIdCuenta($id);
        foreach ($operaciones as $operacion) {
            $this->operacionDAO->eliminar($operacion->getId());
        }
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        return $result;
    }

    // Estos métodos permiten usar el modo transaccional para operaciones de persistencia de cuentas.

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function endTransaction() {
        $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollback() {
        $this->pdo->rollback();
    }
}
