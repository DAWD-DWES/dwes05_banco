<?php

// Definición de la interfaz IDAO
interface IDAO {
    public function obtenerPorId(int $id): ?object;
    
    public function obtenerTodos(): array;
    
    public function crear(object $object);
    
    public function modificar(object $object);
    
    public function eliminar(int $id);
}

