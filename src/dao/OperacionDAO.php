<?php

require_once '../src/dao/IDAO.php';
require_once '../src/modelo/Operacion.php';

class OperacionDAO implements IDAO {

    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorId(int $id): ?Operacion {
        $stmt = $this->pdo->prepare("SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones WHERE operacion_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Operacion');
        $operacion = $stmt->fetch();
        return $operacion ? $this->inicializarPostPDO($operacion) : null;
    }

    public function obtenerPorIdCuenta(int $idCuenta): array {
        $stmt = $this->pdo->prepare("SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones WHERE cuenta_id = :idCuenta");
        $stmt->execute(['idCuenta' => $idCuenta]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Operacion');
        $operaciones = $stmt->fetchAll() ?? [];
        array_walk($operaciones, fn($operacion) => $this->inicializarPostPDO($operacion));
        return $operaciones;
    }

    private function inicializarPostPDO(Operacion $operacion): Operacion {
        if (is_string($operacion->getFecha())) {
            $operacion->setFecha(new DateTime($operacion->getFecha()));
        }
        if (is_string($operacion->getTipo())) {
            $operacion->setTipo(match ($operacion->getTipo()) {
                TipoOperacion::INGRESO->value => TipoOperacion::INGRESO,
                TipoOperacion::DEBITO->value => TipoOperacion::DEBITO,
                default => null
            });
        }
        return $operacion;
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Operacion');
    }

    public function crear(object $object) {
        if ($object instanceof Operacion) {
            $operacion = $object;
            $stmt = $this->pdo->prepare("INSERT INTO operaciones (cuenta_id, tipo_operacion, cantidad, fecha_operacion, descripcion) VALUES (:cuenta_id, :tipo_operacion, :cantidad, :fecha_operacion, :descripcion)");
            $stmt->execute([
                'cuenta_id' => $operacion->getIdCuenta(),
                'tipo_operacion' => $operacion->getTipo()->value,
                'cantidad' => $operacion->getCantidad(),
                'fecha_operacion' => $operacion->getFecha()->format('Y-m-d'),
                'descripcion' => $operacion->getDescripcion()
            ]);
            $operacion->setId($this->pdo->lastInsertId());
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Operacion.');
        }
    }

    public function modificar(object $object) {
        if ($object instanceof Operacion) {
            $operacion = $object;
            $stmt = $this->pdo->prepare("UPDATE operacions SET cuenta_id = :cuenta_id, tipo_operacion = :tipo_operacion, cantidad = :cantidad, fecha_operacion = :fecha_operacion, descripcion = :descripcion WHERE operacion_id = :id");
            $stmt->execute([
                'id' => $operacion->getId(),
                'cuenta_id' => $operacion->getIdCuenta(),
                'tipo_operacion' => $operacion->getTipo(),
                'cantidad' => $operacion->getCantidad(),
                'fecha_operacion' => $operacion->getFecha()->format('Y-m-d'),
                'descripcion' => $operacion->getDescripcion()
            ]);
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Operacion.');
        }
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM operacions WHERE operacion_id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Otros métodos como obtenerTodos, etc.
}
