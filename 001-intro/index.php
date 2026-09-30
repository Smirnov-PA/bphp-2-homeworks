<?php

echo 'Имя файла: ' . basename(__FILE__) . '<br>';
echo 'Номер строки: ' . __LINE__ . '<br>';

$a = 'Рыба';
$b = 'человек';
$s = mb_substr(mb_strtolower($a), 0, -1);

echo "$a {$s}ою сыта, а $b {$b}ом";

?>