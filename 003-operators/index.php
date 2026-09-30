<?php

$name = 'иван';
$surname = 'иванов';
$patronymic = 'иванович';

$fullName = mb_convert_case($surname, MB_CASE_TITLE, 'UTF-8') . ' '
           . mb_convert_case($name, MB_CASE_TITLE, 'UTF-8') . ' '
           . mb_convert_case($patronymic, MB_CASE_TITLE, 'UTF-8');

$lastNameSeparately = mb_convert_case($surname, MB_CASE_TITLE, 'UTF-8');

$nameSeparately = mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8') . '.';

$middleNameSeparately = mb_strtoupper(mb_substr($patronymic, 0, 1, 'UTF-8'), 'UTF-8') . '.';

$surnameAndInitials = $lastNameSeparately . ' ' . $nameSeparately . $middleNameSeparately;

$fio = mb_strtoupper(mb_substr($surname, 0, 1, 'UTF-8'), 'UTF-8')
      . mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8')
      . mb_strtoupper(mb_substr($patronymic, 0, 1, 'UTF-8'), 'UTF-8');

echo "Полное имя: '$fullName'" . PHP_EOL;
echo "Фамилия и инициалы: '$surnameAndInitials'" . PHP_EOL;
echo "Аббревиатура: '$fio'" . PHP_EOL;

?>