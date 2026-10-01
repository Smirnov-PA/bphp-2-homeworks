<?php

$variable = 3.14;

if (is_null($variable)) {
    $type = 'null';
} elseif (is_bool($variable)) {
    $type = 'bool';
} elseif (is_int($variable)) {
    $type = 'int';
} elseif (is_float($variable)) {
    $type = 'float';
} elseif (is_string($variable)) {
    $type = 'string';
} else {
    $type = 'other';
}

echo "type is $type" . PHP_EOL;

// дополнительное задание

$variable = 3.14;

switch (true) {
    case is_null($variable):
        $type = 'null';
        break;
    case is_bool($variable):
        $type = 'bool';
        break;
    case is_int($variable):
        $type = 'int';
        break;
    case is_float($variable):
        $type = 'float';
        break;
    case is_string($variable):
        $type = 'string';
        break;
    default:
        $type = 'other';
}

echo "type is $type" . PHP_EOL;

?>