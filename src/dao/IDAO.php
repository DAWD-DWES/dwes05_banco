<?php

namespace App\dao;

// Definición de la interfaz IDAO
interface IDAO {

    public function obtenerPorId(int $id): ?object;

    public function obtenerTodos(): array;

    public function crear(object $object): bool;

    public function modificar(object $object): bool;

    public function eliminar(int $id): bool;
}
