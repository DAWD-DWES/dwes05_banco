<?php


 function autoload_b898ad8945c5d4d52f3df1d0437cce04($class)
{
    $classes = array(
        'Clases\Calculator' => __DIR__ .'/Calculator.php',
        'Clases\Add' => __DIR__ .'/Add.php',
        'Clases\AddResponse' => __DIR__ .'/AddResponse.php',
        'Clases\Subtract' => __DIR__ .'/Subtract.php',
        'Clases\SubtractResponse' => __DIR__ .'/SubtractResponse.php',
        'Clases\Multiply' => __DIR__ .'/Multiply.php',
        'Clases\MultiplyResponse' => __DIR__ .'/MultiplyResponse.php',
        'Clases\Divide' => __DIR__ .'/Divide.php',
        'Clases\DivideResponse' => __DIR__ .'/DivideResponse.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_b898ad8945c5d4d52f3df1d0437cce04');

// Do nothing. The rest is just leftovers from the code generation.
{
}
