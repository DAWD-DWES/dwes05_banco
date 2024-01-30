<?php

/**
 * Interface Cuenta 
 */
Interface IProductoBancario {

    public function ingreso($cantidad, $asunto): void;

    public function debito($cantidad, $asunto): void;
    
    public function getSaldo(): float;
    
}
