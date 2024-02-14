<?php

require_once '../src/dao/IDAO.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/modelo/CuentaAhorros.php';
require_once '../src/modelo/CuentaCorriente.php';
require_once '../src/modelo/TipoCuenta.php';
require_once '../src/dao/OperacionDAO.php';

class CuentaDAO implements IDAO {

    private PDO $pdo;
    private OperacionDAO $operacionDAO;

    public function __construct(PDO $pdo, OperacionDAO $operacionDAO) {
        $this->pdo = $pdo;
        $this->operacionDAO = $operacionDAO;
    }
    
    public function obtenerPorId(int $id): CuentaCorriente|CuentaAhorros|null {
        $stmt = $this->pdo->prepare("SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas WHERE cuenta_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $datosCuenta = $stmt->fetch();
        if ($datosCuenta) {
            $cuenta = $this->crearCuenta($datosCuenta);
            $operaciones = $this->operacionDAO->obtenerPorIdCuenta($cuenta->getId());
            $cuenta->setOperaciones($operaciones);
            return $cuenta;
        }
    }

    public function obtenerIdCuentasPorClienteId(int $idCliente): array {
        $stmt = $this->pdo->prepare("SELECT cuenta_id FROM cuentas WHERE cliente_id = :idCliente");
        $stmt->execute(['idCliente' => $idCliente]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $idCuentas = $stmt->fetchAll() ?? [];
        return $idCuentas;
    }

    public function obtenerIdCuentasPorClienteDni(string $dni): array {
        $stmt = $this->pdo->prepare("SELECT cuenta_id FROM cuentas WHERE dni = :dni");
        $stmt->execute(['dni' => $dni]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $idCuentas = $stmt->fetchAll() ?? [];
        return $idCuentas;
    }

    private function crearCuenta(object $datosCuenta): CuentaCorriente|CuentaAhorros {
        $cuenta = match (strtoupper($datosCuenta?->tipo)) {
            TipoCuenta::AHORROS->name => (new CuentaAhorros($this->operacionDAO, $datosCuenta->idCliente, $datosCuenta->saldo)),
            TipoCuenta::CORRIENTE->name => (new CuentaCorriente($this->operacionDAO, $datosCuenta->idCliente, $datosCuenta->saldo)),
            default => null
        };
        if (is_string($datosCuenta->fechaCreacion)) {
            $cuenta->setFechaCreacion(new DateTime($datosCuenta->fechaCreacion));
        }
        $cuenta->setId($datosCuenta->id);
        $operaciones = $this->operacionDAO->obtenerPorIdCuenta($datosCuenta->id);
        $cuenta->setOperaciones($operaciones);
        return $cuenta;
    }

    public function obtenerTodos(): array {
        $stmt = $this->pdo->query("SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas");
        $cuentasDatos = $stmt->fetchAll(PDO::FETCH_OBJ);
        return array_values(array_map(fn($datos) => $this->crearCuenta($datos), $cuentasDatos));
    }

    public function crear(object $object) {
        if ($object instanceof Cuenta) {
            $cuenta = $object;
            $stmt = $this->pdo->prepare("INSERT INTO cuentas (cliente_id, tipo, saldo, fecha_creacion) VALUES (:cliente_id, :tipo, :saldo, :fecha_creacion)");
            $stmt->execute([
                'cliente_id' => $cuenta->getIdCliente(),
                'tipo' => (get_class($cuenta) == "CuentaCorriente" ? TipoCuenta::CORRIENTE->name : TipoCuenta::AHORROS->name),
                'saldo' => $cuenta->getSaldo(),
                'fecha_creacion' => $cuenta->getFechaCreacion()->format('Y-m-d H:i:s')
            ]);
            $cuenta->setId($this->pdo->lastInsertId());
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cuenta.');
        }
    }

    public function modificar(object $object) {
        if ($object instanceof Cuenta) {
            $cuenta = $object;
            $stmt = $this->pdo->prepare("UPDATE cuentas SET cliente_id = :cliente_id, tipo = :tipo, saldo = :saldo, fecha_creacion = :fecha_creacion WHERE cuenta_id = :id");
            $stmt->execute([
                'id' => $cuenta->getId(),
                'cliente_id' => $cuenta->getIdCliente(),
                'tipo' => $cuenta->getTipo(),
                'saldo' => $cuenta->getSaldo(),
                'fecha_creacion' => $cuenta->getFechaCreacion()->format('Y-m-d H:i:s')
            ]);
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cuenta.');
        }
    }

    public function eliminar(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM cuentas WHERE cuenta_id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollback() {
        $this->pdo->rollback();
    }
}
