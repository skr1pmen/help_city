<?php

namespace app\models;

use app\repository\UserRepository;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $email;
    public $password;
    public $repeatPassword;
    public $name;
    public $surname;

    public function rules()
    {
        return [
            [['email', 'password', 'name', 'surname'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['password', 'string', 'length' => [8, 24]],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Ваша почта',
            'password' => 'Ваш пароль',
            'repeatPassword' => 'Подтвердите пароль',
            'name' => 'Ваше имя',
            'surname' => 'Ваша фамилия',
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = UserRepository::getUserByEmail($this->email);
            if ($user) {
                $this->addError($attribute, 'Пользователь с такой почтой уже существует!');
            }
        }
    }
}