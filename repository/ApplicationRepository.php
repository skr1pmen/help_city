<?php

namespace app\repository;

use app\entity\Applications;

class ApplicationRepository
{
    public static function getCountApplicationUser($user_id) // Получение количества заявок конкретного пользователя
    {
        return count(Applications::findAll(['user_id' => $user_id]));
    }

    public static function getAllApplication($user_id, $city_id) // Получение всех заявок (если есть user_id, то сортировка по нему. Если нет, то глобально)
    {
        if ($user_id) {
            return Applications::find(['user_id' => $user_id, 'city_id' => $city_id, 'is_visible' => true])->orderBy(['id' => SORT_DESC])->all();
        }
        return Applications::find(['city_id' => $city_id, 'is_visible' => true])->orderBy(['id' => SORT_DESC])->all();
    }

    public static function getApplication($id) // Получение данных о заявке
    {
        return Applications::findOne(['id' => $id]);
    }

    public static function create($title, $description, $address, $user_id, $city_id) // Создание ново заявки
    {
        $application = new Applications(); // Создание новой заявки
        $application->title = $title; // Заполнение заявки данными
        $application->description = $description; // Заполнение заявки данными
        $application->address = $address; // Заполнение заявки данными
        $application->user_id = $user_id; // Заполнение заявки данными
        $application->city_id = $city_id; // Заполнение заявки данными
        $application->save(); // Сохранение новой заявки
        return $application->id; // Возврат id заявки
    }

    public static function edit($id, $title, $description, $address) // Редактирование заявки
    {
        $application = ApplicationRepository::getApplication($id); // Получение заявки
        $application->title = $title; // Изменение данных заявки
        $application->description = $description; // Изменение данных заявки
        $application->address = $address; // Изменение данных заявки
        $application->update(); // Сохранение изменений
    }

    public static function delete($id) // Удаление заявки (Не удаляет заявку, а лишь скрывает её от всех)
    {
        $application = ApplicationRepository::getApplication($id); // Получение заявки
        $application->is_visible = false; // Изменение данных заявки
        $application->update(); // Сохранение изменений
    }
}