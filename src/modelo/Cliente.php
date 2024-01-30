<?php

/**
 * Clase Cliente 
 */
class Cliente {

    /**
     * ID del cliente
     * @var string
     */
    private string $id;

    /**
     * DNI del cliente
     * @var string
     */
    private string $dni;

    /**
     * Nombre del cliente
     * @var string
     */
    private string $nombre;

    /**
     * Apellido1 del cliente
     * @var string
     */
    private string $apellido1;

    /**
     * Apellido2 del cliente
     * @var string
     */
    private string $apellido2;

    /**
     * Fecha de nacimiento del cliente
     * @var DateTime
     */
    private DateTime $fechaNacimiento;

    /**
     * Teléfono del cliente
     * @var string
     */
    private string $telefono;

    /**
     * Colección de identificadores de las cuentas del cliente
     * @var array
     */
    private array $idCuentas;

    public function __construct(string $dni = null, string $nombre = null, string $apellido1 = null, string $apellido2 = null, string $telefono = null, string $fechaNacimiento = null) {
        if (!is_null($dni)) {
            $this->setDni($dni);
        }
        if (!is_null($nombre)) {
            $this->setNombre($nombre);
        }
        if (!is_null($apellido1)) {
            $this->setApellido1($apellido1);
        }
        if (!is_null($apellido2)) {
            $this->setApellido2($apellido2);
        }
        if (!is_null($telefono)) {
            $this->setTelefono($telefono);
        }
        if (!is_null($fechaNacimiento)) {
            $this->setFechaNacimiento(new DateTime($fechaNacimiento));
        }
        $this->setCuentas([]);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDni(): string {
        return $this->dni;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido1(): string {
        return $this->apellido1;
    }

    public function getApellido2(): string {
        return $this->apellido2;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function getFechaNacimiento(): DateTime {
        return $this->fechaNacimiento;
    }

    public function getCuentas(): array {
        return $this->idCuentas;
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    public function setDni(string $dni) {
        $this->dni = $dni;
        return $this;
    }

    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function setApellido1(string $apellido1) {
        $this->apellido1 = $apellido1;
        return $this;
    }

    public function setApellido2(string $apellido2) {
        $this->apellido2 = $apellido2;
        return $this;
    }

    public function setTelefono(string $telefono) {
        $this->telefono = $telefono;
        return $this;
    }

    public function setFechaNacimiento(DateTime $fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
        return $this;
    }

    public function setIdCuentas(array $idCuentas) {
        $this->idCuentas = $idCuentas;
        return $this;
    }

    public function altaCuenta(string $idCuenta) {
        $this->idCuentas[] = $idCuenta;
    }

    public function tieneCuenta(string $idCuenta) {
        return (array_search($idCuenta, $this->getCuentas()) !== false);
    }

    public function bajaCuenta(string $idCuenta) {
        $clave = array_search($idCuenta, $this->getCuentas());
        // Si la clave existe en el array, elimina el elemento
        if ($clave !== false) {
            unset($this->getCuentas[$clave]);
        }
        $this->setCuentas(array_values($this->getCuentas()));
    }
}
