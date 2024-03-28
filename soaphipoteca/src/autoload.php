<?php


 function autoload_9c4a79e86b543e1f842936e29b458bba($class)
{
    $classes = array(
        'Hipoteca\ServicioHipotecaCalculoHipotecaService' => __DIR__ .'/ServicioHipotecaCalculoHipotecaService.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_9c4a79e86b543e1f842936e29b458bba');

// Do nothing. The rest is just leftovers from the code generation.
{
}
