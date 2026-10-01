<?php

echo 'Имя файла: ' . basename(__FILE__) . '<br>';
echo 'Номер строки: ' . __LINE__ . '<br>';

$multiText = <<<ТЕКСТ
Многострочная строка.
Первая строка.
Вторая строка.
Третья строка.
ТЕКСТ;

echo $multiText . '<br>';

$a = 'Рыба';
$b = 'человек';
$s = mb_substr(mb_strtolower($a), 0, -1);

echo "$a {$s}ою сыта, а $b {$b}ом";

?>