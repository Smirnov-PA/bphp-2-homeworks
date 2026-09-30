<?php

$meaningA = trim(fgets(STDIN));

$meaningB = trim(fgets(STDIN));

$number_1 = filter_var($meaningA, FILTER_VALIDATE_INT);

$number_2 = filter_var($meaningB, FILTER_VALIDATE_INT);

if ($number_1 === false || $number_2 === false) {
    fwrite(STDERR, "Введите число" . PHP_EOL);
    exit(1);
}

if ($number_2 === 0) {
    fwrite(STDERR, "Нельзя делить на 0" . PHP_EOL);
    exit(1);
}

$result = $number_1 / $number_2;
fwrite(STDOUT, $result . PHP_EOL);

?>