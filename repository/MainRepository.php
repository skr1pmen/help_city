<?php

namespace app\repository;

use app\entity\Applications;

class MainRepository
{
    public static function createdApplication() // Получение количества созданных заявок за последние 7 дней
    {
        $createdApplication = []; // Создание списка заявок
        $dates = []; // Создание массива дат последних 7 дней
        for ($i = 0; $i < 7; $i++) { // Перебор каждого дня из массива дат
            $dates[] = Date('Y-m-d', strtotime("-{$i} days")); // Получение дня
        }
        foreach ($dates as $date) { // Перебор заявок
            $createdApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 1])); // Получения количества заявок на каждый день
        };
        return $createdApplication; // Возврат количества заявок
    }

    public static function processingApplication() // Получение количества обработанных заявок за последние 7 дней
    {
        $processingApplication = []; // Создание списка заявок
        $dates = []; // Создание массива дат последних 7 дней
        for ($i = 0; $i < 7; $i++) { // Перебор каждого дня из массива дат
            $dates[] = Date('Y-m-d', strtotime("-{$i} days")); // Получение дня
        }
        foreach ($dates as $date) { // Перебор заявок
            $processingApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 2])); // Получения количества заявок на каждый день
        };
        return $processingApplication; // Возврат количества заявок
    }

    public static function atWorkApplication() // Получение количества рабочих заявок за последние 7 дней
    {
        $atWorkApplication = []; // Создание списка заявок
        $dates = []; // Создание массива дат последних 7 дней
        for ($i = 0; $i < 7; $i++) { // Перебор каждого дня из массива дат
            $dates[] = Date('Y-m-d', strtotime("-{$i} days")); // Получение дня
        }
        foreach ($dates as $date) { // Перебор заявок
            $atWorkApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 3])); // Получения количества заявок на каждый день
        };
        return $atWorkApplication; // Возврат количества заявок
    }

    public static function resolvedApplication() // Получение количества завершённых заявок за последние 7 дней
    {
        $resolvedApplication = []; // Создание списка заявок
        $dates = []; // Создание массива дат последних 7 дней
        for ($i = 0; $i < 7; $i++) { // Перебор каждого дня из массива дат
            $dates[] = Date('Y-m-d', strtotime("-{$i} days")); // Получение дня
        }
        foreach ($dates as $date) { // Перебор заявок
            $resolvedApplication[] = count(Applications::findAll(['create_date' => $date, 'status_id' => 4])); // Получения количества заявок на каждый день
        };
        return $resolvedApplication; // Возврат количества заявок
    }
}