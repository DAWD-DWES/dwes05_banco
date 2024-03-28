<?php

class CalculoHipoteca {

    /**
     * @soap
     * @param float $cantidad
     * @param int $anyos
     * @param float $tasaInteresAnual
     * @return float 
     */
    public function calculoCuota(float $cantidad, int $anyos, float $tasaInteresAnual): float {
        $tasaInteresMensual = $tasaInteresAnual / 12 / 100; // Convertimos a decimal y dividimos entre 12
        $totalPagos = $anyos * 12;

        // Calculamos la cuota mensual
        $cuota = $cantidad * ($tasaInteresMensual * pow(1 + $tasaInteresMensual, $totalPagos)) / (pow(1 + $tasaInteresMensual, $totalPagos) - 1);

        return $cuota;
    }
}
