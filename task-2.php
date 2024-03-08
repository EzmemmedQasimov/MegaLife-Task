<?php

function evaluateExpression($expression)
{
    $outputQueue = [];
    $operatorStack = [];
    $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];
    $expression = preg_replace('/\s+/', '', $expression);
    $tokens = preg_split('((\d+|\+|\-|\*|\/|\(|\)))', $expression, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            array_push($outputQueue, $token);
        } elseif (isset($precedence[$token])) {
            while (!empty($operatorStack) && end($operatorStack) !== '(' && $precedence[end($operatorStack)] >= $precedence[$token]) {
                array_push($outputQueue, array_pop($operatorStack));
            }
            array_push($operatorStack, $token);
        } elseif ($token == '(') {
            array_push($operatorStack, $token);
        } elseif ($token == ')') {
            while (end($operatorStack) !== '(') {
                array_push($outputQueue, array_pop($operatorStack));
            }
            array_pop($operatorStack);
        }
    }

    while (!empty($operatorStack)) {
        array_push($outputQueue, array_pop($operatorStack));
    }


    $stack = [];
    foreach ($outputQueue as $token) {
        if (is_numeric($token)) {
            array_push($stack, $token);
        } else {
            $right = array_pop($stack);
            $left = array_pop($stack);
            switch ($token) {
                case '+':
                    $result = $left + $right;
                    break;
                case '-':
                    $result = $left - $right;
                    break;
                case '*':
                    $result = $left * $right;
                    break;
                case '/':
                    $result = $left / $right;
                    break;
            }
            array_push($stack, $result);
        }
    }

    return array_pop($stack);
}

// Example
echo evaluateExpression("1 + 1") . "\n";
echo evaluateExpression(" 2-1 + 2 ") . "\n";
echo evaluateExpression("(1+(4+5+2)*3)-(6+8)") . "\n";
