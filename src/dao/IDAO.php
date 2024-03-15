<?php

namespace App\dao;

// Definición de la interfaz IDAO
interface IDAO {

    public function obtenerPorId(int $id): ?object;

    public function obtenerTodos(): array;

    public function crear(object $object): int;

    public function modificar(object $object): void;

    public function eliminar(int $id): void;
}
