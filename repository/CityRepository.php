<?php

namespace app\repository;

use app\entity\Cities;

class CityRepository
{
    public static function getCities() // Получение всех городов
    {
        return Cities::find()->all();
    }

    public static function getCity($cityName) // Получение города по имени
    {
        return Cities::findOne(['name' => $cityName]);
    }

    public static function getCityId($cityName) // Получение id города по имени
    {
        return Cities::findOne(['name' => $cityName])->id;
    }

    public static function getCityById($id) // Получение имени города по id
    {
        return Cities::findOne(['id' => $id])->name;
    }
}