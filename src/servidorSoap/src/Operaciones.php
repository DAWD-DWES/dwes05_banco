<?php

namespace ServicioCalculadora;

class Operaciones {

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
     * @param float $a
     * @param float $b
     * @return float
     */
    public function multiplica($a, $b) {
        return $a * $b;
    }

    /**
     * @soap
     * @param float $a
     * @param float $b
     * @return float
     */
    public function divide($a, $b) {
        return $a / $b;
    }
}
