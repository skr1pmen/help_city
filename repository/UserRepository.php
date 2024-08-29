<?php

namespace app\repository;

use app\entity\Users;

class UserRepository
{
    public static function getUserById($id) // Получение пользователя по id
    {
        return Users::find()->where(['id' => $id])->one();
    }

    public static function getUserByEmail($email) //Получение пользователя по почте
    {
        return Users::findOne(['email' => $email]);
    }

    public static function createUser($email, $password, $name, $surname, $code, $city) // Создание нового пользователя
    {
        $user = new Users(); // Создание нового пользователя
        $user->email = $email; // Заполнение пользователя данными
        $user->password = password_hash($password, PASSWORD_DEFAULT); // Заполнение пользователя данными
        $user->name = $name; // Заполнение пользователя данными
        $user->surname = $surname; // Заполнение пользователя данными
        $user->verification_code = $code; // Заполнение пользователя данными
        $user->city_id = $city; // Заполнение пользователя данными
        $user->save(); // Сохранение пользователя
        return $user->id; // Возврат id пользователя
    }

    public static function editDataUser($id, $name, $surname, $city) // Редактирование пользователя
    {
        $user = UserRepository::getUserById($id); // Поиск пользователя для изменений
        $user->name = $name; // Данные для изменений
        $user->surname = $surname; // Данные для изменений
        $user->city_id = $city; // Данные для изменений
        $user->update(); // Сохранение данных
    }

    public static function verification($id) // Верификация пользователя
    {
        $user = UserRepository::getUserById($id); // Поиск пользователя для изменений
        $user->is_verified = true; // Данные для изменений
        $user->verification_code = null; // Данные для изменений
        $user->update(); // Сохранение данных
    }
}