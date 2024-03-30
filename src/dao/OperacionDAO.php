<?php

namespace App\dao;

use App\modelo\Operacion;
use App\modelo\TipoOperacion;
use DateTime;
use PDO;

/**
 * Clase OperacionDAO
 */
class OperacionDAO implements IDAO {

    /**
     * Conexión a la base de datos
     * @var PDO
     */
    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtener operación por identificador
     * @param int $id
     * @return Operacion|null
     */
    public function obtenerPorId(int $id): ?Operacion {
        $sql = "SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones WHERE operacion_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Operacion::class);
        $operacion = $stmt->fetch();
        return $operacion ? $this->inicializarPostPDO($operacion) : null;
    }

    /**
     * Obtener operaciones por identificador de cuenta
     * @param int $idCuenta
     * @return array
     */
    public function obtenerPorIdCuenta(int $idCuenta): array {
        $sql = "SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones WHERE cuenta_id = :idCuenta;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idCuenta' => $idCuenta]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Operacion::class);
        $operaciones = $stmt->fetchAll() ?? [];
        array_walk($operaciones, fn($operacion) => $this->inicializarPostPDO($operacion));
        return $operaciones;
    }

    /**
     * Cambia el valor de la propiedad de FechaCreacion de string a DateTime y Tipo de Operación
     * @param Operacion $operacion
     * @return Operacion
     */
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

    /**
     * Obtener todas las operaciones
     * @return type
     */
    public function obtenerTodos(): array {
        $sql = "SELECT operacion_id as id, cuenta_id as idCuenta, tipo_operacion as tipo, cantidad, fecha_operacion as fecha, descripcion FROM operaciones;";
        $stmt = $this->pdo->query($sql);
        $operaciones = $stmt->fetchAll(PDO::FETCH_CLASS, Operacion::class);
        array_walk($operaciones, function ($operacion) {
            $this->inicializarPostPDO($cliente);
        });
        return $operaciones;
    }

    /**
     * Crea un registro de una instancia de operación
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function crear(object $object): bool {
        $sql = "INSERT INTO operaciones (cuenta_id, tipo_operacion, cantidad, descripcion) VALUES (:cuenta_id, :tipo_operacion, :cantidad, :descripcion);";
        if ($object instanceof Operacion) {
            $operacion = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'cuenta_id' => $operacion->getIdCuenta(),
                'tipo_operacion' => $operacion->getTipo()->value,
                'cantidad' => $operacion->getCantidad(),
                'descripcion' => $operacion->getDescripcion()
            ]);
            if ($result) {
                $operacion->setId($this->pdo->lastInsertId());
            }
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Operacion.');
        }
        return $result;
    }

    /**
     * Modifica un registro de una instancia de operación
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function modificar(object $object): bool {
        $sql = "UPDATE operaciones SET cuenta_id = :cuenta_id, tipo_operacion = :tipo_operacion, cantidad = :cantidad, fecha_operacion = :fecha_operacion, descripcion = :descripcion WHERE operacion_id = :id;";
        if ($object instanceof Operacion) {
            $operacion = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'id' => $operacion->getId(),
                'cuenta_id' => $operacion->getIdCuenta(),
                'tipo_operacion' => $operacion->getTipo(),
                'cantidad' => $operacion->getCantidad(),
                'fecha_operacion' => $operacion->getFecha()->format('Y-m-d H:i:s'),
                'descripcion' => $operacion->getDescripcion()
            ]);
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Operacion.');
        }
        return $result;
    }

    /**
     * Elimina un registro de una instancia de operación
     * @param type $id
     */
    public function eliminar(int $id): bool {
        $sql = "DELETE FROM operaciones WHERE operacion_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        return $result;
    }
}
