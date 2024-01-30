<?php

require_once '../src/modelo/Cuenta.php';

class CuentaDAO {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorId(int $id) {
        $stmt = $this->pdo->prepare("SELECT cuenta_id as id, cliente_id as idCliente, tipo, saldo, fecha_creacion as fechaCreacion FROM cuentas WHERE cuenta_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cuenta');
        return $stmt->fetch();
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

    // Otros métodos, como obtenerTodos, etc.
}

