<?php

namespace App\modelo;

/**
 * Interface IProductoBancario
 */
Interface IProductoBancario {

    public function ingreso(float $cantidad, string $descripcion): void;

    public function debito(float $cantidad, string $asunto): void;
}
