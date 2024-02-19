<?php

require_once '../src/dao/IDAO.php';
require_once '../src/modelo/Cliente.php';
require_once '../src/dao/CuentaDAO.php';

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
        $stmt = $this->pdo->prepare("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE cliente_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $cliente = $stmt->fetch();
        $stmt->closeCursor();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($this->getId()));
        }
        return $cliente;
    }

    /**
     * Obtener un cliente dado su DNI
     * 
     * @param string $dni
     * @return Cliente|null
     */
    public function obtenerPorDNI(string $dni): ?Cliente {
        $stmt = $this->pdo->prepare("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes WHERE dni = :dni");
        $stmt->execute(['dni' => $dni]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $cliente = $stmt->fetch();
        $stmt->closeCursor();
        if ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($cliente->getId()));
        }
        return $cliente;
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
        $stmt = $this->pdo->query("SELECT cliente_id as id, dni, nombre, apellido1, apellido2, fecha_nacimiento as fechaNacimiento, telefono FROM clientes");
        $clientes = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cliente');
        $stmt->closeCursor();
        array_walk($clientes, function ($cliente) {
            $this->inicializarPostPDO($cliente);
            $cliente->setIdCuentas($this->cuentaDAO->obtenerIdCuentasPorClienteId($cliente->getId()));
        });
        return $clientes;
    }

    /**
     * Crea un registro de una instancia de cliente
     * @param object $object
     * @throws InvalidArgumentException
     */
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
            $stmt->closeCursor();
            $cliente->setId($this->pdo->lastInsertId());
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cliente.');
        }
    }

    /**
     * Modifica un registro de una instancia de clienteç
     * 
     * @param object $object
     * @throws InvalidArgumentException
     */
    public function modificar(object $object) {
        if ($object instanceof Cliente) {
            $cliente = $object;
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
            $stmt->closeCursor();
        } else {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Cliente.');
        }
    }

    /**
     * Elimina un registro de una instancia de cliente
     * @param int $id
     */
    public function eliminar(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE cliente_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->closeCursor();
    }
}
