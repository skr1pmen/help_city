<?php

namespace app\models;

use app\repository\UserRepository;
use Yii;
use yii\base\Model;

class AuthorizationForm extends Model
{
    // Создание полей для формы
    public $email;
    public $password;
    public $_user = false;

    public function attributeLabels() // Псевдонимы для полей
    {
        return [
            'email' => 'Почта',
            'password' => 'Пароль'
        ];
    }

    public function rules() // Правила валидации полей
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params) // Валидация пароля
    {
        if (!$this->hasErrors()) { // Проверка на ошибки
            $user = $this->getUser(); // Получение пользователя

            if (!$user || !$user->validatePassword($this->password)) { // Валидация
                $this->addError($attribute, "Ошибка в логине или пароле"); // Создание ошибки
            }
        }
    }

    public function getUser() // Получение пользователя
    {
        if ($this->_user === false) { // Проверка наличия пользователя
            $this->_user = UserRepository::getUserByEmail($this->email); // Сохранение пользователя
        }
        return $this->_user; // Возврат пользователя
    }

    public function login() // Авторизация пользователя
    {
        if ($this->validate()) { // Проверка на валидность
            return Yii::$app->user->login($this->getUser()); // Авторизация пользователя
        }
        return false; // False если всё плохо
    }
}