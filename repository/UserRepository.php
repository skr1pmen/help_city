<?php

namespace app\repository;

use app\entity\Users;

class UserRepository
{
    public static function getUserById($id)
    {
        return Users::find()->where(['id' => $id])->one();
    }

    public static function getUserByEmail($email)
    {
        return Users::findOne(['email' => $email]);
    }

    public static function createUser($email, $password, $name, $surname, $code, $city)
    {
        $user = new Users();
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->name = $name;
        $user->surname = $surname;
        $user->verification_code = $code;
        $user->city_id = $city;
        $user->save();
        return $user->id;
    }

    public static function editDataUser($id, $name, $surname, $city)
    {
        $user = UserRepository::getUserById($id);
        $user->name = $name;
        $user->surname = $surname;
        $user->city = $city;
        $user->update();
    }

    public static function verification($id)
    {
        $user = UserRepository::getUserById($id);
        $user->is_verified = true;
        $user->verification_code = null;
        $user->update();
    }
}