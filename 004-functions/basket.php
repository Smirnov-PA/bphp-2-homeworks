<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

function displayingShoppingList(array $items, bool $pause = false): void
{
    if (count($items) > 0) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }

    if ($pause) {
        echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
    }
}

function operationRequest(array $operations, array $items): int
{
    do {
        displayingShoppingList($items);

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;

        $availableOperations = $operations;

        if (count($items) === 0) {
            unset($availableOperations[OPERATION_DELETE]);
        }

        echo implode(PHP_EOL, $availableOperations) . PHP_EOL . '> ';
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $availableOperations)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($operationNumber, $availableOperations));

    return (int)$operationNumber;
}

function productName(string $hint): string
{
    echo $hint . PHP_EOL . '> ';
    return trim(fgets(STDIN));
}

function addProduct(array $items): array
{
    $items[] = productName('Введение название товара для добавления в список:');
    return $items;
}

function deleteProduct(array $items): array
{
    displayingShoppingList($items);

    $itemName = productName('Введение название товара для удаления из списка:');

    while (($key = array_search($itemName, $items, true)) !== false) {
        unset($items[$key]);
    }

    return array_values($items);
}

do {
    system('clear');

    $operationNumber = operationRequest($operations, $items);

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            $items = addProduct($items);
            break;

        case OPERATION_DELETE:
            $items = deleteProduct($items);
            break;

        case OPERATION_PRINT:
            displayingShoppingList($items, true);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;