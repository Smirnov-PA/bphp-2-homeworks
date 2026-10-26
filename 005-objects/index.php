<?php

function scheduleWork($year, $month, $numberMonths = 1, $firstWorkingDay = true)
{
    $scheduleMonths = [];
    $counter = 0;

    if (!$firstWorkingDay) {
        $counter = 0;
    }

    for ($i = 0; $i < $numberMonths; $i++) {
        $currentMonth = $month + $i;
        $currentYear = $year;

        while ($currentMonth > 12) {
            $currentMonth -= 12;
            $currentYear++;
        }

        $numberDaysMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $monthName = obtainingNameMonth($currentMonth);

        $daysMonth = [];

        for ($day = 1; $day <= $numberDaysMonth; $day++) {
            $timestamp = mktime(0, 0, 0, $currentMonth, $day, $currentYear);
            $dateDay = (int)date('N', $timestamp);

            $workingDay = false;

            if ($counter === 0) {
                $workingDay = true;
            }

            if ($workingDay && $dateDay >= 6) {
                $workingDay = false;
                $daysMonth[$day] = [
                    'день' => $day,
                    'рабочий' => false,
                    'перенос' => true,
                    'день недели' => $dateDay,
                ];

                $transfer = ($dateDay === 6) ? 2 : 1;
                $monday = $day + $transfer;

                if ($monday <= $numberDaysMonth) {
                    if (!isset($daysMonth[$monday])) {
                        $mondayTimestamp = mktime(0, 0, 0, $currentMonth, $monday, $currentYear);
                        $daysMonth[$monday] = [
                            'день' => $monday,
                            'рабочий' => true,
                            'перенесенный день' => true,
                            'день недели' => (int)date('N', $mondayTimestamp),
                        ];
                    } else {
                        $daysMonth[$monday]['рабочий'] = true;
                        $daysMonth[$monday]['перенесенный день'] = true;
                    }
                }
            } elseif (!isset($daysMonth[$day])) {
                $daysMonth[$day] = [
                    'день' => $day,
                    'рабочий' => $workingDay,
                    'день недели' => $dateDay,
                ];
            }

            $counter = ($counter + 1) % 3;
        }

        ksort($daysMonth);

        for ($day = 1; $day <= $numberDaysMonth; $day++) {
            if (!isset($daysMonth[$day])) {
                $timestamp = mktime(0, 0, 0, $currentMonth, $day, $currentYear);
                $daysMonth[$day] = [
                    'день' => $day,
                    'рабочий' => false,
                    'день недели' => (int)date('N', $timestamp),
                ];
            }
        }
        ksort($daysMonth);

        $scheduleMonths[] = [
            'год' => $currentYear,
            'месяц' => $currentMonth,
            'название' => $monthName,
            'дни' => $daysMonth,
        ];
    }

    return $scheduleMonths;
}

function obtainingNameMonth($monthName)
{
    $namesMonths = [
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март',
        4 => 'Апрель', 5 => 'Май', 6 => 'Июнь',
        7 => 'Июль', 8 => 'Август', 9 => 'Сентябрь',
        10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
    ];
    return $namesMonths[$monthName] ?? '';
}

function gettingNameDayWeek($dayWeek)
{
    $namesDays = [
        1 => 'Пн',
        2 => 'Вт',
        3 => 'Ср',
        4 => 'Чт',
        5 => 'Пт',
        6 => 'Сб',
        7 => 'Вс',
    ];
    return $namesDays[$dayWeek] ?? '';
}

function graphicsOutput($scheduleMonths)
{
    echo "\033[32mзелёный\033[0m — рабочие дни, ";
    echo "\033[31mкрасный\033[0m — календарные выходные.\n";
    echo "\n";

    foreach ($scheduleMonths as $dataMonth) {

        echo "{$dataMonth['название']} {$dataMonth['год']} \n\n";

        $line = '';
        foreach ($dataMonth['дни'] as $dataDay) {
            $number = str_pad($dataDay['день'], 2, ' ', STR_PAD_LEFT);
            $dayWeek = gettingNameDayWeek($dataDay['день недели']);
            $dateDay = $dataDay['день недели'];

            if (!empty($dataDay['рабочий'])) {
                $block = "\033[32m {$number} {$dayWeek} \033[0m";
            } elseif ($dateDay >= 6) {
                $block = "\033[31m {$number} {$dayWeek} \033[0m";
            } else {
                $block = " {$number} {$dayWeek} ";
            }

            $line .= $block . "  ";

            if ($dataDay['день'] % 7 === 0) {
                echo $line . "\n";
                $line = '';
            }
        }

        if ($line !== '') {
            echo $line . "\n";
        }
    }
}

$year = (int)date('Y');
$month = (int)date('n');
$numberMonths = 6;

if (PHP_SAPI === 'cli') {
    $args = $argv;
    if (isset($args[1]) && is_numeric($args[1])) {
        $year = (int)$args[1];
    }
    if (isset($args[2]) && is_numeric($args[2])) {
        $month = (int)$args[2];
    }
    if (isset($args[3]) && is_numeric($args[3])) {
        $numberMonths = (int)$args[3];
    }
} else {
    if (isset($_GET['год']) && is_numeric($_GET['год'])) {
        $year = (int)$_GET['год'];
    }
    if (isset($_GET['месяц']) && is_numeric($_GET['месяц'])) {
        $month = (int)$_GET['месяц'];
    }
    if (isset($_GET['количество']) && is_numeric($_GET['количество'])) {
        $numberMonths = (int)$_GET['количество'];
    }
}

$schedule = scheduleWork($year, $month, $numberMonths);
graphicsOutput($schedule);

?>