<?php

namespace app\entity;

use app\repository\UserRepository;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property integer id
 * @property string name
 * @property string surname
 * @property string email
 * @property string password
 * @property string create_date
 * @property boolean is_verified
 * @property integer verification_code
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return new static(UserRepository::getUserById($id));
    }

    public function getId()
    {
        return $this->id;
    }

    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function findUserByEmail($email)
    {
        return new static(UserRepository::getUserByEmail($email));
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }
}