<?php

namespace App\bd;

use PDO;

/**
 * Clase que representa el singleton de la conexión a la Base de Datos
 */
class BD {
    /*
     * @var ?PDO $bd Almacena la única instancia PDO de conexión
     */

    protected static ?PDO $bd = null;

    /**
     * Constructor privado de la clase BD
     * 
     * @param string $host Nombre del Host donde reside el servidor de la base de datos
     * @param string $port Número del puerto donde escucha el servidor de la base de datos
     * @param string $database Nombre de la base de datos del juego
     * @param string $usuario Nombre del usuario para acceder a la base de datos 
     * @param string $passwrod Password del usuario
     * 
     * @returns void
     */
    private function __construct(string $host, string $port, string $database, string $usuario, string $password) {
        self::$bd = new \PDO("mysql:host=" . "$host:$port" . ";dbname=" . $database, $usuario, $password);
        self::$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
    }

    /**
     * Obtiene una instancia del singleton
     * 
     * @param string $host Nombre del Host donde reside el servidor de la base de datos
     * @param string $port Número del puerto donde escucha el servidor de la base de datos
     * @param string $database Nombre de la base de datos del juego
     * @param string $usuario Nombre del usuario para acceder a la base de datos 
     * @param string $passwrod Password del usuario
     * 
     * @returns void
     */
    public static function getConexion(string $host, string $port, string $database, string $usuario, string $password) {
        if (!self::$bd) {
            new BD($host, $port, $database, $usuario, $password);
        }
        return self::$bd;
    }
}
