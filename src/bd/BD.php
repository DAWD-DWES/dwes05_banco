<?php

class BD
{
    protected static $bd = null;
    const DB_HOST = '127.0.0.1';
    const DB_PORT = '3306';
    const DB_DATABASE = 'banco';
    const DB_USERNAME = 'gestor';
    const DB_PASSWORD = 'secreto';
    
    private function __construct()
    {
            self::$bd = new PDO("mysql:host=" . BD::DB_HOST . ";dbname=" . BD::DB_DATABASE, BD::DB_USERNAME, BD::DB_PASSWORD);
            self::$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getConexion()
    {
        if (!self::$bd) {
            new BD();
        }
        return self::$bd;
    }
}
