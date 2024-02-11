<?php

require_once '../src/modelo/IDAO.php';
require_once '../src/modelo/Cuenta.php';
require_once '../src/modelo/CuentaAhorros.php';
require_once '../src/modelo/CuentaCorriente.php';
require_once '../src/modelo/TipoCuenta.php';
require_once 'OperacionDAO.php';

class CuentaDAO implements IDAO{

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorId(int $id): CuentaCorriente|CuentaAhorros|null {
        $stmt = $this->pdo->prepare("SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas WHERE cuenta_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_OBJECT);
        $cuentaDatos = $stmt->fetch();
        if ($cuentaDatos) {
            return $this->crearCuenta($cuentaDatos);
        }
    }

    private function crearCuenta(Object $cuentaDatos): CuentaCorriente|CuentaAhorros {
        $operacionDAO = new OperacionDAO($this->pdo);
        $cuenta = match ($cuentaDatos?->tipo) {
            TipoCuenta::AHORROS => (new CuentaAhorros($cuentaDatos->dni, $cuentaDatos->saldo)),
            TipoCuenta::CORRIENTE => (new CuentaAhorros($cuentaDatos->dni, $cuentaDatos->saldo)),
            "default" => null
        };
        if (is_string($cuentaDatos->fechaCreacion())) {
            $cuenta->setFechaCreacion(new DateTime($cuentaDatos->fechaCreacion));
        }
        $cuenta->setId($cuentaDatos->id);
        $operaciones = $operacionDAO->obtenerPorIdCuenta($cuentaDatos->id);
        $cuenta->setOperaciones($operaciones);
        return $cuenta;
    }

    public function obtenerTodos(): array {
        $stmt = $this->pdo->query("SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas");
        $cuentasDatos = $stmt->fetchAll(PDO::FETCH_OBJECT);
        return array_values(array_map (fn($datos) => $this->crearCuenta($datos), $cuentasDatos));
    }

    public function crear(Cuenta $cuenta) {
        $stmt = $this->pdo->prepare("INSERT INTO cuentas (cliente_id, tipo, saldo, fecha_creacion) VALUES (:cliente_id, :tipo, :saldo, :fecha_creacion)");
        $stmt->execute([
            'cliente_id' => $cuenta->getIdCliente(),
            'tipo' => $cuenta->getTipo(),
            'saldo' => $cuenta->getSaldo(),
            'fecha_creacion' => $cuenta->getFechaCreacion()->format('Y-m-d H:i:s')
        ]);
        $cuenta->setId($this->pdo->lastInsertId());
    }

    public function modificar(Cuenta $cuenta) {
        $stmt = $this->pdo->prepare("UPDATE cuentas SET cliente_id = :cliente_id, tipo = :tipo, saldo = :saldo, fecha_creacion = :fecha_creacion WHERE cuenta_id = :id");
        $stmt->execute([
            'id' => $cuenta->getId(),
            'cliente_id' => $cuenta->getIdCliente(),
            'tipo' => $cuenta->getTipo(),
            'saldo' => $cuenta->getSaldo(),
            'fecha_creacion' => $cuenta->getFechaCreacion()->format('Y-m-d H:i:s')
        ]);
    }

    public function eliminar(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM cuentas WHERE cuenta_id = :id");
        $stmt->execute(['id' => $id]);
    }
}
