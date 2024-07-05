<?php

namespace app\repository;

use app\entity\Cities;

class CityRepository
{
    public static function getCities()
    {
        return Cities::find()->all();
    }

    public static function getCity($cityName)
    {
        return Cities::findOne(['name' => $cityName]);
    }

    public static function getCityId($cityName)
    {
        return Cities::findOne(['name' => $cityName])->id;
    }

    public static function getCityById($id)
    {
        return Cities::findOne(['id' => $id])->name;
    }
}