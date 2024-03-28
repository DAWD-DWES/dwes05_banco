<?php

function autoload_f0bb222b02cc3f75ef060f4ee019eed7($class) {
    $classes = array(
        'TipoCambio\TipoCambio' => __DIR__ . '/TipoCambio.php',
        'TipoCambio\VariablesDisponibles' => __DIR__ . '/VariablesDisponibles.php',
        'TipoCambio\VariablesDisponiblesResponse' => __DIR__ . '/VariablesDisponiblesResponse.php',
        'TipoCambio\InfoVariable' => __DIR__ . '/InfoVariable.php',
        'TipoCambio\ArrayOfVariable' => __DIR__ . '/ArrayOfVariable.php',
        'TipoCambio\Variable' => __DIR__ . '/Variable.php',
        'TipoCambio\ArrayOfVar' => __DIR__ . '/ArrayOfVar.php',
        'TipoCambio\VarCustom' => __DIR__ . '/VarCustom.php',
        'TipoCambio\ArrayOfVarDolar' => __DIR__ . '/ArrayOfVarDolar.php',
        'TipoCambio\VarDolar' => __DIR__ . '/VarDolar.php',
        'TipoCambio\Variables' => __DIR__ . '/Variables.php',
        'TipoCambio\VariablesResponse' => __DIR__ . '/VariablesResponse.php',
        'TipoCambio\TipoCambioFechaInicial' => __DIR__ . '/TipoCambioFechaInicial.php',
        'TipoCambio\TipoCambioFechaInicialResponse' => __DIR__ . '/TipoCambioFechaInicialResponse.php',
        'TipoCambio\DataVariable' => __DIR__ . '/DataVariable.php',
        'TipoCambio\TipoCambioRango' => __DIR__ . '/TipoCambioRango.php',
        'TipoCambio\TipoCambioRangoResponse' => __DIR__ . '/TipoCambioRangoResponse.php',
        'TipoCambio\TipoCambioFechaInicialMoneda' => __DIR__ . '/TipoCambioFechaInicialMoneda.php',
        'TipoCambio\TipoCambioFechaInicialMonedaResponse' => __DIR__ . '/TipoCambioFechaInicialMonedaResponse.php',
        'TipoCambio\TipoCambioRangoMoneda' => __DIR__ . '/TipoCambioRangoMoneda.php',
        'TipoCambio\TipoCambioRangoMonedaResponse' => __DIR__ . '/TipoCambioRangoMonedaResponse.php',
        'TipoCambio\TipoCambioDia' => __DIR__ . '/TipoCambioDia.php',
        'TipoCambio\TipoCambioDiaResponse' => __DIR__ . '/TipoCambioDiaResponse.php',
        'TipoCambio\TipoCambioDiaString' => __DIR__ . '/TipoCambioDiaString.php',
        'TipoCambio\TipoCambioDiaStringResponse' => __DIR__ . '/TipoCambioDiaStringResponse.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_f0bb222b02cc3f75ef060f4ee019eed7');

// Do nothing. The rest is just leftovers from the code generation.
{
    
}
