<?php

require "../vendor/autoload.php";
require "../src/autoload.php";

use eftec\bladeone\BladeOne;
use Clases\{
    Calculator,
    Add,
    Subtract,
    Multiply,
    Divide
};

$views = __DIR__ . '\..\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\..\cache'; // it uses the folder /cache to compile the result.

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$operadores = ['+', '-', '*', '/'];

function evalExpresion(int $operando1 = 0, string $operador = "", int $operando2 = 0): int {
    $service = new Calculator();
    $res = 0;
    switch ($operador ?? null) {
        case '+': {
                $request = new Add($operando1, $operando2);
                $response = $service->Add($request);
                $res = $response->getAddResult();
                break;
            }
        case '-': {
                $request = new Subtract($operando1, $operando2);
                $response = $service->Subtract($request);
                $res = $response->getSubtractResult();
                break;
            }
        case '*': {
                $request = new Multiply($operando1, $operando2);
                $response = $service->Multiply($request);
                $res = $response->getMultiplyResult();
                break;
            }
        case '/': {
                $request = new Divide($operando1, $operando2);
                $response = $service->Divide($request);
                $res = $response->getDivideResult();
                break;
            }
        default: {
                $res = $operando1;
            }
    }
    return ($res > 0) ? $res : 0;
}

$service = new Clases\Calculator();

$valor = filter_input(INPUT_POST, 'valor') ?? 0;
$expresion = filter_input(INPUT_POST, 'expresion') ?? '';

if (!empty($_POST)) {
    $expresion .= ($_POST['digito'] ?? $_POST['operador'] ?? $_POST['calcula'] ?? $_POST['reset']);

    if (preg_match('/^([0-9]+)$/', $expresion, $coincidencias)) {
        $valor = (int) $coincidencias[1];
    } else if (preg_match('/^([0-9]+)([+\-*\/])$/', $expresion, $coincidencias)) {
        $valor = (int) $coincidencias[1];
    } else if (preg_match('/^([0-9]+)([+\-*\/])([0-9]+)$/', $expresion, $coincidencias)) {
        $valor = (int) $coincidencias[3];
    } else if (preg_match('/^([0-9]+)([+\-*\/])([0-9]+)(=)$/', $expresion, $coincidencias)) {
        $valor = (int) evalExpresion($coincidencias[1], $coincidencias[2], $coincidencias[3]);
    } else if (preg_match('/^([0-9]+)([+\-*\/])([0-9]+)(=)([0-9]+)$/', $expresion, $coincidencias)) {
        $valor = (int) $coincidencias[5];
        $expresion = $valor;
    } else if (preg_match('/^([0-9]+)([+\-*\/])([0-9]+)(=)([+\-*\/])$/', $expresion, $coincidencias)) {
        $valor = (int) evalExpresion($coincidencias[1], $coincidencias[2], $coincidencias[3]);
        $expresion = $valor . $coincidencias[5];;
    } else if (preg_match('/^([0-9]+)([+\-*\/])([0-9]+)([+\-*\/])$/', $expresion, $coincidencias)) {
        $valor = (int) evalExpresion($coincidencias[1], $coincidencias[2], $coincidencias[3]);
        $expresion = $valor . $coincidencias[4];
    } else if (preg_match('/AC/', $expresion, $coincidencias)) {
        $valor = 0;
        $expresion = "";
    } else {
        $expresion = substr($expresion, 0, -1); //Se ignora el botón pulsado
    }
}

echo $blade->run('app-calculadora', compact('valor', 'expresion'));
