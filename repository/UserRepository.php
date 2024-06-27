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

    public static function createUser($email, $password, $name, $surname)
    {
        $user = new Users();
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->name = $name;
        $user->surname = $surname;
        $user->save();
        return $user->id;
    }
}