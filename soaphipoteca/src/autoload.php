<?php


 function autoload_90b37f0f712da0502d114e10ab1a11b5($class)
{
    $classes = array(
        'Hipoteca\CalculoHipotecaService' => __DIR__ .'/CalculoHipotecaService.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_90b37f0f712da0502d114e10ab1a11b5');

// Do nothing. The rest is just leftovers from the code generation.
{
}
