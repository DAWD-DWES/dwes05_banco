<?php

require_once '../src/dao/IDAO.php';
require_once '../src/modelo/Cliente.php';
require_once '../src/dao/CuentaDAO.php';

class ClienteDAO implements IDAO {

    private PDO $pdo;
    private CuentaDAO $cuentaDAO;

    public function __construct($pdo, $cuentaDAO) {
        $this->pdo = $pdo;
        $this->cuentaDAO = $cuentaDAO;
    }

    public function obtenerPorId(int $id): ?Cliente {
        $stmt = $this->pdo->prepare("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE cliente_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $cliente = $stmt->fetch();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($this->getId()));
            return $cliente;
        }
    }

    public function obtenerPorDNI(string $dni): ?Cliente {
        $stmt = $this->pdo->prepare("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE dni = :dni");
        $stmt->execute(['dni' => $dni]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $cliente = $stmt->fetch();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($this->getId()));
            return $cliente;
        }
    }

    private function inicializarPostPDO(Cliente $cliente): Cliente {
        if (is_string($cliente->getFechaNacimiento())) {
            $cliente->setFechaNacimiento(new DateTime($cliente->getFechaNacimiento()));
        }
        return $cliente;
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes");
        $clientes = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cliente');
        return $clientes;
    }

    public function crear(object $object) {
        if ($object instanceof Cliente) {
            $cliente = $object;
            $stmt = $this->pdo->prepare("INSERT INTO clientes (dni, nombre, apellido1, apellido2, fecha_nacimiento, telefono) VALUES (:dni, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :telefono)");
            $stmt->execute([
                'dni' => $cliente->getDni(),
                'nombre' => $cliente->getNombre(),
                'apellido1' => $cliente->getApellido1(),
                'apellido2' => $cliente->getApellido2(),
                'fecha_nacimiento' => $cliente->getFechaNacimiento()->format('Y-m-d'),
                'telefono' => $cliente->getTelefono()
            ]);
            $cliente->setId($this->pdo->lastInsertId());
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cliente.');
        }
    }

    public function modificar(object $object) {
        $stmt = $this->pdo->prepare("UPDATE clientes SET dni = :dni, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono WHERE cliente_id = :id");
        $stmt->execute([
            'id' => $cliente->getId(),
            'dni' => $cliente->getDni(),
            'nombre' => $cliente->getNombre(),
            'apellido1' => $cliente->getApellido1(),
            'apellido2' => $cliente->getApellido2(),
            'fecha_nacimiento' => $cliente->getFechaNacimiento()->format('Y-m-d'),
            'telefono' => $cliente->getTelefono()
        ]);
    }

    public function eliminar(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE cliente_id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Otros métodos como obtenerTodos, etc.
}
