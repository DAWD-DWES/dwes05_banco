<?php

// Definición de la interfaz IDAO
interface IDAO {
    public function obtenerPorId(int $id): ?object;
    
    public function obtenerTodos();
    
    public function crear(object $object);
    
    public function modificar(object $object);
    
    public function eliminar(int $id);
}

