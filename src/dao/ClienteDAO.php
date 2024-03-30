<?php

namespace App\dao;

use App\modelo\Cliente;
use App\dao\CuentaDAO;
use PDO;
use DateTime;
use InvalidArgumentException;

/**
 * Clase ClienteDAO
 */
class ClienteDAO implements IDAO {

    /**
     * Conexión a la base de datos
     * @var PDO
     */
    private PDO $pdo;

    /**
     * DAO para gestionar cuentas 
     * @var CuentaDAO
     */
    private CuentaDAO $cuentaDAO;

    public function __construct($pdo, $cuentaDAO) {
        $this->pdo = $pdo;
        $this->cuentaDAO = $cuentaDAO;
    }

    /**
     * Obtener un cliente dado su identificador
     * 
     * @param int $id
     * @return Cliente|null
     */
    public function obtenerPorId(int $id): ?Cliente {
        $sql = "SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE cliente_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Cliente::class);
        $cliente = $stmt->fetch();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($this->getId()));
        }
        return $cliente ?: null;
    }

    /**
     * Obtener un cliente dado su DNI
     * 
     * @param string $dni
     * @return Cliente|null
     */
    public function obtenerPorDNI(string $dni): ?Cliente {
        $sql = "SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE dni = :dni;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['dni' => $dni]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Cliente::class);
        $cliente = $stmt->fetch();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($cliente->getId()));
        }
        return $cliente ?: null;
    }

    /**
     * Cambia el valor de la propiedad de FechaNacimiento de string a DateTime
     * @param Cliente $cliente
     * @return Cliente
     */
    private function inicializarPostPDO(Cliente $cliente): Cliente {
        if (is_string($cliente->getFechaNacimiento())) {
            $cliente->setFechaNacimiento(new DateTime($cliente->getFechaNacimiento()));
        }
        return $cliente;
    }

    /**
     * Obtiene la lista de todos los clientes
     * @return type
     */
    public function obtenerTodos(): array {
        $sql = "SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes;";
        $stmt = $this->pdo->query($sql);
        $clientes = $stmt->fetchAll(PDO::FETCH_CLASS, Cliente::class);
        array_walk($clientes, function ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($cliente->getId()));
        });
        return $clientes;
    }

    /**
     * Obtiene el número de clientes en la BD
     * @return int Número de clientes
     */
    public function numeroClientes(): int {
        $sql = "SELECT count(*) FROM clientes;";
        $stmt = $this->pdo->query($sql);
        $numero = $stmt->fetchColumn();
        return $numero;
    }

    /**
     * Crea un registro de una instancia de cliente
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function crear(object $object): bool {
        $sql = "INSERT INTO clientes (dni, nombre, apellido1, apellido2, fecha_nacimiento, telefono) VALUES (:dni, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :telefono);";
        if ($object instanceof \App\modelo\Cliente) {
            $cliente = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'dni' => $cliente->getDni(),
                'nombre' => $cliente->getNombre(),
                'apellido1' => $cliente->getApellido1(),
                'apellido2' => $cliente->getApellido2(),
                'fecha_nacimiento' => $cliente->getFechaNacimiento()->format('Y-m-d'),
                'telefono' => $cliente->getTelefono()
            ]);
            if ($result) {
                $cliente->setId($this->pdo->lastInsertId());
            }
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cliente.');
        }
        return $result;
    }

    /**
     * Modifica un registro de una instancia de cliente
     * 
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function modificar(object $object): bool {
        $sql = "UPDATE clientes SET dni = :dni, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono WHERE cliente_id = :id;";
        if ($object instanceof \App\modelo\Cliente) {
            $cliente = $object;
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                'id' => $cliente->getId(),
                'dni' => $cliente->getDni(),
                'nombre' => $cliente->getNombre(),
                'apellido1' => $cliente->getApellido1(),
                'apellido2' => $cliente->getApellido2(),
                'fecha_nacimiento' => $cliente->getFechaNacimiento()->format('Y-m-d'),
                'telefono' => $cliente->getTelefono()
            ]);
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cliente.');
        }
        return $result;
    }

    /**
     * Elimina un registro de una instancia de cliente
     * @param int $id
     */
    public function eliminar(int $id): bool {
        $sql = "DELETE FROM clientes WHERE cliente_id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        return $result;
    }
}
