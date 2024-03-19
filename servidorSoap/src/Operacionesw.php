<?php

namespace Clases;

class Operacionesw {

    /**
     * @soap
     * @param float $a
     * @param float $b
     * @return float
     */
    public function resta($a, $b) {
        return $a - $b;
    }

    /**
     * @soap
     * @param float $a
     * @param float $b
     * @return float
     */
    public function suma($a, $b) {
        return $a + $b;
    }

    /**
     * @soap
     * @param  string $texto
     * @return string
     */
    public function saludo($texto) {
        return "Hola $texto";
    }

}

