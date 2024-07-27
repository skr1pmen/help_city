<?php

namespace app\repository;

use app\entity\Applications;

class ApplicationRepository
{
    public static function getCountApplicationUser($user_id)
    {
        return count(Applications::findAll(['user_id' => $user_id]));
    }

    public static function getAllApplication($user_id)
    {
        if ($user_id) {
            return Applications::findAll(['user_id' => $user_id]);
        }
        return Applications::find()->all();
    }

    public static function getApplication($id)
    {
        return Applications::findOne(['id' => $id]);
    }

    public static function create($title, $description, $address, $user_id, $city_id)
    {
        $application = new Applications();
        $application->title = $title;
        $application->description = $description;
        $application->address = $address;
        $application->user_id = $user_id;
        $application->city_id = $city_id;
        $application->save();
        return $application->id;
    }

    public static function edit($id, $title, $description, $address)
    {
        $application = ApplicationRepository::getApplication($id);
        $application->title = $title;
        $application->description = $description;
        $application->address = $address;
        $application->update();
    }

    public static function delete($id)
    {
        $application = ApplicationRepository::getApplication($id);
        $application->delete();
    }
}