<?php

namespace Calculadora;

class Calculadora {
    /**
     * @soap
     * @param int $a
     * @param int $b
     * @return int
     */

    public function resta($a, $b) {
        return $a - $b;
    }
    
    /**
     * @soap
     * @param int $a
     * @param int $b
     * @return int
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
