<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

function otobrazitSpisok(array $items): void
{
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode("\n", $items) . "\n";
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}

function vybratOperaciyu(array $operations, array $items): int
{
    do {
        system('clear');

        otobrazitSpisok($items);

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;

        $dostupnyeOperacii = $operations;
        if (count($items) === 0) {
            unset($dostupnyeOperacii[OPERATION_DELETE]);
        }

        echo implode(PHP_EOL, $dostupnyeOperacii) . PHP_EOL . '> ';
        $nomerOperacii = trim(fgets(STDIN));

        if (!array_key_exists($nomerOperacii, $dostupnyeOperacii)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($nomerOperacii, $dostupnyeOperacii));

    return (int)$nomerOperacii;
}

function dobavitTovar(array &$items): void
{
    echo "Введите название товара для добавления в список: \n> ";
    $nazvanieTovara = trim(fgets(STDIN));
    $items[] = $nazvanieTovara;
}

function udalitTovar(array &$items): void
{
    echo 'Текущий список покупок:' . PHP_EOL;
    otobrazitSpisok($items);

    echo 'Введите название товара для удаления из списка:' . PHP_EOL . '> ';
    $nazvanieTovara = trim(fgets(STDIN));

    if (in_array($nazvanieTovara, $items, true) !== false) {
        while (($key = array_search($nazvanieTovara, $items, true)) !== false) {
            unset($items[$key]);
        }
    }
}

function napechatatSpisok(array $items): void
{
    echo 'Ваш список покупок: ' . PHP_EOL;
    otobrazitSpisok($items);
    echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

do {
    $operationNumber = vybratOperaciyu($operations, $items);

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            dobavitTovar($items);
            break;

        case OPERATION_DELETE:
            udalitTovar($items);
            break;

        case OPERATION_PRINT:
            napechatatSpisok($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;

?>
